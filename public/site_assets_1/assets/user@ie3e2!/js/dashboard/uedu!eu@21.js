    let csrf_token = $('meta[name=csrf-token]').attr('content');
    /** Education Form Script */

    $(document).on('click', '.openForm', function (event) {
        
      form = $(this).attr('data-form');
      id = $(this).attr('data-id');
      type_id = $(this).attr('data-type-id');
      education_level_id = $(this).attr('data-education-level-id');
      loadUserEducationForm(form, id, type_id, education_level_id);

    });
    
    function loadUserEducationForm(form, id=null, type_id=null, education_level_id=null)
    {
        let route = baseurl + "get-education-form";
        let param = {"_token": csrf_token, "education_level_id": education_level_id};
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
            if(form=='edit')
            {
              $('.educationList_'+id).hide();
              $(".educationListEdit_"+id).html(json.html);
            }else
            {
              $('.educationListAdd_'+education_level_id).html(json.html);
            }
              $('#education_level_id').select2();
              $('#education_type_id').select2();
              $('#country_id_dd').select2();

              // $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");
              selmark();
            if(form=='edit'){
              filterEducationTypes(type_id);
              StillCheck('education');
            }else{
              filterEducationTypes(0);
            }
            $('.openForm').prop('disabled',true);

        }

        });      
        $('.addEducation').hide();
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

      var edu_type_id = $("#education_type_id").val();

      if(edu_type_id){
        
        // if(validateFormFields('university_board','Please select university board.','')) errStaus=true;
        
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
    showEducation();
    function showEducation(education_level_id=null)
    {
    
      $.post(baseurl + "show-education", {'education_level_id': education_level_id, _method: 'POST', _token: csrf_token})
      .done(function (response) {
        $.each(response.data, function (key, value) {
          $('#educationList_'+key).html(value);
        });

      });
    
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
                var education_level_id = $('#education_level_id option:selected').val();
                $('.form-empty').html('');
                $('.openForm').prop('disabled',false);
                showEducation(education_level_id);
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
            if(response==''){
              $('.education_type_div').hide();
              $('#education_types_dd').html(response); 
            }else{              
              $('.education_type_div').show();
              $('#education_types_dd').html(response); 
              $('#education_type_id').select2();
            }

          });

        }
        var education_level_text = $('#education_level_id option:selected').text();
        $('.education_level_id').html(' - '+education_level_text);
    }
    
    function cancelUserEducationForm(education_id) {

      if(education_id!=0){      
      $('.educationList_'+education_id).show();
      }
      $('.form-empty').html('');      
      $('.openForm').prop('disabled',false);
      $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");

    }
    
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

    /**End of Education */
   
    $(document).on("click","#pursuing",function(){     
      clrErr();
      StillCheck('education');
    });
    
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

    }


    $(document).on('change', '#country_id_dd', function (e) {
      e.preventDefault();
      $('#location').val('');
    });
    
    function CountryChange(){
      $('.country_change').show();
      $('.country_text').hide();
    }

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
  