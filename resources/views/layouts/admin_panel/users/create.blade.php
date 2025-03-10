<x-admin-app-layout>

    @section('title', __('Create'). ' ' .$page_title)

    <div class="widget">
        <div class="widget-heading">
            <span class="widget-heading-text">
                <b>{{ __('Create'). ' ' .$page_title }}</b>
            </span>
        </div>
        <form action="{{ route('admin_panel.users.store') }}" method="POST" id="users_form">
            @csrf
            <div class="row g-3">
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Name') }}*</b></label>
                    <input autofocus type="text" name="name" class="form-control" placeholder="{{ __('Name for registration...') }}">
                    <span class="text-danger validation-errors" id="name"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Email') }}*</b></label>
                    <input type="text" name="email" class="form-control" placeholder="{{ __('Email for registration...') }}">
                    <span class="text-danger validation-errors" id="email"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Password') }}*</b></label>
                    <input type="text" name="password" class="form-control" placeholder="{{ __('Password for registration...') }}">
                    <span class="text-danger validation-errors" id="password"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Confirm Password') }}*</b></label>
                    <input type="text" name="password_confirmation" class="form-control" placeholder="{{ __('Enter the password again...') }}">
                    <span class="text-danger validation-errors" id="password_confirmation"></span>
                </div>
            </div>
            <div class="mt-4 d-grid gap-2 d-sm-flex justify-content-sm-center">
                <button type="submit" id="submit_button" class="btn custom-button text-uppercase">{{ __('Save') }}</button>
                <a href="{{ route('admin_panel.users.index') }}" id="abort_button" class="btn custom-anchor text-uppercase">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>

</x-admin-app-layout>