
<div class="card mt-5">
    <div class="row d-flex mb-4">
        <div class="col-md-4 col-lg-2 fw-bolder mb-2">
            Skill Name
        </div>
        <div class="col-md-4 col-lg-6">
           {{-- <?php
            $skill_id = (isset($userSkill) ? $userSkill->skill_id : $suggested_skill_id);
            ?> --}}
            {!! Form::select('skill_id', [''=>__('Select skill')]+$skills, null, array('class'=>'form-select required', 'id'=>'skill_id')) !!} 
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
    @php
        $start_date = isset($userSkill->start_date)?Carbon\Carbon::parse($userSkill->start_date):null;
        $end_date = isset($userSkill->end_date)?Carbon\Carbon::parse($userSkill->end_date):null;
    @endphp            
    <div class="row align-items-baseline">
        <label for="" class="form-label fw-bold">Practising from (Optional) </label>
        <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12 col-12 mb-3">
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1">From</span>
                {!! Form::month('start_date', $start_date??null, array('class'=>'form-control required', 'max' =>date("Y-m"), 'min'=>'1980-01','id'=>'start_date', 'placeholder'=>__('Start date'))) !!}
            </div>
            <small class="help-block form-text text-muted text-danger err_msg start_date-error" id="err_start_date"></small> 
        </div>
        <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12 col-12 hide_currently_working_checked">
            <div class="input-group mb-2">
                <span class="input-group-text" id="basic-addon1">To</span>
                {!! Form::month('end_date', $end_date??null, array('class'=>'form-control required','max' =>date("Y-m"), 'min'=>'1980-01', 'id'=>'end_date', 'placeholder'=>__('End date'))) !!}
            </div>
            <small class="help-block form-text text-muted text-danger err_msg end_date-error" id="err_end_date"></small> 
        </div>
        <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12 col-6 mb-3 justify-content-center">
            <input class="form-check-input" type="checkbox" value="1" id="is_currently_working" name="is_currently_working" @if(isset($userSkill) && $userSkill->is_currently_working != '') checked @endif>
            <label class="form-check-label" for="is_currently_working"> On progress </label>
        </div>
    </div>


    <div class="row">
        <div class="col-6 text-center">
            <button class="btn bg-grey-color user-skill-cancel" onClick="cancelUserSkillForm({{$userSkill->id??0}})" type="button">Cancel</button>
        </div>
        <div class="col-6 text-center">
            <button class="btn btn-submit btn_c_s1" type="button" onClick="submitUserSkillForm();">Save</button>
        </div>
    </div>
</div>