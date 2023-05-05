@extends('layouts.app')
@section('custom_scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ asset('site_assets_1/assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/userbasic.w2fr4ha2.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/careeinfo.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/intl-tel-input/css/intlTelInput.css')}}" rel="stylesheet">
<script src="{{ asset('site_assets_1/assets/intl-tel-input/js/intlTelInput.js')}}" ></script>
<!--icons fa -->
<!--icons fa -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
@section('content')
<div class="wrapper" >
	@include('layouts.header')
	@include('layouts.side_navbar')

    @if(Session::has('message'))
        <script>toastr.success("{{ Session('message') }}");</script>
    @endif
	<div class="main-panel main-panel-custom">
		<div class="content">
			<div class="page-inner">
                <div id="abt_meusr" class="mt-4">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img src="{{asset('images/career_info.png')}}">&nbsp;Career Information</h2>
                    </div>
                    @php
                        $noticePeriod = app\Helpers\DataArrayHelper::langNoticePeriodsArray();
                        $user = Auth::user();
                        $countries = app\Helpers\DataArrayHelper::CountriesArray();
                        $country_id = (!empty($user->country_id))?$user->country_id:$ip_data['country_id'];
                        $country = \App\Model\Country::where('country_id',$country_id)->pluck('country')->first();
                    @endphp
                    <div class="card mt-5">                        
                        {!! Form::open(array('method' => 'put', 'route' => array('career_info_save'), 'class' => 'form', 'onSubmit' => 'return validateCareerInfoForm()')) !!}
                        <div class="container">
                            <div class="mb-3 career_title">
                                <label for="career_title" class="form-label">@if($user->employment_status=='fresher') Jobs looking for @else Your designation @endif</label>
                                {!! Form::text('career_title', $user->career_title??null, array('class'=>'form-control required typeahead', 'id'=>'career_title', 'placeholder'=>__('ex:auditor, doctor'))) !!}
                                <small class="form-text text-muted text-danger err_msg" id="err_career_title"></small>
                            </div>
                            @php
                                $exp = explode('.',$user->total_experience);
                                $exp_in_year = $exp[0]??'';
                                $exp_in_month = $exp[1]??'';
                            @endphp
                            <label for="exampleInputEmail1" class="form-label">Total years of experience</label>
                            <div class="row mb-4">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                    {!! Form::select('exp_in_year', MiscHelper::getNumExpYears(), $exp_in_year, array('class'=>'form-select required', 'id'=>'exp_in_year')) !!}
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                    {!! Form::select('exp_in_month', MiscHelper::getNumExpMonths(), $exp_in_month, array('class'=>'form-select required', 'id'=>'exp_in_month')) !!}
                                </div>
                                <small class="form-text text-muted text-danger err_msg" id="err_total_exp"></small>
                            </div>
                            <div class="row mb-4">
                                <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                                    <label for="expected_salary" class="form-label">Expected salary</label>
                                    <div class="input-group mb-3 slct_apnd">
                                        {!! Form::select('salary_currency', ['₹'=>'₹'], $user->salary_currency, array('class'=>'form-select','id'=>'salary_currency')) !!}
                                        {!! Form::text('expected_salary', null, array('class'=>'form-control required', 'data-type'=>'currency', 'id'=>'expected_salary', 'minlength'=>'0', 'maxlength'=>'10', 'placeholder'=>__('Expected Salary'))) !!}
                                        <span class="input-group-text"> / annam</span>
                                    </div>
                                    <small class="form-text text-muted text-danger err_msg" id="err_expected_salary"></small>
                                </div>
                            </div>
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
                            <div class="mb-3 city">
                                <label for="" class="form-label">City</label>
                                {!! Form::text('location', $user->location??null, array('class'=>'form-control-2 required typeahead', 'id'=>'location', 'placeholder'=>__('Enter your location'),' aria-label'=>'Enter your location')) !!}
                                <small class="form-text text-muted text-danger err_msg" id="err_location"></small>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Contact Number</label>
                                {!! Form::hidden('full_number', null, array('id'=>'full_number')) !!}
                                {!! Form::tel('phone', $user->phone??null, array('class'=>'form-control mob_cp validMob', 'id'=>'phone', 'onkeypress'=> 'return isNumber(event)', 'minlength'=>'9', 'maxlength'=>'14', 'placeholder'=>__('Phone'))) !!}
                                <small class="form-text text-muted text-danger err_msg" id="err_phone"></small> 
                                {!! APFrmErrHelp::showErrors($errors, 'phone') !!}
                            </div>
                            <div class="form-check mb-2 is_watsapp_number">
                                {!! Form::checkbox('is_watsapp_number', 'yes', $user->is_watsapp_number??'', array('class'=>'form-check-input', 'id'=>'is_watsapp_number')) !!}
                                <label class="form-check-label" for="is_watsapp_number">Is this watsapp number.</label>
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
<script type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/select2/select2.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" integrity="sha512-HWlJyU4ut5HkEj0QsK/IxBCY55n5ZpskyjVlAoV9Z7XQwwkqXoYdCIC93/htL3Gu5H3R4an/S0h2NXfbZk3g7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('#country_id').select2();
 var baseurl = "{{ url('/') }}";
 var expected_salary = "{{$user->expected_salary??''}}";
 var employment_status = "{{$user->employment_status??''}}";
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/formwizard/usiup@4h6i1.js') }}"></script>
@endpush