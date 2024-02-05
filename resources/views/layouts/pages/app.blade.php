<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    
    @include('layouts.meta')
    <!-- Favicons -->
    <link href="{{ asset('site_assets_1/favicon.ico')}}" rel="icon">
    <link href="{{ asset('site_assets_1/favicon.ico')}}" rel="apple-touch-icon">

    <!-- Vendor CSS Files -->
    @include('layouts.style.styles')

    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{asset('css/main_2.min.css')}}">
    <link href="{{ asset('css/user_skill.min.css') }}" rel="stylesheet">

    @yield('custom_styles')
    @include('layouts.style.script')
    @yield('custom_scripts')
</head>

<body>
    <div id="page-container">
        @yield('content')
        @yield('modals')
        @yield('custom_bottom_scripts')
        @stack('scripts')
    </div>
    @yield('footer')
</body>
    @include('layouts.style.custom_script')
</html>