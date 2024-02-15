var login_continue = '';
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
          // setMsg(fieldId,'Please enter a valid email');
        } else {
          $('#'+fieldId).removeClass('is-invalid').addClass('is-valid');
          $(".err_msg").html('');
        }
    }
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
$(document).on('click', ".edit-email", function() {
  $('#user_type').val('');
    $('.rtname').hide();
    $('.rtpassword').hide();
    $('.rtemail').show();
    $('.display-email').hide();
    $('.f-pass').show();

});
$(document).on('keyup', "#password", function() {
    if($(this).val() != ''){$("#showpico").show();}
    else{$("#showpico").hide();}
});
$("#showpico").hide();

$(document).on('click', ".btn-dlt-acc", function() {
  login_continue = 'yes';
  validateLoginForm();
  $('.btn-cancel').trigger('click');
});
function validateLoginForm() {
    clrErr();
    var errStaus = false;
    var user_type = $('#user_type').val();
    var email = $('#email').val();
    if(validateFormFields('email','Please enter your email address','validEmail')) errStaus=true;      
  
    if(errStaus == false){  
      var form = $('#submitform'); 
      var formData = form.serialize();

      // Append additional input
      formData += '&login_continue='+login_continue;
      if(is_empty(user_type))
      {     
        $.ajax({
            url     : form.attr('action'),
            type    : form.attr('method'),
            data    : formData,
            dataType: 'json',        
            success:function(data) {
              login_continue = '';
              $('#user_type').val(data.user_type);
              if(data.is_deleted=='deleted'){
                $('#dltaccountModal').modal('show');
              }
              if(data.user_type=='new'){
                 $('.rtname').show();
                 $('.rtpassword').show();
                 $('.f-pass').hide();
              }else{
                 $('.rtpassword').show();
              }
              $('.rtemail').hide();
              $('#display-email').html(email);
              $('.display-email').show();
              if(data.is_deleted=='deleted'){
                $('.edit-email').trigger('click');
              }
            },
            error: function(json){
                if (json.status === 422) {
                    var resJSON = json.responseJSON;
                    $.each(resJSON.errors, function (key, value) {
                      $('.' + key + '-error').html(value);                    
                      $('#' + key).addClass('is-invalid');
                    });
                }
            }
        });
      }else{
        if(user_type=='new'){
          if(validateFormFields('password','Please enter your password','validPass')) errStaus=true;
          if(validateFormFields('name','Please enter name.','NameVali')) errStaus=true;
        }else{
          if(validateFormFields('password','Please enter your password','')) errStaus=true;
        }

        if(errStaus==false){
            $.ajax({
              url     : form.attr('action'),
              type    : form.attr('method'),
              data    : form.serialize(),
              dataType: 'json',        
              success:function(data) {
                  window.location = baseurl+data.page;
              },
              error: function(json){
                  if (json.status === 422) {
                      var resJSON = json.responseJSON;
                      $.each(resJSON.errors, function (key, value) {
                        $('#err_' + key).html(value);                    
                        $('#' + key).addClass('is-invalid');
                        if(key=='email'){
                          $('.edit-email').trigger('click');                 
                        }
                      });
                  }
              }
            });
          }
      }

      return false;
    }else{
        return false;
    }
}

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
