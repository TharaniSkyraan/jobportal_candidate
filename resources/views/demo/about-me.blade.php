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
                <div id="abt_meusr" class="mt-4">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img src="{{asset('images/candidate_educ.png')}}">&nbsp;About me</h2>
                    </div>

                    <div class="card mt-5">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="profilepictureappend">
                                    <div class="text-center icnsuld">
                                        <i class="fa fa-camera cursor-pointer update-profile"></i>
                                    </div>
                                    <img src="https://mugaam.s3.ap-south-1.amazonaws.com/ProfilePictures/IVmHWwJHIdfWRpZH0HRms53XfEqiAAPM1RkMTgB1.png" class="savecompanyname updateprofilepicture">
                                </div>
                            </div>

                            <div class="col-md-9">
                                <div class="mb-4">
                                    <label for="exampleInputPassword1" class="form-label fw-bolder">Your Name</label>
                                    <div class="fw-bolder">Skyraan</div>
                                </div>
                                <div class="mb-4">
                                    <label for="exampleInputPassword1" class="form-label fw-bolder">Your Email ID</label>
                                    <div class="fw-bolder d-flex align-items-center">xyz@gmail.com &nbsp;<i class="fa-solid fa-check"></i></div>
                                </div>
                                <div class="mb-4">
                                    <label for="exampleInputPassword1" class="form-label fw-bolder">Your Phone number(optional)</label>
                                    <div class="fw-bolder">+91 ***** *****</div>
                                </div>
                                <div class="col-md-10 mb-4">
                                    <label for="date_of_birth" class="col-form-label fw-bolder">Date of Birth</label>
                                    <input class="form-control required" id="date_of_birth" min="1900-01-02" max="2008-12-31" placeholder="Date of Birth" autocomplete="off" name="date_of_birth" type="date" value="2008-10-24">
                                    <small class="form-text text-muted text-danger err_msg" id="err_date_of_birth"></small>
							    </div>
                                <div class="col-md-10 mb-4">
                                    <label for="exampleInputPassword1" class="form-label fw-bolder">Gender</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Select your gender</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="col-md-10 mb-4">
                                    <label for="exampleInputPassword1" class="form-label fw-bolder">Marital Status</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Select your status</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="col-md-10 mb-4">
                                    <label for="exampleInputPassword1" class="form-label fw-bolder">Currently living City</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Select city name</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>



                <div class="text-center">

                </div>
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>