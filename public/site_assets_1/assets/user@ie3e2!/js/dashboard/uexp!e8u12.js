    let csrf_token = $('meta[name=csrf-token]').attr('content');
  
    /** Experience Form Script  */

    //==============================================================//


    $(document).on('click', '.openForm', function (event) {

      form = $(this).attr('data-form');
      id = $(this).attr('data-id');
      type_id = $(this).attr('data-type-id');
      loadUserExperienceForm(form, id);   
  
    });
    showExperience();
    function showExperience()
    {

        $.post(baseurl + "show-experience", {_method: 'POST', _token: csrf_token})

        .done(function (response) {

          $('#experience_div').html(response);

        });

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
  
          $('.addExperience').hide();
        } 
  
      });
  
    }
    
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

      if($('.date_start').val() !='')
      {
        var date_start = new Date($('.date_start').val());
        date_start = (date_start.getFullYear())+'-'+(date_start.getMonth()+1);
      }
      if($('.date_end').val() !='')
      {
        var date_end = new Date($('.date_end').val());
        date_end = (date_end.getFullYear())+'-'+(date_end.getMonth()+1);
      }

      if($("input[name='is_currently_working']").is(':checked') == false){
        if(date_start >= date_end){
            setMsg('date_start','Please select less than from end year of month'); errStaus=true;
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
          // profilePercentage();
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

    function cancelUserExperienceForm(experience_id) 
    {

      $('.experience_div').show();
      $('.addExperience').show();
      if(experience_id!=0){      
        $('.experience_edited_div_'+experience_id).show();
      }
      
      if($(".experience_div").length==0){
      $('.append-form-experience').html(`<div class="text-center"><img draggable="false" src="${baseurl}site_assets_1/assets/img/fresher.png" height="250" width="250"></div>`);
      }else{
        $('.append-form-experience').html('');
      }

    }

    /**End of Experience */
    
  
  function StillCheck(form){
  

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
  
  $(document).on('change', '#country_id_dd', function (e) {
    e.preventDefault();
    $('#location').val('');
  });
  
  function CountryChange(){
    $('.country_change').show();
    $('.country_text').hide();
  }