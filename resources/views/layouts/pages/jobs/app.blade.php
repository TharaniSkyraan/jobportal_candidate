<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    
    @include('layouts.meta')

    <!-- Favicons -->
    <link href="{{ asset('site_assets_1/favicon.ico')}}" rel="icon">
    <link href="{{ asset('site_assets_1/favicon.ico')}}" rel="apple-touch-icon">

    <!-- Vendor CSS Files -->
    @include('layouts.style.styles')
    
    @include('layouts.style.script')

    @yield('custom_styles')
</head>
<body>
    <div id="page-container">
        @yield('content')

        @yield('modals')
        
        @yield('custom_scripts')
    </div>
    @include('layouts.footer.footer')
</body>
    @include('layouts.style.custom_script')
</html>