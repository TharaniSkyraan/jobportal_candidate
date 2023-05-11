    let csrf_token = $('meta[name=csrf-token]').attr('content');
 
    /** Education Form Script */
    $(function(){
      // if (education_level_id != ''){                      
      var path = baseurl + "/suggestion-education-types-dropdown";
    
      var cache = {};
      $('#education_type').typeahead({ // focus on first result in dropdown
          displayText: function(item) {
              return item.name
          },
          afterSelect: function(item) {
            this.$element[0].id = item.id
          },
          source: function(query, result) {
              var education_level_id = $('#education_level_id').val();
              if ((query in cache)) {
                  // If result is already in local_cache, return it
                  result(cache[query]);
                  return;
              }
              $.ajax({
                  url: path,
                  method: 'POST',
                  data: {q: query,education_level_id:education_level_id, _token: csrf_token},
                  dataType: 'json',
                  success: function(data) {
                      cache[query] = data;
                      result(data);
                  }
              });
          },
          autoSelect: true,
          showHintOnFocus: true
       }).focus(function () {
           $(this).typeahead("search", "");
       });
    });
    /**  Submit */

    function validateAccountForm() {
      clrErr();
      var errStaus = false; 
      if(validateFormFields('education_level_id','Please enter education level','')) errStaus=true;
       if($('.education_type_div').is(":visible")==true && $('.education_type').val()==''){
           if(validateFormFields('education_type','Please enter the Education type','')) errStaus=true;    
      }
      // form validation ends
      
      if(errStaus == false){
        return true;
      }else{
        return false;
      }
      
    }

    /**End Submit form */

    $(document).on('change', '#education_level_id', function (e) {
      e.preventDefault();
      $('.education_type').val('');
      filterEducationTypes();
    });

    function filterEducationTypes(education_type_id=0)
    {
        var education_level_id = $('#education_level_id').val();
          
        $.post(baseurl + "/filter-education-types-dropdown", {education_level_id: education_level_id, education_type_id: education_type_id, _method: 'POST', _token: csrf_token})
        .done(function (response) {

          if(response!=''){
            $('.education_type_div').show();
          }else{
            $('.education_type_div').hide();
          }

        });
    }
    /**EMployment status */
    $(document).on('click', '.employment_status', function (e) {
      checkstatus();
    });
    function checkstatus()
    {
        if($("input[name='employment_status']:checked").val()=='fresher'){
            $('.experience-text').removeClass('fw-bolder');
            $('.fresher-text').addClass('fw-bolder');
            $('.levtstge_fre').addClass('checked');
            $('.levtstge_exp').removeClass('checked');   
        }else
        
        if($("input[name='employment_status']:checked").val()=='experienced'){
            $('.fresher-text').removeClass('fw-bolder');
            $('.levtstge_exp').addClass('checked');
            $('.experience-text').addClass('fw-bolder');
            $('.levtstge_fre').removeClass('checked');
        }
    }
    checkstatus();

    /***Career Info */
    if(document.getElementById('country_id'))
    {

      if(document.getElementById('phone'))
      {
       
        var input = document.querySelector("#phone");
        var iti = window.intlTelInput(input, {
            separateDialCode: true,
            formatOnDisplay: false,
            utilsScript: baseurl+"/site_assets_1/assets/intl-tel-input/js/utils.js",
        });
        iti.setCountry("in"); 
      
        $(document).on('keyup change', ".validMob", function() {
            
          var ck_phone = /^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/i;
          var fieldId = $(this).attr('id');
          var fieldVal = $(this).val();

          $('#'+fieldId).removeClass('is-invalid').removeClass('is-valid');
          // alert()
          if(fieldVal == ''){
            $('#'+fieldId).removeClass('is-invalid');
            clrErr();
          }
          
          if(fieldId.indexOf('phone') === -1) {  var checkEmail = false; }else{ var checkEmail = true; }
          if(checkEmail === true){
              if(!ck_phone.test(fieldVal)){
                setMsg(fieldId,'Please enter a valid phone number');
              } else {
                $('#'+fieldId).removeClass('is-invalid').addClass('is-valid');
                $(".err_msg").html('');
              }
          }
        });
      }

      function CountryChange(){
        $('.country_change').show();
        $('.country_text').hide();
      }
  
      /**
      * Search Location
      */
      
      $(function(){
          var cache1 = JSON.parse(localStorage.getItem('city'))??{};
          $('#location.typeahead').typeahead({ // focus on first result in dropdown
              source: function(query, result) {
                  var country_code = $('#country_id').find(':selected').attr('data-code');
                  var local_cache = JSON.parse(localStorage.getItem('city'));
                  if ((local_cache!=null) && ((country_code+query) in local_cache)) {
                      // If result is already in local_cache, return it
                      result(cache1[country_code+query]);
                      return;
                  }
                  $.ajax({
                      url: 'api/autocomplete/search_location',
                      method: 'GET',
                      data: {q: query,country_code:country_code},
                      dataType: 'json',
                      success: function(data) {
                          cache1[country_code+query] = data;
                          localStorage.setItem('city',JSON.stringify(cache1));
                          result(data);
                      }
                  });
              },
              autoSelect: true,
              showHintOnFocus: true
          }).focus(function () {
              $(this).typeahead("search", "");
          });

          
          var cache2 = JSON.parse(localStorage.getItem('designation'))??{};
          $('#career_title.typeahead').typeahead({ // focus on first result in dropdown
              source: function(query, result) {
                  var local_cache = JSON.parse(localStorage.getItem('designation'));
                  if ((local_cache!=null) && (query in local_cache)) {
                      // If result is already in local_cache, return it
                      result(cache2[query]);
                      return;
                  }
                  $.ajax({
                      url: 'api/autocomplete/search_designation',
                      method: 'GET',
                      data: {q: query},
                      dataType: 'json',
                      success: function(data) {
                          cache2[query] = data;
                          localStorage.setItem('designation',JSON.stringify(cache2));
                          result(data);
                      }
                  });
              },
              autoSelect: true,
              showHintOnFocus: true
          }).focus(function () {
              $(this).typeahead("search", "");
          });
      });
    
      function validateCareerInfoForm() {
        clrErr();
        var errStaus = false; 
        if(validateFormFields('career_title','Please enter Designation ','')) errStaus=true;
        if(validateFormFields('expected_salary','Please enter expected salary','')) errStaus=true;
        if(validateFormFields('country_id','Please enter country','')) errStaus=true;
        if(validateFormFields('location','Please enter location','')) errStaus=true;
        if(validateFormFields('phone','Please enter contact number.','validMobile')) errStaus=true;
        $("#full_number").val($('.iti__selected-dial-code').html()+String($("#phone").val()).replace(/ /g, ""));
   
        if(employment_status!='fresher'){
          if($('#exp_in_year').val()==0&&$('#exp_in_month').val()==0){
            $('#err_total_exp').html('Please select your experience');
            errStaus=true;
          }
        }
        // form validation ends
        
        if(errStaus == false){
          return true;
        }else{
          return false;
        }
      }
      function updateTextView(_obj){
        var num = getNumber(_obj.val());
        if(num==0){
            _obj.val('');
        }else{
            _obj.val(num.toLocaleString('en-IN'));
        }
      }
      function getNumber(_str){
        var arr = _str.split('');
        var out = new Array();
        for(var cnt=0;cnt<arr.length;cnt++){
            if(isNaN(arr[cnt])==false){
            out.push(arr[cnt]);
            }
        }
        return Number(out.join(''));
      }
      $("input[data-type='currency']").on('keyup',function(){
        updateTextView($(this));
      });
      var expected_salary = expected_salary || "";
      $('#expected_salary').val(expected_salary).trigger('keyup');
  
    }
 
    /**Skill */

    // input tag start

  if(document.getElementById('skills'))
  {
      
      var cache = JSON.parse(localStorage.getItem('skill'))??{};
      
      var inputElm = document.querySelector('input[name=skills]');
      var tagify = new Tagify(inputElm, {
              whitelist: []
          });

      function fetchTags(query) {
          return $.ajax({
              url     : baseurl+"/skillsdata",
              type    : 'GET',
              data    : {"key": query},
              dataType: 'json',          
          });
      }
      
      tagify.on('input', function(event)
      { 
          var query = event.detail.value;  
          var local_cache = JSON.parse(localStorage.getItem('skill'));
          if ((local_cache!=null) && (query in local_cache)) {
              // If result is already in cache, return it
              response = local_cache[query];
              tagify.settings.whitelist.length = 0; // clear the current whitelist
              tagify.settings.whitelist.push(...response, ...tagify.value); // add the new tags to the whitelist
              //tagify.settings.whitelist.push(...result, ...tagify.value)
              tagify.dropdown.show.call(tagify, query); // show the dropdown with the new tags
          }else{ 
              fetchTags(query).done(function(response) {
                  cache[query] = response;
                  localStorage.setItem('skill',JSON.stringify(cache));
                  tagify.settings.whitelist.length = 0; // clear the current whitelist
                  tagify.settings.whitelist.push(...response, ...tagify.value); // add the new tags to the whitelist
                  //tagify.settings.whitelist.push(...result, ...tagify.value)
                  tagify.dropdown.show.call(tagify, query); // show the dropdown with the new tags
              });
          }    

      });
      $(".tag-plus").click(function() {
        var sid = $(this).attr('data-sid');
        var sval = $(this).attr('data-sval');
        $(this).closest('.skls_cdte').remove();
        tagify.addTags([{id: sid, value: sval}]);
      });
      
      function validateSkillForm() {
        clrErr();
        var errStaus = false; 
        if(validateFormFields('skills','Please enter Skill','')) errStaus=true;
        // form validation ends
        
        if(errStaus == false){
          return true;
        }else{
          return false;
        }
        
      }
  }

  /**Resume Upload */

    $('.file_upld').click(function(){
      $('#file').click();
    });

    var $fileInput = $('#file');
    var $droparea = $('.file_upld');

    // highlight drag area
    $fileInput.on('dragenter focus click', function() {
    $droparea.addClass('is-active');
    });

    // back to normal state
    $fileInput.on('dragleave blur drop', function() {
    $droparea.removeClass('is-active');
    });

    // change inner text
    $fileInput.on('change', function() {
      var filesCount = $(this)[0].files.length;
      var $textContainer = $(this).prev();
      $(".file_upload").attr('src', baseurl+'/images/file_img.png');
      if (filesCount === 1) {
          // if single file is selected, show file name
          var fileName = $(this).val().split('\\').pop();
          $textContainer.text(fileName);
      } else {
        $(".file_upload").attr('src', baseurl+'/images/upload_img.png');
          // otherwise show number of files
          $textContainer.text('No files selected');
      }
    });

    function validateFile() 
    {

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

