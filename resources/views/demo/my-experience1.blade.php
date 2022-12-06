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
                <div id="my_expernce1" class="mt-4">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img src="{{asset('images/candidate_educ.png')}}">&nbsp;My Experience</h2>
                    </div>

                    <h3 class="mt-5 mb-3">Total years of experience :<span class="fw-bolder">2 years 6 months</span></h3>

                    <div class="card mt-4">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label fw-bolder">Designation</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>   

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label fw-bolder">Name of Organization/Industry</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div> 

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label fw-bolder">Working</label>
                            <div class="row">
                                <div class="col-md-8 col-sm-12 col-xs-12">
                                    <div class="row">
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
                                
                                <div class="col-md-4 col-sm-12 col-xs-12 align-self-center">
                                    <input class="form-check-input" id="pursuing" name="pursuing" type="checkbox" value="yes">
                                    <label class="form-check-label" for="pursuing">
                                    Pursuing
                                    </label>
                                </div>
                            </div>
                        </div> 

                        <div class="mb-3">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label fw-bolder">About my job (Optional)</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Write about your roles and responsibilities in this industry/ Organaisation" rows="3"></textarea>
                            </div>
                        </div> 

                        <div class="mb-4">    
                            <label for="" class="form-label fw-bolder">Tools / Softwares Used (Optional)</label>   
                            <input type="text" name="used_tools" class="form-control" value="" id="tagsinputexp" style="display: none;"><div id="tagsinputexp_tagsinput" class="tagsinput" style="width: auto; min-height: auto; height: auto;"><div id="tagsinputexp_addTag"><input id="tagsinputexp_tag" class="tag-input ui-autocomplete-input" value="" placeholder="Add a tag" autocomplete="off"></div></div>
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
                </div>
            </div>
        </div>
    </div>
</div>