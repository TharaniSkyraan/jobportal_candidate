
  let csrf_token = $('meta[name=csrf-token]').attr('content');
  var act_ftab = 'basic_info';
  //on progress diasbled date function ends

  function selmark(){
      var score = $('input[name="result_type_id"]:checked').val();

      if(score == 1){
        $("#show_gpa_field").show();
        $("#show_percentage_field").hide();
        $("#show_grade_field").hide();
      }else if(score == 2){
        $("#show_gpa_field").hide();
        $("#show_percentage_field").hide();
        $("#show_grade_field").show();
      }else if(score == 3){
        $("#show_gpa_field").hide();
        $("#show_percentage_field").show();
        $("#show_grade_field").hide();
      }else{
        $("#show_gpa_field").show();
        $("#show_percentage_field").hide();
        $("#show_grade_field").hide();
      }
    }

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
  function isgpa(){
    $('#gpa').bind({
      focusin: onFocusIn,
      keyup: onChange
    });
  }

  function ispercentage(){
    $('#percentage').bind({
      focusin: onFocusIn,
      keyup: onChange
    });
  }

  const onFocusIn = (e) => {
    const $target = $(e.currentTarget);
    $target.data('val', $target.val());
  };

  const onChange = (e) => {
    if($(e.currentTarget).attr('id')=='percentage'){
      var valida = /^((100)|(\d{1,2}(\.\d*)?))%?$/;
    }else{
      var valida = /^((10)|(\d{1,1}(\.\d*)?))?$/;
    }
    const regex = valida,
      $target = $(e.currentTarget),
      value = $target.val(),
      event = e || window.event,
      keyCode = event.keyCode || event.which,
      isValid = value.trim().length === 0 ||
        (keyInRange(keyCode) && regex.test(value));
    if (!isValid) {
      $target.val($target.data('val'));
      setMsg('percentage','Enter values from 1 to 100 ');
      event.preventDefault();
    } else {
      $target.data('val', value);
    }
  };

  const keyInRange = (keyCode) =>
    (keyCode >= 48 && keyCode <= 57)     || /* top row numbers       */
    (keyCode >= 96 && keyCode <= 105)    || /* keypad numbers        */
    (keyCode === 110 || keyCode === 190) || /* decimal separator     */
    (keyCode === 53)                     || /* percentage            */
    (keyCode === 8 || keyCode === 46);      /* back-space and delete */

  $("#profileModal").on("hidden.bs.modal", function () {
      // put your default event here
      window.location = baseurl;
  });

  $(".nav-item").click(function(){ 
      
    $('.user-experience-cancel').trigger('click');
    $('.user-education-cancel').trigger('click');
    $('.user-skill-cancel').trigger('click');
    $('.user-language-cancel').trigger('click');
    $('.user-project-cancel').trigger('click');

  });
  
  $('#country_id').select2();
  // basic info form validation starts
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
      if(validateFormFields('user_location ','Please Enter City.','ValiCity')) errStaus=true;
      if(validateFormFields('marital_status_id ','Please select Marital status.','')) errStaus=true;
      if(validateFormFields('country_id ','Please select Country.','')) errStaus=true;
      if(validateFormFields('career_title ','Please Enter job career title.','')) errStaus=true;
      if(validateFormFields('expected_salary ','Please Enter expected salary.','')) errStaus=true;

      if($('input[name="employment_status"]:checked').val() == 'experienced'){
        if(validateFormFields('total_experience ','Please Enter total experience.','')) errStaus=true;
        if(validateFormFields('current_salary ','Please Enter current salary.','')) errStaus=true;
      }
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
    function updateTextView(_obj){
        var num = getNumber(_obj.val());
        if(num==0){
            _obj.val('');
        }else{
            _obj.val(num.toLocaleString('en-IN'));
        }
    }
    function getNumber(_str){
        var arr = _str.split('');
        var out = new Array();
        for(var cnt=0;cnt<arr.length;cnt++){
            if(isNaN(arr[cnt])==false){
            out.push(arr[cnt]);
            }
        }
        return Number(out.join(''));
    }
    $(document).ready(function(){
        $("input[data-type='currency']").on('keyup',function(){
            updateTextView($(this));
        });
        $('#current_salary').val(current_salary).trigger('keyup');
        $('#expected_salary').val(expected_salary).trigger('keyup');
    
    });
    $('.employment_status').on('change', function (e) {
      checkempstatus();       
    });
    checkempstatus();
    function checkempstatus(){
      employment_status = $('input[name="employment_status"]:checked').val(); 

      if(employment_status == 'experienced'){
        $('.total_experience').show();
        $('#current_salary').val(current_salary);
      }else{
        $('.total_experience').hide();
        $('#current_salary').val('');
      }
    }
    // form validation ends

    function increaseValue() {
        var value = parseInt(document.getElementById('number').value, 10);
        value = isNaN(value) ? 0 : value;
        value++;
        document.getElementById('number').value = value;
    }

    function decreaseValue() {
        var value = parseInt(document.getElementById('number').value, 10);
        value = isNaN(value) ? 0 : value;
        value < 1 ? value = 1 : '';
        value--;
        document.getElementById('number').value = value;
    }

    function collapsedExp(id){
      if($('.more-details'+id).find(".collapsed").length == 0){ 
        $('.more-details'+id).find(".collapse-up-arrow").show();
        $('.more-details'+id).find(".collapse-down-arrow").hide();
      }else{
        $('.more-details'+id).find(".collapse-up-arrow").hide();
        $('.more-details'+id).find(".collapse-down-arrow").show();
      }

    }

    function collapsedProj(id){
      if($('.more-details-proj'+id).find(".collapsed").length == 0){ 
        $('.more-details-proj'+id).find(".collapse-up-arrow-proj").show();
        $('.more-details-proj'+id).find(".collapse-down-arrow-proj").hide();
      }else{
        $('.more-details-proj'+id).find(".collapse-up-arrow-proj").hide();
        $('.more-details-proj'+id).find(".collapse-down-arrow-proj").show();
      }
    }

    //add more fields group
    $(document).on("click",".addMoreskills",function(){
      $('.append-form-skills').show();
    });

    //add more fields group
    $(document).on("click",".addMorelanguages",function(){
      $('.append-form-languages').show();
    });
    
    $('#country_id').on('change', function (e) {
        e.preventDefault();
        $('#user_location').val('');
    });

    /** Basic Info Script End */

    /** Education Form Script */

    $(document).ready(function(){     

        // add more fields group
          
        $(document).on('change', '#education_level_id', function (e) {
            e.preventDefault();
            filterEducationTypes(0);
        });

    });

    $(document).on("click","#pursuing",function(){     
      clrErr();
      StillCheck('education');
    });


    function delete_user_education(id) {

        var msg = "Are you sure! you want to delete?";

        if (confirm(msg)) {

            $.post(baseurl + "delete-education", {id: id, _method: 'DELETE', _token: csrf_token})
            .done(function (response) {

                if (response == 'ok')
                {                    
                  $('.undo_education_'+id).show();
                  $('.delete_education_'+id).hide();
                  $('.edit_education_'+id).hide();
                  $('.education_edited_div_' + id).removeClass("education_div");
                  
                  if($(".education_div").length == 1){
                    $('.delete_education').hide();
                  }
                } else
                {
                  alert('Request Failed!');

                }

            });

        }

    }

    function undo_user_education(id) {
      var msg = "Are you sure! you want to undo?";
      if (confirm(msg)) {
        $.post(baseurl + "undo-education", {id: id, _method: 'POST', _token: csrf_token})
        .done(function (response) {
          if (response == 'ok')
          {                    
            $('.undo_education_'+id).hide();
            $('.delete_education_'+id).show();
            $('.edit_education_'+id).show();
            $('.education_edited_div_' + id).addClass("education_div");           
            if($(".education_div").length > 1){
              $('.education_div').find(".delete_education").show();
            }
          } else
          {
            alert('Request Failed!');
          }
        });
      }
    }

    /**  Submit */

    function validateeducationForm(){
      clrErr();
      var errStaus = false; 
      if(validateFormFields('education_level_id','Please enter education level.','')) errStaus=true;
      if(document.getElementById('education_type_id')!=null){
        if(validateFormFields('education_type_id','Please enter the Education type','')) errStaus=true;
      }
      if(validateFormFields('country_id_dd','Please enter Country.','')) errStaus=true;
      if(validateFormFields('location','Please enter city','ValiCity')) errStaus=true;
      if($('#institution').val()!=''){
          if(validateFormFields('institution','Please enter Institution.','ValInstitute')) errStaus=true;
      }
      
      /** var score_vali = $('input[name="result_type_id"]:checked').val();

      if(score_vali == 1){
        if(validateFormFields('gpa','Please enter GPA.','')) errStaus=true;
          var gpa_val = $("#gpa").val();
          if($.isNumeric(gpa_val)){
            var check_gpa_val = Math.round(gpa_val);
            if(check_gpa_val > 10){
              setMsg('gpa','Enter values from 1 to 10');
              errStaus=true;
            }
          }else{
            setMsg('gpa','Enter values from 1 to 10');
            errStaus=true;
          }
      }
      if(score_vali == 2){
        if(validateFormFields('grade','Please enter Grade.','')) errStaus=true;
      }
      if(score_vali == 3){
        if(validateFormFields('percentage','Please enter percentage.','')) errStaus=true;
      }
      var gpa_val = $("#gpa").val();
      if($.isNumeric(gpa_val)){
        var check_gpa_val = Math.round(gpa_val);
        if(check_gpa_val > 10){
          setMsg('gpa','Enter values from 1 to 10');
          errStaus=true;
        }
      }else{
        setMsg('gpa','Enter values from 1 to 10');
        errStaus=true;
      } */

      var edu_type_id = $("#education_type_id").val();

      if(edu_type_id){
        
        if(validateFormFields('university_board','Please select university board.','')) errStaus=true;
        
        var today = new Date();
        var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
        var yyyy = today.getFullYear();

        var yyyy1 = today.getFullYear()-100;

        todaymonthyear = yyyy+'-'+mm;
        yearincrtoday = yyyy1+'-'+mm;
        
        if($("#add_edit_user_education").find('.from_year').val() == ''){
          validateFormFields('from_year','Please enter Date start.','');
          errStaus=true;
        }else if($('.from_year').val() >= todaymonthyear){
          setMsg('from_year','Please select less than current year'); errStaus=true;
        }
        
          
        if($("input[name='pursuing']").is(':checked') == false){

            if($("#add_edit_user_education").find('.to_year').val() == ''){
              validateFormFields('to_year','Please select Date end.','');
              errStaus=true;
            }else if($('.to_year').val() <= $('.from_year').val()){
              setMsg('to_year','Please select greater than from year'); errStaus=true;
            }
        }

      }
      
      if(errStaus) {
        return false;
      } else {
        return true;		
      }

    }

    function submitUserEducationForm() {

      // Education form validation starts
      
      var result = validateeducationForm(); 
      
      if(result != false){
      
      // form validation ends

          var form = $('#add_edit_user_education');

          $.ajax({

              url     : form.attr('action'),

              type    : form.attr('method'),

              data    : form.serialize(),

              dataType: 'json',

              success : function (json){

                $('.append-form-education').html('');
                
                $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");
                showEducation();

                $('#education_success').html('<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert-update">'
                                                +'<strong>Success!</strong> Education Updated'
                                                +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                                              +'</div>');

                $("#education_success").fadeTo(2000, 500).slideUp(500, function() {
                  $("#education_success").slideUp(500);
                });
                $('.addEducation').show();                
              },

              error: function(json){

                  if (json.status === 422) {

                  var resJSON = json.responseJSON;

                  $('.help-block').html('');

                  $.each(resJSON.errors, function (key, value) {

                      // $('.' + key + '-error').html('<strong>' + value + '</strong>');
                    $('.' + key + '-error').html(value);

                    $('#div_' + key).addClass('has-error');

                  });

                  }
                }

            });

      }

    }
        
    /**End Submit form */

    function filterEducationTypes(education_type_id)
    {

        var education_level_id = $('#education_level_id').val();

        if (education_level_id != ''){
                      
        $.post(baseurl + "filter-education-types-dropdown", {education_level_id: education_level_id, education_type_id: education_type_id, _method: 'POST', _token: csrf_token})

          .done(function (response) {

            $('#education_types_dd').html(response); 
            $('#education_type_id').select2();

          });

        }

    }
    
    function cancelUserEducationForm(education_id) {

      if(education_id!=0){      
      $('.education_edited_div_'+education_id).show();
      }
      $('.append-form-education').html('');
      $('#div-'+act_ftab).find(".btn-add").show();

    }

      /**End of Education */

    


    /** Experience Form Script  */

    //==============================================================//


    
    function validateexperienceForm(){
      clrErr();
      var errStaus = false; 
      if(validateFormFields('title','Please enter Designation.','')) errStaus=true;
      if(validateFormFields('country_id_dd','Please enter Country.','')) errStaus=true;
      if(validateFormFields('company','Please enter Company.','ValiCity')) errStaus=true;
      if(validateFormFields('location','Please enter city','ValiCity')) errStaus=true;
      
      if($("#add_edit_user_experience").find('.date_start').val() == ''){
        validateFormFields('date_start','Please enter Date start.','');
        errStaus=true;
      }
          
      if($("input[name='is_currently_working']").is(':checked') == false){
        if($("#add_edit_user_experience").find('.date_end').val() == ''){
          validateFormFields('date_end','Please select Date end.','');
          errStaus=true;
        }
      }

      var today = new Date();
      var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
      var yyyy = today.getFullYear();

      var yyyy1 = today.getFullYear()-100;

      todaymonthyear = yyyy+'-'+mm;
      yearincrtoday = yyyy1+'-'+mm;
      
      if($('.date_start').val() >= todaymonthyear){
        setMsg('date_start','Please select less than current year'); errStaus=true;
      }

      if($("input[name='is_currently_working']").is(':checked') == false){
        if($('.date_end').val() <= $('.date_start').val()){
          setMsg('date_end','Please select greater than from year'); errStaus=true;
        }
      }

      if(errStaus) {
        return false;
      } else {
        return true;		
      }
    }

    $(document).on("click","#flexCheckDefault",function(){
      clrErr();
      StillCheck('experience');
    });


    function submitUserExperienceForm() {
      var result = validateexperienceForm(); 
      if(result != false){
        var form = $('#add_edit_user_experience');
        $.ajax({
        url     : form.attr('action'),
        type    : form.attr('method'),
        data    : form.serialize(),
        dataType: 'json',
        success : function (json){
          $('.append-form-experience').html('');
          $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");
          showExperience();

          $('#experience_success').html('<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert-update">'
                            +'<strong>Success!</strong> Experience Updated'
                            +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                          +'</div>');

          $("#experience_success").fadeTo(2000, 500).slideUp(500, function() {
            $("#experience_success").slideUp(500);
          });
          
          $('.addExperience').show();
          profilePercentage();
        },
        error: function(json){
            if (json.status === 422) {
                var resJSON = json.responseJSON;
                $('.help-block').html('');
                $.each(resJSON.errors, function (key, value) {
                // $('.' + key + '-error').html('<strong>' + value + '</strong>');
                $('.' + key + '-error').html(value);
                $('#div_' + key).addClass('has-error');
                });
            } 
          }
        });
      }
    }

    function delete_user_experience(id) {
      var msg = "Are you sure! you want to delete?";
      if(confirm(msg)) {
        $.post(baseurl + "delete-experience", {id: id, _method: 'DELETE', _token: csrf_token})
        .done(function (response) {
          if (response == 'ok')
          {                    
            $('.undo_experience_'+id).show();
            $('.delete_experience_'+id).hide();
            $('.edit_experience_'+id).hide();
            $('.experience_edited_div_' + id).removeClass("experience_div");
            if($(".experience_div").length == 1){
              $('.delete_experience').hide();
            }
          } else
          {
              alert('Request Failed!');
          }
        });
      }
    }

    function undo_user_experience(id) {
      var msg = "Are you sure! you want to undo?";
      if(confirm(msg)) {
        $.post(baseurl + "undo-experience", {id: id, _method: 'POST', _token: csrf_token})
        .done(function (response) {
              if (response == 'ok')
              {                    
                $('.undo_experience_'+id).hide();
                $('.delete_experience_'+id).show();
                $('.edit_experience_'+id).show();
                $('.experience_edited_div_' + id).addClass("experience_div");           
                if($(".experience_div").length > 1){
                  $('.experience_div').find(".delete_experience").show();
                }

              } else
              {
                alert('Request Failed!');
              }
        });
      }
    }

    function cancelUserExperienceForm(experience_id) {

      if(experience_id!=0){      
        $('.experience_edited_div_'+experience_id).show();
      }
      
      if($(".experience_div").length==0){
      $('.append-form-experience').html(`<div class="text-center"><img src="${baseurl}site_assets_1/assets/img/fresher.png" height="250" width="250"></div>`);
      }else{
        $('.append-form-experience').html('');
      }
      $('#div-'+act_ftab).find(".btn-add").show();

    }

    /**End of Experience */


    /** Start of Project */


    $(document).on("click","#is_on_going",function(){
      clrErr();
      StillCheck('project');
    });

    function validateprojectForm(){
      clrErr();
      var errStaus = false; 
      if(validateFormFields('name','Please enter Project title.','ValiCity')) errStaus=true;
      // if(validateFormFields('user_experience_id','Please enter Your project done by.','')) errStaus=true;
      // if(validateFormFields('country_id_dd','Please enter Country.','')) errStaus=true;
      // if(validateFormFields('location','Please enter city.','ValiCity')) errStaus=true;
      if(validateFormFields('description','Please enter Description.','')) errStaus=true;
      
      var today = new Date();
      var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
      var yyyy = today.getFullYear();

      var yyyy1 = today.getFullYear()-100;

      todaymonthyear = yyyy+'-'+mm;
      yearincrtoday = yyyy1+'-'+mm;

      if($("#add_edit_user_project").find('#date_start').val() != ''){
        if($('#date_start').val() >= todaymonthyear){
          setMsg('date_start','Please select less than current year'); errStaus=true;
        }
      }

      if($("input[name='is_on_going']").is(':checked') == false){
        if($("#add_edit_user_project").find('#date_end').val() != ''){
          if($('#date_end').val() <= $('#date_start').val()){
            setMsg('date_end','Please select greater than from year'); errStaus=true;
          }
        }
      }

      if(errStaus) {
        return false;
      } else {
        return true;		
      }
    }

    function submitUserProjectForm() {
      var result = validateprojectForm(); 
      if(result != false){
        var form = $('#add_edit_user_project');
        $.ajax({
            url     : form.attr('action'),
          type    : form.attr('method'),
          data    : form.serialize(),
          dataType: 'json',
          success : function (json){
            $('.append-form-project').html('');
            $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");
            showProjects();

            $('#project_success').html('<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert-update">'
                    +'<strong>Success!</strong> Project Updated'
                    +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                    +'</div>');
            $("#project_success").fadeTo(2000, 500).slideUp(500, function() {
            $("#project_success").slideUp(500);
            });

            $('.addProject').show();
            profilePercentage();

          },
          error: function(json){
            if (json.status === 422) {
              var resJSON = json.responseJSON;
              $('.help-block').html('');
              $.each(resJSON.errors, function (key, value) {
                $('.' + key + '-error').html(value);
                $('#div_' + key).addClass('has-error');

              });
            }          
          }
        });
      }
    }

    function delete_user_project(id) {

      var msg = "Are you sure! you want to delete?";

      if (confirm(msg)) {

          $.post(baseurl + "delete-project", {id: id, _method: 'DELETE', _token: csrf_token})

          .done(function (response) {

              if (response == 'ok')
              {                	
                $('.undo_project_'+id).show();
                $('.delete_project_'+id).hide();
                $('.edit_project_'+id).hide();
                $('.project_edited_div_' + id).removeClass("project_div");
                if($(".project_div").length == 1){
                  $('.delete_project').hide();
                }
              } else
              {
                  alert('Request Failed!');
              }

          });

      }

    }
    
    function undo_user_project(id) {
        var msg = "Are you sure! you want to undo?";
        if (confirm(msg)) {
            $.post(baseurl + "undo-project", {id: id, _method: 'POST', _token: csrf_token})
            .done(function (response) {
                if (response == 'ok')
                {
                  $('.undo_project_'+id).hide();
                  $('.delete_project_'+id).show();
                  $('.edit_project_'+id).show();
                  $('.project_edited_div_' + id).addClass("project_div");           
                  if($(".project_div").length > 1){
                    $('.project_div').find(".delete_project").show();
                  }
                } else
                {
                    alert('Request Failed!');
                }
            });
        }
    }             

    function cancelUserProjectForm(project_id) {

      if(project_id!=0){      
        $('.project_edited_div_'+project_id).show();
      }
      if($(".project_div").length==0){
        $('.append-form-project').html(`<div class="text-center"><img src="${baseurl}site_assets_1/assets/img/fresher.png')}}" height="250" width="250"></div>`);
      }else{
        $('.append-form-project').html('');
      }
      $('#div-'+act_ftab).find(".btn-add").show();

    }

  /** End of Project */

  /** Start of Skill */

  $(document).on("click","#is_currently_working",function(){
    clrErr();
    StillCheck('skill');
  });



  function validateskillForm(){
    clrErr();
    var errStaus = false; 
    if(validateFormFields('skill_id','Please enter Skill.','')) errStaus=true;
    
    if($("input[name='level_id']").is(':checked') == false){
      if(validateFormFields('level_id','Please slect Skill level.','')) errStaus=true;
    }

    var today = new Date();
    var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
    var yyyy = today.getFullYear();

    var yyyy1 = today.getFullYear()-100;

    todaymonthyear = yyyy+'-'+mm;
    yearincrtoday = yyyy1+'-'+mm;

    if($('#start_date').val() >= todaymonthyear){
      setMsg('start_date','Please select less than current year'); errStaus=true;
    }

    if($('#end_date').val() != ""){
      if($('#end_date').val() <= $('#start_date').val()){

        setMsg('end_date','Please select greater than from year'); errStaus=true;

      }
    }
    
    if(errStaus) {
      return false;
    } else {
      return true;		
    }
  }
  
  
  //on progress diasbled date function ends

  function submitUserSkillForm() {
    
    var result = validateskillForm(); 
    
    if(result != false){

      var form = $('#add_edit_user_skill');

      $.ajax({

        url     : form.attr('action'),
        type    : form.attr('method'),
        data    : form.serialize(),
        dataType: 'json',
        success : function (json){

          $('.append-form-skill').html('');

          $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");
          showSkills();

          $('#skill_success').html('<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert-update">'
                            +'<strong>Success!</strong> Skill Updated'
                            +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                          +'</div>');

          $("#skill_success").fadeTo(2000, 500).slideUp(500, function() {
            $("#skill_success").slideUp(500);
          });
          $('.addSkills').show();

        },
        error: function(json){

            if (json.status === 422) {
                var resJSON = json.responseJSON;
                $('.help-block').html('');
                $.each(resJSON.errors, function (key, value) {
                $('.' + key + '-error').html('<strong>' + value + '</strong>');
                $('#div_' + key).addClass('has-error');

                });

            } 

        }

      });
    }

  }

  function delete_user_skill(id) {
      var msg = "Are you sure! you want to delete?";
      if (confirm(msg)) {
          $.post(baseurl + "delete-skill", {id: id, _method: 'DELETE', _token: csrf_token})
          .done(function (response) {
            if (response == 'ok')
            {
              $('.undo_skill_'+id).show();
              $('.delete_skill_'+id).hide();
              $('.edit_skill_'+id).hide();
              $('.skill_edited_div_' + id).removeClass("skill_div");
              if($(".skill_div").length == 1){
                $('.delete_skill').hide();
              }
            } else
            {
            alert('Request Failed!');
            }
          });
      }
  }
  function undo_user_skill(id) {
    var msg = "Are you sure! you want to undo?";
    if (confirm(msg)) {
      $.post(baseurl + "undo-skill", {id: id, _method: 'post', _token: csrf_token})
      .done(function (response) {
        if (response == 'ok')
        {                
          $('.undo_skill_'+id).hide();
          $('.delete_skill_'+id).show();
          $('.edit_skill_'+id).show();
          $('.skill_edited_div_' + id).addClass("skill_div");           
          if($(".skill_div").length > 1){
            $('.skill_div').find(".delete_skill").show();
          }
        } else
        {
        alert('Request Failed!');
        }
      });
    }
  }


  function cancelUserSkillForm(skill_id) {

    if(skill_id!=0){      
    $('.skill_edited_div_'+skill_id).show();
    }
    $('.append-form-skill').html('');
    $('#div-'+act_ftab).find(".btn-add").show();

  }
  function SkillLevel(){
    clrErr();
  }
  /** End Of skill */


  /** Start of Languages */


  function validatelanguageForm(){
    clrErr();
    var errStaus = false; 
    if(validateFormFields('language_id','Please Select Language.','')) errStaus=true;
    
    if($("input[name='language_level_id']").is(':checked') == false){
      if(validateFormFields('language_level_id ','Please select Language level.','')) errStaus=true;
    }
    
    if($("input[name='write']:checked").val() == undefined && $("input[name='read']:checked").val() == undefined && $("input[name='speak']:checked").val() == undefined){
      $('#err_swr').html('Please Select any Read, Write or Speak')
      errStaus=true;
    }

    if(errStaus) {
      return false;
    } else {
      return true;		
    }
  }

  function submitUserLanguageForm() {

    var result = validatelanguageForm(); 
    
    if(result != false){

      var form = $('#add_edit_user_language');

      $.ajax({

        url     : form.attr('action'),
        type    : form.attr('method'),
        data    : form.serialize(),
        dataType: 'json',
        success : function (json){

          $('.append-card-language').html('');
          $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");
          showLanguages();
          
          $('#language_success').html('<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert-update">'
                            +'<strong>Success!</strong> Language Updated'
                            +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                          +'</div>');

          $("#language_success").fadeTo(2000, 500).slideUp(500, function() {
            $("#language_success").slideUp(500);
          });
          $('.addLanguages').show();


        },

        error: function(json){

          if (json.status === 422) {
            var resJSON = json.responseJSON;
            $('.help-block').html('');
            $.each(resJSON.errors, function (key, value) {
            $('.' + key + '-error').html('<strong>' + value + '</strong>');
            $('#div_' + key).addClass('has-error');
          });

          }
        }
      });
    }

  }

  function delete_user_language(id) {

    var msg = "Are you sure! you want to delete?";
    if (confirm(msg)) {
    $.post(baseurl + "delete-language", {id: id, _method: 'DELETE', _token: csrf_token})
      .done(function (response) {
          if (response == 'ok')
          {                    
            $('.undo_language_'+id).show();
            $('.delete_language_'+id).hide();
            $('.edit_language_'+id).hide();    
            $('.language_edited_div_' + id).removeClass("language_div");
            if($(".language_div").length == 1){
              $('.delete_language').hide();
            }
          } else
          {
            alert('Request Failed!');
          }
      });
    }
  }

  function undo_user_language(id) {
      var msg = "Are you sure! you want to undo?";
      if (confirm(msg)) {
        $.post(baseurl + "undo-language", {id: id, _method: 'POST', _token: csrf_token})
        .done(function (response) {
          if (response == 'ok')
          {                    
            $('.undo_language_'+id).hide();
            $('.delete_language_'+id).show();
            $('.edit_language_'+id).show();
            $('.language_edited_div_' + id).addClass("language_div");           
            if($(".language_div").length > 1){
              $('.language_div').find(".delete_language").show();
            }
          } else
          {
            alert('Request Failed!');
          }
        });
      }
  }

  function cancelUserLanguageForm(language_id) {

    if(language_id!=0){      
      $('.language_edited_div_'+language_id).show();
    }
    $('.append-card-language').html('');
    $('#div-'+act_ftab).find(".btn-add").show();

  }
  /**End of Languages */

  /**Location Country */

  $(document).on('change', '#country_id_dd', function (e) {
      e.preventDefault();
      $('#location').val('');
  });

  /** */
  $('.select2-hidden-accessible').on('select2:open', function() {
      document.querySelector('.select2-search__field').focus();
  });

  function CountryChange(){
    $('.country_change').show();
    $('.country_text').hide();
  }
  

  /**
    * Search Location
    */
  $(function(){
    var location_user = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: 'api/autocomplete/search_location',
    remote: {
        url: "api/autocomplete/search_location",
        replace: function(url, query) {
          var country_code = $('#country_id').find(':selected').attr('data-code')
          return url + "?q=" + query+"&country_code="+country_code;
        },        
        filter: function(stocks) {
          return $.map(stocks, function(data) {
            return {
                // tokens: data.tokens,
                // symbol: data.symbol,
                name: data.name
            }
          });
        }
    }
  });
  
  location_user.initialize();
      $('#user_location.typeahead').typeahead({
      hint: true,
      highlight: false,
      minLength: 1,
  },{
      name: 'location_user',
      displayKey: 'name',
      source: location_user.ttAdapter(),
      limit:Number.MAX_VALUE
      }); 
  });
  
  $(document).on('click', '#pills-tab .nav-item', function (event) {
    event.preventDefault();
    act_ftab = $(this).children().attr('data-id');
    showData(act_ftab);
  });

  function showData(tab){

    $('#'+tab+"_div").addClass('is-loading');

    // $('#div-'+tab).addClass('is-loading');
    switch(tab) {
      case 'education':
        $.post(baseurl + "show-education", {_method: 'POST', _token: csrf_token})
          .done(function (response) {
          $('#education_div').html(response);
          $('#'+tab+"_div").removeClass('is-loading');
        });
        break;
      case 'experience':
        $.post(baseurl + "show-experience", {_method: 'POST', _token: csrf_token})
          .done(function (response) {
          $('#experience_div').html(response);
          $('#'+tab+"_div").removeClass('is-loading');
        });
        break;
      case 'projects':
        $.post(baseurl + "show-projects", {_method: 'POST', _token: csrf_token})
        .done(function (response) {
            $('#projects_div').html(response);
            $('#'+tab+"_div").removeClass('is-loading');
        });
        break;
      case 'skill':
        $.post(baseurl + "show-skills", {_method: 'POST', _token: csrf_token})
          .done(function (response) {
          $('#skill_div').html(response);
          $('#'+tab+"_div").removeClass('is-loading');
        });
        break;
      case 'language':
        $.post(baseurl + "show-languages", {_method: 'POST', _token: csrf_token})
        .done(function (response) {
          $('#language_div').html(response);
          $('#'+tab+"_div").removeClass('is-loading');
        });
        break;
      default:
        // code block
    }

  }  

  $(document).on('click', '.openForm', function (event) {

    form = $(this).attr('data-form');
    id = $(this).attr('data-id');
    type_id = $(this).attr('data-type-id');

    $('#div-'+act_ftab).find(".btn-add").hide();

    switch(act_ftab) {
      case 'education':
          loadUserEducationForm(form, id, type_id);
        break;
      case 'experience':
        loadUserExperienceForm(form, id);        
        break;
      case 'projects':
        loadUserProjectForm(form, id);             
        break;
      case 'skill':
        loadUserSkillForm(form, id);
        break;
      case 'language':
        loadUserLanguageForm(form, id);        
        break;
      default:
        // code block
    }

  });


  function loadUserEducationForm(form, id=null, type_id=null){

      let route = baseurl + "get-education-form";
      let param = {"_token": csrf_token};
      if(form=='edit'){
        route = baseurl + "get-education-edit-form";
        param = {"education_id": id, "_token": csrf_token};
      }

      $.ajax({
        type: "POST",
        url: route,
        data: param,
        datatype: 'json',
        success: function (json) {
                     
          $('.education_div').show();         
          if(form=='edit'){
            $('.education_edited_div_'+id).hide();
          }
          $(".append-form-education").html(json.html);

          $('#education_level_id').select2();
          $('#education_type_id').select2();
          $('#country_id_dd').select2();

          $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");
          selmark();
          if(form=='edit'){
            filterEducationTypes(type_id);
            StillCheck('education');
          }

        }

      });      
      $('.addEducation').hide();
  }
  
  function loadUserExperienceForm(form, id=null){

    // Education form validation starts

    let route = baseurl + "get-experience-form";
    let param = {"_token": csrf_token};
    if(form=='edit'){
      route = baseurl + "get-experience-edit-form";
      param = {"profile_experience_id": id, "_token": csrf_token};
    }

    $.ajax({
      type: "POST",
      url: route,
      data: param,
      datatype: 'json',
      success: function (json) {

        $('.experience_div').show();
        if(form=='edit'){
          $('.experience_edited_div_'+id).hide();
        }

        $(".append-form-experience").html(json.html);
        $('#country_id_dd').select2();

          if(form=='edit'){
            StillCheck('experience');
          }   
        $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");

      } 

    });

  }

  function loadUserProjectForm(form, id=null){
    
    let route = baseurl + "get-project-form";
    let param = {"_token": csrf_token};
    if(form=='edit'){
      route = baseurl + "get-project-edit-form";
      param = {"project_id": id, "_token": csrf_token};
    }

    $.ajax({
      type: "POST",
      url: route,
      data: param,
      datatype: 'json',
      success: function (json) {  

        $('.project_div').show();    

        if(form=='edit'){
        $('.project_edited_div_'+id).hide();
        }
        $(".append-form-project").html(json.html);                
        $('#country_id_dd').select2();
        if(form=='edit'){
          StillCheck('project');
        }   
        $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");

      }

    });

  }
  // function loadUserSkillForm(suggested_skill_id){
  function loadUserSkillForm(form, id=null){

    let route = baseurl + "get-skill-form";
    let param = {"_token": csrf_token, "suggested_skill_id": 0};
    if(form=='edit'){
      route = baseurl + "get-skill-edit-form";
      param = {"skill_id": id, "_token": csrf_token};
    }

    $.ajax({
      type: "POST",
      url: route,
      data: param,
      datatype: 'json',
      success: function (json) {  
        $('.skill_div').show();
        if(form=='edit'){
          $('.skill_edited_div_'+id).hide();
        }
        $(".append-form-skill").html(json.html);
        $('#skill_id').select2();  
        if(form=='edit'){        
          StillCheck('skill');
        }
        $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");

      }

    });

  }
         
  function loadUserLanguageForm(form, id=null){

    let route = baseurl + "get-language-form";
    let param = {"_token": csrf_token};
    if(form=='edit'){
      route = baseurl + "get-language-edit-form";
      param = {"user_language_id": id, "_token": csrf_token};
    }
  
    $.ajax({
      type: "POST",
      url: route,
      data: param,
      datatype: 'json',
      success: function (json) {  

        $('.language_div').show();   
        if(form=='edit'){         
          $('.language_edited_div_'+id).hide();
        }
        $(".append-card-language").html(json.html);
        $('#language_id').select2();
        $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");

      }

    });

  }
  
  function StillCheck(form){
  
    if(form=='education'){          
      if($("input[name='pursuing']").is(':checked') == false){
        $('.to_year').prop('disabled', false);
        $(".to_year").css("cursor",'pointer');
      }else{
        $('.to_year').prop('disabled', true);   
        $(".to_year").css("cursor",'not-allowed'); 
        $('.to_year').val('');    
      }  
    }
    
    if(form=='experience'){          
      if($("input[name='is_currently_working']").is(':checked') == false){          
        $("#date_end").prop('disabled', false);
        $("#date_end").css("cursor",'pointer');
      }else{
        $("#date_end").prop('disabled', true);
        $("#date_end").css("cursor",'not-allowed');
        $("#date_end").val('');
      }  
    }
    
    if(form=='project'){          
      if($("input[name='is_on_going']").is(':checked') == false){          
        $("#date_end").prop('disabled', false);
        $("#date_end").css("cursor",'pointer');
      }else{
        $("#date_end").prop('disabled', true);
        $("#date_end").css("cursor",'not-allowed');
        $("#date_end").val('');
      }  
    }
    
    if(form=='skill'){          
      if($("input[name='is_currently_working']").is(':checked') == false){          
        $("#end_date").prop('disabled', false);
        $("#end_date").css("cursor",'pointer');
      }else{
        $("#end_date").prop('disabled', true);
        $("#end_date").css("cursor",'not-allowed');
        $("#end_date").val('');
      }  
    }

  }