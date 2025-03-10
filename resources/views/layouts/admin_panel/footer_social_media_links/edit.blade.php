<x-admin-app-layout>

    @section('title', __('Edit'). ' ' .$page_title)

    <div class="widget">
        <div class="widget-heading">
            <span class="widget-heading-text">
                <b>{{ __('Edit'). ' ' .$page_title }}</b>
            </span>
        </div>
        <form action="{{ route('admin_panel.footer_social_media_links.update',$footer_social_media_link) }}" method="POST" id="footer_social_media_links_form">
            @csrf
            @method('put')
            <div class="row g-3">
                <div class="col-xl-6">
                    <label><b>Url*</b></label>
                    <input type="text" name="url" class="form-control" placeholder="{{$footer_social_media_link->url}}" value="{{ $footer_social_media_link->url }}">
                    <span class="text-danger validation-errors" id="url"></span>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <label><b>{{ __('Assign to Web') }}*</b></label>
                    <select class="form-select" name="is_selected" id="assign_record_select">
                        <option value="select">{{ __('Select an option') }}</option>
                        <option value="0" @selected($footer_social_media_link->is_selected == '0')>{{ __('No') }}</option>
                        <option value="1" @selected($footer_social_media_link->is_selected == '1')>{{ __('Yes') }}</option>
                    </select>
                    <span class="text-danger validation-errors" id="is_selected"></span>
                </div>
                <div class="col-sm-6 col-xl-3 {{ !$footer_social_media_link->is_selected ? 'd-none' : '' }}" id="positions_container">
                    <label><b>{{ __('Assign Position') }}*</b></label>
                    <select class="form-select" name="position" id="assign_position_select">
                        <option value="select">{{ __('Select an option') }}</option>
                        @foreach ($available_positions as $available_position)
                            <option value="{{ $available_position['position'] }}" @selected($footer_social_media_link->position == $available_position['position'])>
                                {{ $available_position['position'] }} {{ $available_position['message'] }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger validation-errors" id="position"></span>
                </div>
            </div>
            <div class="mt-4 d-grid gap-2 d-sm-flex justify-content-sm-center">
                <button type="submit" id="submit_button" class="btn custom-button text-uppercase">{{ __('Update') }}</button>
                <a href="{{ route('admin_panel.footer_social_media_links.index') }}" id="abort_button" class="btn custom-anchor text-uppercase">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>

</x-admin-app-layout>