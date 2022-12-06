@extends('layouts.app')
@section('custom_scripts')
<link href="{{ asset('site_assets_1/assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('site_assets_1/assets/date_flatpicker/flatpickr.min.css')}}">
<script src="{{ asset('site_assets_1/assets/date_flatpicker/flatpickr.js')}}"></script>
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/userbasic.w2fr4ha2.css')}}" rel="stylesheet">
<script  type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/typehead/typeahead.bundle.js') }}"></script>
<link href="{{asset('css/candidate_wzrd.css')}}" rel="stylesheet">

<!--icons fa -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@endsection
 
@section('content')

<section id="cndidate_wzrd">
    <div class="container">
        <div class="row">
            <div class="col-md-3 align-self-center text-center cndte_mbile">
                <img src="{{asset('images/candidate_left.png')}}" alt="">
            </div>

            <div class="col-md-6">
                <div class="card lgncard1">
                    <div class="site2_logo mb-4 mt-2 text-center">
                        <a href="{{url('/')}}" class="href">
                            <img src="{{asset('images/footer_logo.png')}}" alt="logo">
                        </a>
                        <h1 class="fw-bolder mt-3">
                            OTP Verification
                        </h1>
                        <p class="grytxtv pdngtxt">An OTP was sent to the given mobile number. Enter it below.</p>
                    </div>

                    <div class="text-center mb-5">
                        <h2>+91 123456789 &nbsp;&nbsp;<i class="fa fa-edit cursor-pointer text-primary"></i></h2>
                    </div>

                    <div class="container">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Received OTP</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <small id="emailHelp" class="form-text"></small>
                        </div>
                        <div class="mt-5 mb-5">
                            <span class="restnt">Resend OTP <span class="text-primary">23s</span></span>
                        </div>
                        <div class="mb-5 mx-5 cdt_crtect">
                            <button class="btn form-control text-center text-white">create account</button>
                        </div>
                    </div>
                </div> 
            </div>   
                       
            <div class="col-md-3 align-self-center text-center cndte_mbile">
                <img src="{{asset('images/candidate_right.png')}}" alt="">
            </div>
        </div>
    </div>
</section>

@endsection