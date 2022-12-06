  
  $('#country_id').select2();
  $('#notice_period').select2();

  $( "#date_of_birth" ).change(function(e) {
    var vals = e.target.value.split('-');
    var year = vals[0];
    var def_val = $("#date_of_birth").attr('max');

    var split_def_val = def_val.split('-');
    var split_def_val_year = split_def_val[0];

    if(year>split_def_val_year){
      setMsg('date_of_birth ','Date should less than '+def_val);
      return false;
      }

      $('#err_date_of_birth').hide();
      return true;
  });

  $(document).ready(function(){

      var dtToday = new Date();

      var month = dtToday.getMonth() + 1;
      var day = dtToday.getDate();
      var year = dtToday.getFullYear();

      if(month < 10)
          month = '0' + month.toString();
      if(day < 10)
          day = '0' + day.toString();

      var maxDate = year + '-' + month + '-' + day;    
      $('#date_of_birth').attr('max', maxDate);

    });
    // form validation starts
    function validateAccountForm(){ 
      clrErr();
      var errStaus = false; 
      
      if(validateFormFields('first_name','Please enter the First name','NameVali')) errStaus=true;
      if(validateFormFields('last_name','Please enter Last name','NameVali')) errStaus=true;
      if(validateFormFields('date_of_birth','Please enter Date of birth','')) errStaus=true;
      if(validateFormFields('marital_status_id','Please select marital status','')) errStaus=true;
      if(validateFormFields('country_id','Please select Country location','')) errStaus=true;
      if(validateFormFields('location','Please enter city','ValiCity')) errStaus=true;
    
      var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
      var yyyy = today.getFullYear()-14;

      var yyyy1 = today.getFullYear()-100;

      yeardectoday = yyyy+'-'+mm+'-'+dd;
      yearincrtoday = yyyy1+'-'+mm+'-'+dd;

      if($('#date_of_birth').val() > yeardectoday && $('#date_of_birth').val() > yearincrtoday){
        setMsg('date_of_birth','Enter date between '+ yearincrtoday +' to '+ yeardectoday);
        errStaus=true;
      }
      
      if(errStaus) {
        return false;
      } else {
        return true;		
      }
    }
    // form validation ends
    
      $(document).ready(function(){

        if(cv==0 && error_count==0){
          $("#resume_upload_modal").modal('show');
        }

      });

      $('#Fresher').on('change', function (e) {
        $('.notice_period').hide();
      });

      $('#Experienced').on('change', function (e) {
        $('.notice_period').show();
      });

      if(employment_status!='experienced') 
      {
        $('.notice_period').hide();
      }

      $('#country_id').on('change', function (e) {
          e.preventDefault();
          $('#location').val('');
      });
      
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
                          if(percentComplete == 100){
                                $('.success').html('Uploading... Please wait');
                          }
                      }
                  }, false);
                  return xhr;
              },
              url     : baseurl + 'resumeupdate',
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
                // $('#uploadStatus').html('Completed. Redirecting...');
                // setTimeout(function() {
                //     $('#exampleModalCenters').modal();
                // }, 2000);

                $('.success').html('Resume Uploaded Successfully');
                $(".success").fadeTo(3000, 500).slideUp(500, function() {
                  // $(".success").slideUp(500);
                  $("#resume_upload_modal").modal('toggle');
                });
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
        else{
          $('.file-error').html('Please select valid file');
        }
      }


      $('.select2-hidden-accessible').on('select2:open', function() {
          document.querySelector('.select2-search__field').focus();
      });
      function CountryChange(){
        $('.country_change').show();
        $('.country_text').hide();
      }
      
      /**
      * Search Location
      */
      $(function(){
          var location_s = new Bloodhound({
          datumTokenizer: Bloodhound.tokenizers.whitespace,
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          prefetch: 'api/autocomplete/search_location_default',
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
      
      location_s.initialize();
          $('#location.typeahead').typeahead({
          hint: true,
          highlight: false,
          minLength: 1,
      },{
          name: 'location_s',
          displayKey: 'name',
          source: location_s.ttAdapter(),
          limit:Number.MAX_VALUE
          }); 
      });

