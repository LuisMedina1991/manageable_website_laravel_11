<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', config('app.name', 'UrWebsite'))</title>

    <!--begin styles inclusion-->
    @include('layouts.assets.styles')
    <!--end styles inclusion-->
    
</head>
<body>
    
    <!--begin website content-->
    @yield('content')
    <!--end website content-->

    <!--begin scripts inclusion-->
    @include('layouts.assets.scripts')
    <!--end scripts inclusion-->

</body>
</html>