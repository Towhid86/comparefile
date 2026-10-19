<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="{{__('IE=edge')}}">
    <meta name="viewport" content="{{__('width=device-width, initial-scale=1.0')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@hasSection('title')
            @yield('title') |
        @endif{{ config('app.name') }}</title>
    @include('layouts.author.partials.css')
</head>

<body>
@yield('main_content')
@include('layouts.author.auth.partials.scripts')
</body>

</html>
