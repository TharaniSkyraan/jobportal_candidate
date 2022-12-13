@extends('layouts.app')

@section('content')
<div class="wrapper" >
	@include('layouts.header')
	@include('layouts.side_navbar')

	<div class="main-panel main-panel-custom">
		<div class="content">
			<div class="page-inner">
                <div id="my_skills" class="mt-4">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img src="{{asset('images/candidate_educ.png')}}">&nbsp;My Skills</h2>
                    </div>

                    <div class="mt-4 mb-3">
                        <h4 class="fw-bolder">Skills from your Jobs</h4>
                    </div>

                    <div class="col-md-12 mb-5">
                        <span class="text-primary skilsdtl">JAVA &nbsp;&nbsp;&nbsp;<i class="fa fa-close"></i></span>
                        <span class="text-primary skilsdtl">C &nbsp;&nbsp;&nbsp;<i class="fa fa-close"></i></span>
                    </div>  
                    
                    <div class="card">
                        <div class="mb-3">
                            <input type="email" class="form-control" id="exampleFormControlInput1" value="JAVA">
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label fw-bolder" for="flexCheckDefault">
                            currently working
                            </label>
                        </div>  

                        <label for="exampleFormControlInput1" class="form-label fw-bolder">Skill level</label>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                       Beginer
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Average
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Professional
                                        </label>
                                    </div>
                                </div>
                            </div>
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

@endsection