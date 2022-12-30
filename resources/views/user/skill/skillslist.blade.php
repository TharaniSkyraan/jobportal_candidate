@php $skills = Auth::user()->userSkills;@endphp
@foreach ($skills as $skill)
<div class="card mt-5 skill_div skill_edited_div_{{$skill->id}}">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-4 dtls">
                <h3 class="fw-bolder mb-1">{{ $skill->getSkill('skill') }}</h3>
                <p class="mb-0">{{ $skill->is_currently_working=='yes'?' Currently Working ':'' }}</p>
                <p class="mb-0">Skill level</p>
                <p class="fw-bolder">{{ $skill->getLevel('language_level')??'-' }}</p>
            </div>
        </div>
        <div class="col-md-6 align-self-center text-end">
            <div class="row">
                <div class="col-6 edit_skill_{{$skill->id}}"><i class="fa fa-edit openForm" data-form="edit" data-id="{{$skill->id}}"></i></div>
                <div class="col-6"><i class="fa fa-trash delete_skill delete_skill_{{$skill->id}}"  @if(count(Auth::user()->userSkills)<2) style="display:none" @endif onclick="delete_user_skill({{$skill->id}});"></i></div>
                <div class="col-6 cursor-pointer undo_skill_{{$skill->id}}" onclick="undo_user_skill({{$skill->id}});" style="display:none"><i class="fa-solid fa-arrow-rotate-left text-green-color border-0 rounded p-2"></i></div>
            </div>
        </div>
    </div>
</div>
@endforeach