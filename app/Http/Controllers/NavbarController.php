<?php

namespace App\Http\Controllers;

use App\Models\BackgroundColor;
use App\Models\Navbar;
use App\Models\NavbarBrand;
use App\Models\NavbarLink;
use App\Models\TextColor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NavbarController extends Controller
{
    public $allNavbars;

    public $allBackgroundColors;

    public $allTextColors;

    public array $navbarLinks;

    public string $pageTitle;

    public function __construct()
    {
        $this->allNavbars = Navbar::with(['navbarBrand', 'navbarLinks'])->get();
        $this->allBackgroundColors = BackgroundColor::all();
        $this->allTextColors = TextColor::all();
        $this->pageTitle = __('Navigation Bar');

        $this->navbarLinks = [
            ['text' => ''],
            ['text' => ''],
            ['text' => ''],
        ];
    }

    public function index()
    {
        $navbars = Navbar::with([
            'backgroundColor',
            'textColor',
            'navbarBrand',
            'navbarLinks',
        ])->paginate();

        return view('layouts.admin_panel.navbars.index',
            [
                'page_title' => $this->pageTitle,
                'navbars' => $navbars,
            ]);
    }

    public function create()
    {
        if ($this->allNavbars->count() > 9) {

            return to_route('admin_panel.navbars.index')->with('error', __('Maximum registration limit reached.'));

        } else {

            return view('layouts.admin_panel.navbars.create',
                [
                    'page_title' => $this->pageTitle,
                    'background_colors' => $this->allBackgroundColors,
                    'text_colors' => $this->allTextColors,
                    'navbar_links' => $this->navbarLinks,
                ]);

        }
    }

    public function store(Request $request)
    {
        $rules = [

            'name' => 'required|min:3|max:25|unique:navbars',
            'background_color_id' => 'not_in:select',
            'text_color_id' => 'not_in:select',
            'navbar_brand_options' => 'not_in:select',
            'navbar_links_options' => 'not_in:select',
            'is_selected' => 'not_in:select',
            'navbar_brand_text' => 'exclude_unless:navbar_brand_options,0|required|min:3|max:20',
            'navbar_brand_image' => 'exclude_unless:navbar_brand_options,0|required|image|mimes:png,jpg,jpeg|max:2048|dimensions:min_width=200,min_height=200,max_width=1024,max_height=1024',
            'navbar_links' => 'exclude_unless:navbar_links_options,0|required|array|size:3',
            'navbar_links.*.text' => 'exclude_unless:navbar_links_options,0|required|min:3|max:15|distinct:ignore_case',

        ];

        $messages = [

            'navbar_brand_image.dimensions' => __('Min dimension :min_width x :min_height, Max dimension :max_width x :max_height'),
            'navbar_links.required' => __('The :attribute field is an empty array'),

        ];

        $request->validate($rules, $messages);

        DB::beginTransaction();

        try {

            $previouslyAssignedNavbar = $this->allNavbars->firstWhere('is_selected', 1);

            if ($request->is_selected == 1) {

                foreach ($this->allNavbars as $existing_navbar) {

                    $existing_navbar->update([

                        'is_selected' => 0,

                    ]);

                }
            }

            $newNavbar = Navbar::create([

                'identifier' => 'main-menu',
                'name' => $request->name,
                'is_selected' => $request->is_selected,
                'background_color_id' => $request->background_color_id,
                'text_color_id' => $request->text_color_id,

            ]);

            if ($request->navbar_links_options == 0) {

                foreach ($request->navbar_links as $index => $requestNavbarLink) {

                    $newNavbarLink = new NavbarLink;
                    $newNavbarLink->text = $requestNavbarLink['text'];
                    $newNavbarLink->navbar_id = $newNavbar->id;

                    switch ($index) {

                        case 0:
                            $newNavbarLink->href = 'first-section';
                            break;

                        case 1:
                            $newNavbarLink->href = 'second-section';
                            break;

                        case 2:
                            $newNavbarLink->href = 'third-section';
                            break;

                    }

                    $newNavbarLink->save();

                }

            } else {

                foreach ($previouslyAssignedNavbar->navbarLinks as $previouslyAssignedNavbarLink) {

                    NavbarLink::create([

                        'href' => $previouslyAssignedNavbarLink->href,
                        'text' => $previouslyAssignedNavbarLink->text,
                        'navbar_id' => $newNavbar->id,

                    ]);

                }
            }

            if ($request->navbar_brand_options == 0) {

                $file = $request->file('navbar_brand_image');
                $destinationPath = 'storage/navbar_brand_images/';
                $fileName = uniqid().'.'.$file->extension();
                $newNavbarBrandImage = $destinationPath.$fileName;

                NavbarBrand::create([

                    'text' => $request->navbar_brand_text,
                    'image' => $newNavbarBrandImage,
                    'navbar_id' => $newNavbar->id,

                ]);

                $file->move($destinationPath, $fileName);

            } else {

                if (! $previouslyAssignedNavbar->navbarBrand->image) {

                    return response()->json(
                        ['errors' => ['navbar_brand_options' => [__('Registry image not found')]]],
                        422
                    );

                } else {

                    $previouslyAssignedNavbarBrandImage = $previouslyAssignedNavbar->navbarBrand->image;
                    $destinationPath = 'storage/navbar_brand_images/';
                    $extension = pathinfo($previouslyAssignedNavbarBrandImage, PATHINFO_EXTENSION);
                    $fileName = uniqid().'.'.$extension;
                    $newNavbarBrandImage = $destinationPath.$fileName;

                    NavbarBrand::create([

                        'text' => $previouslyAssignedNavbar->navbarBrand->text,
                        'image' => $newNavbarBrandImage,
                        'navbar_id' => $newNavbar->id,

                    ]);

                    $copiedFile = copy($previouslyAssignedNavbarBrandImage, $newNavbarBrandImage);

                    if (! $copiedFile) {

                        throw new Exception(__('Error copying image'));
                    }
                }
            }

            DB::commit();

            return response()->json(
                session()->flash('info', __('Successful registration.')),
                201
            );

        } catch (Exception $e) {

            if ($newNavbar && $newNavbar->navbarBrand && $newNavbar->navbarBrand->image) {

                unlink($newNavbar->navbarBrand->image);

            }

            DB::rollBack();

            return response()->json(
                // session()->flash('error', $e->getMessage()),
                session()->flash('error', __('Error creating record.')),
                500
            );

        }
    }

    public function navbarAssign(Navbar $navbar)
    {
        if ($navbar->is_selected) {

            return to_route('admin_panel.navbars.index')->with('error', __('The record is allready assigned to the website.'));

        } else {

            DB::beginTransaction();

            try {

                foreach ($this->allNavbars as $existing_navbar) {

                    $existing_navbar->update([

                        'is_selected' => 0,

                    ]);

                }

                $navbar->update([

                    'is_selected' => 1,

                ]);

                DB::commit();

                return to_route('admin_panel.navbars.index')->with('info', __('Updated successfully.'));

            } catch (Exception $e) {

                DB::rollBack();

                // return to_route('admin_panel.navbars.index')->with('error', $e->getMessage());
                return to_route('admin_panel.navbars.index')->with('error', __('Error assigning record to website.'));

            }
        }
    }

    public function edit(Navbar $navbar)
    {
        $targetNavbar = $this->allNavbars->find($navbar);

        return view('layouts.admin_panel.navbars.edit',
            [
                'navbar' => $targetNavbar,
                'page_title' => $this->pageTitle,
                'background_colors' => $this->allBackgroundColors,
                'text_colors' => $this->allTextColors,
            ]);
    }

    public function update(Request $request, Navbar $navbar)
    {
        $rules = [

            'name' => 'required|min:3|max:25|unique:navbars,name,'.$navbar->id,
            'background_color_id' => 'not_in:select',
            'text_color_id' => 'not_in:select',
            'navbar_brand_options' => 'not_in:select',
            'navbar_links_options' => 'not_in:select',
            'is_selected' => 'not_in:select',
            'navbar_brand_text' => 'exclude_unless:navbar_brand_options,0|required|min:3|max:20',
            'navbar_brand_image' => 'exclude_unless:navbar_brand_options,0|image|mimes:png,jpg,jpeg|max:2048|dimensions:min_width=200,min_height=200,max_width=1024,max_height=1024',
            'navbar_links' => 'exclude_unless:navbar_links_options,0|required|array|min:3|max:3',
            'navbar_links.*.text' => 'exclude_unless:navbar_links_options,0|required|min:3|max:15|distinct:ignore_case',

        ];

        $messages = [

            'navbar_brand_image.dimensions' => __('Min dimension :min_width x :min_height, Max dimension :max_width x :max_height'),
            'navbar_links.required' => __('The :attribute field is an empty array'),

        ];

        $request->validate($rules, $messages);

        if (($navbar->is_selected) && ($request->is_selected == 0)) {

            return response()->json(
                ['errors' => ['is_selected' => [__('You must assign another record first')]]],
                422
            );

        }

        DB::beginTransaction();

        try {

            if ((! $navbar->is_selected) && ($request->is_selected == 1)) {

                foreach ($this->allNavbars as $existing_navbar) {

                    $existing_navbar->update([

                        'is_selected' => 0,

                    ]);

                }
            }

            $navbar->update([

                'name' => $request->name,
                'background_color_id' => $request->background_color_id,
                'text_color_id' => $request->text_color_id,
                'is_selected' => $request->is_selected,

            ]);

            if ($request->navbar_links_options == 0) {

                foreach ($navbar->navbarLinks as $index => $previouslyAssignedNavbarLink) {

                    $previouslyAssignedNavbarLink->update([

                        'text' => $request->navbar_links[$index]['text'],

                    ]);

                }
            }

            if ($request->navbar_brand_options == 0) {

                if ($request->hasFile('navbar_brand_image')) {

                    $file = $request->file('navbar_brand_image');
                    $destinationPath = 'storage/navbar_brand_images/';
                    $fileName = uniqid().'.'.$file->extension();
                    $newNavbarBrandImage = $destinationPath.$fileName;
                    $previouslyAssignedNavbarBrandImage = $navbar->navbarBrand->image;

                    $navbar->navbarBrand()->update([

                        'text' => $request->navbar_brand_text,
                        'image' => $newNavbarBrandImage,

                    ]);

                    $file->move($destinationPath, $fileName);

                    if ($previouslyAssignedNavbarBrandImage) {

                        unlink($previouslyAssignedNavbarBrandImage);

                    }

                } else {

                    $navbar->navbarBrand()->update([

                        'text' => $request->navbar_brand_text,

                    ]);

                }
            }

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

    public function destroy(Navbar $navbar)
    {
        if ($navbar->is_selected) {

            return to_route('admin_panel.navbars.index')->with('error', __('Deleting a record assigned to the website is not allowed.'));

        } else {

            if ($navbar->navbarBrand->image) {

                unlink($navbar->navbarBrand->image);

            }

            $navbar->delete();

            return to_route('admin_panel.navbars.index')->with('info', __('Record deleted.'));

        }
    }
}
