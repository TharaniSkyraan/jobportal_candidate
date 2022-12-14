@extends('layouts.app')


@section('custom_scripts')
<style>
    .prof_bg .fa-key{
        background-color: #fff;
        width: 25px;
        height: 25px;
        color: #000;
        text-align: center;
        border-radius: 50%;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        display: flex;
        font-size: 12px;
    }

    #abt_meusr .card {
        padding: 30px;
    }

    #abt_meusr .prof_bg{
        padding: 20px;
        background: #cccccc29;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgb(0 0 0 / 20%);
    }
</style>
@endsection


@section('content')
<div class="wrapper" >
	@include('layouts.header')
	@include('layouts.side_navbar')





	<div class="main-panel main-panel-custom">
		<div class="content">
			<div class="page-inner">
                <div id="abt_meusr" class="mt-4">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img src="{{asset('images/candidate_educ.png')}}">&nbsp;About me</h2>
                    </div>

                    <div class="card mt-5">
                        <div class="prof_bg">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="profilepictureappend">
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
                                    <div class="col-md-12 text-end">
                                    <div class="fw-bolder d-flex align-items-end justify-content-end cursor-pointer"><i class="fa-solid fa fa-key"></i>&nbsp;Account Settings</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        <div class="row">
                            <div class="col-md-3 col-lg-3"></div>                            
                            <div class="col-md-9">                            
                                <div class="col-md-10 mb-4 mt-3">
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
@endsection