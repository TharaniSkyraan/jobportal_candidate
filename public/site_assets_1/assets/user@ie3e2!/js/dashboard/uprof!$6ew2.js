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
    alert('test');
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