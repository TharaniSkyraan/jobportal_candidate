@extends('layouts.app')

@section('custom_scripts')
<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery-ui.min.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery.tagsinput-revisited.css')}}" rel="stylesheet">	  
<link href="{{ asset('site_assets_1/assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/vendor/selectize/selectize.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/userbasic.w2fr4ha2.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="wrapper" >
        
	@include('layouts.header')
	@include('layouts.side_navbar')

	<div class="main-panel main-panel-custom">
		<div class="content">
			<div class="page-inner">
                <div id="my_eductin" class="mt-4">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img src="{{asset('images/candidate_educ.png')}}">&nbsp;My Eduaction</h2>
                    </div>
                    @php
                        $eduLevels = App\Helpers\DataArrayHelper::langEducationlevelsArray();
                        $eduLevelids = App\Model\UserEducation::whereUserId(Auth::user()->id)->pluck('education_level_id')->toArray();
                    @endphp
                    @foreach ($eduLevels as $key => $eduLevel)  
                    <div class="{{ (!in_array($key, $eduLevelids)) ? 'crdbxpl' : 'crdbxless' }} mt-4">
                        <div class="row">
                            <div class="col-10 px-5">{{ $eduLevel }}</div>
                            <div class="col-2 align-self-center"><i class="fa fa-plus openForm" data-education-level-id="{{$key}}" type="button" data-form="new"></i></div>
                        </div>
                    </div>                    
                    <div class="educationListAdd{{$key}}"></div>  
                    @php
                        $educations = App\Model\UserEducation::whereUserId(Auth::user()->id)->where('education_level_id',$key)->get();
                    @endphp
                    
                        @foreach ($educations as $education)
                        <div class="appendeducation card educationList{{$education->id}} m-1">
                            <div class="text-end" data-edid="{{$education->id}}">
                               <span class="edit_education_{{$education->id}} edit_education"> <i class="fa fa-edit"></i> </span>
                               <span class="delete_education_{{$education->id}} delete_education"> <i class="fa-solid fa-trash-can text-danger"></i> </span>
                               <span class="undo_education_{{$education->id}}" style="display:none;"> <i class="fa-solid fa-arrow-rotate-left text-green-color border-0 rounded p-2"></i> </span>
                            </div>

                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label for="" class="mb-2">Qualification Level</label>
                                    <div class="fw-bolder">{{$eduLevel}}</div>
                                </div>
                                <div class="col-md-6">
                                    @if(!empty($education->education_type_id))
                                    <label for="" class="mb-2">Education</label>
                                    <div class="fw-bolder">{{$education->getEducationType('education_type')?? ' - '}}</div>
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
                                    <div class="fw-bolder">{{Carbon\Carbon::parse($education->from_year)->Format('M Y')}} - {{($education->pursuing!='yes'? Carbon\Carbon::parse($education->to_year)->Format('M Y') : 'Still Pursuing') }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="mb-2">Secured</label>
                                    <div class="fw-bolder">@if($education->percentage!=''){{ $education->getResultType('result_type') }}: {{ $education->percentage }} @else - @endif</div>
                                </div>
                            </div>
                        </div>      
                        <div class="educationListEdit{{$education->id}}"></div>    
                        @endforeach

                    @endforeach

                </div>  
            </div>
        </div>
    </div>
</div>

@endsection
@section('custom_bottom_scripts')
<script type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/selectize/selectize.js')}}"></script>
<script  type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/typehead/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
var baseurl = '{{ url("/") }}/';
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/dashboard/uedu!eu@21.js') }}"></script>
@endsection