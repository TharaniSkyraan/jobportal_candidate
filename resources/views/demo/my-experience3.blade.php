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
                <div id="my_expernce2" class="mt-4">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img src="{{asset('images/candidate_educ.png')}}">&nbsp;My Experience</h2>
                    </div>

                    <h3 class="mt-5 mb-3">Total years of experience :<span class="fw-bolder">2 years 6 months</span></h3>

                    <div class="crdbxpl mt-5">
                        <div class="row">
                            <div class="col-8 px-4 align-self-center">Experience</div>
                            <div class="col-4 text-end"><button>Add New <i class="fa fa-plus"></i></button></div>
                        </div>
                    </div>


                    <div class="card mt-5">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4 text-end">
                                <div class="row">
                                    <div class="col-6"><i class="fa fa-edit"></i></div>
                                    <div class="col-6"><i class="fa fa-trash"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 dtls">
                            <h3 class="fw-bolder mb-1">UX UI Designer</h3>
                            <p class="mb-0">Skyraan Technologies</p>
                            <p class="mb-0">Coimbatore , Tamilnadu, India.</p>
                            <p class="mb-2">1 Nov,2020- .</p>
                            <small>Notice Period :<small class="text-dark"> 2 Months</small></small>
                        </div>
                        <p class="mb-3">Tools / software Used</p>

                        <div class="col-md-12 mb-5 skilsdtl">
                            <span class="text-primary">JAVA &nbsp;&nbsp;&nbsp;<i class="fa fa-close"></i></span>
                            <span class="text-primary">C &nbsp;&nbsp;&nbsp;<i class="fa fa-close"></i></span>
                        </div>    
                        <div class="text-center">
                            <p class="fw-bolder">More Details &nbsp;<i class="fa fa-chevron-up"></i></p>
                        </div>                    
                    </div>

                    <div class="card mt-4">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4 text-end">
                                <div class="row">
                                    <div class="col-6"><i class="fa fa-edit"></i></div>
                                    <div class="col-6"><i class="fa fa-trash"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 dtls">
                            <h3 class="fw-bolder mb-1">UX UI Designer</h3>
                            <p class="mb-0">Skyraan Technologies</p>
                            <p class="mb-0">Coimbatore , Tamilnadu, India.</p>
                            <p class="mb-2">1 Nov,2020- .</p>
                            <small>Notice Period :<small class="text-dark"> 2 Months</small></small>
                        </div>
                        <p class="mb-3">Tools / software Used</p>

                        <div class="col-md-12 mb-5 skilsdtl">
                            <span class="text-primary">JAVA &nbsp;&nbsp;&nbsp;<i class="fa fa-close"></i></span>
                            <span class="text-primary">C &nbsp;&nbsp;&nbsp;<i class="fa fa-close"></i></span>
                        </div>    
                        <div class="text-center">
                            <p class="fw-bolder">More Details &nbsp;<i class="fa fa-chevron-up"></i></p>
                        </div>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>