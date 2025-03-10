<x-admin-app-layout>

    @section('title', __('Edit'). ' ' .$page_title)

    <div class="widget">
        <div class="widget-heading">
            <span class="widget-heading-text">
                <b>{{ __('Edit'). ' ' .$page_title }}</b>
            </span>
        </div>
        <form action="{{ route('admin_panel.third_sections.update',$third_section) }}" method="POST" id="third_sections_form">
            @csrf
            @method('put')
            <div class="row g-3">
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Name') }}*</b></label>
                    <input type="text" name="name" class="form-control" placeholder="{{ $third_section->name }}" value="{{ $third_section->name }}">
                    <span class="text-danger validation-errors" id="name"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Background Color') }}*</b></label>
                    <select class="form-select" name="background_color_id">
                        <option value="select">{{ __('Select an option') }}</option>
                        @foreach ($background_colors as $background_color)
                            <option value="{{ $background_color->id }}" class="{{ $background_color->class }}" @selected($third_section->background_color_id == $background_color->id)>
                                {{ $background_color->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger validation-errors" id="background_color_id"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Edit Form') }}*</b></label>
                    <select class="form-select" name="third_section_contact_form_options" id="third_section_contact_form_select">
                        <option value="select">{{ __('Select an option') }}</option>
                        <option value="1">{{ __('No') }}</option>
                        <option value="0">{{ __('Yes') }}</option>
                    </select>
                    <span class="text-danger validation-errors" id="third_section_contact_form_options"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Assign to Web') }}*</b></label>
                    <select class="form-select" name="is_selected">
                        <option value="select">{{ __('Select an option') }}</option>
                        <option value="0" @selected($third_section->is_selected == '0')>{{ __('No') }}</option>
                        <option value="1" @selected($third_section->is_selected == '1')>{{ __('Yes') }}</option>
                    </select>
                    <span class="text-danger validation-errors" id="is_selected"></span>
                </div>
                <div class="col-12 d-none" id="third_section_contact_form">
                    <div class="card">
                        <div class="card-header text-center">
                            <span><b>{{ __('Edit Form') }}</b></span>
                            <button class="btn custom-button" type="button" data-bs-toggle="collapse" data-bs-target="#third_section_contact_form_content" aria-controls="third_section_contact_form_content" aria-expanded="true" aria-label="Toggle navigation">
                                <i class="fa-solid fa-square-caret-down"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <nav class="navbar">
                                <div class="container-fluid">
                                    <div class="navbar-collapse collapse show" id="third_section_contact_form_content">
                                        <div class="row g-3">
                                            <div class="col-sm-6 col-lg-4">
                                                <label><b>{{ __('Title') }}*</b></label>
                                                <input type="text" name="third_section_contact_form_title" class="form-control" placeholder="{{ $third_section->thirdSectionContactForm->title }}" value="{{ $third_section->thirdSectionContactForm->title }}">
                                                <span class="text-danger validation-errors" id="third_section_contact_form_title"></span>
                                            </div>
                                            @foreach ($labels as $index => $label)
                                                <div class="col-sm-6 col-lg-4">
                                                    <label><b>{{$label['title']}}*</b></label>
                                                    <input type="text" name="labels[{{$index}}][text]" class="form-control" placeholder="{{ $label['text'] }}" value="{{ $label['text'] }}">
                                                    <span class="text-danger validation-errors" id="labels.{{$index}}.text"></span>
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
                <a href="{{ route('admin_panel.third_sections.index') }}" id="abort_button" class="btn custom-anchor text-uppercase">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>

</x-admin-app-layout>