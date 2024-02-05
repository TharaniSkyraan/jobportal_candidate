@extends('layouts.pages.common_app')


@section('custom_scripts')
  <link href="{{ asset('site_assets_1/assets/intl-tel-input/css/intlTelInput.css')}}" rel="stylesheet">
  <script src="{{ asset('site_assets_1/assets/intl-tel-input/js/intlTelInput.js')}}" ></script>
@endsection

@section('content')

@include('layouts.header.header')

<style>
  .navbar{
    display:none;
  } 
  .hide { display: none; }
  .mob_cp
  {
    padding-left: 85px;
    padding-right: 33px
  }
.iti__flag { display: none; }
.iti--separate-dial-code input[type=tel] {
    padding-left: 70px !important;
}
</style>
<style>
.field-icon {
  float: right;
    margin-left: -25px !important;
    margin-top: -27px;
    position: relative;
    z-index: 5;
    left: -3%;
}
.form-control.is-invalid, .was-validated .form-control:invalid {
    border-color: #dc3545;
    padding-right: calc(1.5em + 0.75rem);
    background-image: unset !important;
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}
.iti__flag { display: none; }
.iti--separate-dial-code input[type=tel] {
    padding-left: 70px !important;
}
</style>


<section class="gradient-custom">
  
  <div class="container py-5 h-100">
    <div class="d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-6 col-lg-6 col-xl-6">
        <div class="card" style="border-radius: 1rem;">
          <div class="card-body px-5 py-5">
          <div class="mb-3"> <span class="small"><a href="{{ route('login') }}"> <b> <i class="fa-solid fa-arrow-left-long"></i> {{__('Back to home')}}</b></a></span></div>
  
            <div class="">
              <div class="text-center mb-4">
              <h2 class="fw-bolder mb-2 text-blue-color">Welcome!!</h2>
              @if($is_exist=='yes')
              <div>
                  <p class="mb-2 small">Signing in as </p>
              </div>
              <div>
                  <b>{{$data->email}}</b>
              </div>
              @else
              <h4 class="fw-bold mb-2">Create your account</h4>
              <div>
                  <p class="mb-2 small">Signing up as</p>
              </div>
              <div>
                  <b>{{$data->email}}</b>
              </div>             
              @endif
              </div>

              <form class="" id="submitpassword" action="javascript:void(0)">
                {{ csrf_field() }}
                <input type="hidden" name="is_login" value="{{$is_login}}">
                <input type="hidden" name="account_type" id="account_type" value="{{$data->account_type}}">
                <input type="hidden" name="email" id="email" value="{{$data->email}}">
                <input type="hidden" name="provider" id="provider" value="{{$data->provider}}">

                <!-- Radio Button Employer/Candidate -->
                @if($is_login=='no' && $data->verified==0)
                  <div class="formField userType mb-4">
                    <div class="row radioWrap m-auto">
                      <div class="col-md-6 col-xs-12 col-sm-6 focusable mb-2 optionWrap @if($data->account_type=='candidate') selected @endif candidateWrap" tabindex="0" data-val="exp">
                        <i class="main-4 selectedTick fa-solid fa-circle-check"></i>
                        <div class="row">
                          <div class="col-md-3 col-xs-12 col-sm-3 iconWrap mb-2">
                            <i class="main-6 fa-solid fa-briefcase fa-2xl"></i>
                          </div>
                          <div class="col-md-9 col-xs-12 col-sm-9 textWrap">
                            <h2 class="main-3">Candidate</h2>
                            <p class="main-2">Canditate looking for jobs, May be freshers or experienced canditates</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 col-xs-12 col-sm-6 focusable mb-2 optionWrap @if($data->account_type=='employer') selected @endif employerWrap" tabindex="0" data-val="fresher">
                        <i class="main-4 selectedTick fa-solid fa-circle-check"></i>
                        <div class="row">
                          <div class="col-md-3 col-xs-12 col-sm-3 iconWrap mb-2">
                            <i class="main-6 fa-solid fa-building fa-2xl"></i>
                          </div>
                          <div class="col-md-9 col-xs-12 col-sm-9 textWrap">
                            <h2 class="main-3">Recruiter</h2>
                            <p class="main-2">Employers looking for canditates</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  @endif

                 
                  <!-- /End Radio Button Employer/Candidate -->   
                @if(empty($data->provider) || $data->verified==1)
                
                <div class="mb-4">
                  <label class="form-label fw-bold ">Password</label>
                  <div class=" {{ $errors->has('password') ? ' has-error' : '' }} ">
                      <input class="form-control password" id="password" class="block mt-1 w-full" type="password" name="password" value="{{ old('password') }}" placeholder="{{__('Enter Password')}}" />
                      <span toggle="#password" id="showpico" class="far fa-fw fa-eye-slash field-icon toggle-password"></span>
                  </div>
                  <span class="form-text text-danger err_msg password-error" id="err_password"></span> 
                </div>

                  @if($is_login=='no' && $data->verified==0)
                  <div class="mb-4">
                    <label class="form-label fw-bolder">Phone Number (Optional)</label>  
                    <div class="input-group">  
                      <input type="tel" class="form-control mob_cp validMob " pattern="/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/i"
                      name="phone" id="phone" placeholder="Enter Your Phone number">
                      {!! Form::hidden('full_number', null, array('id'=>'full_number')) !!}
                      <small id="err_phone" class="text-muted err_msg text-danger"></small>
                    </div>
                  </div>
                  @endif
                @endif   
                
                <div id="success">
                  {{-- @if($is_exist=='no' && empty($data->provider))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert-update">
                      <strong>Success!</strong>  Mail Send Successfully
                    </div>
                  @endif --}}
                </div>
                <div class="d-grid mt-5 mb-2">
                  <input type="button" onclick="submitPassword();" class="btn btn_c_s text-wrap submitpassword" value="{{$is_login == 'no' ? 'Continue' : 'Sign In'}}">
                </div>
                @if($is_login=='no' && $data->verified==0 && empty($data->provider))
                <div class="d-grid gap-2 mt-4">
                  <p class="small text-center">{{__('Resend')}} ?<a href="javascript:;"  onclick="resentMail();" > <b> {{__('Click Here')}}</b></a></p>
                </div>
                @endif   
              </form>
                @if($data->verified==1)
                  @if($data->account_type=='candidate')<div class="small text-center">{{__('Forgot Your Password')}}?<a href="{{ route('password.request') }}"> <b> {{__('Click Here')}}</b></a></div>
                  @else<div class="small pb-lg-2 text-center">{{__('Forgot Your Password')}}?<a href="{{ route('password.request') }}"> <b> {{__('Click Here')}}</b></a></div>
                  @endif
                @endif
                
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- verification modal start-->
<div class="modal fade" id="verification" tabindex="-1" aria-labelledby="fullpreviewpopup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        
            <div class="modal-body p-4">
                
                    <div class="mb-2 d-flex align-items-center justify-content-center">
                        <img draggable="false" src="{{ url('site_assets_1/assets/img/mail.png')}}" alt="error">
                    </div>
                    <div class="text-center">
                        <h5 class="m-auto">A verification mail has been sent to your email account.</h5>
                        <h5 class="m-auto">Please check your inbox to verify</h5>
                    </div>
                </div>
                
            </div>
        
        </div>
    </div>
</div>
@endsection
@section('footer')

@include('layouts.footer.footer')
<script>
    let baseurl = '{{ url("/") }}';
    let is_exist = '{{ $is_exist }}';
    let verified = '{{ $data->verified }}';
  @if(empty($data->provider) && $data->verified==0)

      var input = document.querySelector("#phone");
      var iti = window.intlTelInput(input, {
            // allowDropdown: false,
            // autoHideDialCode: true,
            // autoPlaceholder: "off",
            // dropdownContainer: document.body,
            // excludeCountries: ["us"],
            // formatOnDisplay: true,
            // // geoIpLookup: function(callback) {
            // //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
            // //     var countryCode = (resp && resp.country) ? resp.country : "";
            // //     callback(countryCode);
            // //   });
            // // },
            // hiddenInput: "full_number",
            // initialCountry: "auto",
            // localizedCountries: { 'de': 'Deutschland' },
            // nationalMode: false,
            // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
            // placeholderNumberType: "MOBILE",
            // preferredCountries: ['cn', 'jp'],
            separateDialCode: true,
            utilsScript: "{{ asset('site_assets_1/assets/intl-tel-input/js/utils.js')}}",
        });
        iti.setCountry("in");
    @endif
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/password.47ty(8.js') }}"></script>
@endsection