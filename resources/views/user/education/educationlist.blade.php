@foreach ($educations as $education)
    <div class="appendeducation mb-4 card educationList_{{$education->id}} education_div">
        <div class="text-end" data-edid="{{$education->id}}">
            <span class="edit_education_{{$education->id}} edit_education openForm m-2 cursor-pointer" data-form="edit" data-id="{{$education->id}}" data-type-id="{{$education->education_type_id??0}}"> <i class="fa fa-edit"></i> </span>
            <span class="delete_education_{{$education->id}} delete_education m-2 cursor-pointer" @if(count(Auth::user()->userEducation)<2) style="display:none" @endif onclick="delete_user_education('{{$education->id}}');"> <i class="fa-solid fa-trash-can text-danger"></i> </span>
            <span class="undo_education_{{$education->id}} undo_education m-2 cursor-pointer" style="display:none;" onclick="undo_user_education('{{$education->id}}');"> <i class="fa-solid fa-arrow-rotate-left text-green-color border-0 rounded p-2"></i> </span>
        </div>

        <div class="row mb-5">
            <div class="col-md-6">
                <label for="" class="mb-2">Qualification Level</label>
                <div class="fw-bolder">{{$education->getEducationLevel('education_level')}}</div>
            </div>
            <div class="col-md-6">
                @if(!empty($education->education_type_id) || !empty($education->education_type))
                <label for="" class="mb-2">Education</label>
                <div class="fw-bolder">{{$education->education_type??$education->getEducationType('education_type')}}</div>
                @endif
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-6">
                <label for="" class="mb-2">Instition name</label>
                <div class="fw-bolder">{{ucwords($education->institution??'None')}}</div>
            </div>
            <div class="col-md-6">
                <label for="" class="mb-2">Place of Education</label>
                <div class="fw-bolder">{{ ucwords($education->location??'None') }}</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="" class="mb-2">Year of education</label>
                @if(empty($education->from_year) && empty($education->to_year))
                <div class="fw-bolder">None</div>
                @else
                <div class="fw-bolder">{{Carbon\Carbon::parse($education->from_year)->Format('M Y')}} - {{($education->pursuing!='yes'? Carbon\Carbon::parse($education->to_year)->Format('M Y') : 'Still Pursuing') }}</div>
                @endif
            </div>
            <div class="col-md-6">
                <label for="" class="mb-2">Secured</label>
                <div class="fw-bolder">@if($education->percentage!=''){{ $education->getResultType('result_type') }}: {{ $education->percentage }} @else - @endif</div>
            </div>
        </div>
    </div>      
    {{-- <div class="educationListEdit_{{$education->id}} form-empty"></div>     --}}
    @endforeach