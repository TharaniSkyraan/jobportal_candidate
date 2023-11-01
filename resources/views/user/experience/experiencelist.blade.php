@php $experiences = Auth::user()->userExperience;@endphp
@foreach ($experiences as $experience)
    <div class="card mt-4 experience_div experience_edited_div_{{$experience->id}}">
        <div class="row">
            <div class="col-md-8 col-lg-8 col-sm-8 col-8">
                <div class="dtls">
                    <h3 class="mb-3">{{$experience->title}}</h3>
                    <p>{{$experience->company}}</p>
                    <p>{{$experience->location}}</p>
                    <p>{{Carbon\Carbon::parse($experience->date_start)->Format('M Y')}} - {{ ($experience->is_currently_working!=1? Carbon\Carbon::parse($experience->date_end)->Format('M Y') : 'Currently working') }}.</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-sm-4 col-4">
                <div class="row">
                    <div class="col-12 justify-content-evenly d-flex">
                        <span class="m-2 edit_experience edit_experience_{{$experience->id}}"><i class="fa fa-pencil openForm" data-form="edit" data-id="{{$experience->id}}"></i></span>
                        <span class="m-2 delete_experience delete_experience_{{$experience->id}}"  @if(count(Auth::user()->userExperience)<2) style="display:none" @endif onclick="delete_user_experience({{$experience->id}});"><i class="fa fa-trash"></i></span>
                        <span class="m-2 undo_experience_{{$experience->id}}" onclick="undo_user_experience({{$experience->id}});" style="display:none;"><i class="fa-solid fa-arrow-rotate-left text-green-color border-0 rounded p-2"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="more-details-show-hide collapse mt-2" id="collapseExample{{$experience->id}}">
            @if(!empty($experience->description))
            <div class="mb-4">
                <h3 class="gry">Job Description</h3>
                <p class="text-justify">
                {{($experience->description!='')?$experience->description:'No Job Description'}}   
                </p>
            </div>
            @endif

            @if($experience->used_tools!=null)
                <p class="mb-3">Tools / software Used</p>
                <div class="col-md-12 mb-5 skilsdtl">
                    @foreach(explode(',',$experience->used_tools) as $usedtools)
                        <span class="text-primary">{{$usedtools}}</span>
                    @endforeach
                </div>        
            @endif            
        </div>  
        @if($experience->used_tools!=null || !empty($experience->description))
        <div class="text-center more-details more-details{{$experience->id}}"  onclick="collapsedExp({{$experience->id}})">
                <a class="text-green-color" id="more-details-button-exp" data-bs-toggle="collapse" href="#collapseExample{{$experience->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">More details 
                <i class="fa-solid fa-chevron-down collapse-down-arrow"></i> 
                <i class="fa-solid fa-chevron-up collapse-up-arrow" style="display:none;"></i>
            </a>                           
        </div>     
        @endif                 
    </div>
    {{-- <div id="ExperienceList_{{$experience->id}} form-empty"></div> --}}
@endforeach