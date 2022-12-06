
let csrf_token = $('meta[name=csrf-token]').attr('content');

//add more fields group
$(document).on("click",".addLanguages",function(){
  loadUserLanguageForm();
});

if(count==0){
    loadUserLanguageForm(null);
}
function loadUserLanguageForm(){

    $.ajax({

    type: "POST",

    url: baseurl + "/get-language-form",

    data: {"_token": csrf_token},

    datatype: 'json',

    success: function (json) {

        $(".append-card").html(json.html);
        $('#language_id').select2();
      }

    });
  
    $('.addLanguages').hide();  

}

function loadUserLanguageEditForm(user_language_id){

    $.ajax({

    type: "POST",

    url: baseurl + "/get-language-edit-form",

    data: {"user_language_id": user_language_id, "_token": csrf_token},

    datatype: 'json',

    success: function (json) {

      $('.language_div').show();          
      $('.language_edited_div_'+user_language_id).hide();
      $(".append-card").html(json.html);
      $('#language_id').select2();
      $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");

    }

    });
    $('.addLanguages').hide();

}

function submitUserLanguageForm() {

// form validation starts
  clrErr();
  var errStaus = false; 
  
  if(validateFormFields('language_id','Please select language','')) errStaus=true;

  var checked_val = $('input[name="language_level_id"]:checked').val();

  if((checked_val == '') || (checked_val == undefined)){
    validateFormFields('language_level_id','Please select language level','');
    errStaus=true;
  } 
  
  if($("input[name='write']:checked").val() == undefined && $("input[name='read']:checked").val() == undefined && $("input[name='speak']:checked").val() == undefined){
    $('#err_swr').html('Please select the above options')
    errStaus=true;
  }
  // form validation ends
if(errStaus == false){

  var form = $('#add_edit_user_language');

  $.ajax({
      url     : form.attr('action'),
      type    : form.attr('method'),
      data    : form.serialize(),
      dataType: 'json',
      success : function (json){
        $('.append-card').html('');
        $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");
        showLanguages();
        $('#success').html('<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert-update">'
                          +'<strong>Success!</strong> Language Updated'
                          +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                        +'</div>');

        $("#success").fadeTo(2000, 500).slideUp(500, function() {
          $("#success").slideUp(500);
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
    $.post(baseurl + "/delete-language", {id: id, _method: 'DELETE', _token: csrf_token})
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
      }else
      {
        alert('Request Failed!');
      }
    });
  }
}

function undo_user_language(id) {
    var msg = "Are you sure! you want to undo?";
    if (confirm(msg)) {
      $.post(baseurl + "/undo-language", {id: id, _method: 'POST', _token: csrf_token})
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

$(document).ready(function(){

  showLanguages();

});

function showLanguages()
{

$.post(baseurl + "/show-languages", {_method: 'POST', _token: csrf_token})

.done(function (response) {

$('#language_div').html(response);

});

}

function cancelUserLanguageForm(language_id) {

if(language_id!=0){      
  $('.language_edited_div_'+language_id).show();
}
$('.append-card').html('');
$('.addLanguages').show();

}

function PreviousPage()
{
if ($("#add_edit_user_language").serialize()) {
    var answer = window.confirm("Are you sure want to cancel ?");

    if(answer){
      window.location = baseurl + "/skills";
    }
  } else {
    window.location = baseurl + "/skills";
  }

}

function NextPage(origForm){      
  
if($(".language_div").length <= 0){

  $('#success').html('<div class="alert alert-danger alert-dismissible fade show" role="alert" id="success-alert-update">'
                        +'<strong>Missing!</strong> Add Language Detail Atleast One'
                        +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                      +'</div>');

  $("#success").fadeTo(2000, 500).slideUp(500, function() {
    $("#success").slideUp(500);
  });

}else{
        
  if ($("#add_edit_user_language").serialize()) {
    var answer = window.confirm("Are you sure want to cancel ?");

    if(answer){
      // Redirect Dashboard
     if(cv==0 && cerror_count==0){
        $("#resume_upload_modal").modal('show');
      }else{
        window.location = baseurl + "/completed_signup";
      }
    }
  } else {
    // Redirect Dashboard
    if(cv==0 && cerror_count==0){
        $("#resume_upload_modal").modal('show');
    }
    else
    {
      window.location = baseurl + "/completed_signup";
    }
  }

}

}

function validateFile() {

var exts = ['doc','docx','pdf','rtf','txt'];
var single_file_size_max_limit=5;
var total_allowed_file =1;
$('.file-error').html('');
$errStaus = false;
fieldVal = document.getElementById('file');
fieldId = 'file';
if (fieldVal.files.length > 0) {
    if (fieldVal.files.length <= total_allowed_file) {
        // RUN A LOOP TO CHECK EACH SELECTED FILE.
        // for (var i = 0; i <= fieldVal.files.length - 1; i++) {
            i=0;
            var fname = fieldVal.files.item(i).name;
            var fsize = fieldVal.files.item(i).size / 1024 / 1024;
            // const fileSize = fileUpload.files[0].size / 1024 / 1024; // in MiB
            if (fsize <= single_file_size_max_limit) {
                
                var get_ext = fname.split('.');
                get_ext = get_ext.reverse();
                // check file type is valid as given in 'exts' array
                if ($.inArray(get_ext[0].toLowerCase(), exts) > -1) {
                    $('.file-error').html('');
                } else {
                    $('.file-error').html('File extension not supported. Supported file extensions: .docx, .doc, .pdf, .rtf');
                    // setMsg(fieldId, 'Sorry! .' + get_ext[0].toLowerCase() + ' files can\'t be upload.');
                    $errStaus = true;
                    // break;
                }
            } else {
                $('.file-error').html('Sorry! Resume uploaded exceeds maximum file size limit ('+single_file_size_max_limit+' MB).');
                // setMsg(fieldId, 'Sorry! Maximum Single-file Size shound be less than ' + single_file_size_max_limit + ' MB.');
                $errStaus = true;
                // break;
            }
        // }
    } else {
        $('.file-error').html('');
        // setMsg(fieldId, 'Sorry! Maximum ' + total_allowed_file + ' Files only to process at single submission.');
        $errStaus = true;
    }
}else{
    $('.file-error').html('Please Select File');
    // setMsg(fieldId, 'Sorry! Maximum ' + total_allowed_file + ' Files only to process at single submission.');
    $errStaus = true;
}

if ($errStaus) {
    return false;
} else {
    return true;
}
}

function submitCvs()
{

fErr = validateFile();

if(fErr){

    var formData = new FormData();
    formData.append("_token", $('input[name=_token]').val());
    formData.append("file", $('#file')[0].files[0]);

    $("#show_p_bar").show();

    $.ajax({
        xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function(evt) {
              if (evt.lengthComputable) {
                  var percentComplete = ((evt.loaded / evt.total) * 100);
                  // percentComplete = Math.round(percentComplete);
                  percentComplete = Math.round(percentComplete);
                  // console.log(percentComplete);
                  
                  $('.success').html('File Uploading..');
                  $(".progress-bar").width(percentComplete + '%');
                  $(".progress-bar").html(percentComplete+'%');
                  if(percentComplete == 100)
                  {
                        $('.success').html('Uploading... Please wait');
                  }
              }
          }, false);
          return xhr;
        },
        url     : baseurl + '/resumeupdate',
        type    : 'POST',
        data    : formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function(){
                    
            $('.success').html('Submitting..');
            $(".progress-bar").width('0%');
            $(".progress-bar").html('0%');
        },
        success : function (json){
            
            $('.help-block').html('');
            $('.resume').hide();
            $(".progress-bar").width('100%');
            $(".progress-bar").html('100%');
            $(".progress-bar").removeClass('bg-primary');
            $(".progress-bar").addClass('bg-success');

            $('.success').html('Resume Uploaded Successfully');
            $(".success").fadeTo(3000, 500).slideUp(500, function() {
              // $(".success").slideUp(500);
              $("#resume_upload_modal").modal('toggle');
            });
          
            window.location = baseurl + "/completed_signup";
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

}else{
  $('.file-error').html('Please select valid file');
}

}