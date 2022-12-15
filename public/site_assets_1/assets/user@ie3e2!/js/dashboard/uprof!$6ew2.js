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
  
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
    var yyyy = today.getFullYear()-14;
    var yyyy1 = today.getFullYear()-100;

    yeardectoday = yyyy+'-'+mm+'-'+dd;
    yearincrtoday = yyyy1+'-'+mm+'-'+dd;

    if($('#date_of_birth').val() > yeardectoday && $('#date_of_birth').val() > yearincrtoday){
      setMsg('date_of_birth','Enter date between '+ yearincrtoday +' to '+ yeardectoday);
      errStaus=true;
    }
  
    if(errStaus) {
      return false;
    } else {
      return true;		
    }
  }