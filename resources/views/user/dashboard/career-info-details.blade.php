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
                    @php
                        $noticePeriod = app\Helpers\DataArrayHelper::langNoticePeriodsArray();
                        $user = Auth::user();
                        $countries = app\Helpers\DataArrayHelper::CountriesArray();
                    @endphp
                    <div class="card mt-5">
                        {!! Form::model($user, array('method' => 'put', 'route' => array('my_profile_save'), 'id' => 'submitbasicinfoform', 'class' => 'form', 'files'=>true)) !!}
                            <div class="row mt-5">
                                <div class="col-md-12">  
                                    <div class="col-md-12 mb-4">
                                        <div class="{!! APFrmErrHelp::hasError($errors, 'career_title') !!}">
                                          	<label for="career_title" class="form-label fw-bolder">Career Title</label>
                                            {!! Form::text('career_title', null, array('class'=>'form-control required', 'id'=>'career_title', 'placeholder'=>__('ex:auditor, doctor'))) !!}
                                            <small class="form-text text-muted text-danger err_msg" id="err_career_title"></small>
                                            {!! APFrmErrHelp::showErrors($errors, 'career_title') !!} 													
                                        </div>                          
                                    </div>       
										@php
											$country_id = (!empty($user->country_id))?$user->country_id:$ip_data->country_id;
											$country = (!empty($user->country_id))?$user->getCountry('country'):$ip_data->geoplugin_countryName;
										@endphp                   
                                    <div class="col-md-12 mb-4 mt-3">
                                       <label for="div_country_id" class="form-label fw-bolder">Job Preferred Location <span class="country_text">- {{ $country }} <a href="javascript:void(0);" onClick="CountryChange()">Change</a></span></label>  
                                        <div class="mb-3 country_change"  style="display:none;">
                                            <label for="div_country_id" class="form-label fw-bolder">Country </label>  
                                            <div>                              
                                                {!! Form::select('country_id', $countries['value'], $country_id, array('class'=>'form-select required', 'id'=>'country_id'), $countries['attribute']) !!}
                                                <small class="form-text text-muted text-danger err_msg" id="err_country_id"></small>
                                                {!! APFrmErrHelp::showErrors($errors, 'country_id') !!} 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                       <div class="">
                                            <label for="" class="form-label fw-bolder">Employment Status</label>
                                        </div>
                                        <div class="row align-items-center">    
                                            <div class="form-check-inline col-md-4">
                                                {{ Form::radio('employment_status', 'fresher' , true, array('class'=>'form-check-input employment_status', 'id'=>'Fresher')) }}
                                                {{-- <input class="form-check-input employment_status" type="radio" name="employment_status" id="Fresher" value="fresher" @if($user->employment_status=='fresher') checked @endif> --}}
                                                <label class="form-check-label" for="Fresher">Fresher</label>
                                            </div>
                                            <div class="form-check-inline col-md-4">
                                                {{ Form::radio('employment_status', 'experienced' , false, array('class'=>'form-check-input employment_status', 'id'=>'Experienced')) }}
                                                {{-- <input class="form-check-input employment_status" type="radio" name="employment_status" id="Experienced" value="experienced" @if($user->employment_status=='experienced') checked @endif> --}}
                                                <label class="form-check-label" for="Experienced">Experienced</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-4 total_experience" style="display:none;"> 
                                        <label for="total_experience" class="form-label fw-bolder">Total Experience</label>
                                        {!! Form::number('total_experience', null, array('class'=>'form-control','min'=>'0', 'max'=>'40','oninput'=>'validity.valid||this.reportValidity()', 'id'=>'total_experience')) !!}
                                        <small class="form-text text-muted text-danger err_msg" id="err_total_experience"></small>
                                        {!! APFrmErrHelp::showErrors($errors, 'total_experience') !!}
                                    </div>
                                    <div class="col-md-12 mb-4">                                      
										<div class="row">												
											<div class="col-md-3">
												<label for="" class="form-label fw-bolder">Currency</label>
												{!! Form::select('salary_currency', ['₹'=>'₹'], null, array('class'=>'form-select', 'id'=>'salary_currency')) !!}
												<small class="form-text text-muted text-danger err_msg" id="err_salary_currency"></small>
												{!! APFrmErrHelp::showErrors($errors, 'salary_currency') !!}
											</div>
											<div class="col-md-4">
												<label for="" class="form-label fw-bolder">Current Salary (PA)</label>
												{!! Form::text('current_salary', null, array('class'=>'form-control', 'id'=>'current_salary', 'data-type'=>'currency', 'minlength'=>'0', 'maxlength'=>'10', 'placeholder'=>__('Current Salary'))) !!}
												<small class="form-text text-muted text-danger err_msg" id="err_current_salary"></small>
												{!! APFrmErrHelp::showErrors($errors, 'current_salary') !!}
											</div>																
											<div class="col-md-4">
												<label for="" class="form-label fw-bolder">Expected Salary (PA)</label>
												{!! Form::text('expected_salary', null, array('class'=>'form-control', 'data-type'=>'currency', 'id'=>'expected_salary', 'minlength'=>'0', 'maxlength'=>'10', 'placeholder'=>__('Expected Salary'))) !!}
												<small class="form-text text-muted text-danger err_msg" id="err_expected_salary"></small>
												{!! APFrmErrHelp::showErrors($errors, 'expected_salary') !!}
											</div>
										</div>
                                    </div>
                    
                                    <div class="col-md-6 mb-4">
                                        <label for="notice_period" class="form-label fw-bolder">Availablility to join (Optional)</label>
                                        {!! Form::select('notice_period', []+$noticePeriod, null, array('class'=>'form-select notice_period', 'placeholder'=>'Select', 'id'=>'notice_period')) !!}                    
                                        <small class="form-text text-muted text-danger err_msg" id="err_notice_period"></small>
                                        {!! APFrmErrHelp::showErrors($errors, 'notice_period') !!}                             
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-around mb-3">

                                <div class="text-center mt-2">
                                    <button class="btn btn-submit bg-green-color" id="basic-info-submit-button" type="button">Save</button>
                                </div>
                            </div>
				
                        {!! Form::close() !!}

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
@push('scripts')
<script type="text/javascript">
var baseurl = '{{ url("/") }}/';

var current_salary = '{{ old("current_salary")??$user->current_salary??"" }}';
var expected_salary = '{{ old("expected_salary")??$user->expected_salary??"" }}';
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/dashboard/uprof!$6ew2.js') }}"></script>
@endpush