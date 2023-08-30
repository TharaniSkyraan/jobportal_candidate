@php $user = Auth::user()??'';
$projects = ($user->userProjects)??array(); @endphp
@foreach ($projects as $project)    
@php
$date = '';
if ($project->is_on_going == 1)
{
    $date = !empty($project->date_start) ? (Carbon\Carbon::parse($project->date_start)->Format('M Y').' - Currently ongoing') : "Currently ongoing";
}else{
    $start_date = !empty($project->date_start) ? (Carbon\Carbon::parse($project->date_start)->Format('M Y') ) : "";
    $end_date = !empty($project->date_end) ? (" - ".Carbon\Carbon::parse($project->date_end)->Format('M Y') )  : "";
    $date = $start_date . $end_date;
}
@endphp
<div class="card mt-4 project_div project_edited_div_{{$project->id}}">
    <div class="row">
        <div class="col-md-8 col-lg-8 col-sm-8 col-8">
            <div class="mb-2 dtls">
                <h3 class="fw-bolder mb-1">{{$project->name}}</h3>
                <p class="mb-0">{{ $project->getCompany('company') }}</p>
                <p class="mb-2">{{ $date }}.</p>
                <p class="mb-2">{{ $project->url }}.</p>
            </div>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-4 col-4">
            <div class="row">
                <div class="col-12 justify-content-evenly d-flex">
                    <span class="m-2 edit_project_{{$project->id}}"><i class="fa fa-pencil  openForm" data-form="edit" data-id="{{$project->id}}"></i></span>
                    <span class="m-2"> <i class="fa fa-trash delete_project delete_project_{{$project->id}}" @if(count(Auth::user()->userProjects)<2) style="display:none" @endif onclick="delete_user_project({{$project->id}});"></i></span>
                    <span class="m-2 undo_project_{{$project->id}}" onclick="undo_user_project({{$project->id}});" style="display:none;"><i class="fa-solid fa-arrow-rotate-left text-green-color border-0 rounded p-2"></i></span>
                </div>
            </div>
        </div>
    </div>

        
    <div class="more-details-show-hide collapse" id="collapseprojec{{$project->id}}">
        <div class="mb-2">
            <h3 class="gry">About project</h3>
            <p class="text-justify">
                {{ $project->description }}
            </p>
        </div>
        @if(!empty($project->role_on_project))
        <div class="mb-2">
            <h3 class="gry">Role on the project</h3>
            <p class="text-justify">
                {{ $project->role_on_project }}
            </p>
        </div>
        @endif
        @if($project->used_tools!=null)
        <h4 class="mb-3">Tools / software Used</h4>

        <div class="col-md-12 mb-5 skilsdtl">
            @foreach(array_filter(explode(',',$project->used_tools)) as $usedtools)
                <span class="text-primary">{{$usedtools}}</span>
            @endforeach
        </div>    
        @endif
    </div>
    
    <div class="text-center mt-2 more-details-proj more-details-proj{{$project->id}}" onclick="collapsedProj({{$project->id}})">
        <a class="text-green-color" id="more-details-button-proj" data-bs-toggle="collapse" href="#collapseprojec{{$project->id}}" role="button" aria-expanded="false" aria-controls="collapseproject">More details 
        <i class="fa-solid fa-chevron-down collapse-down-arrow-proj"></i> 
        <i class="fa-solid fa-chevron-up collapse-up-arrow-proj" style="display:none;"></i></a>
    </div>                  
</div>
@endforeach