let csrf_token = $('meta[name=csrf-token]').attr('content');
var seconds = 61;
var el = document.getElementById('seconds-counter');

function incrementSeconds() {
    seconds -= 1;
    if(seconds>=0){
      el.innerText = seconds + " s.";
    }
    if(seconds==0){
      el.innerText = 60 + " s.";
      $('.seconds-counter').hide();
      $('#restnt').show();
    }
}

var cancel = setInterval(incrementSeconds, 1000);

$(document).on('keydown, keyup', "#otp", function() {
    var otp = $(this).val();

    if(otp.length==8){

    }

});

$(document).on('click', "#restnt", function() {
  clrErr();
  resentMail();
});
function resentMail() {
  var email = $('#email').html();
  $.ajax({
      url     : baseurl + "/resent_mail",
      type    : 'POST',
      data: {"_token": csrf_token, "email": email},
      dataType: 'json',
      success:function(data) { 
          seconds = 60;    
          $('.seconds-counter').show();
          $('#restnt').hide();
      }
  });
}
function validateLoginForm() {
    clrErr();
    var errStaus = false;

    if(validateFormFields('otp','Please enter otp','')) errStaus=true;      
  
    if(errStaus == false){  
      
      var form = $('#submitform');       
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
                $('.error').html(json.responseJSON.error+' - ');   
                $('#otp').addClass('is-invalid');   
              }
          }
      });
    }else{
    }
    return false
}