@extends('layouts.pages.common_app')
@section('custom_scripts')
<link href="{{ asset('css/candidate_wzrd.css') }}" rel="stylesheet">
@endsection
@section('title') Mugaam - Forget Password @endsection
@section('content')

<section id="cndidate_wzrd">
    <div class="container">
        <div class="row">
            <div class="col-md-3 align-self-center text-center cndte_mbile">
                <img draggable="false" src="{{asset('images/candidate_left.png')}}" alt="">
            </div>
           
            <div class="col-md-6 card-size">
                <div class="card lgncard1">
                  <div class="site2_logo mb-2 mt-2 text-center">
                      <a href="{{url('/')}}" class="href">
                          <img draggable="false" src="{{asset('images/footer_logo.png')}}" alt="logo">
                      </a>
                      <h2 class="fw-bolder mt-3"> Forget Password </h2>
                      <p class="grytxtv px-4">Enter the registered email address of your account to be recovered and receive instructions on password reset.</p>
                  </div>
                       
           
                  <div class="container">
                    <form class="mt-4 mb-3" method="POST" action="{{ route('password.email') }}" onsubmit='return validateResetPwdtForm()'>
                        {{ csrf_field() }}
                        <div class="mb-5 formrow{{ $errors->has('email') ? ' has-error' : '' }}">
                          <label class="form-label fw-bold">Email Address </label>
                          <input type="text" name="email" class="form-control required_1" id="email" autofocus value="{{ old('email') }}" placeholder="{{__('Enter Email Address')}}" >
                          @if ($errors->has('email'))
                          <span>
                              <small class="text-muted text-danger" >{{ $errors->first('email') }}</small>
                          </span>
                          @endif
                          <small id="err_email" class="text-muted err_msg text-danger"></small>
                        </div>
                        <div class="d-grid gap-2 mb-4">
                          <input type="submit" class="btn btn_c_s btn-primary  text-wrap" value="{{__('Send Password Reset Link')}}">
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
<script>

  @if(session('status'))
    swal("{{ session('status') }}");
  @endif
  $(document).on('keyup change', ".required_1", function() {
      
      var ck_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
      var fieldId = $(this).attr('id');
      var fieldVal = $(this).val();

      $('#'+fieldId).removeClass('is-invalid').removeClass('is-valid');

      if(fieldVal == ''){
        $('#'+fieldId).removeClass('is-invalid');
        clrErr();
      }
      
      if(fieldId.indexOf('email') === -1) {  var checkEmail = false; }else{ var checkEmail = true; }
      if(checkEmail === true){
          if(!ck_email.test(fieldVal)){
            setMsg(fieldId,'Please enter a valid email');
          } else {
            $('#'+fieldId).removeClass('is-invalid').addClass('is-valid');
            $(".err_msg").html('');
          }
      }
  });

  function validateResetPwdtForm() {
    clrErr();
    var errStaus = false;
    if(validateFormFields('email','Please enter your email address','validEmail')) errStaus=true;      
    if(errStaus == false){
      return true;
    }else{
      return false;
    }
  }

</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/log&e7.re@3.js') }}"></script>
@endsection