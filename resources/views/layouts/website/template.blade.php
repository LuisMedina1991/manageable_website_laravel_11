@extends('layouts.main_web')

@section('content')

        {{--header template inclusion--}}
        @include('layouts.website.partials.header')
    
        {{--navbar template inclusion--}}
        @include('layouts.website.partials.navbar')
    
        {{--carousel_images template inclusion--}}
        @include('layouts.website.partials.carousel_images')
    
        {{--first_section template inclusion--}}
        @include('layouts.website.partials.first_section')
    
        {{--second_section template inclusion--}}
        @include('layouts.website.partials.second_section')
    
        {{--third_section template inclusion--}}
        @include('layouts.website.partials.third_section')
    
        {{--footer template inclusion--}}
        @include('layouts.website.partials.footer')

@endsection