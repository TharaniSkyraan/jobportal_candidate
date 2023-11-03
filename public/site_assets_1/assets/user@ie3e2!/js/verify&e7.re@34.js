let csrf_token = $('meta[name=csrf-token]').attr('content');

// Get the timer element
var timerEl = $('#seconds-counter');

// Set the initial time to 5 minutes
var remainingTime = 300;

function otptimer(){
    // Calculate the minutes and seconds
    var minutes = Math.floor(remainingTime / 60);
    var seconds = remainingTime % 60;
    console.log(remainingTime);
    // Display the time with leading zeros
    timerEl.text(('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2));

    // Subtract one second from the remaining time
    remainingTime--;

    // Stop the timer when it reaches 0
    if (remainingTime < 1) {
      // Stop the interval
        clearInterval(interval);
      timerEl.text('05:00');
      $('.seconds-counter').hide();
      $('#restnt').show();
    }
}

if(otp!=''){
  var interval = setInterval(otptimer, 1000);  
}else{  
  $('.seconds-counter').hide();
  $('#restnt').show();
}

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
          remainingTime = 300;   
          // Reset the interval and set it to 10s
          
          interval = setInterval(otptimer, 1000);

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