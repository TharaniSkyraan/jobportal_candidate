<div class="card mt-5">
    <div class="mb-2">
    <label for="" class="form-label fw-bolder">Languages Known</label>
    </div>
    <div class="row mb-4">
        <div class="col-md-6 col-xs-6 col-sm-12 col-12 mb-2">
            <div>
                {!! Form::select('language_id', [''=>__('Select language')]+$languages, null, array('class'=>'form-select required', 'id'=>'language_id')) !!} 
                <small class="help-block form-text text-muted text-danger err_msg language_id-error" id="err_language_id"></small>
            </div>
        </div>   
        <div class="col-md-6 col-xs-6 col-sm-12 col-12 align-self-center">  
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="yes" id="read" name="read" @if(isset($userLanguage) && $userLanguage->read == 'yes') checked @endif>
                <label class="form-check-label" for="read">
                Read
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="yes" id="write" name="write" @if(isset($userLanguage) && $userLanguage->write == 'yes') checked @endif>
                <label class="form-check-label" for="write">
                Write
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="yes" id="Speak" name="speak" @if(isset($userLanguage) && $userLanguage->speak == 'yes') checked @endif>
                <label class="form-check-label" for="Speak">
                Speak
                </label>
            </div><br>
            <small class="help-block form-text text-muted text-danger err_msg swr-error" id="err_swr"></small>
            
        </div>

    </div>  
    <div class="row mb-4">
        <div class="col-md-3 fw-bolder mb-2">
            Fluency Level
        </div> 
        <div class="col-md-9 mb-2">
            <div>   
                @foreach($languageLevels as $key => $level)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="language_level_id" id="language_level_{{$key}}" value="{{$key}}" @if(isset($userLanguage) && ($userLanguage->language_level_id==$key)) checked @endif>
                    <label class="form-check-label" for="language_level_{{$key}}">{{$level}}</label>
                </div>
                @endforeach
            </div>
            
            <small class="help-block form-text text-muted text-danger err_msg language_level_id-error" id="err_language_level_id"></small>
            
        </div>
    </div> 

    <div class="row">
        <div class="col-6 text-center">
            <button class="btn bg-grey-color user-language-cancel" onClick="cancelUserLanguageForm({{$userLanguage->id??0}})" type="button">Cancel</button>
        </div>
        <div class="col-6 text-center">
            <button class="btn btn-submit bg-green-color" type="button" onClick="submitUserLanguageForm();">Save</button>
        </div>
    </div>
</div>
