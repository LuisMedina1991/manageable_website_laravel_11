<?php

namespace App\Http\Controllers;

use App\Models\BackgroundColor;
use App\Models\ThirdSection;
use App\Models\ThirdSectionContactForm;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThirdSectionController extends Controller
{
    public $allThirdSections;

    public $allBackgroundColors;

    public string $pageTitle;

    public array $labels;

    public function __construct()
    {
        $this->allThirdSections = ThirdSection::with('thirdSectionContactForm')->get();
        $this->allBackgroundColors = BackgroundColor::all();
        $this->pageTitle = __('Third Section');
        $this->labels = [
            ['title' => __('Name Label'), 'text' => ''],
            ['title' => __('Email Label'), 'text' => ''],
            ['title' => __('Phone Label'), 'text' => ''],
            ['title' => __('Message Label'), 'text' => ''],
        ];
    }

    public function index()
    {
        $thirdSections = ThirdSection::with([
            'backgroundColor',
            'thirdSectionContactForm',
        ])->paginate();

        return view('layouts.admin_panel.third_sections.index',
            [
                'page_title' => $this->pageTitle,
                'third_sections' => $thirdSections,
            ]);
    }

    public function create()
    {
        if ($this->allThirdSections->count() > 9) {

            return to_route('admin_panel.third_sections.index')->with('error', __('Maximum registration limit reached.'));

        } else {

            return view('layouts.admin_panel.third_sections.create',
                [
                    'page_title' => $this->pageTitle,
                    'background_colors' => $this->allBackgroundColors,
                    'labels' => $this->labels,
                ]);

        }
    }

    public function store(Request $request)
    {
        $rules = [

            'name' => 'required|min:3|max:25|unique:third_sections',
            'background_color_id' => 'not_in:select',
            'third_section_contact_form_options' => 'not_in:select',
            'is_selected' => 'not_in:select',
            'third_section_contact_form_title' => 'exclude_unless:third_section_contact_form_options,0|required|min:3|max:25',
            'labels' => 'exclude_unless:third_section_contact_form_options,0|required|array|size:4',
            'labels.*.text' => 'exclude_unless:third_section_contact_form_options,0|required|min:3|max:25|distinct:ignore_case',

        ];

        $messages = [

            'labels.required' => __('The :attribute field is an empty array'),

        ];

        $request->validate($rules, $messages);

        DB::beginTransaction();

        try {

            $previouslyAssignedThirdSection = $this->allThirdSections->firstWhere('is_selected', 1);

            if ($request->is_selected == 1) {

                foreach ($this->allThirdSections as $existing_third_section) {

                    $existing_third_section->update([

                        'is_selected' => 0,

                    ]);

                }
            }

            $newThirdSection = ThirdSection::create([

                'identifier' => 'third-section',
                'name' => $request->name,
                'is_selected' => $request->is_selected,
                'background_color_id' => $request->background_color_id,

            ]);

            if ($request->third_section_contact_form_options == 0) {

                $newThirdSectionContactForm = new ThirdSectionContactForm;
                $newThirdSectionContactForm->title = $request->third_section_contact_form_title;
                $newThirdSectionContactForm->third_section_id = $newThirdSection->id;

                foreach ($request->labels as $index => $label) {

                    switch ($index) {

                        case 0:
                            $newThirdSectionContactForm->name_label = $label['text'];
                            break;

                        case 1:
                            $newThirdSectionContactForm->email_label = $label['text'];
                            break;

                        case 2:
                            $newThirdSectionContactForm->phone_label = $label['text'];
                            break;

                        case 3:
                            $newThirdSectionContactForm->message_label = $label['text'];
                            break;

                    }
                }

                $newThirdSectionContactForm->save();

            } else {

                ThirdSectionContactForm::create([

                    'title' => $previouslyAssignedThirdSection->thirdSectionContactForm->title,
                    'name_label' => $previouslyAssignedThirdSection->thirdSectionContactForm->name_label,
                    'email_label' => $previouslyAssignedThirdSection->thirdSectionContactForm->email_label,
                    'phone_label' => $previouslyAssignedThirdSection->thirdSectionContactForm->phone_label,
                    'message_label' => $previouslyAssignedThirdSection->thirdSectionContactForm->message_label,
                    'third_section_id' => $newThirdSection->id,

                ]);

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

    public function thirdSectionAssign(ThirdSection $thirdSection)
    {
        if ($thirdSection->is_selected) {

            return to_route('admin_panel.third_sections.index')->with('error', __('The record is allready assigned to the website.'));

        } else {

            DB::beginTransaction();

            try {

                foreach ($this->allThirdSections as $existing_third_section) {

                    $existing_third_section->update([

                        'is_selected' => 0,

                    ]);

                }

                $thirdSection->update([

                    'is_selected' => 1,

                ]);

                DB::commit();

                return to_route('admin_panel.third_sections.index')->with('info', __('Updated successfully.'));

            } catch (Exception $e) {

                DB::rollBack();

                // return to_route('admin_panel.third_sections.index')->with('error', $e->getMessage());
                return to_route('admin_panel.third_sections.index')->with('error', __('Error assigning record to website.'));

            }
        }
    }

    public function edit(ThirdSection $thirdSection)
    {
        $targetThirdSection = $this->allThirdSections->find($thirdSection);
        $labels = [];

        foreach ($this->labels as $index => $label) {

            switch ($index) {

                case 0:
                    $labels[] = ['title' => $label['title'], 'text' => $targetThirdSection->thirdSectionContactForm->name_label];
                    break;

                case 1:
                    $labels[] = ['title' => $label['title'], 'text' => $targetThirdSection->thirdSectionContactForm->email_label];
                    break;

                case 2:
                    $labels[] = ['title' => $label['title'], 'text' => $targetThirdSection->thirdSectionContactForm->phone_label];
                    break;

                case 3:
                    $labels[] = ['title' => $label['title'], 'text' => $targetThirdSection->thirdSectionContactForm->message_label];
                    break;

            }
        }

        return view('layouts.admin_panel.third_sections.edit',
            [
                'third_section' => $targetThirdSection,
                'page_title' => $this->pageTitle,
                'background_colors' => $this->allBackgroundColors,
                'labels' => $labels,
            ]);
    }

    public function update(Request $request, ThirdSection $thirdSection)
    {
        $rules = [

            'name' => 'required|min:3|max:25|unique:third_sections,name,'.$thirdSection->id,
            'background_color_id' => 'not_in:select',
            'third_section_contact_form_options' => 'not_in:select',
            'is_selected' => 'not_in:select',
            'third_section_contact_form_title' => 'exclude_unless:third_section_contact_form_options,0|required|min:3|max:25',
            'labels' => 'exclude_unless:third_section_contact_form_options,0|required|array|size:4',
            'labels.*.text' => 'exclude_unless:third_section_contact_form_options,0|required|min:3|max:25|distinct:ignore_case',

        ];

        $messages = [

            'labels.required' => __('The :attribute field is an empty array'),

        ];

        $request->validate($rules, $messages);

        if (($thirdSection->is_selected) && ($request->is_selected == 0)) {

            return response()->json(
                ['errors' => ['is_selected' => [__('You must assign another record first')]]],
                422
            );

        }

        DB::beginTransaction();

        try {

            if ((! $thirdSection->is_selected) && ($request->is_selected == 1)) {

                foreach ($this->allThirdSections as $existing_third_section) {

                    $existing_third_section->update([

                        'is_selected' => 0,

                    ]);

                }
            }

            $thirdSection->update([

                'name' => $request->name,
                'is_selected' => $request->is_selected,
                'background_color_id' => $request->background_color_id,

            ]);

            if ($request->third_section_contact_form_options == 0) {

                $thirdSectionContactForm = $thirdSection->thirdSectionContactForm;
                $thirdSectionContactForm->title = $request->third_section_contact_form_title;

                foreach ($request->labels as $index => $label) {

                    switch ($index) {

                        case 0:
                            $thirdSectionContactForm->name_label = $label['text'];
                            break;

                        case 1:
                            $thirdSectionContactForm->email_label = $label['text'];
                            break;

                        case 2:
                            $thirdSectionContactForm->phone_label = $label['text'];
                            break;

                        case 3:
                            $thirdSectionContactForm->message_label = $label['text'];
                            break;

                    }
                }

                $thirdSectionContactForm->save();

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

    public function destroy(ThirdSection $thirdSection)
    {
        if ($thirdSection->is_selected) {

            return to_route('admin_panel.third_sections.index')->with('error', __('Deleting a record assigned to the website is not allowed.'));

        } else {

            $thirdSection->delete();

            return to_route('admin_panel.third_sections.index')->with('info', __('Record deleted.'));

        }
    }
}
