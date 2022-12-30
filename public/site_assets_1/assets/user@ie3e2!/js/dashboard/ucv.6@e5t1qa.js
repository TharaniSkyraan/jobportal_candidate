let csrf_token = $('meta[name=csrf-token]').attr('content');


$('input[name=primary]').on('change', function() {

    var val = $('input[name=primary]:checked').val();            
    var value = $(this).data('value');
    if(value == 1){
        $(".prime1").hide();
        $(".prime2").show();
        $(".primeinfo1").show();
        $(".primeinfo2").hide();
    }else if(value == 2){
        $(".prime1").show();
        $(".prime2").hide();
        $(".primeinfo1").hide();
        $(".primeinfo2").show();
    }
    
    $.post(baseurl + "/make-default-cv", {id: val, _method: 'POST', _token: csrf_token})
    .done(function (response) {
        if (response == 'ok')
        {       
            toastr.options.timeOut = 10000;
            toastr.success('Successfully Updated.');             
            // window.location = baseurl + "/resume-details";
        } else
        {
            alert('Request Failed!');
        }
    });

});

function Replace(val=''){
    $('#resume_id').val(val);
}  

function deleteResumes(id) {
    msg = 'Are you sure? You are going to delete resume!';
    if (confirm(msg)) {
        $.post(baseurl + "/delete-front-profile-cv", {id: id, _method: 'DELETE', _token: csrf_token})
        .done(function (response) {
            if (response == 'ok')
            {   
                $('.resume'+id).remove();
                $('.upload-resume').show();
                toastr.options.timeOut = 10000;
                toastr.success('Successfully Deleted.');
            } else
            {
                alert('Request Failed!');
            }
        });
    }
}  

function submitCvs()
{

    fErr = validateFile();

    if(fErr){

        var formData = new FormData();
        formData.append("_token", $('input[name=_token]').val());
        formData.append("resume_id", $('#resume_id').val());
        formData.append("file", $('#file')[0].files[0]);
        if($('#resume_id').val()=='')
        {
            var uri = baseurl + '/store-front-profile-cv';
        }else{
            var uri = baseurl + '/update-front-profile-cv';
        }

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
            url     : uri,
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
            
                window.location = baseurl + "/resume-details";
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

$('.download-resume').click(function() {
    const aTag = document.createElement('a');
    aTag.rel = 'noopener';
    aTag.target = "_blank";
    aTag.href = baseurl + '/downloadcv/'+$(this).data("aci");
    aTag.click();
});
