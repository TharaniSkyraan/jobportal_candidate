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
                <div id="my_skills1" class="mt-4">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img src="{{asset('images/candidate_educ.png')}}">&nbsp;My skills</h2>
                    </div>


                    <div class="crdbxpl mt-5">
                        <div class="row">
                            <div class="col-8 px-4 align-self-center">Skill</div>
                            <div class="col-4 text-end"><button>Add New <i class="fa fa-plus"></i></button></div>
                        </div>
                    </div>
                       

                    <div class="card mt-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4 dtls">
                                    <h3 class="fw-bolder mb-1">JAVA</h3>
                                    <p class="mb-0">Currently working</p>
                                    <p class="mb-0">Skill level</p>
                                    <p class="fw-bolder">Professional</p>
                                </div>
                            </div>
                            <div class="col-md-6 align-self-center text-end">
                                <div class="row">
                                    <div class="col-6"><i class="fa fa-edit"></i></div>
                                    <div class="col-6"><i class="fa fa-trash"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4 dtls">
                                    <h3 class="fw-bolder mb-1">C+</h3>
                                    <p class="mb-0">Currently working</p>
                                    <p class="mb-0">Skill level</p>
                                    <p class="fw-bolder">Professional</p>
                                </div>
                            </div>
                            <div class="col-md-6 align-self-center text-end">
                                <div class="row">
                                    <div class="col-6"><i class="fa fa-edit"></i></div>
                                    <div class="col-6"><i class="fa fa-trash"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4 dtls">
                                    <h3 class="fw-bolder mb-1">PHP</h3>
                                    <p class="mb-0">Currently working</p>
                                    <p class="mb-0">Skill level</p>
                                    <p class="fw-bolder">Professional</p>
                                </div>
                            </div>
                            <div class="col-md-6 align-self-center text-end">
                                <div class="row">
                                    <div class="col-6"><i class="fa fa-edit"></i></div>
                                    <div class="col-6"><i class="fa fa-trash"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4 dtls">
                                    <h3 class="fw-bolder mb-1">C++</h3>
                                    <p class="mb-0">Currently working</p>
                                    <p class="mb-0">Skill level</p>
                                    <p class="fw-bolder">Professional</p>
                                </div>
                            </div>
                            <div class="col-md-6 align-self-center text-end">
                                <div class="row">
                                    <div class="col-6"><i class="fa fa-edit"></i></div>
                                    <div class="col-6"><i class="fa fa-trash"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>