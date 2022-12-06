@extends('layouts.app')


@section('content')
@include('layouts.header')
<!-- Header end --> 
<!-- Inner Page Title start -->
<!-- Inner Page Title end -->
<section class="gradient-custom pt-5">
    <!-- About -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{__('Page Expired')}}</h2>
                <p>{{__('The page has expired due to inactivity. Please refresh and try again.')}}</p>
            </div>      
        </div>
    </div>  
</section>
@include('layouts.footer')
@endsection