@extends('layouts.app')
@section('custom_scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ asset('site_assets_1/assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/userbasic.w2fr4ha2.css')}}" rel="stylesheet">
<!--icons fa -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                        <h2 class="fw-bolder"><img src="{{asset('images/candidate_educ.png')}}">&nbsp;Career Information</h2>
                    </div>
                    @php
                        $noticePeriod = app\Helpers\DataArrayHelper::langNoticePeriodsArray();
                        $user = Auth::user();
                        $countries = app\Helpers\DataArrayHelper::CountriesArray();
                        $country_id = (!empty($user->country_id))?$user->country_id:$ip_data->country_id;
                        $country = (!empty($user->country_id))?$user->getCountry('country'):$ip_data->geoplugin_countryName;
                    @endphp
                    <div class="card mt-5">
                        
                    {!! Form::open(array('method' => 'put', 'route' => array('my_profile_save'), 'class' => 'form', 'onSubmit' => 'return validateCareerInfoForm()')) !!}
                    <div class="container">
                        <div class="mb-3">
                            <label for="career_title" class="form-label">Your Current / Last designation</label>
							{!! Form::text('career_title', $user->career_title??null, array('class'=>'form-control required', 'id'=>'career_title', 'placeholder'=>__('ex:auditor, doctor'))) !!}
                            <small class="form-text text-muted text-danger err_msg" id="err_career_title"></small>
                        </div>
                        @php
                            $exp = explode('.',$user->total_experience);
                            $exp_in_year = $exp[0]??'';
                            $exp_in_month = $exp[1]??'';
                        @endphp
                        <label for="exampleInputEmail1" class="form-label">Total years of experience</label>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                {!! Form::select('exp_in_year', MiscHelper::getNumExpYears(), $exp_in_year, array('class'=>'form-select required', 'id'=>'exp_in_year')) !!}
                            </div>

                            <div class="col-md-6">
                                {!! Form::select('exp_in_month', MiscHelper::getNumExpMonths(), $exp_in_month, array('class'=>'form-select required', 'id'=>'exp_in_month')) !!}
                            </div>
                            <small class="form-text text-muted text-danger err_msg" id="err_total_exp"></small>
                        </div>

                        <label for="expected_salary" class="form-label">Expected salary</label>
                        <div class="input-group mb-3 slct_apnd">
                            {!! Form::select('salary_currency', ['₹'=>'₹'], $user->salary_currency, array('class'=>'form-select','id'=>'salary_currency')) !!}
                            {!! Form::text('expected_salary', null, array('class'=>'form-control required', 'data-type'=>'currency', 'id'=>'expected_salary', 'minlength'=>'0', 'maxlength'=>'10', 'placeholder'=>__('Expected Salary'))) !!}
                            <span class="input-group-text">annam</span>
                        </div>
                        <small class="form-text text-muted text-danger err_msg" id="err_expected_salary"></small>
                        
                        <div class="mb-3">
                            <label class="form-label">Jobs location looking for <span class="country_text">- {{ $country }} <a href="javascript:void(0);" onClick="CountryChange()">Change</a></span></label>
                            <div class="country_change"  style="display:none;">
                                <label for="div_country_id" class="form-label">Country </label>  
                                <div>                              
                                    {!! Form::select('country_id', $countries['value'], $country_id, array('class'=>'form-select required', 'id'=>'country_id'), $countries['attribute']) !!}
                                    <small class="form-text text-muted text-danger err_msg" id="err_country_id"></small>
                                    {!! APFrmErrHelp::showErrors($errors, 'country_id') !!} 
                                </div>
                            </div>
                         </div>
                        <div class="mb-3">
                            <label for="" class="form-label">City</label>
                            {!! Form::text('location', $user->location??null, array('class'=>'form-control-2 required typeahead', 'id'=>'location', 'placeholder'=>__('Enter your location'),' aria-label'=>'Enter your location')) !!}
                            <small class="form-text text-muted text-danger err_msg" id="err_location"></small>
                        </div>
                        
                        <div class="d-flex justify-content-around mb-3">

                            <div class="text-center mt-2">
                                <button class="btn btn-submit bg-green-color" id="basic-info-submit-button" type="submit">Save</button>
                            </div>
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
<script>
 var expected_salary = "{{$user->expected_salary??''}}"
</script>
<script  type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/typehead/typeahead.bundle.js') }}"></script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/formwizard/usiup@4h6i1.js') }}"></script>
@endpush