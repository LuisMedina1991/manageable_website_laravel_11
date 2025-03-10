<x-admin-app-layout>

    @section('title', __('Edit'). ' ' .$page_title)

    <div class="widget">
        <div class="widget-heading">
            <span class="widget-heading-text">
                <b>{{ __('Edit'). ' ' .$page_title }}</b>
            </span>
        </div>
        <form action="{{ route('admin_panel.users.update',$user) }}" method="POST" id="users_form">
            @csrf
            @method('put')
            <div class="row g-3">
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Name') }}*</b></label>
                    <input type="text" name="name" class="form-control" placeholder="{{$user->name}}" value="{{ $user->name }}">
                    <span class="text-danger validation-errors" id="name"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Email') }}*</b></label>
                    <input type="text" name="email" class="form-control" placeholder="{{$user->email}}" value="{{ $user->email }}">
                    <span class="text-danger validation-errors" id="email"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Change Password') }}*</b></label>
                    <select class="form-select" name="password_options" id="update_password_select">
                        <option value="select">{{ __('Select an option') }}</option>
                        <option value="0">{{ __('No') }}</option>
                        <option value="1">{{ __('Yes') }}</option>
                    </select>
                    <span class="text-danger validation-errors" id="password_options"></span>
                </div>
                <div class="col-sm-6 col-lg-4 d-none" id="password_container">
                    <label><b>{{ __('New Password') }}*</b></label>
                    <input type="text" name="password" class="form-control" placeholder="{{ __('New password for registration...') }}">
                    <span class="text-danger validation-errors" id="password"></span>
                </div>
                <div class="col-sm-6 col-lg-4 d-none" id="password_confirmation_container">
                    <label><b>{{ __('Confirm Password') }}*</b></label>
                    <input type="text" name="password_confirmation" class="form-control" placeholder="{{ __('Enter the password again...') }}">
                    <span class="text-danger validation-errors" id="password_confirmation"></span>
                </div>
            </div>
            <div class="mt-4 d-grid gap-2 d-sm-flex justify-content-sm-center">
                <button type="submit" id="submit_button" class="btn custom-button text-uppercase">{{ __('Update') }}</button>
                <a href="{{ route('admin_panel.users.index') }}" id="abort_button" class="btn custom-anchor text-uppercase">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>

</x-admin-app-layout>