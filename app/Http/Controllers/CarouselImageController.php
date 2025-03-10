<?php

namespace App\Http\Controllers;

use App\Models\CarouselImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarouselImageController extends Controller
{
    public $allCarouselImages;

    public array $positions;

    public string $pageTitle;

    public function __construct()
    {
        $this->allCarouselImages = CarouselImage::all();
        $this->positions = [
            ['position' => 1],
            ['position' => 2],
            ['position' => 3],
            ['position' => 4],
            ['position' => 5],
            ['position' => 6],
            ['position' => 7],
            ['position' => 8],
            ['position' => 9],
            ['position' => 10],
        ];
        $this->pageTitle = __('Slidable Image');
    }

    public function index()
    {
        $carouselImages = CarouselImage::OrderBy('position')->paginate(3);

        return view('layouts.admin_panel.carousel_images.index',
            [
                'page_title' => $this->pageTitle,
                'carousel_images' => $carouselImages,
            ]);
    }

    public function create()
    {
        if ($this->allCarouselImages->count() > 9) {

            return to_route('admin_panel.carousel_images.index')->with('error', __('Maximum registration limit reached.'));

        } else {

            $availablePositions = [];
            $assignedCarouselImages = $this->allCarouselImages->where('is_selected', 1)->sortBy('position');

            foreach ($this->positions as $iteration) {

                if ($assignedCarouselImages->doesntContain('position', $iteration['position'])) {

                    $availablePositions[] = ['position' => $iteration['position'], 'message' => __('Available')];

                } else {

                    $availablePositions[] = ['position' => $iteration['position'], 'message' => __('Replace')];

                }
            }

            return view('layouts.admin_panel.carousel_images.create',
                [
                    'page_title' => $this->pageTitle,
                    'available_positions' => $availablePositions,
                ]);

        }
    }

    public function store(Request $request)
    {
        $rules = [

            'name' => 'required|min:3|max:25|unique:carousel_images',
            'text' => 'max:25',
            'is_selected' => 'not_in:select',
            'position' => 'exclude_unless:is_selected,1|not_in:select',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048|dimensions:min_width=1000,min_height=300,max_width=2000,max_height=900',

        ];

        $messages = [

            'image.dimensions' => __('Min dimension :min_width x :min_height, Max dimension :max_width x :max_height'),

        ];

        $request->validate($rules, $messages);

        DB::beginTransaction();

        try {

            $file = $request->file('image');
            $destinationPath = 'storage/carousel_images/';
            $fileName = uniqid().'.'.$file->extension();
            $newImage = $destinationPath.$fileName;

            if ($request->is_selected == 1) {

                $assignedCarouselImages = $this->allCarouselImages->where('is_selected', 1)->sortBy('position');

                if ($assignedCarouselImages->contains('position', $request->position)) {

                    $previusPositionOwner = $assignedCarouselImages->firstWhere('position', $request->position);

                    $previusPositionOwner->update([

                        'is_selected' => 0,
                        'position' => 100,

                    ]);

                }

                CarouselImage::create([

                    'name' => $request->name,
                    'image' => $newImage,
                    'text' => $request->text,
                    'is_selected' => $request->is_selected,
                    'position' => $request->position,

                ]);

            } else {

                CarouselImage::create([

                    'name' => $request->name,
                    'image' => $newImage,
                    'text' => $request->text,
                    'is_selected' => $request->is_selected,
                    'position' => 100,

                ]);

            }

            $file->move($destinationPath, $fileName);

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

    public function edit(CarouselImage $carouselImage)
    {
        $availablePositions = [];
        $assignedCarouselImages = $this->allCarouselImages->where('is_selected', 1)->sortBy('position');

        foreach ($this->positions as $iteration) {

            if ($assignedCarouselImages->doesntContain('position', $iteration['position'])) {

                $availablePositions[] = ['position' => $iteration['position'], 'message' => __('Available')];

            } elseif ($carouselImage->position == $iteration['position']) {

                $availablePositions[] = ['position' => $iteration['position'], 'message' => __('Assigned')];

            } else {

                $availablePositions[] = ['position' => $iteration['position'], 'message' => __('Replace')];

            }
        }

        return view('layouts.admin_panel.carousel_images.edit',
            [
                'page_title' => $this->pageTitle,
                'carousel_image' => $carouselImage,
                'available_positions' => $availablePositions,
            ]);
    }

    public function update(Request $request, CarouselImage $carouselImage)
    {
        $rules = [

            'name' => 'required|min:3|max:25|unique:carousel_images,name,'.$carouselImage->id,
            'text' => 'max:25',
            'is_selected' => 'not_in:select',
            'position' => 'exclude_unless:is_selected,1|not_in:select',
            'image' => 'image|mimes:png,jpg,jpeg|max:2048|dimensions:min_width=1000,min_height=300,max_width=2000,max_height=900',

        ];

        $messages = [

            'image.dimensions' => __('Min dimension :min_width x :min_height, Max dimension :max_width x :max_height'),

        ];

        $request->validate($rules, $messages);

        if (($carouselImage->is_selected) && ($request->is_selected == 0) && (count($this->allCarouselImages->where('is_selected', 1)) < 2)) {

            return response()->json(
                ['errors' => ['is_selected' => [__('You must have at least one record assigned')]]],
                422
            );

        }

        DB::beginTransaction();

        try {

            $carouselImage->name = $request->name;
            $carouselImage->text = $request->text;

            if ($request->is_selected == 1) {

                if ($carouselImage->position != $request->position) {

                    $assignedCarouselImages = $this->allCarouselImages->where('is_selected', 1)->sortBy('position');

                    if ($assignedCarouselImages->contains('position', $request->position)) {

                        $previusPositionOwner = $assignedCarouselImages->firstWhere('position', $request->position);

                        $previusPositionOwner->update([

                            'is_selected' => 0,
                            'position' => 100,

                        ]);

                    }
                }

                $carouselImage->is_selected = $request->is_selected;
                $carouselImage->position = $request->position;

            } else {

                $carouselImage->is_selected = 0;
                $carouselImage->position = 100;

            }

            if ($request->hasFile('image')) {

                $file = $request->file('image');
                $destinationPath = 'storage/carousel_images/';
                $fileName = uniqid().'.'.$file->extension();
                $newImage = $destinationPath.$fileName;
                $previusImage = $carouselImage->image;

                $carouselImage->image = $newImage;

                $file->move($destinationPath, $fileName);

                if ($previusImage) {

                    unlink($previusImage);

                }
            }

            $carouselImage->save();

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

    public function destroy(CarouselImage $carouselImage)
    {
        if ($carouselImage->is_selected) {

            return to_route('admin_panel.carousel_images.index')->with('error', __('Deleting a record assigned to the website is not allowed.'));

        } else {

            if ($carouselImage->image) {

                unlink($carouselImage->image);

            }

            $carouselImage->delete();

            return to_route('admin_panel.carousel_images.index')->with('info', __('Record deleted.'));

        }
    }
}
