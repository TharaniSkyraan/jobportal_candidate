@extends('layouts.pages.common_app')


@section('content')
{{-- @include('layouts.header.header') --}}

<section class="gradient-custom pt-5">
    <div class="container-xxl container-p-y">
    <div class="text-center misc-wrapper">
        <h1 class="mb-2 mx-2 fw-bolder">Internal Server Error</h1>
        {{-- <h3 class="mb-2 mx-2">Internal Server Error</h3> --}}
        <p class="mb-4 mx-2">Something went wrong.<br>      
        The server encountered an error and could not complete your request.
        </p>
        <a href="{{ route('index') }}" class="btn btn-primary">Back to home</a>
        <div class="mt-5">
        <img draggable="false" src="{{ url('site_assets_1/assets/images/template/500.svg') }}" alt="img-500-bg" width="500" class="img-fluid" rel="nofollow,noindex">
        </div>
    </div>
    </div>
    {{-- <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{__('Page Not Found')}}</h2>
                <p>{{__('Sorry, the page you are looking for could not be found')}}</p>
            </div>      
        </div>
    </div>   --}}
</section>
{{-- <section class="gradient-custom">
    <!-- About -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{__('Error')}}</h2>
                <p>{{__('Whoops, looks like something went wrong.')}}</p>
            </div>      
        </div>
    </div>  
</section> --}}
{{-- @include('layouts.footer.footer') --}}
@endsection