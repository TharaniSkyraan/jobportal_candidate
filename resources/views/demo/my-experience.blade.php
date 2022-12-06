@extends('layouts.app')

@section('custom_scripts')

<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery-ui.min.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery.tagsinput-revisited.css')}}" rel="stylesheet">	  
<link href="{{ asset('site_assets_1/assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/vendor/selectize/selectize.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/date_flatpicker/flatpickr.min.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/userbasic.w2fr4ha2.css')}}" rel="stylesheet">
<script src="{{ asset('site_assets_1/assets/date_flatpicker/flatpickr.js')}}"></script>
<link href="{{asset('css/user_skill.css')}}" rel="stylesheet">

@endsection

@section('content')
<div class="wrapper" >
	@include('layouts.header')
	@include('demo.sidebar')

	<div class="main-panel main-panel-custom">
		<div class="content">
			<div class="page-inner">
                <div id="my_expernce" class="mt-4">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img src="{{asset('images/candidate_educ.png')}}">&nbsp;My Experience</h2>
                    </div>

                    <h2 class="mt-5 mb-3 text-center fw-bolder">I am</h2>

                    <div class="row expnce">
                        <div class="col-md-6 text-center ">
                            <div>
                                <img src="{{asset('images/fresher_inactive.png')}}" alt="">
                            </div>
                            <div class="fw-bolder mt-3">A Fresher</div>
                        </div>
                        <div class="col-md-6 text-center ">
                            <div>
                                <img src="{{asset('images/experienced_inactive.png')}}" alt="">
                            </div>
                            <div class="fw-bolder mt-3">Experienced</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>