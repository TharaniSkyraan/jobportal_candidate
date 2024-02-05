@extends('layouts.pages.common_app')


@section('content')
@include('layouts.header.header')
<!-- Header end --> 
<!-- Inner Page Title start -->
<!-- Inner Page Title end -->
<section class="gradient-custom pt-5">
    <!-- About -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{__('Error')}}</h2>
                <p>{{__('Too many requests.')}}</p>
            </div>      
        </div>
    </div>  
</section>
@include('layouts.footer.footer')
@endsection
