@extends('layouts.app')

@section('custom_scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
<link href="{{ asset('site_assets_1/assets/intl-tel-input/css/intlTelInput.css')}}" rel="stylesheet">
<script src="{{ asset('site_assets_1/assets/intl-tel-input/js/intlTelInput.js')}}" ></script>
<link href="{{ asset('css/account_settings.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="wrapper" >        
	@include('layouts.dashboard_header')
	@include('layouts.side_navbar')

	<div class="main-panel main-panel-custom main-panel-customize">
		<div class="content">
			<div class="page-header">
				<h4 class="page-title"></h4>
			</div>
			<div class="page-inner">
				<div class="row">
					<div class="col-md-12 col-lg-10">
						<div class="card mb-3 acc-set">
              <div class="text-center card-title">
                <h2 class="fw-bolder p-3 mb-0 border-bottom" >Accounts Settings</h2>
              </div>
							<div class="card-body mt-2">
								<div class="row">
									<div class="col-md-3">
										<!-- <div class="text-center">
											<div class="position-relative d-inline-block mb-4">
												
												<img draggable="false" src="{{ url('site_assets_1/assets/img/default_profile.jpg')}}" alt="Img" class="border border-dark avatar-img rounded-circle" style="width: 40%;" id="profileImage">
												<i class="fa-solid fa-pen-to-square edit-profile" onclick="openModal();"></i> -->
												<!-- <label for="file-input">
													<i class="fa-solid fa-camera profile-camera fa-xs position-absolute" style="top:74%; left:60%"></i>
												</label>
												<input type="file" name="image" id="file-input" required style="display:none"> -->

											<!-- </div>
										</div> -->
										<div class="profilepic m-auto cursor-pointer">
											@if( Auth::check() && Auth::user()->image !=null )
                      
											<img draggable="false" src="{{Auth::user()->image}}" alt="Img" class="profilepic__image w-100 h-100" id="profileImage">
											@else  
											<img draggable="false" src="{{ url('site_assets_1/assets/img/default_profile.jpg')}}" alt="Img" class="profilepic__image w-100 h-100" id="profileImage">
											@endif
										<!-- <img draggable="false" class="profilepic__image w-100" src="{{ url('site_assets_1/assets/img/default_profile.jpg')}}" alt="Profibild" /> -->
											<div class="profilepic__content" onclick="openModal();">
												<span class="profilepic__icon"><i class="fas fa-camera"></i></span>
												<span class="profilepic__text">Edit Profile</span>
											</div>
										</div>
									</div>
									<div class="col-lg-8 col-md-9">
										

										<div class="mb-4">
                      <div class="row">
                        <div class="col-md-6 col-sm-8 col-xs-6 col-8">
                          <label for="" class="form-label fw-bolder">Email
                          </label>
                        </div>
                          <div class="col-md-6 col-sm-4 col-xs-6 col-4 text-center">
                            <img draggable="false" class="align-self-center align-top" src="{{ url('site_assets_1/assets/img/check-mark.png')}}" height="20px" width="20px">
                          </div>
                      </div>
                        
                      <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                          <div class="d-flex">
                            <text class="align-self-center width overflow-auto">{{ Auth::user()->email }} </text>
                          </div>
                        </div>
                      </div>
										</div>

										<div class="mb-4">
                      <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 col-xs-6 col-8">
                          <label for="" class="form-label fw-bolder">Phone Number
                          </label>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 col-xs-6 col-4 text-center">
                          @if(Auth::user()->is_mobile_verified=='yes')
                          <img draggable="false" class="align-self-center align-top" src="{{ url('site_assets_1/assets/img/check-mark.png')}}" height="20px" width="20px"> 
                          @endif
                        </div>
                      </div>
                      <div class="row align-items-center current_phone_number">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 col-xs-6 col-7">
                          <text class=" align-self-center">{{Auth::user()->phone ?? 'None'}}
                          </text>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 col-xs-6 col-4">
                          <div class="text-center">
                            @if(!empty(Auth::user()->phone))
                            <button class="btn rounded-pill align-self-center btns1 bg-color-blue" type="button" onclick="ChangePhoneNumber();">Change</button>
                            @else
                            <button class="btn rounded-pill align-self-center btns1 bg-color-blue" type="button" onclick="ChangePhoneNumber();">Add</button>
                            @endif
                          </div>
                        </div>
                      </div>

                      <div class="row" >
                        <div class="col-md-12 change_phone_number" style="display:none !important;">
                          <div class="row align-items-center">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6 col-10 mb-4">
                              {!! Form::tel('phone', Auth::user()->phone??null, array('class'=>'form-control mob_cp validMob width me-5','style'=>'line-height:0px', 'id'=>'phone', 'onkeypress'=> 'return isNumber(event)', 'minlength'=>'9', 'maxlength'=>'14', 'placeholder'=>__('Phone'))) !!}
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-2 col-3">
                              <button class="btn btn-verify rounded-pill align-self-center btns1 btn-sm" type="button" onclick="ChangePhoneNumberRequest();">Verify</button>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-2 mx-3 col-3">
                                  <button class="btn rounded-pill align-self-center btn-sm btns1 bg-color-blue" type="button" onclick="CurrentPhoneNumber();">Cancel</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <small class="form-text text-muted text-danger err_msg change_phone_number" id="err_phone"></small>
										</div>
                    
										<div class="mb-4 align-items-center">
                      <label for="" class="form-label fw-bolder">Password</label>	
                      <div class="row align-items-center">	
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 col-xs-6 col-7">  
                            <small class="width me-5">**********</small>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 col-xs-6 text-center col-4">
                          <button class="btn rounded-pill align-self-center btn-sm bg-color-blue btns1" type="button" onclick="ChangePassword();">Change</button>                      
                        </div>
                      </div>
										</div>										
									</div>
								</div>
						
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

  <!-- Button trigger modal -->
  <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog  modal-dialog-centered ">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title fw-bolder">Profile picture</h4>
          <button type="button" class="close border-0" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa fa-close"></i>
          </button>
        </div>

				<div class="modal-body">
					<div class="text-center reset-modal">
						<div class="text-center">
							<small class="form-text text-muted text-danger err_msg  mb-4" id="err_image"></small>
						</div>
						<div class="profilepic-modal m-auto mb-4">
							@if(Auth::user()->image !=null )
							<img draggable="false" src="{{Auth::user()->image}}" alt="Img" class="profilepic__image w-100 h-100" id="profileImage">
							@else  
							<img draggable="false" src="{{ url('site_assets_1/assets/img/default_profile.jpg')}}" alt="Img" class="profilepic__image w-100 h-100" id="profileImage">
							@endif
						</div>
						<div id="preview-crop-image"></div>
						<div id="upload-demo" style="display:none"></div>
						<input type="file" id="choose-profile-pic" accept="image/*" style="display:none">
						<small class="form-text text-muted text-danger err_msg" id="err_image"></small>
						<label class="btn btn-secondary btn-block text-white upload-image-label" for="choose-profile-pic" >Upload Image</label>
						<button class="btn btn-success btn-block btn-upload-image" style="display:none">save</button>
						<button class="btn btn-primary btn-block loading" type="button" disabled style="display:none">
							<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
							Uploading...
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- CHnage Password -->
	<div class="modal fade" id="ChangePassword" tabindex="-1" aria-labelledby="ChangePasswordLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="modal-header">
					<h4 class="modal-title fw-bolder">Change Password</h4>
				
          <button type="button" class="close border-0" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa fa-close"></i>
          </button>
          {{-- <button type="button" class="btn-close profilemodalclose" data-bs-dismiss="modal" aria-label="Close"></button> --}}
				</div>
          
        <div class="modal-body">
          <div class="m-auto mx-3 mt-1">
            {!! Form::model(Auth::user(), array('method' => 'post', 'route' => array('change-password'), 'id' => 'change-password')) !!}
              <div class="mb-2">
                <label for="" class="form-label fw-bolder">Enter Old password</label>
                <input type="password" name="old_password" id="old_password" class="form-control password" placeholder="Enter your old password">
                <small class="form-text text-muted text-danger err_msg" id="err_old_password"></small>
                <div class="text-end">
                  <a href="{{ route('password.request') }}" target="_blank"> <b><small>{{__('Forgot Password ?')}}</small></b></a>
                </div>
              </div>

              <div class="mb-2">
                  <label for="" class="form-label fw-bolder">Enter New password</label>
                  <input type="password" name="password" id="password" class="form-control password" placeholder="Enter your new password">
                  <small class="form-text text-muted text-danger err_msg" id="err_password"></small>
              </div>

              <div class="mb-2">
                  <label for="" class="form-label fw-bolder">Confirm password</label>
                  <input type="password" name="confirm_password" id="confirm_password" class="form-control password" placeholder="Enter your confirm password">
                  <small class="form-text text-muted text-danger err_msg" id="err_confirm_password"></small>
              </div>

              <div class="mb-2">
                <label class="form-check-label cursor-pointer user-select-none" for="show_p_chk">
                  <input class="form-check-input" type="checkbox" id="show_p_chk" value="" onclick="showpwd()">
                  <span class="form-check-sign" for="show_p_chk">Show Password</span>
                </label>
              </div>

              <div class="d-flex justify-content-around mt-3">
                  <!-- <div class="text-center">
                      <button class="btn bg-grey-color" onclick ='window.location.href=document.referrer' type="button">Cancel</button>
                  </div> -->
                  <div class="text-center">
                      <button class="btn btn-submit btn_c_s" type="button" onClick="SubmitPasswordChange()">Submit</button>
                  </div>
              </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>

	<!-- CHnage Password -->
	<div class="modal fade" id="changephone" tabindex="-1" aria-labelledby="changephoneLabel" aria-hidden="true">
      <div class="modal-dialog  modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header" style="border-bottom:unset !important">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="m-auto" style="width:70%">
              {!! Form::model(Auth::user(), array('method' => 'post', 'route' => array('verify-otp'), 'id' => 'verify-otp')) !!}
                <div class="text-center">
                  <h2 class="text-green-color">
                    You have changed your phone number 
                  </h2>
                  <h5>Verify by providing the received OTP</h5>
                  <h5>An OTP was sent to the Email provided</h5>
                  {{-- {!! Form::hidden('otp_code', null, array('id'=>'otp_code', 'class'=>'otp')) !!} --}}
                  {!! Form::hidden('full_number', null, array('id'=>'full_number', 'class'=>'otp')) !!}
                  <div id="otp-holder text-center">
                    <div id="otp-content">
                      <input id="otp_code" name="otp_code" type="tel" maxlength="6" pattern="\d{6}" value="" autocomplete="off"/>
                    </div>
                  </div>
                  <small class="form-text text-muted text-danger err_msg" id="err_otp_code"></small> 

                </div>
                <div class="text-center mt-2">
                  <button class="btn btn-submit btn_c_s verify" type="button"  onClick="VerifyPasswordChange()">verify</button>
                </div>
              {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('custom_bottom_scripts')
@endsection

@push('scripts')

<!-- otp starts -->
<script>
document.addEventListener("DOMContentLoaded", function(event) {
  
  function OTPInput() {
    const inputs = document.querySelectorAll('#otp > *[id]');
    for (let i = 0; i < inputs.length; i++) { 
      inputs[i].addEventListener('keydown', function(event) { 
        if (event.key==="Backspace" ) { 
          inputs[i].value='' ; 
          if (i !==0) inputs[i - 1].focus(); 
        } else { 
          if (i===inputs.length - 1 && inputs[i].value !=='' ) { 
            return true; 
          } else if (event.keyCode> 47 && event.keyCode < 58) { 
            inputs[i].value=event.key; 
            if (i !==inputs.length - 1) inputs[i + 1].focus(); event.preventDefault(); 
          } else if (event.keyCode> 64 && event.keyCode < 91) { 
            inputs[i].value=String.fromCharCode(event.keyCode); 
            if (i !==inputs.length - 1) inputs[i + 1].focus(); event.preventDefault(); 
          } 
        } 
      }); 
    } 
  } 
  OTPInput(); 
});
</script>
<!-- otp ends -->


<script type="text/javascript">

var resize = $('#upload-demo').croppie({
    enableExif: true,
    enableOrientation: true,    
    viewport: { // Default { width: 100, height: 100, type: 'square' } 
        width: 200,
        height: 200,
        type: 'square' //square
    },
    boundary: {
        width: 300,
        height: 300
    }
});
$('#choose-profile-pic').on('change', function () { 
	$("#upload-demo").show();
	$(".profilepic-modal").hide();
	$(".btn-upload-image").show();
	$(".upload-image-label").text('Replace image');
  	var reader = new FileReader();
    reader.onload = function (e) {
      resize.croppie('bind',{
        url: e.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
});
$('.btn-upload-image').on('click', function (ev) {
	$(".upload-image-label").hide();	
	$(".btn-upload-image").hide();
  $(".profilemodalclose").hide();
	$(".loading").show();
  resize.croppie('result', {
    type: 'canvas',
    size: 'viewport'
  }).then(function (img) {
    $.ajax({
      url: '{{ route("profile.update") }}',
      type: "POST",
	  contentType:'application/x-www-form-urlencoded; charset=UTF-8',
      data: {"image":img, "_token": "{{ csrf_token() }}"},
      success: function (data) {
		$('.err_msg').html('');
        location.reload();
      },
	  error: function(json){
		if (json.status === 422) {
			var resJSON = json.responseJSON;
			$('.err_msg').html('');
			$.each(resJSON.errors, function (key, value) {
			$('#err_image').html('<strong>' + value + '</strong>');
			});

		}
    }
    });
  });
});
</script>

<script>

  $(document.body).on('hidden.bs.modal', function () {
    $(".reset-modal" ).load(document.URL + ".reset-modal", "" );
  });

	function openModal(){
		$('#profileModal').modal('show');
	} 

	function ChangePassword(){
    clrErr();
    $("#change-password").trigger("reset");
    showpwd();
		$('#ChangePassword').modal('show');
	} 

  function ChangePhoneNumber(){
		$('.current_phone_number').attr("style", "display: none !important");
		$('.change_phone_number').show();
  }

  function CurrentPhoneNumber(){
    $(".current_phone_number").show();
		$('.change_phone_number').attr("style", "display: none !important");
  }

  var input = document.querySelector("#phone");
  var iti = window.intlTelInput(input, {
    separateDialCode: true,
    formatOnDisplay: false,
    utilsScript: "{{ asset('site_assets_1/assets/intl-tel-input/js/utils.js')}}",
  });
  @if(empty($user->phone))iti.setCountry("in");@endif
  $(document).on('keyup change', ".validMob", function() {
      
      var ck_phone = /^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/i;
      var fieldId = $(this).attr('id');
      var fieldVal = $(this).val();

      $('#'+fieldId).removeClass('is-invalid').removeClass('is-valid');
      // alert()
      if(fieldVal == ''){
        $('#'+fieldId).removeClass('is-invalid');
        clrErr();
      }
      
      if(fieldId.indexOf('phone') === -1) {  var checkEmail = false; }else{ var checkEmail = true; }
      if(checkEmail === true){
          if(!ck_phone.test(fieldVal)){
            setMsg(fieldId,'Please enter a valid phone number');
          } else {
            $('#'+fieldId).removeClass('is-invalid').addClass('is-valid');
            $(".err_msg").html('');
          }
      }
	});
	
  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        setMsg('phone ','Please enter a valid phone number.');
        return false;
    }

    $('#err_phone').hide();
    return true;
  }
	function ChangePhoneNumberRequest(){
    clrErr();
    var errStaus = false;
    var old_num = '{{ Auth::user()->phone }}';
    var verified = '{{ Auth::user()->is_mobile_verified }}';
    $("#full_number").val($('.iti__selected-dial-code').html()+String($("#phone").val()).replace(/ /g, ""));
    if(validateFormFields('phone','Please enter your phone number','')) errStaus=true;
    if(errStaus == false){
      var phone = $("#full_number").val();
      if(phone == old_num && verified=='yes')
      {  
        $("#phone").removeClass('is-valid').addClass('is-invalid');   
        $("#err_phone").html('Given number is already Existing.');
        return false;   
      }else
      {
        $("#phone").removeClass('is-invalid');
        $.ajax({
          url     : '{{ route("send-request")}}',
          type    : 'post',
          data    : {"phone": phone, "_token": "{{ csrf_token() }}"},
          dataType: 'json',
          success : function (json){  
            console.log(json);
            $('.err_msg').html('');  
            $('#changephone').modal('show');
            $("#otp_code").val('');
          },
          error: function(json){
            $('.err_msg').html('');   
            if (json.status === 422) {
              var resJSON = json.responseJSON;
              $.each(resJSON.errors, function (key, value) {     
                $('#err_' + key).html(value);               
              });
            }
          }
        });
      }
    }
  }
  function VerifyPasswordChange(){
     var errStaus = false;

     if(validateFormFields('otp_code','Please enter otp','')) errStaus=true;
     if(errStaus == false){
         if($('#otp_code').val().length < 6){
           $('#err_otp_code').html('Please Enter Valid otp');
           return false;
         }
       else{
        var phone = $("#full_number").val();
        var otp = $("#otp_code").val();        
         $.ajax({             
            url     : '{{ route("verify-otp")}}',
            type    : 'post',
            data    : {"phone": phone, "otp": otp, "_token": "{{ csrf_token() }}"},
            dataType: 'json',
            success : function (json){  
               $("#otp_code").val('');
               toastr.options.timeOut = 10000;
               toastr.success('Successfully Updated.');
               window.location = "{{ route('accounts_settings') }}";
             },
               error: function(json){
                 $('.err_msg').html('');  
                 if (json.status === 422) {
                     var resJSON = json.responseJSON;
                     $.each(resJSON.errors, function (key, value) {     
                       $('#err_otp_code').html(value);               
                     });
                 }

             }
         });
       }
     }
   }

	function SubmitPasswordChange(){
    clrErr();
    var errStaus = false;
    if(validateFormFields('old_password','Please enter your old password','')) errStaus=true;
    if(validateFormFields('password','Please enter your password','validPass')) errStaus=true;
    if(validateFormFields('confirm_password','Please enter confirm your password','validPass')) errStaus=true;
    if(errStaus == false){
      if( $("#password").val() != $("#confirm_password").val() ){
        $("#confirm_password").removeClass('is-valid').addClass('is-invalid');   
        $("#err_confirm_password").html('Passwords didn’t match. Try again.');
        return false;
      }
      else{
          $("#confirm_password","#password","#old_password").removeClass('is-invalid');
          var form = $('#change-password');   
          $.ajax({
              url     : form.attr('action'),
              type    : form.attr('method'),
              data    : form.serialize(),
              dataType: 'json',
              success : function (json){  
                // console.log(json);
                $('.err_msg').html('');  
                $('.password').val('');    
                  toastr.options.timeOut = 10000;
                  toastr.success('Password Changed');
              },
              error: function(json){
                    $('.err_msg').html('');   
                    if (json.status === 422) {
                        var resJSON = json.responseJSON;
                        $.each(resJSON.errors, function (key, value) {     
                          $('#err_' + key).html(value);               
                        });
                    }
                }
          });
      }
    }else{
      return false;
    }
  }
  function showpwd(){
    let old_pwd = $("#old_password");
      let pwd = $("#password");
      let cpwd = $("#confirm_password");
      if($("#show_p_chk").is(':checked') === true){
        old_pwd.attr("type", "text");
        pwd.attr("type", "text");
        cpwd.attr("type", "text");
      }else{
        old_pwd.attr("type", "password");
        pwd.attr("type", "password");
        cpwd.attr("type", "password");
      }
  }
  $('#otp_code').on('keypress', function(e) {
    var count = $(this).val().length;
    if(count==5){
      e.preventDefault();
      $(this).val($(this).val()+e.originalEvent.key)
    }if(count>5){
      e.preventDefault();      
    }
  });  
  $("#otp_code").bind("paste", function(e){
    var pastedData = e.originalEvent.clipboardData.getData('text');
      e.preventDefault();
      $(this).val(pastedData.slice(0,6));
  });
  </script>
@endpush
