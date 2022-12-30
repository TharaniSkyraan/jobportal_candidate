@extends('layouts.app')
@section('custom_scripts')
<link href="{{ asset('css/candidate_wzrd.css') }}" rel="stylesheet">
@endsection

@section('content')

<section id="cndidate_wzrd">
    <div class="container">
        <div class="row">
            <div class="col-md-3 align-self-center text-center cndte_mbile">
                <img src="{{asset('images/candidate_left.png')}}" alt="">
            </div>
           
            <div class="col-md-6 card-size">
                <div class="card lgncard1">
                    <div class="site2_logo mb-4 mt-2 text-center">
                        <a href="{{url('/')}}" class="href">
                            <img src="{{asset('images/footer_logo.png')}}" alt="logo">
                        </a>
                        <h1 class="fw-bolder mt-3">
                            OTP Verification
                        </h1>
                        <p class="grytxtv pdngtxt">An OTP was sent to the given email id. Enter it below.</p>
                    </div>

                    <div class="text-center mb-5">
                        <h3 id="email">{{$user->email}}</h2>
                    </div>

                    <div class="container"> 
                        <form class="mb-3" method="POST" id="submitform" action="{{ route('verify_signup') }}" onsubmit='return validateLoginForm()' >
                           @csrf
                            <div class="mb-3">
                                <label for="otp" class="form-label">Received OTP</label>
                                <input type="text" class="form-control" id="otp" name   ="otp" aria-describedby="otp">
                                <small id="err_otp" class="text-muted err_msg text-danger"></small>
                            </div>
                            <div class="mt-3 mb-5">
                                <span class="text-danger error err_msg"></span>
                                <span class="restnt text-primary" id="restnt" style="display:none;"> <a href="javascript:;">Resend OTP</a></span>
                                <span class="restnt seconds-counter">Resend OTP <span class="text-primary" id="seconds-counter"> </span></span>
                            </div>
                            <div class="mb-5 cdt_crtect">
                                <button class="btn form-control subtbtn text-center text-white">Verify</button>
                            </div>
                        </form>
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
@section('footer')
{{-- @include('layouts.footer') --}}
<script>
    let baseurl = '{{ url("/") }}';
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/verify&e7.re@34.js') }}"></script>
@endsection