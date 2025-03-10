<?php

namespace App\Http\Controllers;

use App\Models\FirstSection;
use App\Models\FirstSectionFrame;
use App\Models\TextColor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FirstSectionController extends Controller
{
    public $allFirstSections;

    public $allTextColors;

    public string $pageTitle;

    public function __construct()
    {
        $this->allFirstSections = FirstSection::with(['firstSectionFrames'])->get();
        $this->allTextColors = TextColor::all();
        $this->pageTitle = __('First Section');
    }

    public function index()
    {
        $firstSections = FirstSection::with([
            'textColor',
            'firstSectionFrames',
        ])->paginate();

        return view('layouts.admin_panel.first_sections.index',
            [
                'page_title' => $this->pageTitle,
                'first_sections' => $firstSections,
            ]);
    }

    public function create()
    {
        if ($this->allFirstSections->count() > 9) {

            return to_route('admin_panel.first_sections.index')->with('error', __('Maximum registration limit reached.'));

        } else {

            return view('layouts.admin_panel.first_sections.create',
                [
                    'page_title' => $this->pageTitle,
                    'text_colors' => $this->allTextColors,
                ]);

        }
    }

    public function store(Request $request)
    {
        $rules = [

            'name' => 'required|min:3|max:25|unique:first_sections',
            'title' => 'required|min:3|max:50',
            'text_color_id' => 'not_in:select',
            'first_section_frames_options' => 'not_in:select',
            'is_selected' => 'not_in:select',
            'first_section_frames' => 'exclude_unless:first_section_frames_options,0|required|array|min:1|max:4',
            'first_section_frames.*.subtitle' => 'exclude_unless:first_section_frames_options,0|required|min:3|max:50|distinct:ignore_case',
            'first_section_frames.*.text' => 'exclude_unless:first_section_frames_options,0|required|min:25|max:255|distinct:ignore_case',

        ];

        $messages = [

            'first_section_frames.required' => __('The :attribute field is an empty array'),

        ];

        $request->validate($rules, $messages);

        DB::beginTransaction();

        try {

            $previouslyAssignedFirstSection = $this->allFirstSections->firstWhere('is_selected', 1);

            if ($request->is_selected == 1) {

                foreach ($this->allFirstSections as $existing_first_section) {

                    $existing_first_section->update([

                        'is_selected' => 0,

                    ]);

                }
            }

            $newFirstSection = FirstSection::create([

                'identifier' => 'first-section',
                'name' => $request->name,
                'title' => $request->title,
                'is_selected' => $request->is_selected,
                'text_color_id' => $request->text_color_id,

            ]);

            if ($request->first_section_frames_options == 0) {

                foreach ($request->first_section_frames as $requestFirstSectionFrame) {

                    FirstSectionFrame::create([

                        'subtitle' => $requestFirstSectionFrame['subtitle'],
                        'text' => $requestFirstSectionFrame['text'],
                        'first_section_id' => $newFirstSection->id,

                    ]);

                }

            } else {

                foreach ($previouslyAssignedFirstSection->firstSectionFrames as $previouslyAssignedFirstSectionFrame) {

                    FirstSectionFrame::create([

                        'subtitle' => $previouslyAssignedFirstSectionFrame->subtitle,
                        'text' => $previouslyAssignedFirstSectionFrame->text,
                        'first_section_id' => $newFirstSection->id,

                    ]);

                }
            }

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

    public function firstSectionAssign(FirstSection $firstSection)
    {
        if ($firstSection->is_selected) {

            return to_route('admin_panel.first_sections.index')->with('error', __('The record is allready assigned to the website.'));

        } else {

            DB::beginTransaction();

            try {

                foreach ($this->allFirstSections as $existing_first_section) {

                    $existing_first_section->update([

                        'is_selected' => 0,

                    ]);

                }

                $firstSection->update([

                    'is_selected' => 1,

                ]);

                DB::commit();

                return to_route('admin_panel.first_sections.index')->with('info', __('Updated successfully.'));

            } catch (Exception $e) {

                DB::rollBack();

                // return to_route('admin_panel.first_sections.index')->with('error', $e->getMessage());
                return to_route('admin_panel.first_sections.index')->with('error', __('Error assigning record to website.'));

            }
        }
    }

    public function edit(FirstSection $firstSection)
    {
        $targetFirstSection = $this->allFirstSections->find($firstSection);

        return view('layouts.admin_panel.first_sections.edit',
            [
                'first_section' => $targetFirstSection,
                'page_title' => $this->pageTitle,
                'text_colors' => $this->allTextColors,
            ]);
    }

    public function update(Request $request, FirstSection $firstSection)
    {
        $rules = [

            'name' => 'required|min:3|max:25|unique:first_sections,name,'.$firstSection->id,
            'title' => 'required|min:3|max:50',
            'text_color_id' => 'not_in:select',
            'first_section_frames_options' => 'not_in:select',
            'is_selected' => 'not_in:select',
            'first_section_frames' => 'exclude_unless:first_section_frames_options,0|required|array|min:1|max:4',
            'first_section_frames.*.subtitle' => 'exclude_unless:first_section_frames_options,0|required|min:3|max:50|distinct:ignore_case',
            'first_section_frames.*.text' => 'exclude_unless:first_section_frames_options,0|required|min:25|max:255|distinct:ignore_case',

        ];

        $messages = [

            'first_section_frames.required' => __('The :attribute field is an empty array'),

        ];

        $request->validate($rules, $messages);

        if (($firstSection->is_selected) && ($request->is_selected == 0)) {

            return response()->json(
                ['errors' => ['is_selected' => [__('You must assign another record first')]]],
                422
            );

        }

        DB::beginTransaction();

        try {

            if ((! $firstSection->is_selected) && ($request->is_selected == 1)) {

                foreach ($this->allFirstSections as $existing_first_section) {

                    $existing_first_section->update([

                        'is_selected' => 0,

                    ]);

                }
            }

            $firstSection->update([

                'name' => $request->name,
                'title' => $request->title,
                'is_selected' => $request->is_selected,
                'text_color_id' => $request->text_color_id,

            ]);

            if ($request->first_section_frames_options == 0) {

                $existingFirstSectionFramesCount = count($firstSection->firstSectionFrames);
                $requestFirstSectionFramesCount = count($request->first_section_frames);

                if (($existingFirstSectionFramesCount == $requestFirstSectionFramesCount) || ($existingFirstSectionFramesCount > $requestFirstSectionFramesCount)) {

                    foreach ($firstSection->firstSectionFrames as $index => $existingFirstSectionFrame) {

                        if (array_key_exists($index, $request->first_section_frames)) {

                            $existingFirstSectionFrame->update([

                                'subtitle' => $request->first_section_frames[$index]['subtitle'],
                                'text' => $request->first_section_frames[$index]['text'],

                            ]);

                        } else {

                            $existingFirstSectionFrame->delete();

                        }
                    }

                } elseif ($existingFirstSectionFramesCount < $requestFirstSectionFramesCount) {

                    foreach ($request->first_section_frames as $index => $requestFirstSectionFrame) {

                        if ($index < $existingFirstSectionFramesCount) {

                            $existingFirstSectionFrame = $firstSection->firstSectionFrames[$index];

                            $existingFirstSectionFrame->update([

                                'subtitle' => $requestFirstSectionFrame['subtitle'],
                                'text' => $requestFirstSectionFrame['text'],

                            ]);

                        } else {

                            FirstSectionFrame::create([

                                'subtitle' => $requestFirstSectionFrame['subtitle'],
                                'text' => $requestFirstSectionFrame['text'],
                                'first_section_id' => $firstSection->id,

                            ]);

                        }
                    }
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

    public function destroy(FirstSection $firstSection)
    {
        if ($firstSection->is_selected) {

            return to_route('admin_panel.first_sections.index')->with('error', __('Deleting a record assigned to the website is not allowed.'));

        } else {

            $firstSection->delete();

            return to_route('admin_panel.first_sections.index')->with('info', __('Record deleted.'));

        }
    }
}
