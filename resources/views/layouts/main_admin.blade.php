<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>@yield('title',__('Admin Panel'))</title>
        @include('layouts.assets.styles')
    </head>
    <body>
        <div class="main-flex-container">
            @include('layouts.admin_panel.partials.sidebar')
            <div class="main-sections">
                @include('layouts.admin_panel.partials.header')
                <main class="main-content">
                    {{ $slot }}
                </main>
                @include('layouts.admin_panel.partials.footer')
            </div>
        </div>
        {{--$translations property comes from render() method on app\View\Components\AdminAppLayout.php--}}
        <script>
            window._translations = {{ Js::from($translations) }};
        </script>
        @include('layouts.assets.scripts')
    </body>
</html>