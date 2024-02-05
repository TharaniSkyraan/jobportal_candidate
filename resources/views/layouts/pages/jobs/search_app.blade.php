<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    
    @include('layouts.meta')

    <!-- Favicons -->
    <link href="{{ asset('site_assets_1/favicon.ico')}}" rel="icon">
    <link href="{{ asset('site_assets_1/favicon.ico')}}" rel="apple-touch-icon">
    
    <!-- Vendor CSS File -->    
    @include('layouts.style.styles')
    <link href="{{ asset('site_assets_1/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    
    <!-- Custom css file -->
    <link href="{{ asset('site_assets_1/assets/css/custom_style.css?v1') }}" rel="stylesheet">
    <link href="{{ asset('site_assets_1/assets/1a9ve2/css/filters.w2fr4ha2.css')}}" rel="stylesheet">    

    @include('layouts.style.script')

    <!-- Vendor JS Files -->
    <script  type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/typehead/typeahead.bundle.js') }}"></script>

</head>
<body>
    <div id="page-container">
        @yield('content')

        @yield('modals')
        
    </div>
    @include('layouts.footer.footer')
</body>
<!-- Custom JS File -->
@include('layouts.style.custom_script')
<script type="text/javascript" src="{{ asset('site_assets_1/assets/1a9ve2/js/filters.51e7k9a1.js?v=1.114333') }}"></script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/1a9ve2/js/sercpag.fquiv23.js') }}"></script>
</html>