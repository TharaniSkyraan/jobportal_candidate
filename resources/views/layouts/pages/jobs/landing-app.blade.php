<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    
    @include('layouts.meta')
    <!-- Favicons -->
    <link href="{{ asset('site_assets_1/favicon.ico')}}" rel="icon">
    <link href="{{ asset('site_assets_1/favicon.ico')}}" rel="apple-touch-icon">

    <!-- Main CSS File -->
    @include('layouts.style.styles')
    <link rel="stylesheet" href="{{asset('css/main_2.min.css')}}">
    <link href="{{ asset('site_assets_1/assets/4wuiq1Y2/css/hmewq1om.css') }}" rel="stylesheet">
    <link href="{{ asset('site_assets_1/assets/1a9ve2/css/chpg.er23fw.css')}}" rel="stylesheet">

    <!-- Vendor style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.8/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.8/slick-theme.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" rel="stylesheet" />
    

    @include('layouts.style.script')

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

    <!-- Vendor script -->
    <script type="text/javascript" src="{{ asset('site_assets_1/assets/1a9ve2/js/chpag.fquiv23.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" integrity="sha512-HWlJyU4ut5HkEj0QsK/IxBCY55n5ZpskyjVlAoV9Z7XQwwkqXoYdCIC93/htL3Gu5H3R4an/S0h2NXfbZk3g7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script rel="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.8/slick.min.js"></script>
</html>