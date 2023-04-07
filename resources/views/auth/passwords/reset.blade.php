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
           
            <div class="col-md-6">
              <div class="card lgncard1">
                  <div class="site2_logo mb-4 mt-2 text-center">
                      <a href="{{url('/')}}" class="href">
                          <img src="{{asset('images/footer_logo.png')}}" alt="logo">
                      </a>
                      <h2 class="fw-bolder mt-3"> Reset Password </h2>
                      <p class="grytxtv">Enter the email associated with your account and we'll send you instructions to reset your password.</p>
                  </div>
                       
              
            
                  <div class="container">
                    <form class="mt-4 mb-3" method="POST" action="{{ route('password.request') }}" onsubmit="return changepwdform()">
                      {{ csrf_field() }}
                      <input type="hidden" name="token" value="{{ $token }}">
                      <input type="hidden" name="is_set_password" value="yes">
                        <div class="mb-4 {{ $errors->has('email') ? ' has-error' : '' }}">
                          <!--<label class="form-label fw-bold">Email Address </label>-->
                          <input id="email" type="hidden" class="form-control" name="email" value="{{ Auth::user()->email??$email }}">
                          @if ($errors->has('email'))
                          {{-- <span class="form-text text-danger"> --}}
                              <h4 class="text-danger fw-bold">{{ $errors->first('email') }}</h4>
                          {{-- </span> --}}
                          @endif
                        </div>
                        
                        <div class="mb-4 {{ $errors->has('password') ? ' has-error' : '' }}">
                          <label class="form-label fw-bold">{{__('Password')}}</label>
                          <input type="password" name="password" id="password" class="form-control required" value="{{ old('password') }}" placeholder="{{__('Enter Password')}}" >
                          @if ($errors->has('password'))
                          <span class="form-text text-danger err_msg" >
                              {{ $errors->first('password') }}
                          </span>
                          @endif
                          <span class="form-text text-danger err_msg" id="err_password"></span> 
                        </div>
                        
                        <div class="mb-3 {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                          <label class="form-label fw-bold">{{__('Confirm Password')}}</label>
                          <input type="password" name="password_confirmation" class="form-control required" id="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="{{__('Enter Confirm Password')}}" >
                          @if ($errors->has('password_confirmation'))
                          <span class="form-text text-danger err_msg" >
                            {{ $errors->first('password_confirmation') }}
                          </span>
                          @endif
                          <span class="form-text text-danger err_msg " id="err_password_confirmation"></span> 
                        </div>
                        <div class="mb-5">
                          <label class="form-check-label cursor-pointer user-select-none" for="show_p_chk">
                            <input class="form-check-input" type="checkbox" id="show_p_chk" value="">
                            <span class="form-check-sign" for="show_p_chk">Show Password</span>
                          </label>
                        </div>
                        
                        <div class="d-grid gap-2 ">
                          <input type="submit" class="btn btn_c_s" value="{{__('Submit')}}">
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
<script>
  $("#show_p_chk").on("click", function() {
    // e.preventDefault();
    let pwd = $("#password");
    let cpwd = $("#password_confirmation");
    if (pwd.attr("type") == "password" && cpwd.attr("type") == "password") {
      pwd.attr("type", "text");
      cpwd.attr("type", "text");
    } else {
      pwd.attr("type", "password");
      cpwd.attr("type", "password");
    }
  });
  function changepwdform(){
    clrErr();
    var errStaus = false;
    if(validateFormFields('password','Please enter your password','validPass')) errStaus=true;
    if(validateFormFields('password_confirmation','Please enter confirm your password','validPass')) errStaus=true;

    if(errStaus == false){

      if( $("#password").val() != $("#password_confirmation").val() ){
        $("#password_confirmation").removeClass('is-valid').addClass('is-invalid');   
        $("#err_password_confirmation").html('Passwords didn’t match. Try again.');
        return false;
      }
      else{
        return true;
      }
    }else{
      return false;
    }
  }
</script>
  
{{-- @include('layouts.footer') --}}
@endsection
