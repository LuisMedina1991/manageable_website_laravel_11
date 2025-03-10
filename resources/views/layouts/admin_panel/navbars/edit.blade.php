<x-admin-app-layout>

    @section('title', __('Edit'). ' ' .$page_title)

    <div class="widget">
        <div class="widget-heading">
            <span class="widget-heading-text">
                <b>{{ __('Edit'). ' ' .$page_title }}</b>
            </span>
        </div>
        <form action="{{ route('admin_panel.navbars.update',$navbar) }}" method="POST" id="navbars_form">
            @csrf
            @method('put')
            <div class="row g-3">
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Name') }}*</b></label>
                    <input type="text" name="name" class="form-control" placeholder="{{$navbar->name}}" value="{{ $navbar->name }}">
                    <span class="text-danger validation-errors" id="name"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Background Color') }}*</b></label>
                    <select class="form-select" name="background_color_id">
                        <option value="select">{{ __('Select an option') }}</option>
                        @foreach ($background_colors as $background_color)
                            <option value="{{ $background_color->id }}" class="{{ $background_color->class }}" @selected($navbar->background_color_id == $background_color->id)>
                                {{ $background_color->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger validation-errors" id="background_color_id"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Text Color') }}*</b></label>
                    <select class="form-select" name="text_color_id">
                        <option value="select">{{ __('Select an option') }}</option>
                        @foreach ($text_colors as $text_color)
                            <option value="{{ $text_color->id }}" class="{{ $text_color->class }}" @selected($navbar->text_color_id == $text_color->id)>
                                {{ $text_color->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger validation-errors" id="text_color_id"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Edit Logo') }}*</b></label>
                    <select class="form-select" name="navbar_brand_options" id="navbar_brand_select">
                        <option value="select">{{ __('Select an option') }}</option>
                        <option value="1">{{ __('No') }}</option>
                        <option value="0">{{ __('Yes') }}</option>
                    </select>
                    <span class="text-danger validation-errors" id="navbar_brand_options"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Edit Links') }}*</b></label>
                    <select class="form-select" name="navbar_links_options" id="navbar_links_select">
                        <option value="select">{{ __('Select an option') }}</option>
                        <option value="1">{{ __('No') }}</option>
                        <option value="0">{{ __('Yes') }}</option>
                    </select>
                    <span class="text-danger validation-errors" id="navbar_links_options"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Assign to Web') }}*</b></label>
                    <select class="form-select" name="is_selected">
                        <option value="select">{{ __('Select an option') }}</option>
                        <option value="0" @selected($navbar->is_selected == '0')>{{ __('No') }}</option>
                        <option value="1" @selected($navbar->is_selected == '1')>{{ __('Yes') }}</option>
                    </select>
                    <span class="text-danger validation-errors" id="is_selected"></span>
                </div>
                <div class="col-12 d-none" id="navbar_brand_form">
                    <div class="card">
                        <div class="card-header text-center">
                            <span><b>{{ __('Edit Logo') }}</b></span>
                            <button class="btn custom-button" type="button" data-bs-toggle="collapse" data-bs-target="#navbar_brand_form_content" aria-controls="navbar_brand_form_content" aria-expanded="true" aria-label="Toggle navigation">
                                <i class="fa-solid fa-square-caret-down"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <nav class="navbar">
                                <div class="container-fluid">
                                    <div class="navbar-collapse collapse show" id="navbar_brand_form_content">
                                        <div class="row g-3">
                                            <div class="col-lg-4">
                                                <label><b>{{ __('Text') }}*</b></label>
                                                <input type="text" name="navbar_brand_text" class="form-control" placeholder="{{$navbar->navbarBrand->text}}" value="{{ $navbar->navbarBrand->text }}">
                                                <span class="text-danger validation-errors" id="navbar_brand_text"></span>
                                            </div>
                                            <div class="col-lg-8">
                                                <label><b>{{ __('Image for Registration') }}*</b></label>
                                                <input type="file" id="file_input" name="navbar_brand_image" class="form-control" accept="image/x-png,image/jpeg">
                                                <span class="text-danger validation-errors" id="navbar_brand_image"></span>
                                            </div>
                                            <div class="col-12 text-center">
                                                <label><b>{{ __('Image Preview') }}</b></label>
                                                <div id="image_preview_container">
                                                    @if($navbar->navbarBrand->image)
                                                        <img id="preloaded_image_preview" src="{{ asset($navbar->navbarBrand->image) }}" class="rounded" width="150" height="150" alt="preloaded image preview">
                                                    @else
                                                        <img id="preloaded_image_preview" src="{{ asset('storage/no_image_available.png') }}" class="rounded" width="150" height="150" alt="image not found">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-none" id="navbar_links_form">
                    <div class="card">
                        <div class="card-header text-center">
                            <span><b>{{ __('Edit Links') }}</b></span>
                            <button class="btn custom-button" type="button" data-bs-toggle="collapse" data-bs-target="#navbar_links_form_content" aria-controls="navbar_links_form_content" aria-expanded="true" aria-label="Toggle navigation">
                                <i class="fa-solid fa-square-caret-down"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <nav class="navbar">
                                <div class="container-fluid">
                                    <div class="navbar-collapse collapse show" id="navbar_links_form_content">
                                        <div class="row g-3">
                                            @foreach ($navbar->navbarLinks as $index => $navbar_link)
                                                <div class="col-sm-6 col-lg-4">
                                                    <label><b>{{ __('Link'). ' ' .$loop->iteration }}*</b></label>
                                                    <input type="text" name="navbar_links[{{$index}}][text]" class="form-control" placeholder="{{$navbar_link->text}}" value="{{ $navbar_link->text }}">
                                                    <span class="text-danger validation-errors" id="navbar_links.{{$index}}.text"></span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 d-grid gap-2 d-sm-flex justify-content-sm-center">
                <button type="submit" id="submit_button" class="btn custom-button text-uppercase">{{ __('Update') }}</button>
                <a href="{{ route('admin_panel.navbars.index') }}" id="abort_button" class="btn custom-anchor text-uppercase">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>

</x-admin-app-layout>