<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\View\Component;

class AdminAppLayout extends Component
{
    public array $translations;

    public function __construct()
    {
        $this->translations = [];
    }

    public function render(): View|Closure|string
    {
        $locale = App::getLocale();

        if (File::exists(base_path("lang/$locale.json"))) {

            $this->translations = json_decode(File::get(base_path("lang/$locale.json")), true);

        }

        return view('layouts.main_admin');
    }
}
