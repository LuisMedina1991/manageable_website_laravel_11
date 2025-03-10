<?php

namespace App\Http\Controllers;

use App\Models\BackgroundColor;
use App\Models\SecondSection;
use App\Models\SecondSectionBlock;
use App\Models\TextColor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SecondSectionController extends Controller
{
    public $allSecondSections;

    public $allBackgroundColors;

    public $allTextColors;

    public string $pageTitle;

    public function __construct()
    {
        $this->allSecondSections = SecondSection::with(['secondSectionBlocks'])->get();
        $this->allBackgroundColors = BackgroundColor::all();
        $this->allTextColors = TextColor::all();
        $this->pageTitle = __('Second Section');
    }

    public function index()
    {
        $secondSections = SecondSection::with([
            'backgroundColor',
            'textColor',
            'secondSectionBlocks',
        ])->paginate();

        return view('layouts.admin_panel.second_sections.index',
            [
                'page_title' => $this->pageTitle,
                'second_sections' => $secondSections,
            ]);
    }

    public function create()
    {
        if ($this->allSecondSections->count() > 9) {

            return to_route('admin_panel.second_sections.index')->with('error', __('Maximum registration limit reached.'));

        } else {

            return view('layouts.admin_panel.second_sections.create',
                [
                    'page_title' => $this->pageTitle,
                    'background_colors' => $this->allBackgroundColors,
                    'text_colors' => $this->allTextColors,
                ]);

        }
    }

    public function store(Request $request)
    {
        $rules = [

            'name' => 'required|min:3|max:25|unique:second_sections',
            'background_color_id' => 'not_in:select',
            'text_color_id' => 'not_in:select',
            'second_section_blocks_options' => 'not_in:select',
            'is_selected' => 'not_in:select',
            'second_section_blocks' => 'exclude_unless:second_section_blocks_options,0|required|array|min:1|max:4',
            'second_section_blocks.*.text' => 'exclude_unless:second_section_blocks_options,0|required|min:50|max:100|distinct:ignore_case',
            'second_section_blocks.*.image' => 'exclude_unless:second_section_blocks_options,0|required|image|mimes:png,jpg,jpeg|max:2048|dimensions:min_width=400,min_height=400,max_width=1120,max_height=1120',

        ];

        $messages = [

            'second_section_blocks.required' => __('The :attribute field is an empty array'),
            'second_section_blocks.*.image.dimensions' => __('Min dimension :min_width x :min_height, Max dimension :max_width x :max_height'),

        ];

        $request->validate($rules, $messages);

        DB::beginTransaction();

        try {

            $previouslyAssignedSecondSection = $this->allSecondSections->firstWhere('is_selected', 1);

            if ($request->is_selected == 1) {

                foreach ($this->allSecondSections as $existing_second_section) {

                    $existing_second_section->update([

                        'is_selected' => 0,

                    ]);

                }
            }

            $newSecondSection = SecondSection::create([

                'identifier' => 'second-section',
                'name' => $request->name,
                'is_selected' => $request->is_selected,
                'background_color_id' => $request->background_color_id,
                'text_color_id' => $request->text_color_id,

            ]);

            $filesToStore = [];
            $filesToCopy = [];
            $destinationPath = 'storage/second_section_blocks_images/';

            if ($request->second_section_blocks_options == 0) {

                foreach ($request->second_section_blocks as $index => $requestSecondSectionBlock) {

                    $file = $request->file('second_section_blocks.'.$index.'.image');
                    $fileName = uniqid().'.'.$file->extension();
                    $newSecondSectionBlockImage = $destinationPath.$fileName;

                    SecondSectionBlock::create([

                        'image' => $newSecondSectionBlockImage,
                        'text' => $requestSecondSectionBlock['text'],
                        'second_section_id' => $newSecondSection->id,

                    ]);

                    $filesToStore[] = ['file' => $file, 'file_name' => $fileName];

                }

            } else {

                foreach ($previouslyAssignedSecondSection->secondSectionBlocks as $previouslyAssignedSecondSectionBlock) {

                    if (! $previouslyAssignedSecondSectionBlock->image) {

                        return response()->json(
                            ['errors' => ['second_section_blocks_options' => [__('Registry image not found')]]],
                            422
                        );

                    } else {

                        $previouslyAssignedSecondSectionBlockImage = $previouslyAssignedSecondSectionBlock->image;
                        $extension = pathinfo($previouslyAssignedSecondSectionBlockImage, PATHINFO_EXTENSION);
                        $fileName = uniqid().'.'.$extension;
                        $newSecondSectionBlockImage = $destinationPath.$fileName;

                        SecondSectionBlock::create([

                            'image' => $newSecondSectionBlockImage,
                            'text' => $previouslyAssignedSecondSectionBlock->text,
                            'second_section_id' => $newSecondSection->id,

                        ]);

                        $filesToCopy[] = ['source_file_path' => $previouslyAssignedSecondSectionBlockImage, 'destination_path' => $newSecondSectionBlockImage];

                    }
                }
            }

            if (count($filesToStore) > 0) {

                foreach ($filesToStore as $fileToStore) {

                    $fileToStore['file']->move($destinationPath, $fileToStore['file_name']);

                }
            }

            if (count($filesToCopy) > 0) {

                foreach ($filesToCopy as $fileToCopy) {

                    $copiedFile = copy($fileToCopy['source_file_path'], $fileToCopy['destination_path']);

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

            if ($newSecondSection && $newSecondSection->secondSectionBlocks) {

                foreach ($newSecondSection->secondSectionBlocks as $newSecondSectionBlock) {

                    if ($newSecondSectionBlock->image) {

                        unlink($newSecondSectionBlock->image);

                    }
                }
            }

            DB::rollBack();

            return response()->json(
                // session()->flash('error', $e->getMessage()),
                session()->flash('error', __('Error creating record.')),
                500
            );

        }
    }

    public function secondSectionAssign(SecondSection $secondSection)
    {
        if ($secondSection->is_selected) {

            return to_route('admin_panel.second_sections.index')->with('error', __('The record is allready assigned to the website.'));

        } else {

            DB::beginTransaction();

            try {

                foreach ($this->allSecondSections as $existing_second_section) {

                    $existing_second_section->update([

                        'is_selected' => 0,

                    ]);

                }

                $secondSection->update([

                    'is_selected' => 1,

                ]);

                DB::commit();

                return to_route('admin_panel.second_sections.index')->with('info', __('Updated successfully.'));

            } catch (Exception $e) {

                DB::rollBack();

                // return to_route('admin_panel.second_sections.index')->with('error', $e->getMessage());
                return to_route('admin_panel.second_sections.index')->with('error', __('Error assigning record to website.'));

            }
        }
    }

    public function edit(SecondSection $secondSection)
    {
        $targetSecondSection = $this->allSecondSections->find($secondSection);

        return view('layouts.admin_panel.second_sections.edit',
            [
                'second_section' => $targetSecondSection,
                'page_title' => $this->pageTitle,
                'background_colors' => $this->allBackgroundColors,
                'text_colors' => $this->allTextColors,
            ]);
    }

    public function update(Request $request, SecondSection $secondSection)
    {
        $rules = [

            'name' => 'required|min:3|max:25|unique:second_sections,name,'.$secondSection->id,
            'background_color_id' => 'not_in:select',
            'text_color_id' => 'not_in:select',
            'second_section_blocks_options' => 'not_in:select',
            'is_selected' => 'not_in:select',
            'second_section_blocks' => 'exclude_unless:second_section_blocks_options,0|required|array|min:1|max:4',
            'second_section_blocks.*.text' => 'exclude_unless:second_section_blocks_options,0|required|min:50|max:100|distinct:ignore_case',
            'second_section_blocks.*.image' => 'exclude_unless:second_section_blocks_options,0|image|mimes:png,jpg,jpeg|max:2048|dimensions:min_width=400,min_height=400,max_width=1120,max_height=1120',

        ];

        $messages = [

            'second_section_blocks.required' => __('The :attribute field is an empty array'),
            'second_section_blocks.*.image.dimensions' => __('Min dimension :min_width x :min_height, Max dimension :max_width x :max_height'),

        ];

        $request->validate($rules, $messages);

        if (($secondSection->is_selected) && ($request->is_selected == 0)) {

            return response()->json(
                ['errors' => ['is_selected' => [__('You must assign another record first')]]],
                422
            );

        }

        DB::beginTransaction();

        try {

            if ((! $secondSection->is_selected) && ($request->is_selected == 1)) {

                foreach ($this->allSecondSections as $existing_second_section) {

                    $existing_second_section->update([

                        'is_selected' => 0,

                    ]);

                }
            }

            $secondSection->update([

                'name' => $request->name,
                'is_selected' => $request->is_selected,
                'background_color_id' => $request->background_color_id,
                'text_color_id' => $request->text_color_id,

            ]);

            if ($request->second_section_blocks_options == 0) {

                $existingSecondSectionBlocksCount = count($secondSection->secondSectionBlocks);
                $requestSecondSectionBlocksCount = count($request->second_section_blocks);
                $filesToStore = [];
                $filesToDelete = [];
                $destinationPath = 'storage/second_section_blocks_images/';

                foreach ($request->second_section_blocks as $index => $requestSecondSectionBlock) {

                    if ($request->hasFile('second_section_blocks.'.$index.'.image')) {

                        $file = $request->file('second_section_blocks.'.$index.'.image');
                        $fileName = uniqid().'.'.$file->extension();
                        $newSecondSectionBlockImage = $destinationPath.$fileName;
                        $filesToStore[$index] = ['file' => $file, 'file_name' => $fileName, 'new_second_section_block_image' => $newSecondSectionBlockImage];

                    }

                    if ($existingSecondSectionBlocksCount < $requestSecondSectionBlocksCount) {

                        if ($index < $existingSecondSectionBlocksCount) {

                            $existingSecondSectionBlock = $secondSection->secondSectionBlocks[$index];

                            if (array_key_exists($index, $filesToStore)) {

                                if ($existingSecondSectionBlock->image) {

                                    $filesToDelete[] = ['file_path' => $existingSecondSectionBlock->image];

                                }

                                $existingSecondSectionBlock->update([

                                    'image' => $filesToStore[$index]['new_second_section_block_image'],
                                    'text' => $requestSecondSectionBlock['text'],

                                ]);

                            } else {

                                $existingSecondSectionBlock->update([

                                    'text' => $requestSecondSectionBlock['text'],

                                ]);

                            }

                        } else {

                            if (! array_key_exists($index, $filesToStore)) {

                                return response()->json(
                                    ['errors' => ['second_section_blocks.'.$index.'.image' => [__('Required field')]]],
                                    422
                                );

                            } else {

                                SecondSectionBlock::create([

                                    'image' => $filesToStore[$index]['new_second_section_block_image'],
                                    'text' => $requestSecondSectionBlock['text'],
                                    'second_section_id' => $secondSection->id,

                                ]);

                            }
                        }
                    }
                }

                if (($existingSecondSectionBlocksCount == $requestSecondSectionBlocksCount) || ($existingSecondSectionBlocksCount > $requestSecondSectionBlocksCount)) {

                    foreach ($secondSection->secondSectionBlocks as $index => $existingSecondSectionBlock) {

                        if (array_key_exists($index, $request->second_section_blocks)) {

                            if (array_key_exists($index, $filesToStore)) {

                                if ($existingSecondSectionBlock->image) {

                                    $filesToDelete[] = ['file_path' => $existingSecondSectionBlock->image];

                                }

                                $existingSecondSectionBlock->update([

                                    'image' => $filesToStore[$index]['new_second_section_block_image'],
                                    'text' => $request->second_section_blocks[$index]['text'],

                                ]);

                            } else {

                                $existingSecondSectionBlock->update([

                                    'text' => $request->second_section_blocks[$index]['text'],

                                ]);

                            }

                        } else {

                            if ($existingSecondSectionBlock->image) {

                                $filesToDelete[] = ['file_path' => $existingSecondSectionBlock->image];

                            }

                            $existingSecondSectionBlock->delete();

                        }
                    }
                }

                if (count($filesToStore) > 0) {

                    foreach ($filesToStore as $fileToStore) {

                        $fileToStore['file']->move($destinationPath, $fileToStore['file_name']);

                    }
                }

                if (count($filesToDelete) > 0) {

                    foreach ($filesToDelete as $fileToDelete) {

                        unlink($fileToDelete['file_path']);

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

    public function destroy(SecondSection $secondSection)
    {
        if ($secondSection->is_selected) {

            return to_route('admin_panel.second_sections.index')->with('error', __('Deleting a record assigned to the website is not allowed.'));

        } else {

            foreach ($secondSection->secondSectionBlocks as $secondSectionBlock) {

                if ($secondSectionBlock->image) {

                    unlink($secondSectionBlock->image);

                }
            }

            $secondSection->delete();

            return to_route('admin_panel.second_sections.index')->with('info', __('Record deleted.'));

        }
    }
}
