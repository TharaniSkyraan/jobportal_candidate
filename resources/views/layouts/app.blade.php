<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />        
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('layouts.meta')
    <!-- Favicons -->
    <link href="{{ asset('site_assets_1/favicon.ico')}}" rel="icon">
    <link href="{{ asset('site_assets_1/favicon.ico')}}" rel="apple-touch-icon">
    
    @include('layouts.styles')
    @include('layouts.top_scripts')
    
    @yield('custom_styles')



    @yield('custom_scripts')

</head>

<body>
    <div id="page-container">
    @yield('content')

    @include('layouts.scripts')

    @yield('modals')
    
    @yield('custom_bottom_scripts')
    
    @stack('scripts')
    </div>
    @yield('footer')
</body>
</html>