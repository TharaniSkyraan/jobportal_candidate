@extends('layouts.pages.common_app')
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
                    <div class="site2_logo mb-1 mt-2 text-center">
                        <a href="{{url('/')}}" class="href">
                            <img draggable="false" src="{{asset('images/footer_logo.png')}}" alt="logo">
                        </a>
                        <h2 class="fw-bolder mt-3"> Welcome </h2>
                        <p class="grytxtv">Take your first step towards your Career</p>
                        @if(Session::has('error'))
                            <h4 class="text-danger clrerror"> <strong>Failed!</strong> {{ Session::get('error') }} <i class="fa fa-close clrerror cursor-pointer ms-2" onclick="event.preventDefault(); $('.clrerror').remove();"></i></h4>
                        @endif

                    </div>
                    <div class="container">
                        
                        <form class="mb-3" method="POST" id="submitform" action="{{ route('accountverification') }}" onsubmit='return validateLoginForm()' >
                            {{ csrf_field() }}
                            {!! Form::hidden('user_type','', array('id'=>'user_type')) !!}
                            
                            <div class="mb-3 text-center display-email" style="display:none;">
                                <h5>
                                    <text id="display-email">...</text> 
                                    <i class='fas fa-pencil-alt cursor-pointer edit-email p-2'></i>
                                </h5>       
                            </div>
                            <div class="mb-3 rtname" style="display:none;">
                                <label class="form-label">Your Name</label>
                                <input type="text" name="name" class="form-control" autofocus id="name" value="{{ old('name') }}" placeholder="{{__('Enter Your Name')}}" >
                                <small id="err_name" class="text-muted err_msg text-danger"></small>
                            </div> 
                            <div class="mb-3 rtemail">
                                <label class="form-label">Email Address </label>
                                <input type="text" name="email" class="form-control required_1" autofocus id="email" value="" placeholder="{{__('Enter Email Address')}}" >
                                <small id="err_email" class="text-muted err_msg text-danger"></small>
                            </div> 
                            <div class="mb-3 rtpassword" style="display:none;">
                                <label class="form-label">Password</label>
                                <div>
                                    <input class="form-control password" id="password" class="block mt-1 w-full" type="password" name="password" value="" placeholder="{{__('Enter Password')}}" />
                                    <span toggle="#password" id="showpico" class="far fa-fw fa-eye-slash field-icon toggle-password"></span>
                                </div>
                                <small id="err_password" class="text-muted err_msg text-danger"></small> 
                            </div>

                            <div class="d-grid gap-2">
                               <button class="btn form-control btn_c_s btn-primary text-center text-white" type="submit">Continue</button>
                            </div>
                        </form>
                        <div class="small text-center f-pass">
                            {{__('Forgot Your Password')}}?<a href="{{ route('password.request') }}"> <b> {{__('Click Here')}}</b></a>
                        </div>

                        <div class="row text-center mx-5 mt-4 mb-5">
                            <span class="text-center mb-3">or</span>
                            <div class="col-md-4 col-sm-4 col-4 col-xs-4">
                                <a href="{{ url('signinorsignup/google')}}" class=""><img draggable="false" src="{{ url('site_assets_1/assets/img/social_media/google.png')}}" width="40px"></a>
                            </div>
                            <div class="col-md-4 col-sm-4 col-4 col-xs-4">
                                <a href="{{ url('signinorsignup/apple')}}" class=""><img draggable="false" src="{{ url('site_assets_1/assets/img/social_media/apple.png')}}" width="40px"></a>
                            </div> 
                            <div class="col-md-4 col-sm-4 col-4 col-xs-4">
                                <a href="{{ url('signinorsignup/facebook')}}" class=""><img draggable="false" src="{{ url('site_assets_1/assets/img/social_media/fb.png')}}" width="40px"></a>
                            </div>
                        </div>

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
{{-- @include('layouts.footer.footer') --}}
<script>
    let baseurl = '{{ url("/") }}';
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/log&e7.re@3.js') }}"></script>
@endsection