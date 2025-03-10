<x-admin-app-layout>

    @section('title',__('Admin Panel'))

    <div class="widget">
        <div class="d-flex flex-column align-items-center justify-content-center">
            <h1 class="text-uppercase text-center">
                <b>{{ __('Welcome to your Administration Panel') }}</b>
            </h1>
            <h3 class="text-uppercase text-center">
                <b>{{ __('Use our customization system and bring your website to life') }}</b>
            </h3>
            <h5 class="text-uppercase text-center">
                <b>{{ __('if you notice a malfunction, please contact support staff or the system administrator') }}</b>
            </h5>
        </div>
    </div>
    
</x-admin-app-layout>