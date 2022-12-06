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
                        Welcome
                    </h1>
                    <p class="grytxtv">Take your first step towards your Career</p>
                    </div>
                    <div class="container">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <small id="emailHelp" class="form-text"></small>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label">Your Phone number/ Email ID</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <small id="emailHelp" class="form-text"></small>
                        </div>

                        <div class="mb-3 mx-5">
                            <button class="btn form-control btn-primary subtbtn text-center text-white">Verify to create account</button>
                        </div>

                        <div class="row text-center mx-5 mt-4 mb-5">
                            <span class="text-center mb-3">or signup with</span>
                            <div class="col-md-4 col-sm-4 col-4 col-xs-4">
                                <a href="https://mugaam.com/signinorsignup/google" class="">
                                    <img src="{{asset('site_assets_1/assets/img/social_media/google.png')}}" width="40px">
                                </a>
                            </div>
                            <div class="col-md-4 col-sm-4 col-4 col-xs-4">
                                <a href="https://mugaam.com/signinorsignup/apple" class="">
                                    <img src="{{asset('site_assets_1/assets/img/social_media/apple.png')}}" width="40px">
                                </a>
                            </div> 
                            <div class="col-md-4 col-sm-4 col-4 col-xs-4">
                                <a href="https://mugaam.com/signinorsignup/facebook" class="">
                                    <img src="{{asset('site_assets_1/assets/img/social_media/fb.png')}}" width="40px">
                                </a>
                            </div>
                        </div>

                        <div class="mb-3 text-center">
                            <span>Already have a account? <a href="#" class="text-decoration-none">Login</a></span>
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