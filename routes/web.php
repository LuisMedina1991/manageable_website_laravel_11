<?php

use App\Http\Controllers\CarouselImageController;
use App\Http\Controllers\FirstSectionController;
use App\Http\Controllers\FooterSocialMediaLinkController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\SecondSectionController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\ThirdSectionController;
use App\Http\Controllers\UserController;
use App\Mail\ThirdSectionContactFormMailable;   // Import added to make use of the created mailable
use Illuminate\Support\Facades\Route;

Route::controller(TemplateController::class)
    ->name('template.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'sendMail')->name('send_mail');
    });

Route::prefix('admin_panel')
    ->name('admin_panel.')
    ->middleware('auth')
    ->group(function () {

        Route::get('/', function () {
            return view('layouts.admin_panel.template');
        })->name('index');

        /* route to display the email template that will be sent from the website */
        Route::get('email_preview', function () {
            $data = [
                'remitent_name' => __('John Doe'),
                'remitent_email' => __('admin_account@mailinator.com'),
                'remitent_phone' => '+59166666666',
                'remitent_message' => __('This is a fake message to display in the template.'),
            ];

            return new ThirdSectionContactFormMailable($data);
        })->name('email_preview');

        Route::controller(HeaderController::class)
            ->prefix('headers')
            ->name('headers.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('edit/{header}', 'edit')->name('edit');
                Route::put('update/{header}', 'update')->name('update');
                Route::put('assign/{header}', 'headerAssign')->name('assign');
                Route::delete('{header}', 'destroy')->name('destroy');
            });

        Route::controller(NavbarController::class)
            ->prefix('navbars')
            ->name('navbars.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('edit/{navbar}', 'edit')->name('edit');
                Route::put('update/{navbar}', 'update')->name('update');
                Route::put('assign/{navbar}', 'navbarAssign')->name('assign');
                Route::delete('{navbar}', 'destroy')->name('destroy');
            });

        Route::controller(CarouselImageController::class)
            ->prefix('carousel_images')
            ->name('carousel_images.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('edit/{carousel_image}', 'edit')->name('edit');
                Route::put('update/{carousel_image}', 'update')->name('update');
                Route::delete('{carousel_image}', 'destroy')->name('destroy');
            });

        Route::controller(FirstSectionController::class)
            ->prefix('first_sections')
            ->name('first_sections.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('edit/{first_section}', 'edit')->name('edit');
                Route::put('update/{first_section}', 'update')->name('update');
                Route::put('assign/{first_section}', 'firstSectionAssign')->name('assign');
                Route::delete('{first_section}', 'destroy')->name('destroy');
            });

        Route::controller(SecondSectionController::class)
            ->prefix('second_sections')
            ->name('second_sections.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('edit/{second_section}', 'edit')->name('edit');
                Route::put('update/{second_section}', 'update')->name('update');
                Route::put('assign/{second_section}', 'secondSectionAssign')->name('assign');
                Route::delete('{second_section}', 'destroy')->name('destroy');
            });

        Route::controller(ThirdSectionController::class)
            ->prefix('third_sections')
            ->name('third_sections.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('edit/{third_section}', 'edit')->name('edit');
                Route::put('update/{third_section}', 'update')->name('update');
                Route::put('assign/{third_section}', 'thirdSectionAssign')->name('assign');
                Route::delete('{third_section}', 'destroy')->name('destroy');
            });

        Route::controller(FooterSocialMediaLinkController::class)
            ->prefix('footer_social_media_links')
            ->name('footer_social_media_links.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('edit/{footer_social_media_link}', 'edit')->name('edit');
                Route::put('update/{footer_social_media_link}', 'update')->name('update');
            });

        Route::controller(UserController::class)
            ->prefix('users')
            ->name('users.')
            ->middleware('can:users_resources')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('edit/{user}', 'edit')->name('edit');
                Route::put('update/{user}', 'update')->name('update');
                Route::delete('{user}', 'destroy')->name('destroy');
            });
    });

require __DIR__.'/auth.php';
