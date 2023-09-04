let csrf_token = $('meta[name=csrf-token]').attr('content');

$(document).on('click', '.openForm', function (event) {
  $('.add-form .user-project-cancel').hide();
    form = $(this).attr('data-form');
    id = $(this).attr('data-id');
    loadUserProjectForm(form, id);
    
});

$(document).on("click","#is_on_going",function(){
  clrErr();
  StillCheck('project');
});

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
      $('.addProjects').hide();
      $('.project_div').show();    

      if(form=='edit'){
      $('.project_edited_div_'+id).hide();
      }
      $(".append-form-project").html(json.html);                
      $('#country_id_dd').select2();
      if(form=='edit'){
        StillCheck('project');
      }   
      
      $('.addProjects').hide();
      $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");

    }

  });

}
function validateprojectForm(){
  clrErr();
  var errStaus = false; 
  if(validateFormFields('name','Please enter Project title.','ValiCity')) errStaus=true;
  // if(validateFormFields('user_experience_id','Please enter Your project done by.','')) errStaus=true;
  // if(validateFormFields('country_id_dd','Please enter Country.','')) errStaus=true;
  // if(validateFormFields('location','Please enter city.','ValiCity')) errStaus=true;
  if(validateFormFields('description','Please enter Description.','')) errStaus=true;
  
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

  if($("input[name='is_on_going']").is(':checked') == false){
    if($("#add_edit_user_project").find('#date_end').val() != ''){
      if(validateFormFields('date_start','Please select Date start','')) errStaus=true;
      if(date_end <= date_start && $('.date_start').val() !=''){
        setMsg('date_end','Please select greater than from year'); errStaus=true;
      }
    }
  }else{
    if(validateFormFields('date_start','Please select date start','')) errStaus=true;
  }
  if($('#url').val() != ""){
    if(validateFormFields('url','Please enter valide link.','validateURL')) errStaus=true;
  }
  if($('#user_experience_id').val() == ""){
    setMsg('user_experience_id','Please enter Your project done by'); errStaus=true;
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
    $('.btn_c_s1').prop("disabled", true);
    $.ajax({
      url     : form.attr('action'),
      type    : form.attr('method'),
      data    : form.serialize(),
      dataType: 'json',
      success : function (json){
        $('.append-form-project').html('');
        $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");
        showProjects();
        $('.btn_c_s1').prop("disabled", false);

        // $('#project_success').html('<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert-update">'
        //         +'<strong>Success!</strong> Project Updated'
        //         +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
        //         +'</div>');
        // $("#project_success").fadeTo(2000, 500).slideUp(500, function() {
        // $("#project_success").slideUp(500);
        // });

        $('.addProjects').show();
        toastr.options.timeOut = 10000;
        toastr.success('Successfully Updated.');     
        // profilePercentage();

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
  $('.addProjects').show();
  $('.project_div').show();  
  if(project_id!=0){      
    $('.project_edited_div_'+project_id).show();
  }
  if($(".project_div").length==0){
    $('.append-form-project').html(`<div class="text-center"><img draggable="false" src="${baseurl}site_assets_1/assets/img/fresher.png" height="250" width="250"></div>`);
  }else{
    $('.append-form-project').html('');
  }
  $('.addProjects').show();

}

function StillCheck(form)
{
  
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

}
showProjects();
function showProjects(){
  $.post(baseurl + "show-projects", {_method: 'POST', _token: csrf_token})
  .done(function (response) {
      $('#projects_div').html(response);
      // $("div").removeClass('is-loading');
  });
}

$(document).on('click', '#work_as_team', function (event) 
{
  if($("input[name='work_as_team']").is(':checked') == false)
  {
    $('.team-length').hide();
  }else{
    $('.team-length').show();    
  }

});
function CountryChange(){
  $('.country_change').show();
  $('.country_text').hide();
}

$(document).on('change', '#country_id_dd', function (e) {
  e.preventDefault();
  $('#location').val('');
});

function collapsedProj(id){
  if($('.more-details-proj'+id).find(".collapsed").length == 0){ 
    $('.more-details-proj'+id).find(".collapse-up-arrow-proj").show();
    $('.more-details-proj'+id).find(".collapse-down-arrow-proj").hide();
  }else{
    $('.more-details-proj'+id).find(".collapse-up-arrow-proj").hide();
    $('.more-details-proj'+id).find(".collapse-down-arrow-proj").show();
  }
}

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