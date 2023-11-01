@extends('layouts.app')
@section('custom_scripts')
<link href="{{ asset('css/candidate_wzrd.css') }}" rel="stylesheet">
@endsection

@section('content')

<section id="cndidate_wzrd">
    <div class="container">
        <div class="row">
            <div class="col-md-3 align-self-center text-center cndte_mbile">
                <img draggable="false" src="{{asset('images/candidate_left.png')}}" alt="">
            </div>
           
            <div class="col-md-6 card-size">
                <div class="card lgncard1">
                    <div class="site2_logo mb-3 mt-2 text-center">
                        <a href="{{url('/')}}" class="href">
                            <img draggable="false" src="{{asset('images/footer_logo.png')}}" alt="logo">
                        </a>
                        <h2 class="fw-bolder mt-3">
                            OTP Verification
                        </h2>
                        <p class="grytxtv pdngtxt">An OTP was sent to the given email id. Enter it below.</p>
                    </div>

                    <div class="text-center mb-3">
                        <h5 id="email">{{$user->email}}</h5>
                    </div>

                    <div class="container"> 
                        <form class="mb-3" method="POST" id="submitform" action="{{ route('verify_signup') }}" onsubmit='return validateLoginForm()' >
                           @csrf
                            <div class="mb-3">
                                <label for="otp" class="form-label">Received OTP</label>
                                <input type="text" placeholder="Enter OTP" class="form-control" id="otp" name   ="otp" aria-describedby="otp">
                                <small id="err_otp" class="text-muted err_msg text-danger"></small>
                            </div>
                            <div class="mt-3 mb-5">
                                <span class="text-danger error err_msg"></span>
                                <span class="restnt text-primary" id="restnt" style="display:none;"> <a href="javascript:;">Resend OTP</a></span>
                                <span class="restnt seconds-counter">Resend OTP <span class="text-primary" id="seconds-counter"> </span></span>
                            </div>
                            <div class="mb-5 cdt_crtect">
                                <button class="btn form-control btn_c_s btn-primary text-center text-white">Verify</button>
                            </div>
                        </form>
                    </div>
                </div> 
            </div>              
            <div class="col-md-3 align-self-center text-center cndte_mbile">
                <img draggable="false" src="{{asset('images/candidate_right.png')}}" alt="">
            </div>
        </div>
    </div>
</section>

@endsection
@section('footer')
{{-- @include('layouts.footer') --}}
<script>
    let baseurl = '{{ url("/") }}';
    $('#otp').on('input', function() {
        var inputValue = $(this).val();
        var digitsOnly = inputValue.replace(/\D/g, '');
        if (digitsOnly.length > 6) {
        digitsOnly = digitsOnly.slice(0, 6);
        }
        $(this).val(digitsOnly);
    });
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/verify&e7.re@34.js') }}"></script>
@endsection