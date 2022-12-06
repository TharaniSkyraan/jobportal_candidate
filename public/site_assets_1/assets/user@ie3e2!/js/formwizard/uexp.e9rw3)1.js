let csrf_token = $('meta[name=csrf-token]').attr('content');

$(document).on("keyup","#job_description",function(e){
      var len = this.value.length;
      set = 255;
      if (len >= set) {
          this.value = this.value.substring(0, set);
      }
      if (len >= set) {
        $('.job_desc_remain_char').html('Remaining Maximum characters: <span class="text-danger">'+(set-len)+'</span>');
      }else{
        $('.job_desc_remain_char').html('');
      }
  });

  if(count==0){
    loadUserExperienceForm();
  }
  /** Experience Form Script  */

  $(document).on('change', '#country_id_dd', function (e) {
      e.preventDefault();       
      $('#location').val('');
  });
  
  showExperience();

  function showExperience()
  {

      $.post(baseurl + "/show-experience", {_method: 'POST', _token: csrf_token})

      .done(function (response) {

      $('#experience_div').html(response);

      });

  }

  //add more fields group
  $(document).on("click",".addExperience",function(){

      loadUserExperienceForm();

  });

  function loadUserExperienceForm(){

      $.ajax({

          type: "POST",
          url: baseurl + "/get-experience-form",
          data: {"_token": csrf_token},
          datatype: 'json',
          success: function (json) {
            $(".append-card").html(json.html);
            $('#country_id_dd').select2();
          }

      });
      $('.addExperience').hide();

  }

  function loadUserExperienceEditForm(profile_experience_id){
     $.ajax({
      type: "POST",
      url: baseurl + "/get-experience-edit-form",
      data: {"profile_experience_id": profile_experience_id, "_token": csrf_token},
      datatype: 'json',
      success: function (json) {

          $('.experience_div').show();    
          $('.experience_edited_div_'+profile_experience_id).hide();

          $(".append-card").html(json.html);
          $('#country_id_dd').select2();
          StillCheck();
          $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");
        }

      });
      $('.addExperience').hide();

  }

  function submitUserExperienceForm() {

    // form validation starts
    clrErr();
    var errStaus = false; 
    
    if(validateFormFields('title','Please enter title.','ValiDesignation')) errStaus=true;
    if(validateFormFields('company','Please enter company','ValiCity')) errStaus=true;
    if(validateFormFields('country_id_dd','Please enter Country id','')) errStaus=true;
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
    // form validation ends

    if(errStaus == false){

      var form = $('#add_edit_user_experience');

      $.ajax({
      url     : form.attr('action'),
      type    : form.attr('method'),
      data    : form.serialize(),
      dataType: 'json',
      success : function (json){

        $('.append-card').html('');          
        $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");
        showExperience();
        $('#success').html('<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert-update">'
                          +'<strong>Success!</strong> Experience Updated'
                          +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                        +'</div>');

        $("#success").fadeTo(2000, 500).slideUp(500, function() {
          $("#success").slideUp(500);
        });
        
          $('.addExperience').show();

      },
      error: function(json){

          if (json.status === 422) {

              var resJSON = json.responseJSON;

              $('.help-block').html('');

              $.each(resJSON.errors, function (key, value) {

               $('.' + key + '-error').html(value);
              });

          } 

        }

      });
    }

  }

  function delete_user_experience(id) {
    var msg = "Are you sure! you want to delete?";
    if(confirm(msg)) {
      $.post(baseurl + "/delete-experience", {id: id, _method: 'DELETE', _token: csrf_token})
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
      $.post(baseurl + "/undo-experience", {id: id, _method: 'POST', _token: csrf_token})
          .done(function (response) {
              if (response == 'ok')
              {        
                          
                $('.undo_experience_'+id).hide();
                $('.delete_experience_'+id).show();
                $('.edit_experience_'+id).show();
                $('.delete_experience').show();
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
    $('.append-card').html('');
    $('.addExperience').show();

  }

function PreviousPage(){
  if ($("#add_edit_user_experience").serialize()) {
      var answer = window.confirm("Are you sure want to cancel ?");

      if(answer){
        window.location = baseurl + "/education";
      }
    } else {
      window.location = baseurl + "/education";
    }
  
}

function NextPage(origForm){
    
    if(employment_status =='experienced'){

      if($(".experience_div").length <= 0){
          $('#success').html('<div class="alert alert-danger alert-dismissible fade show" role="alert" id="success-alert-update">'
                                +'<strong>Missing!</strong> Add Experience Detail Atleast One'
                                +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                              +'</div>');

          $("#success").fadeTo(2000, 500).slideUp(500, function() {
            $("#success").slideUp(500);
          });
      }else{

          if ($("#add_edit_user_experience").serialize()) {
            var answer = window.confirm("Are you sure want to cancel ?");

            if(answer){
              window.location = baseurl + "/skills";
            }
          }else{
              window.location = baseurl + "/skills";
          }
      }
        
    }else{
      window.location = baseurl + "/skills";
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

/** End Of Form Script */

$('.select2-hidden-accessible').on('select2:open', function() {
    document.querySelector('.select2-search__field').focus();
});
    
//still working diasbled date function 
$(document).on("click","#flexCheckDefault",function(){
  StillCheck();
}); 
//still working diasbled date function ends

function CountryChange(){
  $('.country_change').show();
  $('.country_text').hide();
}
function StillCheck(){
    if($("input[name='is_currently_working']").is(':checked') == false){          
      $("#date_end").prop('disabled', false);
      $("#date_end").css("cursor",'pointer');
    }else{
      $("#date_end").prop('disabled', true);
      $("#date_end").css("cursor",'not-allowed');
      $("#date_end").val('');
    }
}