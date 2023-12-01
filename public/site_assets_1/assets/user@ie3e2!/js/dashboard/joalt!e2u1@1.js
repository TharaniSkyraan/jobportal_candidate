    let csrf_token = $('meta[name=csrf-token]').attr('content');
  
    /** JobAlert Form Script  */

    //==============================================================//


    $(document).on('click', '.openForm', function (event) {

      form = $(this).attr('data-form');
      id = $(this).attr('data-id');
      type_id = $(this).attr('data-type-id');
      loadJobAlertForm(form, id);   
  
    });
    showJobAlert();
    function showJobAlert()
    {

        $.post(baseurl + "show-job-alert", {_method: 'POST', _token: csrf_token})

        .done(function (response) {

          $('#job_alert_div').html(response);

            if($('#job_alert_div .card').length >= 5){
              $('.addJobAlert').hide();
            }else{
              $('.addJobAlert').show();
            }
        });

    }
    
    function loadJobAlertForm(form, id=null){
      // Jobalert form validation starts
  
      let route = baseurl + "get-job-alert-form";
      let param = {"_token": csrf_token};
      if(form=='edit'){
        route = baseurl + "get-job-alert-edit-form";
        param = {"job_alert_id": id, "_token": csrf_token};
      }
  
      $.ajax({
        type: "POST",
        url: route,
        data: param,
        datatype: 'json',
        success: function (json) {
  
          $('.addJobAlert').hide();
          $('.job_alert_div').show();
          if(form=='edit'){
            $('.job_alert_edited_div_'+id).hide();
          }
  
          $(".append-form-job_alert").html(json.html);
          $('#country_id_dd').select2();
  
          $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");
  
          
          rangeSetup($('#experienceFid').val());
        } 
  
      });
  
    }
    
    function validatejob_alertForm(){
      clrErr();
      var errStaus = false;
      if($('#title').val()==''){
        if(validateFormFields('location','Please enter city','ValiCity')) errStaus=true;
      } 
      if($('#location').val()==''){
        if(validateFormFields('title','Please enter Designation.','')) errStaus=true;
      }
      if(validateFormFields('country_id_dd','Please enter Country.','')) errStaus=true;
      
      if(errStaus) {
        return false;
      } else {
        return true;		
      }
    }


    function submitJobAlertForm() {
      var result = validatejob_alertForm(); 
      if(result != false){
       $('.btn_c_s1').prop("disabled", true);
        var form = $('#add_edit_user_job_alert');
        $.ajax({
        url     : form.attr('action'),
        type    : form.attr('method'),
        data    : form.serialize(),
        dataType: 'json',
        success : function (json){
          $('.append-form-job_alert').html('');
          $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");
          showJobAlert();

          $('#job_alert_success').html('<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert-update">'
                            +'<strong>Success!</strong> JobAlert Updated'
                            +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                          +'</div>');

          $("#job_alert_success").fadeTo(2000, 500).slideUp(500, function() {
            $("#job_alert_success").slideUp(500);
          });
          
          $('.btn_c_s1').prop("disabled", false);
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
            $('.btn_c_s1').prop("disabled", false);
          }
        });
      }
    }

    function delete_user_job_alert(id) {
      
      swal({
        text: "Are you sure! you want to delete?",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if(willDelete) {
            $.post(baseurl + "delete-job-alert", {id: id, _method: 'DELETE', _token: csrf_token})
            .done(function (response) {
              if (response == 'ok')
              {                    
                $('.undo_job_alert_'+id).show();
                $('.delete_job_alert_'+id).hide();
                $('.edit_job_alert_'+id).hide();
                $('.job_alert_edited_div_' + id).removeClass("job_alert_div");
                if($(".job_alert_div").length == 1){
                  $('.delete_job_alert').hide();
                }
              } else
              {
                  alert('Request Failed!');
              }
            });
        }
      });

    }

    function undo_user_job_alert(id) {
      
      swal({
        text: "Are you sure! you want to undo?",
        buttons: true,
      })
      .then((willUndo) => {
        if(willUndo) {
            $.post(baseurl + "undo-job-alert", {id: id, _method: 'POST', _token: csrf_token})
            .done(function (response) {
                  if (response == 'ok')
                  {                    
                    $('.undo_job_alert_'+id).hide();
                    $('.delete_job_alert_'+id).show();
                    $('.edit_job_alert_'+id).show();
                    $('.job_alert_edited_div_' + id).addClass("job_alert_div");           
                    if($(".job_alert_div").length > 1){
                      $('.job_alert_div').find(".delete_job_alert").show();
                    }

                  } else
                  {
                    alert('Request Failed!');
                  }
            });
        }
      });

    }

    function cancelJobAlertForm(job_alert_id) 
    {

      $('.job_alert_div').show();
      
      if($('#job_alert_div .card').length >= 5){
        $('.addJobAlert').hide();
      }else{
        $('.addJobAlert').show();
      }
      if(job_alert_id!=0){      
        $('.job_alert_edited_div_'+job_alert_id).show();
      }
      
      if($(".job_alert_div").length==0){
      $('.append-form-job_alert').html(`<div class="text-center no_kmbq1"><img draggable="false" src="${baseurl}images/profile/job_alert.svg" height="250" width="250"><div class="no_kmbq2">No<br/><strong>”JOB Alerts”</strong></div></div>`);
      }else{
        $('.append-form-job_alert').html('');
      }

    }

    /**End of JobAlert */
    
  
  function collapsedJobALert(id){
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
  
$(document).on('input', '#exp-range-slider' , function(e){
  let vall = $(this).val();
  $('#experienceFid').val(vall);
  rangeSetup(vall);
});

function rangeSetup(val='any'){

  const range = document.getElementById('exp-range-slider');
  const rangeV = document.getElementById('rangeV');
  var vall = 0;
  txt = 'Any';
  if(val === 'any'){
      txt = 'Any';
      vall = 30;
      document.getElementById('exp-range-slider').value = vall;
  }
  else{
      txt = val;
      vall = val ;
      document.getElementById('exp-range-slider').value = vall;
  }
  
  newValue = Number( (vall - range.min) * 100 / (range.max - range.min) );
  newPosition = 10 - (newValue * 0.2);

  rangeV.innerHTML = `<span>${txt}</span>`;
  rangeV.style.left = `calc(${newValue}% + (${newPosition}px))`;

}
