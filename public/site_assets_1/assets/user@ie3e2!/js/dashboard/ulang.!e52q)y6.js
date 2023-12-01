let csrf_token = $('meta[name=csrf-token]').attr('content');

 
$(document).on('click', '.openForm', function (event) {

  form = $(this).attr('data-form');
  id = $(this).attr('data-id');
  loadUserLanguageForm(form, id);      

});

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

      $('.addbtn').hide();
      $('.language_div').show();   
      if(form=='edit'){         
        $('.language_edited_div_'+id).hide();
      }
      $(".append-card-language").html(json.html);
      $('#language_id').select2();
      $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");

      // toastr.options.timeOut = 1000;
      // toastr.success('Successfully Updated.');  
      
    }

  });

}



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
    $('.btn_c_s1').prop("disabled", true);
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
        $('.addbtn').show();
        toastr.success(json.message);
        

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

function delete_user_language(id) {

  swal({
    text: "Are you sure! you want to delete?",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if(willDelete) {
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
              // toastr.success(response.message);
            }
          } else
          {
            alert('Request Failed!');
          }
      });
    }
  });

}

function undo_user_language(id) {
  swal({
    text: "Are you sure! you want to undo?",
    buttons: true,
  })
  .then((willUndo) => {
    if(willUndo) {
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
  });
}

function cancelUserLanguageForm(language_id) {

  if(language_id!=0){      
    $('.language_edited_div_'+language_id).show();
  }
  $('.append-card-language').html('');
  $('.addbtn').show();

}
showLanguages();
function showLanguages()
{

  $.post(baseurl + "show-languages", {_method: 'POST', _token: csrf_token})
  .done(function (response) {
    $('#language_div').html(response);
  });

}
