@php $experiences = Auth::user()->userExperience;@endphp
@foreach ($experiences as $experience)
    <div class="card mt-4 experience_div experience_edited_div_{{$experience->id}}">
        <div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-4 text-end">
                <div class="row">
                    <div class="col-6 edit_experience edit_experience_{{$experience->id}}"><i class="fa fa-edit openForm" data-form="edit" data-id="{{$experience->id}}"></i></div>
                    <div class="col-6 delete_experience delete_experience_{{$experience->id}}"  @if(count(Auth::user()->userExperience)<2) style="display:none" @endif onclick="delete_user_experience({{$experience->id}});"><i class="fa fa-trash"></i></div>
                    <div class="col-6 undo_experience_{{$experience->id}}" onclick="undo_user_experience({{$experience->id}});" style="display:none;"><i class="fa-solid fa-arrow-rotate-left text-green-color border-0 rounded p-2"></i></div>
                </div>
            </div>
        </div>

        <div class="mb-4 dtls">
            <h3 class="fw-bolder mb-1">{{$experience->title}}</h3>
            <p class="mb-0">{{$experience->company}}</p>
            <p class="mb-0">{{$experience->location}}</p>
            <p class="mb-2">{{Carbon\Carbon::parse($experience->date_start)->Format('M Y')}} - {{ ($experience->is_currently_working!=1? Carbon\Carbon::parse($experience->date_end)->Format('M Y') : 'Currently working') }}.</p>
        </div>

        <div class="more-details-show-hide collapse mt-3" id="collapseExample{{$experience->id}}">
            <div class="mb-5">
                <h3 class="gry">Job Description</h3>
                <p class="text-justify">
                {{($experience->description!='')?$experience->description:'No Job Description'}}   
                </p>
            </div>

            @if($experience->used_tools!=null)
                <p class="mb-3">Tools / software Used</p>
                <div class="col-md-12 mb-5 skilsdtl">
                    @foreach(explode(',',$experience->used_tools) as $usedtools)
                        <span class="text-primary">{{$usedtools}} &nbsp;&nbsp;&nbsp;<i class="fa fa-close"></i></span>
                    @endforeach
                </div>        
            @endif            
        </div>  
        <div class="text-center more-details more-details{{$experience->id}}"  onclick="collapsedExp({{$experience->id}})">
                <a class="text-green-color" id="more-details-button-exp" data-bs-toggle="collapse" href="#collapseExample{{$experience->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">More details 
                <i class="fa-solid fa-chevron-down collapse-down-arrow"></i> 
                <i class="fa-solid fa-chevron-up collapse-up-arrow" style="display:none;"></i>
            </a>                           
        </div>                      
    </div>
    {{-- <div id="ExperienceList_{{$experience->id}} form-empty"></div> --}}
@endforeach