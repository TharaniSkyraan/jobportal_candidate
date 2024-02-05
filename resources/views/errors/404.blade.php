@extends('layouts.pages.common_app')


@section('content')
{{-- @include('layouts.header.header') --}}
<!-- Header end --> 

<section class="gradient-custom pt-5">
    <div class="container-xxl container-p-y">
    <div class="text-center misc-wrapper">
        <h2 class="mb-2 mx-2">Page Not Found</h2>
        <p class="mb-4 mx-2">
        Sorry, The requested URL was not found on this server.
        </p>
        <a href="{{ route('index') }}" class="btn btn-primary">Back to home</a>
        <div class="mt-5">
        <img draggable="false" src="{{ url('site_assets_1/assets/images/template/404.svg') }}" alt="img-404-bg" width="500" class="img-fluid" rel="nofollow,noindex">
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
{{-- @include('layouts.footer.footer') --}}
@endsection