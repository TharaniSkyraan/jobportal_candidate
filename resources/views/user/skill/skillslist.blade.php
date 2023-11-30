@php $skills = Auth::user()->userSkills;@endphp
@forelse ($skills as $skill)
@php
  $from = $skill->start_date?\Carbon\Carbon::parse($skill->start_date)->Format('M Y'):'';
  $to = ($skill->is_currently_working!='yes'? ($skill->end_date?\Carbon\Carbon::parse($skill->end_date)->Format('M Y'):'') : 'Currently working');
  $date = $from .((!empty($from) && !empty($to))?' - ':''). $to;
@endphp
<div class="card mt-3 skill_div skill_edited_div_{{$skill->id}}">
    <div class="row">
        <div class="col-md-8 col-lg-8 col-sm-8 col-8">
            <div class="mb-4 dtls">
                <h3>{{ $skill->getSkill('skill') }}</h3>
                <p>{{ $date }}</p>
                <p>Skill level</p>
                <p>{{ $skill->getLevel('language_level')??'-' }}</p>
            </div>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-4 col-4">
            <div class="row">
                <div class="col-12 justify-content-evenly d-flex">
                    <span class="m-2 edit_skill_{{$skill->id}}"><i class="fa fa-pencil openForm" data-form="edit" data-id="{{$skill->id}}"></i></span>
                    <span class="m-2"><i class="fa fa-trash delete_skill delete_skill_{{$skill->id}}"  @if(count(Auth::user()->userSkills)<2) style="display:none" @endif onclick="delete_user_skill({{$skill->id}});"></i></span>
                    <span class="m-2 cursor-pointer undo_skill_{{$skill->id}}" onclick="undo_user_skill({{$skill->id}});" style="display:none"><i class="fa-solid fa-arrow-rotate-left text-green-color border-0 rounded p-2"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
@empty    
{{ count(Auth::user()->userSkills) }} 
@endforelse
