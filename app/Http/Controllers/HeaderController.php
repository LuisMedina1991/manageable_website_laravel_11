<?php

namespace App\Http\Controllers;

use App\Models\BackgroundColor;
use App\Models\Header;
use App\Models\TextColor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HeaderController extends Controller
{
    public $allHeaders;

    public $allBackgroundColors;

    public $allTextColors;

    public string $pageTitle;

    public function __construct()
    {
        $this->pageTitle = __('Header');
        $this->allHeaders = Header::all();
        $this->allBackgroundColors = BackgroundColor::all();
        $this->allTextColors = TextColor::all();
    }

    public function index()
    {
        $headers = Header::with([
            'backgroundColor',
            'textColor',
        ])->paginate();

        return view('layouts.admin_panel.headers.index',
            [
                'page_title' => $this->pageTitle,
                'headers' => $headers,
            ]);
    }

    public function create()
    {
        if ($this->allHeaders->count() > 9) {

            return to_route('admin_panel.headers.index')->with('error', __('Maximum registration limit reached.'));

        } else {

            return view('layouts.admin_panel.headers.create',
                [
                    'page_title' => $this->pageTitle,
                    'background_colors' => $this->allBackgroundColors,
                    'text_colors' => $this->allTextColors,
                ]);

        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:25|unique:headers',
            'link_phone' => 'required|numeric|integer|gt:0|min_digits:8|max_digits:15',
            'background_color_id' => 'not_in:select',
            'text_color_id' => 'not_in:select',
            'link_text' => 'required|min:10|max:50',
            'is_selected' => 'not_in:select',
        ]);

        DB::beginTransaction();

        try {

            if ($request->is_selected == 1) {

                foreach ($this->allHeaders as $existing_header) {

                    $existing_header->update([

                        'is_selected' => 0,

                    ]);

                }
            }

            Header::create([

                'identifier' => 'main-header',
                'name' => $request->name,
                'link_phone' => $request->link_phone,
                'link_text' => $request->link_text,
                'is_selected' => $request->is_selected,
                'background_color_id' => $request->background_color_id,
                'text_color_id' => $request->text_color_id,

            ]);

            DB::commit();

            return response()->json(
                session()->flash('info', __('Successful registration.')),
                201
            );

        } catch (Exception $e) {

            DB::rollBack();

            return response()->json(
                // session()->flash('error', $e->getMessage()),
                session()->flash('error', __('Error creating record.')),
                500
            );

        }
    }

    public function headerAssign(Header $header)
    {
        if ($header->is_selected) {

            return to_route('admin_panel.headers.index')->with('error', __('The record is allready assigned to the website.'));

        } else {

            DB::beginTransaction();

            try {

                foreach ($this->allHeaders as $existing_header) {

                    $existing_header->update([

                        'is_selected' => 0,

                    ]);

                }

                $header->update([

                    'is_selected' => 1,

                ]);

                DB::commit();

                return to_route('admin_panel.headers.index')->with('info', __('Updated successfully.'));

            } catch (Exception $e) {

                DB::rollBack();

                // return to_route('admin_panel.headers.index')->with('error', $e->getMessage());
                return to_route('admin_panel.headers.index')->with('error', __('Error assigning record to website.'));

            }
        }
    }

    public function edit(Header $header)
    {
        return view('layouts.admin_panel.headers.edit',
            [
                'header' => $header,
                'page_title' => $this->pageTitle,
                'background_colors' => $this->allBackgroundColors,
                'text_colors' => $this->allTextColors,
            ]);
    }

    public function update(Request $request, Header $header)
    {
        $request->validate([
            'name' => 'required|min:3|max:25|unique:headers,name,'.$header->id,
            'link_phone' => 'required|numeric|integer|gt:0|min_digits:8|max_digits:15',
            'background_color_id' => 'not_in:select',
            'text_color_id' => 'not_in:select',
            'link_text' => 'required|min:10|max:50',
            'is_selected' => 'not_in:select',
        ]);

        if (($header->is_selected) && ($request->is_selected == 0)) {

            return response()->json(
                ['errors' => ['is_selected' => [__('You must assign another record first')]]],
                422
            );

        }

        DB::beginTransaction();

        try {

            if ((! $header->is_selected) && ($request->is_selected == 1)) {

                foreach ($this->allHeaders as $existing_header) {

                    $existing_header->update([

                        'is_selected' => 0,

                    ]);

                }
            }

            $header->update([

                'name' => $request->name,
                'link_phone' => $request->link_phone,
                'link_text' => $request->link_text,
                'is_selected' => $request->is_selected,
                'background_color_id' => $request->background_color_id,
                'text_color_id' => $request->text_color_id,

            ]);

            DB::commit();

            return response()->json(
                session()->flash('info', __('Updated successfully.')),
                201
            );

        } catch (Exception $e) {

            DB::rollBack();

            return response()->json(
                // session()->flash('error', $e->getMessage()),
                session()->flash('error', __('Error updating record.')),
                500
            );

        }
    }

    public function destroy(Header $header)
    {
        if ($header->is_selected) {

            return to_route('admin_panel.headers.index')->with('error', __('Deleting a record assigned to the website is not allowed.'));

        } else {

            $header->delete();

            return to_route('admin_panel.headers.index')->with('info', __('Record deleted.'));

        }
    }
}
