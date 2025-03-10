<x-admin-app-layout>

    @section('title', __('Edit'). ' ' .$page_title)

    <div class="widget">
        <div class="widget-heading">
            <span class="widget-heading-text">
                <b>{{ __('Edit'). ' ' .$page_title }}</b>
            </span>
        </div>
        <form action="{{ route('admin_panel.headers.update',$header) }}" method="POST" id="headers_form">
            @csrf
            @method('put')
            <div class="row g-3">
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Name') }}*</b></label>
                    <input type="text" name="name" class="form-control" placeholder="{{ $header->name }}" value="{{ old('name',$header->name) }}">
                    <span class="text-danger validation-errors" id="name"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Link Number') }}*</b></label>
                    <input type="text" name="link_phone" class="form-control" placeholder="{{ $header->link_phone }}" value="{{ old('link_phone',$header->link_phone) }}">
                    <span class="text-danger validation-errors" id="link_phone"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Background Color') }}*</b></label>
                    <select class="form-select" name="background_color_id">
                        <option value="select">{{ __('Select an option') }}</option>
                        @foreach ($background_colors as $background_color)
                            <option value="{{ $background_color->id }}" class="{{ $background_color->class }}" @selected( old('background_color_id',$header->background_color_id) == $background_color->id )>
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
                            <option value="{{ $text_color->id }}" class="{{ $text_color->class }}" @selected( old('text_color_id',$header->text_color_id) == $text_color->id )>
                                {{ $text_color->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger validation-errors" id="text_color_id"></span>
                </div>
                <div class="col-lg-8">
                    <label><b>{{ __('Link Text') }}*</b></label>
                    <input type="text" name="link_text" class="form-control" placeholder="{{ $header->link_text }}" value="{{ old('link_text',$header->link_text) }}">
                    <span class="text-danger validation-errors" id="link_text"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Assign to Web') }}*</b></label>
                    <select class="form-select" name="is_selected">
                        <option value="select">{{ __('Select an option') }}</option>
                        <option value="0" @selected(old('is_selected',$header->is_selected) == '0')>{{ __('No') }}</option>
                        <option value="1" @selected(old('is_selected',$header->is_selected) == '1')>{{ __('Yes') }}</option>
                    </select>
                    <span class="text-danger validation-errors" id="is_selected"></span>
                </div>
            </div>

            <div class="mt-4 d-grid gap-2 d-sm-flex justify-content-sm-center">
                <button type="submit" id="submit_button" class="btn custom-button text-uppercase">{{ __('Update') }}</button>
                <a href="{{ route('admin_panel.headers.index') }}" id="abort_button" class="btn custom-anchor text-uppercase">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
    
</x-admin-app-layout>