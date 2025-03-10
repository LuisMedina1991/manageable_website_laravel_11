<?php

namespace App\Http\Controllers;

use App\Models\FooterSocialMediaLink;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FooterSocialMediaLinkController extends Controller
{
    public $allFooterSocialMediaLinks;

    public array $positions;

    public string $pageTitle;

    public function __construct()
    {
        $this->allFooterSocialMediaLinks = FooterSocialMediaLink::all();
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
            ['position' => 11],
            ['position' => 12],
            ['position' => 13],
            ['position' => 14],
        ];
        $this->pageTitle = __('Social Networks');
    }

    public function index()
    {
        $footerSocialMediaLinks = FooterSocialMediaLink::OrderBy('position')->paginate(7);

        return view('layouts.admin_panel.footer_social_media_links.index',
            [
                'page_title' => $this->pageTitle,
                'footer_social_media_links' => $footerSocialMediaLinks,
            ]);
    }

    public function edit(FooterSocialMediaLink $footerSocialMediaLink)
    {
        $availablePositions = [];
        $assignedFooterSocialMediaLinks = $this->allFooterSocialMediaLinks->where('is_selected', 1)->sortBy('position');

        foreach ($this->positions as $iteration) {

            if ($assignedFooterSocialMediaLinks->doesntContain('position', $iteration['position'])) {

                $availablePositions[] = ['position' => $iteration['position'], 'message' => __('Available')];

            } elseif ($footerSocialMediaLink->position == $iteration['position']) {

                $availablePositions[] = ['position' => $iteration['position'], 'message' => __('Assigned')];

            } else {

                $availablePositions[] = ['position' => $iteration['position'], 'message' => __('Replace')];

            }
        }

        return view('layouts.admin_panel.footer_social_media_links.edit',
            [
                'page_title' => $this->pageTitle,
                'footer_social_media_link' => $footerSocialMediaLink,
                'available_positions' => $availablePositions,
            ]);
    }

    public function update(Request $request, FooterSocialMediaLink $footerSocialMediaLink)
    {
        $request->validate([
            'url' => 'required|max:255|url:https|active_url',
            'is_selected' => 'not_in:select',
            'position' => 'exclude_unless:is_selected,1|not_in:select',
        ]);

        if (($footerSocialMediaLink->is_selected) && ($request->is_selected == 0) && (count($this->allFooterSocialMediaLinks->where('is_selected', 1)) < 2)) {

            return response()->json(
                ['errors' => ['is_selected' => [__('You must have at least one record assigned')]]],
                422
            );

        }

        DB::beginTransaction();

        try {

            $footerSocialMediaLink->url = $request->url;

            if ($request->is_selected == 1) {

                if ($footerSocialMediaLink->position != $request->position) {

                    $assignedFooterSocialMediaLinks = $this->allFooterSocialMediaLinks->where('is_selected', 1)->sortBy('position');

                    if ($assignedFooterSocialMediaLinks->contains('position', $request->position)) {

                        $previusPositionOwner = $assignedFooterSocialMediaLinks->firstWhere('position', $request->position);

                        $previusPositionOwner->update([

                            'is_selected' => 0,
                            'position' => 100,

                        ]);

                    }
                }

                $footerSocialMediaLink->is_selected = $request->is_selected;
                $footerSocialMediaLink->position = $request->position;

            } else {

                $footerSocialMediaLink->is_selected = 0;
                $footerSocialMediaLink->position = 100;

            }

            $footerSocialMediaLink->save();

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
}
