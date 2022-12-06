    let csrf_token = $('meta[name=csrf-token]').attr('content');


    function SkillLevel(){
        clrErr();
    }
    showSkills();

    //add more fields group
    $(document).on("click",".addSkills",function(){
        loadUserSkillForm(null);
    });

    if(count==0){
        loadUserSkillForm(null);
    }
  function loadUserSkillForm(suggested_skill_id){

    if(suggested_skill_id !=0){
      $('#suggestion_skill_div_' + suggested_skill_id).remove();
    }      

      $.ajax({
        type: "POST",
        url: baseurl + "/get-skill-form",
        data: {"_token": csrf_token, "suggested_skill_id": suggested_skill_id},
        datatype: 'json',
        success: function (json) {
          $(".append-card").html(json.html);
          $('#skill_id').select2();
        }
      });
    $('.addSkills').hide();

  }
  
  function loadUserSkillEditForm(skill_id){

      $.ajax({

      type: "POST",

      url: baseurl + "/get-skill-edit-form",

      data: {"skill_id": skill_id, "_token": csrf_token},

      datatype: 'json',

      success: function (json) {
        $('.skill_div').show();            
        $('.skill_edited_div_'+skill_id).hide();
        $(".append-card").html(json.html);
        $('#skill_id').select2();
        $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");
        StillCheck();
      }

    });
    
    $('.addSkills').hide();

  }

  function submitUserSkillForm() {
    // form validation starts
    clrErr();
    var errStaus = false; 
    var skill_id = $('#skill_id').val();
    
    if(validateFormFields('skill_id','Please enter skill','')) errStaus=true;

    var checked_val = $('input[name="level_id"]:checked').val();

    if((checked_val == '') || (checked_val == undefined)){
      validateFormFields('level_id','Please enter experience','');
      errStaus=true;
    } 
    
    // form validation ends

    if(errStaus == false){


      var form = $('#add_edit_user_skill');

      $.ajax({

        url     : form.attr('action'),

        type    : form.attr('method'),

        data    : form.serialize(),

        dataType: 'json',

        success : function (json){


          $('.append-card').html('');

            $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");
          showSkills();
          
          $('#success').html('<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert-update">'
                            +'<strong>Success!</strong> Skill Updated'
                            +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                          +'</div>');

          $("#success").fadeTo(2000, 500).slideUp(500, function() {
            $("#success").slideUp(500);
          });
          $('.addSkills').show();
          $('#suggestion_skill_div_' + skill_id).remove()

        },

        error: function(json){

            if (json.status === 422) {

                var resJSON = json.responseJSON;

                $('.help-block').html('');

                $.each(resJSON.errors, function (key, value) {

                $('.' + key + '-error').html('<strong>' + value + '</strong>');

                $('#div_' + key).addClass('has-error');

                });

            } else {

                // Error

                // Incorrect credentials

                // alert('Incorrect credentials. Please try again.')

            }

        }

      });

    }

  }

  function delete_user_skill(id) {
      var msg = "Are you sure! you want to delete?";
      if (confirm(msg)) {
          $.post(baseurl + "/delete-skill", {id: id, _method: 'DELETE', _token: csrf_token})
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
      $.post(baseurl + "/undo-skill", {id: id, _method: 'post', _token: csrf_token})
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

  function showSkills(){

      $.post(baseurl + "/show-skills", {_method: 'POST', _token: csrf_token})

          .done(function (response) {

          $('#skill_div').html(response);

          });

  }

  function cancelUserSkillForm(skill_id) {

    if(skill_id!=0){      
      $('.skill_edited_div_'+skill_id).show();
    }
    $('.append-card').html('');
    $('.addSkills').show();

  }

  function PreviousPage(){
    if ($("#add_edit_user_skill").serialize()) {
      var answer = window.confirm("Are you sure want to cancel ?");

      if(answer){
        window.location = baseurl + "/experience";
      }
    } else {
      window.location = baseurl + "/experience";
    }
    
  }

  function NextPage(origForm){
  
      if($(".skill_div").length <= 0){
        $('#success').html('<div class="alert alert-danger alert-dismissible fade show" role="alert" id="success-alert-update">'
                              +'<strong>Missing!</strong> Add Skill Detail Atleast One'
                              +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                            +'</div>');

        $("#success").fadeTo(2000, 500).slideUp(500, function() {
          $("#success").slideUp(500);
        });
      }else{
        
          if ($("#add_edit_user_skill").serialize()) {
            var answer = window.confirm("Are you sure want to cancel ?");

            if(answer){
              window.location = baseurl + "/languages";
            }
          } else {
              window.location = baseurl + "/languages";
          }
      }
   
  }

    
$(document).on("click","#is_currently_working",function(){
  StillCheck();
}); 
function StillCheck(){
  if($("input[name='is_currently_working']").is(':checked') == false){          
    $("#end_date").prop('disabled', false);
    $("#end_date").css("cursor",'pointer');
  }else{
    $("#end_date").prop('disabled', true);
    $("#end_date").css("cursor",'not-allowed');
    $("#end_date").val('');
  }
}

