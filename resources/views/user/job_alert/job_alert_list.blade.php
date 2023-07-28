@php $jobalerts = Auth::user()->JobAlert;@endphp
@foreach ($jobalerts as $job_alert)
    <div class="card mt-4 job_alert_div job_alert_edited_div_{{$job_alert->id}}">
        <div class="row">
            <div class="col-md-8 col-lg-8 col-sm-8 col-8">
                <div class="dtls">
                    <h3 class="fw-bolder mb-1">{{$job_alert->title}}</h3>
                    <p class="mb-0">{{$job_alert->location}}</p>
                    <p class="mb-0">@if(!empty($job_alert->experienceFid) && $job_alert->experienceFid!=0){{$job_alert->experienceFid}} Years @endif </p>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-sm-4 col-4">
                <div class="row">
                    <div class="col-12 justify-content-evenly d-flex">
                        <span class="m-2 edit_job_alert edit_job_alert_{{$job_alert->id}}"><i class="fa fa-pencil openForm" data-form="edit" data-id="{{$job_alert->id}}"></i></span>
                        <span class="m-2 delete_job_alert delete_job_alert_{{$job_alert->id}}"  @if(count(Auth::user()->JobAlert)<2) style="display:none" @endif onclick="delete_user_job_alert({{$job_alert->id}});"><i class="fa fa-trash"></i></span>
                        <span class="m-2 undo_job_alert_{{$job_alert->id}}" onclick="undo_user_job_alert({{$job_alert->id}});" style="display:none;"><i class="fa-solid fa-arrow-rotate-left text-green-color border-0 rounded p-2"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="more-details-show-hide collapse mt-2" id="collapseExample{{$job_alert->id}}">
            @if(!empty($job_alert->jobtypeFGid))
            <div class="mb-4">
                <h5>Job Type</h5>
                <p class="text-justify">
                    - {{implode(",",$job_alert->getJobType())}}   
                </p>
            </div>
            @endif

            @if(!empty($job_alert->jobshiftFGid))
            <div class="mb-4">
                <h5>Job Shift</h5>
                <p class="text-justify">
                    - {{implode(",",$job_alert->getJobShift())}}   
                </p>
            </div>
            @endif

            @if(!empty($job_alert->wfhtypeFid))
            <div class="mb-4">
                <h5>Remote</h5>
                <p class="text-justify">
                    - {{$job_alert->getWFH()}}   
                </p>
            </div>
            @endif

            @if(!empty($job_alert->salaryFGid))
                <div class="mb-4">
                    <h5>Expected Salary</h5>
                    <p class="text-justify">
                    - {{$job_alert->getSalary()}}   
                    </p>
                </div>
            @endif   

            @if(!empty($job_alert->posteddateFid))
                <div class="mb-4">
                    <h5>Jobs Posted within</h5>
                    <p class="text-justify">
                    - {{$job_alert->getDatePosted()}}   
                    </p>
                </div>
            @endif        
        </div>  
        @if(!empty($job_alert->jobtypeFGid) || !empty($job_alert->jobshiftFGid) || !empty($job_alert->wfhtypeFid) || !empty($job_alert->salaryFGid) || !empty($job_alert->posteddateFid) || !empty($job_alert->experienceFid))
        <div class="text-center more-details more-details{{$job_alert->id}}"  onclick="collapsedJobALert({{$job_alert->id}})">
            <a class="text-green-color" id="more-details-button-exp" data-bs-toggle="collapse" href="#collapseExample{{$job_alert->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">More details 
                <i class="fa-solid fa-chevron-down collapse-down-arrow"></i> 
                <i class="fa-solid fa-chevron-up collapse-up-arrow" style="display:none;"></i>
            </a>                           
        </div>     
        @endif                 
    </div>
@endforeach