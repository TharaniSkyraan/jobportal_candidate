<!-- modal for resume upload start -->

<style>

    .file-drop-area {
        position: relative;
        display: flex;
        align-items: center;
        /* width: 450px; */
        max-width: 100%;
        padding: 25px;
        border: 1px solid black;
        border-radius: 3px;
        transition: 0.2s;
        height: 190px;
        white-space: pre-line;
        text-align: center;
        place-content: center;
        border: dotted #d1d1d1;
    }
    .file-drop-area.is-active {
      background-color: rgba(255, 255, 255, 0.05);
    }
    
    .fake-btn {
      flex-shrink: 0;
      background-color: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 3px;
      padding: 8px 15px;
      margin-right: 10px;
      font-size: 12px;
      text-transform: uppercase;
    }
    
    .file-msg {
      font-size: medium;
      font-weight: 300;
      line-height: 1.4;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    
    .file-input {
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 100%;
      cursor: pointer;
      opacity: 0;
    }
    .file-input:focus {
      outline: none;
    }
    
</style>

{{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#resume_upload_modal">
    Launch demo modal
</button> --}}
  
<!-- Modal -->
<div class="modal fade" id="resume_upload_modal" tabindex="-1" aria-labelledby="resume_upload_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body h-100">
            <form>
              {{csrf_field()}}
               {!! Form::hidden('resume_id', null, array('id'=>'resume_id')) !!}
              <div class="resume">
                <div class="text-center mt-3 mb-4"><h4 class="fw-bold">Upload Your Resume </h4></div>
                <div class="file-drop-area m-4">
                    <div class="icon"><i class="fas fa-cloud-upload-alt fa-3x"></i>
                    <span class="file-msg">Select or drag and drop document here</span></div>
                    <input class="file-input" type="file" name="file" id="file" accept=".doc,.docx,.pdf,.rtf">
                </div>
                <div class="text-center">
                  <span class="help-block form-text text-danger err_msg file-error"></span>
                </div>
                <div class="d-flex justify-content-around mt-5 mb-3">              
                      <div>
                          <button type="button" onclick="submitCvs();" class="btn btn_c_s"> Submit </button>
                      </div>
                </div> 
              </div> 
            </form> 
          <div class="text-center mb-3"><h4 class="fw-bold success"></h4></div>

          <div class="form-group form-inline w-100" id="show_p_bar" style="display:none">
            <label for="inlineinput" class="col-md-2 col-form-label "> </label>
            
            <div class="col-md-12 p-0">
                <p style="font-size: large;font-weight: bold;" class="text-center" id="uploadStatus"></p>
                <div class="progress custom_pr_bar" >
                  <div id="progress_bar_id" class="progress-bar progress-bar-striped progress-bar-animated  custom_pr_bar_in">  </div>
                </div>
            </div>
          
        </div>
      </div>
    </div>
</div>



<script>
    var $fileInput = $('.file-input');
    var $droparea = $('.file-drop-area');

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

</script>

<!-- modal for resume upload end -->

