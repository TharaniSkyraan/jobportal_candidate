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
                    <div class="{{ (!in_array($key, $eduLevelids)) ? 'crdbxpl' : 'crdbxless' }} mt-4 {{ (in_array($key, $eduLevelids) && ($key!=1 || $key!=2))? '' : 'openForm' }}" data-education-level-id="{{$key}}" type="button" data-form="new">
                        <div class="row">
                            <div class="col-10 px-5">{{ $eduLevel }}</div>
                            <div class="col-2 align-self-center">
                            @if(in_array($key, $eduLevelids) && ($key!=1 || $key!=2)) @else <i class="fa fa-plus"></i>@endif</div>
                        </div>
                    </div>                    
                    <div class="educationListAdd_{{$key}} educationListAdd mb-4 form-empty"></div>  
                    @php
                        $educations = App\Model\UserEducation::whereUserId(Auth::user()->id)->where('education_level_id',$key)->get();
                    @endphp
                    <div id="educationList_{{$key}}"></div>
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