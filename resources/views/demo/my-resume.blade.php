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
                <div id="my_resme" class="mt-4">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img src="{{asset('images/candidate_educ.png')}}">&nbsp;My Resume</h2>
                    </div>

                    <div class="card mt-5">
                        <span class="fw-bolder">Resume( <span class="fw-normal">You can keep up to 2 resumes</span> )</span>
                        <div class="row mt-3">
                            <div class="col-md-4 mb-3">
                                <a class="text-dark text-decoration-underline">Job portal Resume</a>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-2 align-self-center"><i class="fa fa-info"></i></div>
                                            <div class="col-10">
                                                <span class="form-check form-switch">
                                                    <input class="form-check-input" type="radio" data-value="1" name="primary" value="1" checked="">
                                                    <span class="form-check-label primeinfo1">primary</span>                                        
                                                </span>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="col-md-6">
                                        <span><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;Replace</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-5 text-center">
                            <table>
                                <th><a class="text-decoration-underline" href="">Upload Resume</a></th>
                                <th><i class="fas fa-arrow-up"></i></th>
                            </table>     
                        </div>
                    </div>

                    <div class="card mt-5">
                        <span class="fw-bolder">Cover Letter( <span class="fw-normal">optional</span> )</span>

                        <div class="col-md-12 mt-5 text-center">
                            <table>
                                <th><a class="text-decoration-underline" href="">Upload Resume</a></th>
                                <th><i class="fas fa-arrow-up"></i></th>
                            </table>     
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>