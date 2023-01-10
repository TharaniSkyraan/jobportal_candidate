
<div class="card mt-5">
    <div class="row d-flex mb-4">
        <div class="col-md-4 col-lg-2 fw-bolder mb-2">
            Skill Name
        </div>
        <div class="col-md-4 col-lg-6">
            <?php
            $skill_id = (isset($userSkill) ? $userSkill->skill_id : $suggested_skill_id);
            ?>
            {!! Form::select('skill_id', [''=>__('Select skill')]+$skills, $skill_id, array('class'=>'form-select required', 'id'=>'skill_id')) !!} 
            <small class="help-block form-text text-muted text-danger err_msg skill_id-error" id="err_skill_id"></small>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-4 col-lg-2 align-align-self-center">
            <label for="" class="form-label fw-bolder">Skill Level</label>
        </div>
        <div class="col-lg-10 col-md-10">
        <div class="d-grid gap-2 d-md-flex justify-content-md-left">    
            @foreach($levels as $key => $level)
            <div>
                <input class="form-check-input skill_level required" onClick="SkillLevel();" type="radio" name="level_id" id="skill_level_{{$key}}" value="{{$key}}" @if(isset($userSkill) && ($userSkill->level_id==$key)) checked @endif>
                <label class="form-check-label" for="skill_level_{{$key}}">{{$level}}</label>
            </div>
            @endforeach
        </div>
        <small class="help-block form-text text-muted text-danger err_msg level_id-error" id="err_level_id"></small>
        </div>
        

    </div>

    <div class="row">
        <div class="mb-2 fw-bolder">
            Practising from (Optional) 
        </div>
        <div class="mb-3">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-4 mb-2">
                    {!! Form::month('start_date', $userSkill->start_date??null, array('class'=>'form-control required', 'max' =>date("Y-m"), 'min'=>'1980-01', 'id'=>'start_date', 'placeholder'=>__('Start date'))) !!}

                    <small class="form-text text-muted text-danger err_msg start_date-error" id="err_start_date"></small>
                </div>
                
                <div class="col-md-1 mb-2 text-center hide_currently_working_checked">
                to
                </div>

                <div class="col-md-5 col-lg-4 mb-2 hide_currently_working_checked">

                    {!! Form::month('end_date', $userSkill->end_date??null, array('class'=>'form-control required', 'max' =>date("Y-m"), 'min'=>'1980-01', 'id'=>'end_date', 'placeholder'=>__('End date'))) !!}


                <small class="form-text text-muted text-danger err_msg end_date-error" id="err_end_date"></small>
                </div>

                <div class="col-md-6 align-self-center col-lg-3">
                    <input class="form-check-input" type="checkbox" value="yes" id="is_currently_working" name="is_currently_working" @if(isset($userSkill) && $userSkill->is_currently_working=='yes') checked @endif>
                    <label class="form-check-label" for="is_currently_working">
                    Currently working
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6 text-center">
            <button class="btn bg-grey-color user-skill-cancel" onClick="cancelUserSkillForm({{$userSkill->id??0}})" type="button">Cancel</button>
        </div>
        <div class="col-6 text-center">
            <button class="btn btn-submit bg-green-color" type="button" onClick="submitUserSkillForm();">Save</button>
        </div>
    </div>
</div>