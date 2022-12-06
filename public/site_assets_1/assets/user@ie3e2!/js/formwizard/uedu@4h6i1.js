let csrf_token = $('meta[name=csrf-token]').attr('content');

/** Education Form Script */
$(document).ready(function(){

  // add more fields group
  $(document).on("click",".addEducation",function(){          
    $(document).on('load',loadUserEducationForm());          
  });

  if(count==0){
    // loadUserEducationForm();
    $(document).on('load',loadUserEducationForm());          
  }
    
  $(document).on('change', '#education_level_id', function (e) {
    e.preventDefault();
    filterEducationTypes(0);
  });

  $(document).on('change', '#country_id_dd', function (e) {
    e.preventDefault();
    $('#location').val('');
  });

});

function loadUserEducationForm(){

    $.ajax({
      type: "POST",
      url: baseurl + "/get-education-form",
      data: {"_token": csrf_token},
      datatype: 'json',
      success: function (json) {
        $(".append-card").html(json.html);
        $('#education_level_id').select2();
        $('#education_type_id').select2();
        $('#country_id_dd').select2();
        
        $("#show_gpa_field").show();
        $("#show_percentage_field").hide();
        $("#show_grade_field").hide();

      }
    });
  $('.addEducation').hide();
}

showEducation();

function showEducation()
{

  $.post(baseurl + "/show-education", {_method: 'POST', _token: csrf_token})
  .done(function (response) {
    $('#education_div').html(response);
  });

}

function loadUserEducationEditForm(education_id, education_type_id){
    
  $.ajax({
      type: "POST",
      url: baseurl + "/get-education-edit-form",
      data: {"education_id": education_id, "_token": csrf_token},
      datatype: 'json',
      success: function (json) {

        $('.education_div').show();            
        $('.education_edited_div_'+education_id).hide();
        $(".append-card").html(json.html);
        filterEducationTypes(education_type_id);

        $('#education_level_id').select2();
        $('#education_type_id').select2();
        $('#country_id_dd').select2();
        
        $("#show_gpa_field").show();
        $("#show_percentage_field").hide();
        $("#show_grade_field").hide();
        $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");
        selmark();
        StillCheck();
      } 

  });
  $('.addEducation').hide();

}

function delete_user_education(id) {
    var msg = "Are you sure! you want to delete?";
    if (confirm(msg)) {
        $.post(baseurl + "/delete-education", {id: id, _method: 'DELETE', _token: csrf_token})
        .done(function (response) {
            if (response == 'ok')
            {   
              //$('.education_edited_div_' + id).remove();
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
    $.post(baseurl + "/undo-education", {id: id, _method: 'POST', _token: csrf_token})
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

/**  Submit */

function submitUserEducationForm() {
  clrErr();
  var errStaus = false; 
  if(validateFormFields('education_level_id','Please enter education level','')) errStaus=true;
  if(document.getElementById('education_type_id')!=null){
    if(validateFormFields('education_type_id','Please enter the Education type','')) errStaus=true;
  }
  if(validateFormFields('country_id_dd','Please enter Country','')) errStaus=true;
  if(validateFormFields('location','Please enter city','ValiCity')) errStaus=true;
  if($('#institution').val()!=''){
      if(validateFormFields('institution','Please enter Institution','ValInstitute')) errStaus=true;
  }
    var today = new Date();
    var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
    var yyyy = today.getFullYear();

    var yyyy1 = today.getFullYear()-100;

    todaymonthyear = yyyy+'-'+mm;
    yearincrtoday = yyyy1+'-'+mm;

            
    // var date = new Date();
    // var yearOfDate = date.getFullYear(); // 2025
    // var monthOfDate = date.getMonth() + 1; // 9
    // var dayOfMonth = date.getDate(); // 24

    // var together = [yearOfDate, monthOfDate].join('-');
    
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
        }else if( ($('.to_year').val() <= $('.from_year').val())){
          setMsg('to_year','Please select greater than from year'); errStaus=true;
        }
    }
        
    //   var score_vali = $('input[name="result_type_id"]:checked').val();

    //   if(score_vali == 1){
    //     if(validateFormFields('gpa','Please enter GPA','')) errStaus=true;
    //       var gpa_val = $("#gpa").val();
    //       if($.isNumeric(gpa_val)){
    //         var check_gpa_val = Math.round(gpa_val);
    //         if(check_gpa_val > 10){
    //           setMsg('gpa','Enter values from 1 to 10');
    //           errStaus=true;
    //         }
    //       }else{
    //         setMsg('gpa','Enter values from 1 to 10');
    //         errStaus=true;
    //       }
    //   }
    //   if(score_vali == 2){
    //     if(validateFormFields('grade','Please enter Grade','')) errStaus=true;
    //   }
    //   if(score_vali == 3){
    //     if(validateFormFields('percentage','Please enter percentage','')) errStaus=true;
    //   } 

  // form validation ends
  
  if(errStaus == false){

    var form = $('#add_edit_user_education');

    $.ajax({
      url     : form.attr('action'),
      type    : form.attr('method'),
      data    : form.serialize(),
      dataType: 'json',
      success : function (json){

        $('.append-card').html('');
        $(".tabs").animate({scrollTop: $(window).scrollTop(0)},"slow");
        showEducation();
        $('#success').html('<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert-update">'
                          +'<strong>Success!</strong> Education Updated'
                          +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                        +'</div>');

        $("#success").fadeTo(2000, 500).slideUp(500, function() {
          $("#success").slideUp(500);
        });
        $('.addEducation').show();
        
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
    $.post(baseurl + "/filter-education-types-dropdown", {education_level_id: education_level_id, education_type_id: education_type_id, _method: 'POST', _token: csrf_token})

      .done(function (response) {

          if(response!=''){
              $('.education_type_div').show();
          }else{
              $('.education_type_div').hide();
          }
          $('#education_types_dd').html(response);
          if(document.getElementById('education_type_id')){
            $('#education_type_id').select2();
          }

      });

    }

}


function cancelUserEducationForm(education_id) {

  if(education_id!=0){      
    $('.education_edited_div_'+education_id).show();
  }
  $('.append-card').html('');
  $('.addEducation').show();

}
function PreviousPage(){
  if ($("#add_edit_user_education").serialize()) {
    var answer = window.confirm("Are you sure want to cancel ?");

    if(answer){
      window.location = baseurl + "/basic_info";
    }
  } else {
    window.location = baseurl + "/basic_info";
  }
  
}

function NextPage(origForm){
  
  if($(".education_div").length <= 0){
      $('#success').html('<div class="alert alert-danger alert-dismissible fade show" role="alert" id="success-alert-update">'
                            +'<strong>Missing!</strong> Add Education Detail Atleast One'
                            +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                          +'</div>');

      $("#success").fadeTo(2000, 500).slideUp(500, function() {
        $("#success").slideUp(500);
      });
  }else{
    if ($("#add_edit_user_education").serialize()) {
      var answer = window.confirm("Are you sure want to cancel ?");

      if(answer){
        window.location = baseurl + "/experience";
      }
    } else {
      window.location = baseurl + "/experience";
    }
  }
  
}


/** End of Form Script */

function CountryChange(){
  $('.country_change').show();
  $('.country_text').hide();
}

$(document).on("click","#pursuing",function(){     
  clrErr();
  StillCheck();
});

function StillCheck(){
  if($("input[name='pursuing']").is(':checked') == false){
    $('.to_year').prop('disabled', false);
    $('.to_year').css("cursor",'pointer');  
  }else{
    $('.to_year').prop('disabled', true);  
    $('.to_year').css("cursor",'not-allowed');
    $('.to_year').val('');    
  }
}