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

<style>

</style>



@section('content')
<div class="wrapper" >
	@include('layouts.header')
	@include('demo.sidebar')

	<div class="main-panel main-panel-custom">
		<div class="content">
			<div class="page-inner">
                <div id="my_eductin" class="mt-4">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img src="{{asset('images/candidate_educ.png')}}">&nbsp;My Eduaction</h2>
                    </div>

                    <div class="crdbxpl mt-5">
                        <div class="row">
                            <div class="col-10 px-5">PG ( Post Graduate )</div>
                            <div class="col-2 align-self-center"><i class="fa fa-plus"></i></div>
                        </div>
                    </div>

                    <div class="crdbxless">
                        <div class="row">
                            <div class="col-10 px-5">UG ( Under Graduate )</div>
                            <div class="col-2 align-self-center"><i class="fa fa-minus"></i></div>
                        </div>
                    </div>

                    <!--edit design-->
                    <div class="appendeducation card">
                        <div class="text-end">
                            <i class="fa fa-edit"></i>
                        </div>

                        <div class="row mb-5">
                            <div class="col-md-6">
                                <label for="" class="mb-2">Name Of Degree</label>
                                <div class="fw-bolder">Bachelor of Engineering</div>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="mb-2">Major Subject</label>
                                <div class="fw-bolder">UG (Under Graduate)</div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-md-6">
                                <label for="" class="mb-2">Place of Education</label>
                                <div class="fw-bolder">Coimbatore, Tamilnadu, India</div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-md-6">
                                <label for="" class="mb-2">Instition name</label>
                                <div class="fw-bolder">ABC college of Engineering and Technology</div>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="mb-2">University / Board</label>
                                <div class="fw-bolder">Anna University</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="" class="mb-2">Year of education</label>
                                <div class="fw-bolder">2012-2020</div>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="mb-2">Secured</label>
                                <div class="fw-bolder">80%</div>
                            </div>
                        </div>
                    </div>


        



                    <div class="card mt-5">
                        <div class="col-md-10 mb-4">
                            <label for="exampleInputPassword1" class="form-label fw-bolder">Name of Degree</label>
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Bachelor of Engineering</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col-md-10">
                            <label for="exampleInputPassword1" class="form-label fw-bolder">Major Subject</label>
                            <select class="form-select" aria-label="Default select example">
                                <option selected>UG(Under Graduate)</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>

                        <hr/>

                        <div class="col-md-10 mb-4">
                            <label for="exampleInputPassword1" class="form-label fw-bolder">Place of Education</label>
                            <div class="mb-3">
                                <label for="exampleInputPassword2" class="form-label fw-bolder">Country</label>
                            </div>
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Your current Country</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label for="exampleInputPassword1" class="form-label fw-bolder">State</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Your current State</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="exampleInputPassword1" class="form-label fw-bolder">City</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Your current City</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>

                        <hr/>

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label fw-bolder">Institution name</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label fw-bolder">University / Board</label>
                            <select class="form-select" aria-label="Default select example">
                                <option selected></option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <div class="row">
                                    <label for="" class="form-label fw-bolder">Year of education</label>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-2">
                                        <div class="input-group">
                                            <span class="input-group-text" id="">From</span>
                                            <input class="form-control from_year required" id="from_year" max="2022-11" min="1980-01" placeholder="From" autocomplete="off" name="from_year" type="month" value="">
                                        </div>    
                                        <small class="help-block form-text text-muted text-danger err_msg from_year-error" id="err_from_year"></small> 
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-2">
                                        <div class="input-group">
                                            <span class="input-group-text" id="">To</span>
                                            <input class="form-control to_year required" id="to_year" max="2022-11" min="1980-01" placeholder="Completed Year" autocomplete="off" name="to_year" type="month" value="">
                                        </div>      
                                        <small class="help-block form-text text-muted text-danger err_msg to_year-error" id="err_to_year"></small> 
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-2 mt-5">
                                <input class="form-check-input" id="pursuing" name="pursuing" type="checkbox" value="yes">
                                <label class="form-check-label" for="pursuing">
                                Pursuing
                                </label>
                            </div>
                        </div>

                        <hr/>

                        <label for="" class="form-label fw-bolder">Secured</label>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Mark
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Percentage
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="" class="form-label fw-bolder">Your percentage</label>
                            <input type="text" class="form-control" id="">
                        </div>

                        <div class="row mt-5">
                            <div class="col-6 d-flex justify-content-center">
                                <input type="button" class="btn cnsl_btn" value="Cancel">
                            </div>
                            <div class="col-6 d-flex justify-content-center">
                                <input type="submit" class="btn sb_btn" value="Submit">
                            </div>
                        </div>
                    </div>


                    <div class="crdbxpl mt-5">
                        <div class="row">
                            <div class="col-10 px-5">Higher Secondary/+2</div>
                            <div class="col-2 align-self-center"><i class="fa fa-plus"></i></div>
                        </div>
                    </div>

                    <div class="crdbxpl mt-5">
                        <div class="row">
                            <div class="col-10 px-5">High school /10th</div>
                            <div class="col-2 align-self-center"><i class="fa fa-plus"></i></div>
                        </div>
                    </div>

                    <div class="crdbxpl mt-5">
                        <div class="row">
                            <div class="col-10 px-5">Diplomo</div>
                            <div class="col-2 align-self-center"><i class="fa fa-plus"></i></div>
                        </div>
                    </div>

                    <div class="crdbxpl mt-5">
                        <div class="row">
                            <div class="col-10 px-5">Other Certification Course</div>
                            <div class="col-2 align-self-center"><i class="fa fa-plus"></i></div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>

