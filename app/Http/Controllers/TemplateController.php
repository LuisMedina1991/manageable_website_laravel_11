<?php

namespace App\Http\Controllers;

use App\Jobs\ThirdSectionContactFormJob;
use App\Models\CarouselImage;
use App\Models\FirstSection;
use App\Models\FooterSocialMediaLink;
use App\Models\Header;
use App\Models\Navbar;
use App\Models\SecondSection;
use App\Models\ThirdSection;
use Exception;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index()
    {
        $header = Header::with([
            'backgroundColor',
            'textColor',
        ])->firstWhere('is_selected', 1);

        $navbar = Navbar::with([
            'backgroundColor',
            'textColor',
            'navbarBrand',
            'navbarLinks',
        ])->firstWhere('is_selected', 1);

        $carouselImages = CarouselImage::where('is_selected', 1)
            ->OrderBy('position')
            ->get();

        $firstSection = FirstSection::with([
            'textColor',
            'firstSectionFrames',
        ])->firstWhere('is_selected', 1);

        $secondSection = SecondSection::with([
            'backgroundColor',
            'textColor',
            'secondSectionBlocks',
        ])->firstWhere('is_selected', 1);

        $thirdSection = ThirdSection::with([
            'backgroundColor',
            'thirdSectionContactForm',
        ])->firstWhere('is_selected', 1);

        $footerSocialMediaLinks = FooterSocialMediaLink::where('is_selected', 1)
            ->OrderBy('position')
            ->get();

        return view('layouts.website.template',
            [
                'header' => $header,
                'navbar' => $navbar,
                'carousel_images' => $carouselImages->where('image', '!=', null),
                'first_section' => $firstSection,
                'second_section' => $secondSection,
                'third_section' => $thirdSection,
                'footer_social_media_links' => $footerSocialMediaLinks,
            ]);
    }

    public function sendMail(Request $request)
    {
        $validatedContactFormData = $request->validate([
            'remitent_name' => 'required|max:50',
            'remitent_email' => 'required|email|max:100',
            'remitent_phone' => 'required|max:25',
            'remitent_message' => 'required|max:255',
        ]);

        // comment this after setting up the email provider values on ".env" file
        /* return response()->json(
            session()->flash('success', __('MESSAGE SUCCESSFULLY SENT.')),
            201
        ); */

        try {

            // dispatch the job that will be responsible for sending the email in the background
            dispatch(new ThirdSectionContactFormJob($validatedContactFormData));

            return response()->json(
                session()->flash('success', __('MESSAGE SUCCESSFULLY SENT.')),
                201
            );

        } catch (Exception $e) {

            return response()->json(
                // session()->flash('error', $e->getMessage()),
                session()->flash('error', __('ERROR SENDING MESSAGE.')),
                500
            );

        }
    }
}
