
<link rel="shortcut icon" type="image/x-icon" href="{{ asset(get_option('general')['favicon'] ?? 'assets/images/logo/favicon.png')}}">
<!-- Bootstrap -->
{{-- @if(session('direction') === 'rtl')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
@else
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
@endif --}}
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

<!-- Fontawesome -->
<link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome/css/fontawesome-all.min.css') }}">
{{-- jquery-confirm --}}
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}">
<!-- Lily -->
<link rel="stylesheet" href="{{ asset('assets/css/lity.css') }}">
<!-- Style -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/colors/default.color.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<!-- Toaster -->
<link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
@stack('css')

