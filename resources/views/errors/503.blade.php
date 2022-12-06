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
                <h2>{{__('Service Unavailable')}}</h2>
                <p>{{__('Be right back.')}}</p>
            </div>      
        </div>
    </div>  
</section>
@include('layouts.footer')
@endsection