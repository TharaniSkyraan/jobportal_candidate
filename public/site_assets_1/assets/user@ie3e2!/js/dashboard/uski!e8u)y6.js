 let csrf_token = $('meta[name=csrf-token]').attr('content');

$(document).on('click', '.openForm', function (event) {
    form = $(this).attr('data-form');
    id = $(this).attr('data-id');
    type_id = $(this).attr('data-type-id');
    loadUserSkillForm(form, id);
});

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
        $('.addSkills button').hide();
        // toastr.options.timeOut = 1000;
        // toastr.success('Successfully Updated.');  
      }

    });

  }
  
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
    
  if($('.start_date').val() !='')
  {
    var start_date = new Date($('.start_date').val());
    start_date = (start_date.getFullYear())+'-'+(start_date.getMonth()+1);
  }
  if($('.end_date').val() !='')
  {
    var end_date = new Date($('.end_date').val());
    end_date = (end_date.getFullYear())+'-'+(end_date.getMonth()+1);
  }

  if($("input[name='is_currently_working']").is(':checked') == false){
    if($('#end_date').val() != '' || $('#start_date').val() != ''){
      if(validateFormFields('start_date','Please select Date start','')) errStaus=true;
      if(validateFormFields('end_date','Please select Date end','')) errStaus=true;
      if(end_date <= start_date && $('.start_date').val() !=''){
        setMsg('end_date','Please select greater than from year'); errStaus=true;
      }
    }
  }
  
  if($("input[name='is_currently_working']").is(':checked') == true){
    if(validateFormFields('start_date','Please select date start','')) errStaus=true;
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
      $('.btn_c_s1').prop("disabled", true);

      $.ajax({

        url     : form.attr('action'),
        type    : form.attr('method'),
        data    : form.serialize(),
        dataType: 'json',
        success : function (json){

          $('.skill_div').show();   
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
          $('.addSkills button').show();

          $('.btn_c_s1').prop("disabled", false);
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

            $('.btn_c_s1').prop("disabled", false);
        }

      });
    }

  }
  showSkills();

  function showSkills(){

    $.post(baseurl + "show-skills", {_method: 'POST', _token: csrf_token})
    .done(function (response) {

        $('#skill_div').html(response);

    });

}
  function delete_user_skill(id) {
    swal({
      text: "Are you sure! you want to delete?",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if(willDelete) {
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
    });
  }
  function undo_user_skill(id) {
    swal({
      text: "Are you sure! you want to undo?",
      buttons: true,
    })
    .then((willUndo) => {
        if(willUndo) {
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
    });
  }


  function cancelUserSkillForm(skill_id) {

    if(skill_id!=0){      
    $('.skill_edited_div_'+skill_id).show();
    }
    $('.append-form-skill').html('');
    $('.addSkills button').show();


  }
  function SkillLevel(){
    clrErr();
  }
  
  function StillCheck(form){
    
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
