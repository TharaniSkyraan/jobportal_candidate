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
                <div id="my_expernce2" class="mt-4">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img src="{{asset('images/candidate_educ.png')}}">&nbsp;My Experience</h2>
                    </div>
                    @php
                        $total_exp = Auth::user()->total_experience;
                        $total_exp = explode('.',$total_exp);
                    @endphp
                    <h3 class="mt-5 mb-3">Total years of experience :<span class="fw-bolder"> {{$total_exp[0]}} years {{$total_exp[1]}} month</span></h3>

                    <div class="crdbxpl mt-5">
                        <div class="row">
                            <div class="col-8 px-4 align-self-center">Experience</div>
                            <div class="col-4 text-end"><button class="openForm addExperience" type="button" data-form="new">Add New <i class="fa fa-plus"></i></button></div>
                        </div>
                    </div>
                    
                    <div class="append-form-experience">
                        @if(count(Auth::user()->userExperience) == 0)
                        <div class="text-center">
                            <img src="{{ asset('site_assets_1/assets/img/fresher.png')}}" height="250" width="250">
                        </div>
                        @endif 
                    </div>
                    <!-- experience card-->
                    <div class="" id="experience_div"></div>
                    <!-- experience card end -->

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
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/dashboard/uexp!e8u12.js') }}"></script>
@endsection