
let csrf_token = $('meta[name=csrf-token]').attr('content');
var maxBirthdayDate = new Date();
maxBirthdayDate.setFullYear( maxBirthdayDate.getFullYear() - 16 );

$("#date_of_birth").flatpickr({
  maxDate: maxBirthdayDate,
  enableTime: false,
  altInput: true,
  dateFormat: "d-m-Y",
  altFormat:"d-m-Y",
  disableMobile: "true",
  plugins: [
      ShortcutButtonsPlugin({
          button: {
              label: 'Clear',
          },
          onClick: (index, fp) => {
              fp.clear();
              fp.close();
          }
      })
  ]
});
$("#basic-info-submit-button").click(function(){  
    var result = validateBasicinfoForm(); 
    
    if(result != false){
      $('#submitbasicinfoform').submit();
    }

  });

  function validateBasicinfoForm(){
    clrErr();
    var errStaus = false; 
    
    if(validateFormFields('first_name','Please enter the First name.','NameVali')) errStaus=true;
    if(validateFormFields('last_name','Please enter Last name.','NameVali')) errStaus=true;
    if(validateFormFields('date_of_birth ','Please enter date of birth.','')) errStaus=true;
    if(validateFormFields('marital_status_id ','Please select Marital status.','')) errStaus=true;
    if(validateFormFields('gender ','Please specify your gender.','radio')) errStaus=true;
  
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
    var yyyy = today.getFullYear()-14;
    var yyyy1 = today.getFullYear()-70;

    yeardectoday = yyyy+''+mm+''+dd;
    yearincrtoday = yyyy1+''+mm+''+dd;

    var dob = $('#date_of_birth').val();
    var d2 = dob.split("-");
    d2 = d2[2].concat(d2[1], d2[0]);

    if(d2 > yeardectoday && d2 < yearincrtoday){
      setMsg('date_of_birth','Enter valid date of birth');
      errStaus=true;
    }
  
    if(errStaus) {
      return false;
    } else {
      return true;		
    }
  }

  
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
      // console.log('jQuery bind complete');
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
      url: baseurl+'profileupdate',
      type: "POST",
      contentType:'application/x-www-form-urlencoded; charset=UTF-8',
      data: {"image":img, "_token": csrf_token},
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

$('.profilemodalclose').on('click', function (ev) { 
  var count = 0; 
  var timeout = setTimeout(function(count) {       
      $(".upload-image-label").text('Upload Image');
      $(".profilemodalclose").show();
      $(".btn-upload-image").hide();
      $(".profilepic-modal").show();
      $("#upload-demo").hide();
      $(".loading").hide();
      count++;
      if(count==1){
          clearTimeout(timeout);
      }
  }, 1000);
});