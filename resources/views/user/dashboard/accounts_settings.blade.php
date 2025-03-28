@extends('layouts.pages.common_app')

@section('custom_scripts')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
  <link href="{{ asset('site_assets_1/assets/intl-tel-input/css/intlTelInput.css')}}" rel="stylesheet">
  <script src="{{ asset('site_assets_1/assets/intl-tel-input/js/intlTelInput.js')}}" ></script>
  <link href="{{ asset('css/account_settings.css') }}" rel="stylesheet">
@endsection
@section('title') Mugaam - Accounts Settings Page @endsection
@section('content')
<div class="wrapper" >        
	@include('layouts.header.auth.dashboard_header')
	@include('layouts.sidenavbar.side_navbar')

	<div class="main-panel main-panel-custom lkdprw">
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
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6 col-10">
                              {!! Form::tel('phone', Auth::user()->phone??null, array('class'=>'form-control mob_cp validMob width me-5','style'=>'line-height:0px', 'id'=>'phone', 'onkeypress'=> 'return isNumber(event)', 'minlength'=>'9', 'maxlength'=>'14', 'placeholder'=>__('Phone'))) !!}
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-2 col-3 mt-2">
                              <button class="btn btn-verify rounded-pill align-self-center btns1 btn-sm" type="button" onclick="ChangePhoneNumberRequest();">Verify</button>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-2 mx-3 col-3 mt-2">
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
                    <hr>
										<div class="mb-4">  
                      <div class="text-black dlttoggle" data-bs-toggle="collapse" href="#collapseExampledelete" role="button" aria-expanded="false" aria-controls="collapseExampledelete">
                        <span> Delete Acccount</span>
                        <span class="float-end"><i class="fa fa-angle-down dlt-toggle"></i></span>
                      </div>										
                      <div class="collapse collapses" id="collapseExampledelete">
                        <div class="mt-4">
                          <p><span class="px-4"></span>Delete Your Mugaam Account !
                            You are about to submit a request for us to permanently delete your Mugaam Recruiter account and erase your data. Once your account is deleted, all of the app services associated with your account will no longer be available to you on the Mugaam Recruiter platform.
                          </p>  
                          <p>    
                            Note : <b>Please note that your account will undergo a 15-day deactivation period before deletion. Once your account is deleted, it will no longer be available to you and cannot be restored. If you decide later that you want to start using our platform again, you will need to create a new account.</b>
                          </p><br>
                          <div class="text-center">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" value="yes" id="confirm_delete" name="confirm_delete">
                              <label class="form-check-label" for="confirm_delete">
                                Yes, I want to permanently delete my Mugaam Recruiter Account 
                              </label>
                            </div>
                          </div>
                          <div class="text-center mt-2">
                            <button class="btn btn-dlt-acc" type="button" id="dlt-acc" disabled>Delete Account</button>
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
	</div>

  <!-- Deleteaccount trigger modal -->
	<div class="modal fade" id="dltaccountModal" tabindex="-1" aria-labelledby="dltaccountModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
		<div class="modal-dialog  modal-dialog-centered modal-md">
			<div class="modal-content">
				<div class="modal-body">
          <div class="container">              
            <div class="text-center">
              <img draggable="false" src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" alt="logo" class="img-fluid">
            </div>
            <div class="d-req-frm">
              <div class="text-center">
                <h5>Let us know Why are you deleting your account ?</h5>
              </div>
              {!! Form::open(array('method' => 'post', 'route' => array('delete-account'), 'id' => 'delete-account')) !!}
                <div class="row mt-4">
                  @foreach($reasons as $reason)
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                      <div class="form-check mb-2 reasons">
                        {!! Form::checkbox('reasons[]', $reason->id, null, array('class'=>'form-check-input', 'id'=>'reasons'.$reason->id)) !!}
                        <label class="form-check-label" for="reasons{{$reason->id}}">{{$reason->reason}}.</label>
                      </div>
                    </div>
                  @endforeach
                </div> 
                <div class="row">              
                  <div class="mb-4">    
                    <p class="float-end mb-1" id="charCount">0/120</p>
                    {!! Form::textarea('other_reason', null, array('class'=>'form-control', 'rows'=>4, 'id'=>'other_reason', 'placeholder'=>__('Descriptions'))) !!}
                    <small class="form-text text-muted text-danger err_msg" id="err_reasons"></small>
                  </div>
                </div>
                <div class="d-flex mt-2 justify-content-evenly">
                  <div>
                    <button class="btn btn-cancel" data-bs-dismiss="modal" aria-label="Close" type="button">Cancel</button>
                  </div>    
                  <div>
                    <button class="btn btn-dlt-acc" type="button" id="dlt-acc" onClick="DeleteAccountSubmit()">Submit</button>
                  </div>
                </div>
              {!! Form::close() !!} 
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
						<label class="btn-block text-white upload-image-label up_txt" for="choose-profile-pic" >Upload Image</label>
						<label class="btn-block btn-upload-image save_txt" style="display:none">save</label>
						<label class="text-primary btn-block loading" disabled style="display:none">
							<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
							Uploading...
            </label>
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
      <div class="modal-dialog  modal-dialog-centered modal-md">
        <div class="modal-content">
          <div class="modal-header" style="border-bottom:unset !important">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="m-auto">
              {!! Form::model(Auth::user(), array('method' => 'post', 'route' => array('verify-otp'), 'id' => 'verify-otp')) !!}
                <div class="text-center">
                  <h2 class="text-green-color">
                    You have changed your phone number 
                  </h2>
                  <h5>Verify by providing the received OTP</h5>
                  <h5 class="mb-3">An OTP was sent to the Whatsapp provided</h5>
                  {{-- {!! Form::hidden('otp_code', null, array('id'=>'otp_code', 'class'=>'otp')) !!} --}}
                  {!! Form::hidden('full_number', null, array('id'=>'full_number', 'class'=>'otp')) !!}
                  <div class="otp-field">
                      <input type="text" maxlength="1" id="otp0" onkeypress="return /[0-9]/i.test(event.key)"/>
                      <input type="text" maxlength="1"  id="otp1" onkeypress="return /[0-9]/i.test(event.key)"/>
                      <input class="space" type="text" maxlength="1"  id="otp2" onkeypress="return /[0-9]/i.test(event.key)"/>
                      <input type="text" maxlength="1"  id="otp3" onkeypress="return /[0-9]/i.test(event.key)"/>
                      <input type="text" maxlength="1"  id="otp4" onkeypress="return /[0-9]/i.test(event.key)"/>
                      <input type="text" maxlength="1"  id="otp5" onkeypress="return /[0-9]/i.test(event.key)"/>
                  </div>
                  {{-- <div id="otp-holder text-center">
                    <div id="otp-content">
                      <input id="otp_code" name="otp_code" type="tel" maxlength="6" pattern="\d{6}" value="" autocomplete="off"/>
                    </div>
                  </div> --}}
                  <small class="form-text text-muted text-danger err_msg" id="err_otp_code"></small> 

                </div>
                <div class="text-center mt-2">
                  <button class="btn btn-submit btn_c_s verify" type="button"  onClick="VerifyPhoneNumberChange()">verify</button>
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
    $("#upload-demo").hide();
    $(".profilepic-modal").show();
    $(".btn-upload-image").hide();
    $(".upload-image-label").text('Upload image');
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

    $('#err_phone').html('');
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
        $("#err_phone").html('Given number is already Verified.');
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
            // console.log(json);
            $('.err_msg').html('');  
            $('#changephone').modal('show');
            $("#otp_code").val('');
            $('.verify').prop("disabled", true);
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
  function VerifyPhoneNumberChange(){
    clrErr();
    var otp = "";
    inputs.forEach((input) => {
        otp += input.value;
        input.disabled = true;
        input.classList.add("disabled");
    });
    var phone = $("#full_number").val();
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
            inputs.forEach((input) => {
                otp += input.value;
                input.disabled = false;
                input.classList.remove("disabled");
            });

        }
    });
       
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


  const inputs = document.querySelectorAll(".otp-field input");
  let otp = '';

  inputs.forEach((input, index) => {
      input.dataset.index = index;
      input.addEventListener("keyup", handleOtp);
      input.addEventListener("paste", handleOnPasteOtp);
  });

  function handleOtp(e) {

      let cotp = '';
      inputs.forEach((input) => {cotp += input.value;});
      /**
       * <input type="text" 👉 maxlength="1" />
       * 👉 NOTE: On mobile devices `maxlength` property isn't supported,
       * So we to write our own logic to make it work. 🙂
       */
      const input = e.target;
      let fieldIndex = input.dataset.index;
      let value = e.key;
      let value1 = input.value;
      let isValidInput = value.match(/^[0-9]*$/);
      let isValidInput1 = value1.match(/^[0-9]*$/);
      value = isValidInput ? value : (isValidInput1 ? input.value : "");
      // let isValidInput = true;
      $('#otp'+fieldIndex).val(value);

      if (fieldIndex < inputs.length - 1 && isValidInput) {
          input.nextElementSibling.focus();
      }
      
      if (e.key === "Backspace" && fieldIndex > 0 && (otp.length == cotp.length)) {
          input.previousElementSibling.focus();
      }

      otp = cotp; 
      if (otp.length == inputs.length) {
        $('.verify').prop("disabled", false);
      }else{      
        $('.verify').prop("disabled", true);
      }
  }

  function handleOnPasteOtp(e) {
      const data = e.clipboardData.getData("text");
      const value = data.split("");
      let cotp = '';
      inputs.forEach((input, index) => (input.value = value[index]??''));
      inputs.forEach((input) => {cotp += input.value;});
      otp = cotp;
      if (value.length === inputs.length) {
        $('.verify').prop("disabled", false);
      }else{      
        $('.verify').prop("disabled", true);
      }
  }

  const arrowtoggleBtn = document.querySelector('.dlttoggle');
  const angletoggleBtn = document.querySelector('.dlt-toggle');
  const arrowToggle = () => {
      if (angletoggleBtn.classList.contains("fa-angle-up")) {

        angletoggleBtn.classList.replace("fa-angle-up", "fa-angle-down");
      }else{
        angletoggleBtn.classList.replace("fa-angle-down", "fa-angle-up");
      }
  }
  arrowtoggleBtn.addEventListener("click", arrowToggle);

  const DeletAct = () => {  
    if($('#confirm_delete').is(':checked')){ 
      $('#dlt-acc').prop("disabled", false);
    }else{      
      $('#dlt-acc').prop("disabled", true);
    }
  }
  // A button object calls the function:
  document.getElementById("confirm_delete").addEventListener("click", DeletAct);

  $('#dlt-acc').on('click', function (e) {
		$('#dltaccountModal').modal('show');
	});  
  
  const ChartLimit = () => {  
    var textarea = document.getElementById('other_reason');
    var charCountDisplay = document.getElementById('charCount');
    var remainingChars = 120 - textarea.value.length;
    charCountDisplay.textContent = remainingChars+"/120";

    // Disable or enable the textarea based on the character limit
    textarea.disabled = remainingChars < 0;
  }
  // A button object calls the function:
  document.getElementById("other_reason").addEventListener("input", ChartLimit);

	function DeleteAccountSubmit(){
    clrErr();
    var errStaus = false;
    if(validateFormFields('other_reason','Please enter your password','')) errStaus=true;

    $("#other_reason").removeClass('is-invalid');
    if($('input[name="reasons[]"]:checked').val() != undefined || errStaus==false){
        var form = $('#delete-account');   
        $.ajax({
            url     : form.attr('action'),
            type    : form.attr('method'),
            data    : form.serialize(),
            dataType: 'json',
            success : function (json){  
              $('.d-req-frm').html('');
              $('.d-req-frm').html(`<br>
                <img draggable="false" src="{{asset('site_assets_1/assets/img/stgs/success.svg')}}" alt="logo" class="img-fluid1 py-3">
                <p>
                  Your Mugaam account has been deleted temporarily. will take around 15 days to delete your account permanently.If you wish to restore your deleted account ;  login back with in 15 days from the day you deleted your account.
                </p>
                <button class="btn btn-dlt-acc winload" type="button">Ok</button>`);
                $('.d-req-frm').addClass('text-center');
            },
        });
    }else{
      $('#err_reasons').html('Please choice the delete reason');
      return false;
    }
    
  }

  $(document).on("click",".winload",function(){  
    window.location.reload();
  });
  </script>
@endpush
