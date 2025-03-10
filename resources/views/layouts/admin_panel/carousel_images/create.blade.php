<x-admin-app-layout>

    @section('title', __('Create'). ' ' .$page_title)

    <div class="widget">
        <div class="widget-heading">
            <span class="widget-heading-text">
                <b>{{  __('Create'). ' ' .$page_title }}</b>
            </span>
        </div>
        <form action="{{ route('admin_panel.carousel_images.store') }}" method="POST" id="carousel_images_form">
            @csrf
            <div class="row g-3">
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Name') }}*</b></label>
                    <input autofocus type="text" name="name" class="form-control" placeholder="{{ __('Name for registration...') }}">
                    <span class="text-danger validation-errors" id="name"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Text') }}</b></label>
                    <input type="text" name="text" class="form-control" placeholder="{{ __('Text for image...') }}">
                    <span class="text-danger validation-errors" id="text"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Assign to Web') }}*</b></label>
                    <select class="form-select" name="is_selected" id="assign_record_select">
                        <option value="select">{{ __('Select an option') }}</option>
                        <option value="0">{{ __('No') }}</option>
                        <option value="1">{{ __('Yes') }}</option>
                    </select>
                    <span class="text-danger validation-errors" id="is_selected"></span>
                </div>
                <div class="col-sm-6 col-lg-4 d-none" id="positions_container">
                    <label><b>{{ __('Assign Position') }}*</b></label>
                    <select class="form-select" name="position" id="assign_position_select">
                        <option value="select">{{ __('Select an option') }}</option>
                        @foreach ($available_positions as $available_position)
                            <option value="{{ $available_position['position'] }}">
                                {{ $available_position['position'] }} {{ $available_position['message'] }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger validation-errors" id="position"></span>
                </div>
                <div class="col-lg-8">
                    <label><b>{{ __('Image for Registration') }}*</b></label>
                    <input type="file" id="file_input" name="image" class="form-control" accept="image/x-png,image/jpeg">
                    <span class="text-danger validation-errors" id="image"></span>
                </div>
                <div class="col-12 text-center">
                    <label><b>{{ __('Image Preview') }}</b></label>
                    <div id="image_preview_container" class="overflow-x-hidden"></div>
                </div>
            </div>
            <div class="mt-4 d-grid gap-2 d-sm-flex justify-content-sm-center">
                <button type="submit" id="submit_button" class="btn custom-button text-uppercase">{{ __('Save') }}</button>
                <a href="{{ route('admin_panel.carousel_images.index') }}" id="abort_button" class="btn custom-anchor text-uppercase">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>

</x-admin-app-layout>