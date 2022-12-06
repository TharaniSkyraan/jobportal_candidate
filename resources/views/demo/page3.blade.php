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
                            Create Password
                        </h1>

                        <p class="grytxtv pdngtxt">Create password to login in next time. Or you also login with OTP each time</p>
                    </div>

                    <div class="container">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Password</label>
                            <input type="text" class="form-control" placeholder="Enter Your Password" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <small id="emailHelp" class="form-text"></small>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label">Confirm password</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Re enter to confirm your password" aria-describedby="emailHelp">
                            <small id="emailHelp" class="form-text"></small>
                        </div>

                        <div class="mb-5 mt-5 mx-5">
                            <button class="btn form-control subtbtn btn-primary text-center text-white">Save password</button>
                        </div>

                        <div class="mb-3 text-center">
                            <span>Skip for now</span>
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