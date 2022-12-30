    let csrf_token = $('meta[name=csrf-token]').attr('content');

    /** Education Form Script */
    /**  Submit */

    function validateAccountForm() {
      clrErr();
      var errStaus = false; 
      if(validateFormFields('education_level_id','Please enter education level','')) errStaus=true;
      if(document.getElementById('education_type_id')!=null){
        if(validateFormFields('education_type_id','Please enter the Education type','')) errStaus=true;
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
      filterEducationTypes(0);
    });

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

      function CountryChange(){
        $('.country_change').show();
        $('.country_text').hide();
      }
  
      /**
      * Search Location
      */
      
      var country_code = $('#country_id').find(':selected').attr('data-code');
      $(function(){
        var location = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: 'api/autocomplete/search_location?country_code='+country_code,
        remote: {
            url: "api/autocomplete/search_location",
            replace: function(url, query) {
              var country_code = $('#country_id').find(':selected').attr('data-code')
              return url + "?q=" + query+"&country_code="+country_code;
            },        
            filter: function(stocks) {
              return $.map(stocks, function(data) {
                return {
                    // tokens: data.tokens,
                    // symbol: data.symbol,
                    name: data.name
                }
              });
            }
        }
      });
  
      location.initialize();
          $('#location.typeahead').typeahead({
          hint: true,
          highlight: false,
          minLength: 1,
      },{
          name: 'location',
          displayKey: 'name',
          source: location.ttAdapter(),
          limit:Number.MAX_VALUE
          }); 
      });
  
      function validateCareerInfoForm() {
        clrErr();
        var errStaus = false; 
        if(validateFormFields('career_title','Please enter Designation ','')) errStaus=true;
        if(validateFormFields('expected_salary','Please enter expected salary','')) errStaus=true;
        if(validateFormFields('country_id','Please enter country','')) errStaus=true;
        if(validateFormFields('location','Please enter location','')) errStaus=true;
      
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
      
      $(".tag-plus").click(function() {
        var sid = $(this).attr('data-sid');
        var sval = $(this).attr('data-sval');
        $(this).closest('.skls_cdte').remove();
        tagify.addTags([{id: sid, value: sval}]);
      });

      var inputElm = document.querySelector('input[name=skills]'),
      whitelist = [
          {'id':1,'value':'coimbatore'},
          {'id':2,'value':'chennai'}
      ];
      // initialize Tagify on the above input node reference
      var tagify = new Tagify(inputElm, {
        // enforceWhitelist: true,
        // maxTags: 5,
        // make an array from the initial input value
        whitelist: inputElm.value.trim().split(/\s*,\s*/) 
      })

      // Chainable event listeners
      tagify.on('add', onAddTag)
        .on('remove', onRemoveTag)
        .on('input', onInput)
        .on('edit', onTagEdit)
        .on('invalid', onInvalidTag)
        .on('click', onTagClick)
        .on('focus', onTagifyFocusBlur)
        .on('blur', onTagifyFocusBlur)
        .on('dropdown:hide dropdown:show', e => console.log(e.type))
        .on('dropdown:select', onDropdownSelect)

      var mockAjax = (function mockAjax(){
        var timeout;
        return function(duration){
            clearTimeout(timeout); // abort last request
            return new Promise(function(resolve, reject){
                timeout = setTimeout(resolve, duration || 700, whitelist)
            })
        }
      })()

      // tag added callback
      function onAddTag(e){
        clrErr();
        console.log("onAddTag: ", e.detail);
        console.log("original input value: ", inputElm.value)
        tagify.off('add', onAddTag) // exmaple of removing a custom Tagify event
      }

      // tag remvoed callback
      function onRemoveTag(e){
        console.log("onRemoveTag:", e.detail, "tagify instance value:", tagify.value)
      }

      // on character(s) added/removed (user is typing/deleting)
      function onInput(e){
        // console.log("onInput: ", e.detail);
        tagify.settings.whitelist.length = 0; // reset current whitelist
        tagify.loading(true).dropdown.hide.call(tagify) // show the loader animation

        // get new whitelist from a delayed mocked request (Promise)
        mockAjax()
            .then(function(result){
            
                $.ajax({
                    url     : baseurl+"/skills_data",
                    type    : 'GET',
                    data    : {"key": e.detail.value},
                    dataType: 'json',
                    success:function(result) {
                      // console.log(result);
                      // return false;
                        // replace tagify "whitelist" array values with new values
                        // and add back the ones already choses as Tagsx`
                        tagify.settings.whitelist.push(...result.skills, ...tagify.value)

                        // render the suggestions dropdown.
                        tagify.loading(false).dropdown.show.call(tagify, e.detail.value);
                    }
                    
                });
                
            })
      }

      function onTagEdit(e){
        console.log("onTagEdit: ", e.detail);
      }

      // invalid tag added callback
      function onInvalidTag(e){
        console.log("onInvalidTag: ", e.detail);
      }

      // invalid tag added callback
      function onTagClick(e){
        console.log(e.detail);
        console.log("onTagClick: ", e.detail);
      }

      function onTagifyFocusBlur(e){
        console.log(e.type, "event fired")
      }

      function onDropdownSelect(e){
        console.log("onDropdownSelect: ", e.detail)
      }

      
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

      if (filesCount === 1) {
          // if single file is selected, show file name
          var fileName = $(this).val().split('\\').pop();
          $textContainer.text(fileName);
      } else {
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

