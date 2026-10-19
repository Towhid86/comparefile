<!DOCTYPE html>
<html lang="{{ app()->getLocale()?? 'en' }}" dir="{{ session('direction', 'ltr') }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="{{__('IE=edge')}}">
    <meta name="viewport" content="{{__('width=device-width, initial-scale=1.0')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@hasSection('title')
            @yield('title') |
        @endif {{ get_option('general')['title'] ?? config('app.name') }}</title>
    @include('layouts.author.partials.css')
</head>
<body  class="{{ session('direction', 'ltr') }}">

<!-- Side Bar Start -->
@include('layouts.author.partials.side-bar')
<!-- Side Bar End -->
<div class="section-container">
    <!-- header start -->
    @include('layouts.author.partials.header')
    <!-- header end -->
    <!-- erp-state-overview-section start -->
    @yield('main_content')
    <!-- erp-state-overview-section end -->
    @stack('modal')
</div>

@include('layouts.author.partials.script')
</body>
</html>
