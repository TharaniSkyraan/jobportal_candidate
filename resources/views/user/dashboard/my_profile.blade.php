@extends('layouts.app')

@section('custom_scripts')

<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery-ui.min.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery.tagsinput-revisited.css')}}" rel="stylesheet">	  
<link href="{{ asset('site_assets_1/assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/vendor/selectize/selectize.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/userbasic.w2fr4ha2.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/date_flatpicker/flatpickr.min.css')}}" rel="stylesheet">
<script src="{{ asset('site_assets_1/assets/date_flatpicker/flatpickr.js')}}"></script>
@endsection

@section('content')

<div class="wrapper" >
        
	@include('layouts.header')
	@include('layouts.side_navbar')

	<div class="main-panel main-panel-custom">
		<div class="content">
			<div class="">
				<h4 class="page-title"></h4>
			</div>
			<div class="page-inner">
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-body wizard-tab">
								<ul class="nav nav-pills justify-content-around align-items-center" id="pills-tab" role="tablist">
									<li class="nav-item my-2" role="presentation">
										<button class="nav-link active" id="pills-basic_info-tab" data-id="basic_info" data-bs-toggle="pill" data-bs-target="#pills-basic_info" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Basic Info</button>
									</li>
									<li class="nav-item my-2" role="presentation">
										<button class="nav-link" id="pills-education-tab" data-id="education" data-bs-toggle="pill" data-bs-target="#pills-education" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Education</button>
									</li>
									<li class="nav-item my-2" role="presentation">
										<button class="nav-link" id="pills-experience-tab" data-id="experience" data-bs-toggle="pill" data-bs-target="#pills-experience" type="button" role="tab" aria-controls="pills-experience" aria-selected="false">Experience</button>
									</li>
									<li class="nav-item my-2" role="presentation">
										<button class="nav-link" id="pills-projects-tab" data-id="projects" data-bs-toggle="pill" data-bs-target="#pills-projects" type="button" role="tab" aria-controls="pills-projects" aria-selected="false">Projects</button>
									</li>
									<li class="nav-item my-2" role="presentation">
										<button class="nav-link" id="pills-skills-tab" data-id="skill" data-bs-toggle="pill" data-bs-target="#pills-skills" type="button" role="tab" aria-controls="pills-skills" aria-selected="false">Skills</button>
									</li>
									<li class="nav-item my-2" role="presentation">
										<button class="nav-link" id="pills-languages-tab" data-id="language" data-bs-toggle="pill" data-bs-target="#pills-languages" type="button" role="tab" aria-controls="pills-languages" aria-selected="false">Languages</button>
									</li>
								</ul>
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="">
							<div class="">
								<div class="tab-content" id="pills-tabContent">
									<!-- basic-info -->
										
									<!--Start Basic Info Form-->
								
									<div class="card page-inner mt-4 mb-4 tab-pane fade show active" id="pills-basic_info" role="tabpanel" aria-labelledby="pills-basic_info-tab">
												
										<!-- <form class="mt-4 mb-3"> -->
										<div class="row mb-4">
											@if(session()->has('message'))
												<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert-update">
												<strong>Success!</strong> Basic Info Updated Successfully
												<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
												</div>
											@endif
											<div class="col-md-6 mb-2">
												<div class="form-group {!! APFrmErrHelp::hasError($errors, 'first_name') !!}">
												<label for="first_name" class="form-label fw-bolder">First Name</label>
												{!! Form::text('first_name', null, array('class'=>'form-control required', 'id'=>'first_name', 'placeholder'=>__('First Name'))) !!}
												<small class="form-text text-muted text-danger err_msg" id="err_first_name"></small>
												</div>
											</div>

											<div class="col-md-6">
												<label for="last_name" class="form-label fw-bolder">Last Name</label>
												{!! Form::text('last_name', null, array('class'=>'form-control required', 'id'=>'last_name', 'placeholder'=>__('Last Name'))) !!}
												<small class="form-text text-muted text-danger err_msg" id="err_last_name"></small>
											</div>

										</div>

										<!--  -->

										<div class="mb-4">
											<div class="form-check-inline">
												<label for="" class="form-label fw-bolder">Gender</label>
											</div>    
												@php $cgender = (!empty($user->gender))?$user->gender:2; @endphp
												@foreach($genders as $key => $gender)
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" name="gender" id="gender{{$key}}" value="{{$key}}" @if($key==$cgender) checked @endif>
													<label class="form-check-label" for="gender{{$key}}">{{$gender}}</label>
												</div>
												@endforeach
										</div>

										<div class="row mb-4">
											
											<div class="col-md-6 mb-2">
												<label for="date_of_birth" class=" col-form-label fw-bolder">Date of Birth</label>
											
												{!! Form::date('date_of_birth', $user->date_of_birth??null, array('class'=>'form-control required', 'id'=>'date_of_birth', 'min'=>'1900-01-02', 'max'=>'2008-12-31', 'placeholder'=>__('Date of Birth'), 'autocomplete'=>'off')) !!}
												<small class="form-text text-muted text-danger err_msg" id="err_date_of_birth"></small>
											</div>

											<div class="col-md-6 mb-2">
												<label for="marital_status_id" class=" col-form-label fw-bolder">Marital status</label>
												{!! Form::select('marital_status_id', [''=>__('Select Marital Status')]+$maritalStatuses, null, array('class'=>'form-select required', 'id'=>'marital_status_id')) !!}
												<small class="form-text text-muted text-danger err_msg" id="err_marital_status_id"></small>
											</div>

										</div>
										<h3>Career Information : </h3>
										<hr>
										
										<div class="row">
											<div class="col-md-6 mb-3">
												<div class="form-group {!! APFrmErrHelp::hasError($errors, 'career_title') !!}">
													<label for="career_title" class="form-label fw-bolder">Career Title</label>
													{!! Form::text('career_title', null, array('class'=>'form-control required', 'id'=>'career_title', 'placeholder'=>__('ex:auditor, doctor'))) !!}
													<small class="form-text text-muted text-danger err_msg" id="err_career_title"></small>
													{!! APFrmErrHelp::showErrors($errors, 'career_title') !!} 													
												</div>
											</div>
										</div>
										
										@php
											$country_id = (!empty($user->country_id))?$user->country_id:$ip_data->country_id;
											$country = (!empty($user->country_id))?$user->getCountry('country'):$ip_data->geoplugin_countryName;
										@endphp
										<div class="row">											
											<label for="div_country_id" class="form-label fw-bolder">Job Preferred Location <span class="country_text">- {{ $country }} <a href="javascript:void(0);" onClick="CountryChange()">Change</a></span></label>  
											<div class="col-md-6 mb-3 country_change"  style="display:none;">
												<label for="div_country_id" class="form-label fw-bolder">Country </label>  
												<div>                              
													{!! Form::select('country_id', $countries['value'], $country_id, array('class'=>'form-select required', 'id'=>'country_id'), $countries['attribute']) !!}
													<small class="form-text text-muted text-danger err_msg" id="err_country_id"></small>
													{!! APFrmErrHelp::showErrors($errors, 'country_id') !!} 
												</div>
											</div>
										</div>

										<div class="row">      
											<label for="div_location" class="form-label fw-bolder">City</label>                        
											<div class="col-md-6 mb-3">  
												{!! Form::text('user_location', $user->location??null, array('class'=>'form-control-2 required typeahead', 'id'=>'user_location', 'placeholder'=>__('Enter your location'),' aria-label'=>'Enter your location')) !!}
												{!! APFrmErrHelp::showErrors($errors, 'user_location') !!} 
												<small class="form-text text-muted text-danger err_msg" id="err_user_location"></small>
											</div>
										</div>                         

										<div class="mb-4">
											<div class="">
												<label for="" class="form-label fw-bolder">Employment Status</label>
											</div>
											<div class="row align-items-center">    
												<div class="form-check-inline col-md-2">
													{{ Form::radio('employment_status', 'fresher' , true, array('class'=>'form-check-input employment_status', 'id'=>'Fresher')) }}
													{{-- <input class="form-check-input employment_status" type="radio" name="employment_status" id="Fresher" value="fresher" @if($user->employment_status=='fresher') checked @endif> --}}
													<label class="form-check-label" for="Fresher">Fresher</label>
												</div>
												<div class="form-check-inline col-md-2">
													{{ Form::radio('employment_status', 'experienced' , false, array('class'=>'form-check-input employment_status', 'id'=>'Experienced')) }}
													{{-- <input class="form-check-input employment_status" type="radio" name="employment_status" id="Experienced" value="experienced" @if($user->employment_status=='experienced') checked @endif> --}}
													<label class="form-check-label" for="Experienced">Experienced</label>
												</div>
											</div>
										</div>
										<div class="row total_experience" style="display:none;"> 
											<div class="col-md-6 col-12 col-sm-6 col-xs-6 mb-3">  
												<label for="total_experience" class="form-label fw-bolder">Total Experience</label>
												{!! Form::number('total_experience', null, array('class'=>'form-control','min'=>'0', 'max'=>'40','oninput'=>'validity.valid||this.reportValidity()', 'id'=>'total_experience')) !!}
												<small class="form-text text-muted text-danger err_msg" id="err_total_experience"></small>
												{!! APFrmErrHelp::showErrors($errors, 'total_experience') !!}
											</div>
										</div>
										<div class="row">												
											<div class="col-md-1 col-xl-1 col-sm-6 col-xs-12 mb-2">
												<label for="" class="form-label fw-bolder">Currency</label>
												{!! Form::select('salary_currency', ['₹'=>'₹'], null, array('class'=>'form-select', 'id'=>'salary_currency')) !!}
												<small class="form-text text-muted text-danger err_msg" id="err_salary_currency"></small>
												{!! APFrmErrHelp::showErrors($errors, 'salary_currency') !!}
											</div>
											<div class="col-md-2 col-xl-2 col-sm-6 col-xs-12 mb-2">
												<label for="" class="form-label fw-bolder">Current Salary (PA)</label>
												{!! Form::text('current_salary', null, array('class'=>'form-control', 'id'=>'current_salary', 'data-type'=>'currency', 'minlength'=>'0', 'maxlength'=>'10', 'placeholder'=>__('Current Salary'))) !!}
												<small class="form-text text-muted text-danger err_msg" id="err_current_salary"></small>
												{!! APFrmErrHelp::showErrors($errors, 'current_salary') !!}
											</div>																
											<div class="col-md-3 col-xl-3 col-sm-6 col-xs-12 mb-2">
												<label for="" class="form-label fw-bolder">Expected Salary (PA)</label>
												{!! Form::text('expected_salary', null, array('class'=>'form-control', 'data-type'=>'currency', 'id'=>'expected_salary', 'minlength'=>'0', 'maxlength'=>'10', 'placeholder'=>__('Expected Salary'))) !!}
												<small class="form-text text-muted text-danger err_msg" id="err_expected_salary"></small>
												{!! APFrmErrHelp::showErrors($errors, 'expected_salary') !!}
											</div>
										</div>
						
										<div class="row"> 
											<div class="col-md-6 col-12 col-sm-6 col-xs-6 mb-3">  
												<label for="notice_period" class="form-label fw-bolder">Availablility to join (Optional)</label>
												{!! Form::select('notice_period', []+$noticePeriod, null, array('class'=>'form-select notice_period', 'placeholder'=>'Select', 'id'=>'notice_period')) !!}
							
												<small class="form-text text-muted text-danger err_msg" id="err_notice_period"></small>
												{!! APFrmErrHelp::showErrors($errors, 'notice_period') !!}                             
											</div>
										</div>     
										
										<div class="d-flex justify-content-around mb-3">

											<div class="text-center mt-2">
												<button class="btn btn-submit bg-green-color" id="basic-info-submit-button" type="button">Save</button>
											</div>
										</div>
				

										{!! Form::close() !!}
										<!-- End Basic Info Form -->
									</div>

									<!-- basci info ends -->

									<!-- educations start -->
									<div class="tab-pane mt-4 fade" id="pills-education" role="tabpanel" aria-labelledby="pills-education-tab">
										<div class="row" id="div-education">
											<div class="col-12 col-lg-12 m-auto">
												<div class="card page-inner mb-4">
													<div id="education_success"></div>
													<!-- Education Form start-->
													<div class="append-form-education"></div>
													<!-- /Education Form end-->
													<div class="text-center">
														<button class="btn btn-add openForm" type="button" data-form="new">Add Education</button>
													</div>
												</div>
												<!-- education card-->
												<div class="" id="education_div"></div>
												<!-- education card end -->
											</div>
										</div>								
									</div>
									<!-- education ends -->

									<!--experience starts-->
									<div class="tab-pane fade mt-4" id="pills-experience" role="tabpanel" aria-labelledby="pills-experience-tab">
										<div class="row" id="div-experience">
											<div class="col-12 col-lg-12 m-auto">
												<div class="card page-inner mb-4">											
													<div id="experience_success"></div>
													<!-- Experience Form start-->
													<div class="append-form-experience">
														@if(count($user->userExperience) == 0)
														<div class="text-center">
															<img src="{{ asset('site_assets_1/assets/img/fresher.png')}}" height="250" width="250">
														</div>
														@endif 
													</div>
													<!-- /Experience Form end-->										
													<div class="text-center">
														<button class="btn btn-add openForm" type="button" data-form="new">Add Experience</button>
													</div>
												</div>
											
												<!-- experience card-->
												<div class="" id="experience_div"></div>
												<!-- experience card end -->
											</div>
										</div>
									</div>
									<!-- experience ends -->

									<!--projects starts-->
									<div class="tab-pane fade mt-4" id="pills-projects" role="tabpanel" aria-labelledby="pills-projects-tab">
										<div class="row" id="div-projects">
											<div class="col-12 col-lg-12 m-auto">

												<div class="card page-inner mb-4">
													
													<div id="project_success"></div>
													<!-- Projects Form start-->
													<div class="append-form-project">
														@if(count($user->userProjects) == 0)
														<div class="text-center">
															<img src="{{ asset('site_assets_1/assets/img/fresher.png')}}" height="250" width="250">
														</div>
														@endif 
													</div>
													<!-- /Projects Form end-->
												
													<div class="text-center">
														<button class="btn btn-add openForm" type="button" data-form="new">Add Projects</button>
													</div>

												</div>
											
												<!-- projects card-->
												<div class="" id="projects_div"></div>
												<!-- projects card end -->
												
											</div>
										</div>
									</div>
									<!-- projects ends -->

									
									<!-- skills start -->
									<div class="tab-pane fade mt-4" id="pills-skills" role="tabpanel" aria-labelledby="pills-skills-tab">
										<div class="row" id="div-skill">
											<div class="col-12 col-lg-12 m-auto">
												<div class="card page-inner mb-4">
													<!-- Skill Form--->
													<div id="skill_success"></div>

													<div class="append-form-skill" id="append-form-skill"></div>
													
													<!-- End of Form -->
													<div class="text-center">
														<button class="btn btn-add openForm" type="button" data-form="new">Add Skills</button>
													</div>

												</div>

												<!-- Skill List card-->
												<div class="" id="skill_div"></div>                        
												<!-- Skill List card end -->
												
											</div>
										</div>
									</div>
									<!-- skills ends -->
									
									<!-- languages starts -->
									<div class="tab-pane fade mt-4" id="pills-languages" role="tabpanel" aria-labelledby="pills-languages-tab">
										<!--form panels-->
										<div class="row" id="div-language">
											<div class="col-12 col-lg-12 m-auto">
												<div class="multisteps-form__form">
												
													<!--Languages-->
													<div class=" js-active " data-animation="scaleIn">

														<!-- info card-->
														<div class="card page-inner mb-4">
															<div id="language_success"></div>
															<!-- Form Tag -->
															<div class="append-card-language" id="append-card-language"></div>
															<!-- End Form -->
															<div class="text-center">
																<button class="btn btn-add openForm" type="button" data-form="new">Add Language</button>
															</div>
														</div>

														<!-- Language List card-->
														<div class="" id="language_div"></div>                        
														<!-- Language List card end -->

													
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- languages ends -->									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

  <!-- Button trigger modal -->

</div>
@endsection
@section('custom_bottom_scripts')
<script type="text/javascript" src="{{ asset('site_assets_1/assets/js/input_tag/jquery.tagsinput-revisited.js') }}"></script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/selectize/selectize.js')}}"></script>
<script  type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/typehead/typeahead.bundle.js') }}"></script>
@endsection

@push('scripts')
<script type="text/javascript">
var baseurl = '{{ url("/") }}/';

var current_salary = '{{ old("current_salary")??$user->current_salary??"" }}';
var expected_salary = '{{ old("expected_salary")??$user->expected_salary??"" }}';
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/dashboard/uprofile.8y9u2i.js') }}"></script>
@endpush