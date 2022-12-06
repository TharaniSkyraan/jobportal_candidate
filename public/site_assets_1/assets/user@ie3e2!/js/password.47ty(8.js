    
    document.onkeyup = enter;
    function enter(e) {
        if (e.which == 13) {
            $('.submitpassword').trigger('click');
        }
    } 
    
    let provider = $('#provider').val();
    let email = $('#email').val();    
    let csrf_token = $('meta[name=csrf-token]').attr('content');
    if(is_exist=='no' && is_empty(provider)){
        $(document).ready(function() {
            $( "#verification" ).modal( "show" );
        });
    }
 
  $('.optionWrap').click(function(){
    $(".optionWrap").removeClass("selected");
    $(this).addClass("selected");
  });

  $('.candidateWrap').click(function(){
    $('#account_type').val('candidate');
  });

  $('.employerWrap').click(function(){
    $('#account_type').val('employer');
  });

  $(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if(input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
  $(document).on('keyup', "#password", function() {
      if( $(this).val() != '' ){$("#showpico").show();}
      else{$("#showpico").hide();}
  });
  $("#showpico").hide();


  
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

  function is_empty(e) {
    switch (e) {
      case "":
      case 0:
      case "0":
      case null:
      case false:
      case undefined:
        return true;
      default:
        return false;
    }
  }


function submitPassword() {

    var form = $('#submitpassword');

    $('.password-error').html('');

    clrErr();
    var errStaus = false;

    if(is_empty(provider) && verified==1){
        if(validateFormFields('password','Please enter your password','')) errStaus=true;
    }
    else if(is_empty(provider) || verified==1 ){
        if(validateFormFields('password','Please enter your password','validPass')) errStaus=true;
    }

    if(is_empty(provider) && verified==0){
      if($("#phone").val() != '' ){
        if(validateFormFields('phone','Please enter your mobile','validMobile')) errStaus=true;
        $("#full_number").val($('.iti__selected-dial-code').html()+String($("#phone").val()).replace(/ /g, ""));
      }else{
        $("#full_number").val('');
      }
    }
    
    if(errStaus == false){
      // return true;
      // alert()
      $('#password').removeClass('is-invalid').removeClass('is-valid');
      $('#phone').removeClass('is-invalid').removeClass('is-valid');

      $.ajax({
          url     : baseurl + "/signupaccount",
          type    : 'POST',
          data    : form.serialize(),
          dataType: 'json',        
          success:function(data) {
            if(data.emailIsVerfied=='no'){
                          
              $('#success').html('<div class="alert alert-danger alert-dismissible fade show" role="alert" id="success-alert-update">'
                                +'Kindly, verify your account before login'
                              +'</div>');
              $("#success").fadeTo(5000, 500).slideUp(500, function() {
                $("#success").slideUp(500);
              });
            }else{
              window.location = baseurl+data.url;
            }
          },
          error: function(json){
              if (json.status === 422) {
                  var resJSON = json.responseJSON;
                  $.each(resJSON.errors, function (key, value) {
                    $('.' + key + '-error').html(value);                    
                    $('#div_' + key).addClass('has-error');
                  });
              }
          }
      });
    }else{
      return false;
    }
  }

 function resentMail() {

    $.ajax({
        url     : baseurl + "/resent_mail",
        type    : 'POST',
        data: {"_token": csrf_token, "email": email},
        dataType: 'json',
        success:function(data) {                        
          $('#success').html('<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert-update">'
                            +'<strong>Success!</strong> Verification mail has been Sent.. Please Verify Your Account'
                          +'</div>');
          $("#success").fadeTo(5000, 500).slideUp(500, function() {
            $("#success").slideUp(500);
          });
        }
    });
 }

