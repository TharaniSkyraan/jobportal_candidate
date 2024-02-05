@extends('layouts.pages.common_app')

@section('content')

@include('layouts.header.header')
  <div class="main">
<section class="gradient-custom mt-5 mb-5">
    <div class="container-xxl container-p-y">
    <div class="text-center misc-wrapper">
        <h2 class="mb-2 mx-2"><img draggable="false" src="{{ url('site_assets_1/assets/img/Shortlist.png') }}" alt="img-verified-bg" width="25" class="img-fluid"> Email Verified Successfully</h2>
        {{-- <p class="mb-4 mx-2">Continue to Signup</p> --}}
        <div class="mt-5">
          <img draggable="false" src="{{ url('site_assets_1/assets/images/verified.jpg') }}" alt="img-404-bg" width="500" class="img-fluid" rel="nofollow,noindex">
        </div>
    </div>
    </div>
</section>
</div>

@endsection

@section('footer')
@include('layouts.footer.footer')
@endsection