@extends('layouts.app')
@section('custom_scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{asset('css/candidate_wzrd.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/userbasic.w2fr4ha2.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/intl-tel-input/css/intlTelInput.css')}}" rel="stylesheet">
<script src="{{ asset('site_assets_1/assets/intl-tel-input/js/intlTelInput.js')}}" ></script>
<!--icons fa -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('content')
<style>
    .iti__flag { display: none; }
    .iti--separate-dial-code input[type=tel] {
        padding-left: 70px !important;
    }
    .mob_cp
    {
        padding-left: 85px;
        padding-right: 33px
    }
    li {
        /* font-family: 'Nunito', sans-serif !important; */
        
	font-family: "Poppins";
    }
    .city .typeahead.dropdown-menu, .career_title .typeahead.dropdown-menu{
        max-height: 188px !important;
        overflow: auto;
        display: block;         
        width: -webkit-fill-available;
        top: unset !important;
        left: unset !important;
        margin-right: 25px;

    }
    /* Extra Small Devices (Phones) */
@media only screen and (max-width: 353px) {
  /* CSS rules for phones */
    .city .typeahead.dropdown-menu, .career_title .typeahead.dropdown-menu{
        margin-right: 24px;
    }
}

    /* Extra Small Devices (Phones) */
@media (min-width: 354px) and (max-width: 480px) {
  /* CSS rules for phones */
    .city .typeahead.dropdown-menu, .career_title .typeahead.dropdown-menu{
        margin-right: 24px;
    }
}

/* Small Devices (Tablets) */
@media (min-width: 481px) and (max-width: 768px) {
  /* CSS rules for tablets */
    .city .typeahead.dropdown-menu, .career_title .typeahead.dropdown-menu{
        margin-right: 33px;
    }
}

/* Medium Devices (Desktops) */
@media (min-width: 769px) and (max-width: 992px) {
  /* CSS rules for desktops */
    .city .typeahead.dropdown-menu, .career_title .typeahead.dropdown-menu{
        margin-right: 33px;
    }
}

/* Large Devices (Large Screens) */
@media (min-width: 993px) and (max-width: 1300px) {
  /* CSS rules for large screens */
    .city .typeahead.dropdown-menu, .career_title .typeahead.dropdown-menu{
        margin-right: 33px;
    }
}
/* Large Devices (Large Screens) */
@media (min-width: 1301px) and (max-width: 1330px) {
  /* CSS rules for large screens */
    .city .typeahead.dropdown-menu, .career_title .typeahead.dropdown-menu{
        margin-right: 24px;
    }
}

</style>
@php
    $noticePeriod = \App\Helpers\DataArrayHelper::langNoticePeriodsArray();
    $country_id = (!empty($user->country_id))?$user->country_id:$ip_data['country_id'];
    $country = \App\Model\Country::where('country_id',$country_id)->pluck('country')->first();
@endphp
<section id="cndidate_wzrd">
    <div class="container">
        <div class="row">
            <div class="col-md-3 align-self-center text-center cndte_mbile">
                <img draggable="false" src="{{asset('images/candidate_left.png')}}" alt="">
            </div>
            <div class="col-md-6 card-size">
            <div class="scroll-page">
                <div class="card">
                    <!-- <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width:50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> -->
                        <div class="site2_logo mb-2 mt-3 text-center">
                            <a href="{{url('/')}}" class="href">
                                <img draggable="false" src="{{asset('images/footer_logo.png')}}" alt="logo">
                            </a>
                        </div>

                        <h1 class="fw-bolder text-center lvledticn mt-3 mb-4">
                            <div><img draggable="false" src="{{asset('images/career_info.png')}}">&nbsp;Career Info</div>
                        </h1>
                        {!! Form::open(array('method' => 'post', 'route' => array('career-info-save'),  'onSubmit' => 'return validateCareerInfoForm()')) !!}
                        <div class="scroll-height1">
                            <div class="container">
                                <div class="mb-3 career_title">
                                    <label for="career_title" class="form-label">@if($user->employment_status=='fresher') Jobs looking for @else Your designation @endif</label>
                                    {!! Form::text('career_title', $user->career_title??null, array('class'=>'form-control required typeahead', 'id'=>'career_title', 'placeholder'=>__('ex:auditor, doctor'), 'autocomplete'=>'off')) !!}
                                    <small class="form-text text-muted text-danger err_msg" id="err_career_title"></small>
                                </div>
                                @php
                                    $exp = explode('.',$user->total_experience);
                                    $exp_in_year = $exp[0]??'';
                                    $exp_in_month = $exp[1]??'';
                                @endphp
                                @if($user->employment_status=='experienced')
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
                                @endif

                                <label for="expected_salary" class="form-label">Expected salary</label>
                                <div class="input-group mb-3 slct_apnd">
                                    {!! Form::select('salary_currency', ['₹'=>'₹'], $user->salary_currency, array('id'=>'salary_currency')) !!}
                                    {!! Form::text('expected_salary', null, array('class'=>'form-control required', 'data-type'=>'currency', 'id'=>'expected_salary', 'minlength'=>'0', 'maxlength'=>'10', 'placeholder'=>__('Expected Salary'))) !!}
                                    <span class="input-group-text">/ annam</span>
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
                                <div class="mb-3 city">
                                    <label for="" class="form-label">City</label>
                                    {!! Form::text('location', $user->location??null, array('class'=>'form-control required typeahead', 'id'=>'location', 'placeholder'=>__('Enter your location'), 'aria-label'=>'Enter your location', 'autocomplete'=>'off')) !!}
                                    <small class="form-text text-muted text-danger err_msg" id="err_location"></small>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Contact Number</label>
                                    {!! Form::hidden('full_number', null, array('id'=>'full_number')) !!}
                                    {!! Form::tel('phone', $user->phone??null, array('class'=>'form-control mob_cp validMob', 'id'=>'phone', 'onkeypress'=> 'return isNumber(event)', 'minlength'=>'9', 'maxlength'=>'14', 'placeholder'=>__('Phone'))) !!}
                                    <small class="form-text text-muted text-danger err_msg" id="err_phone"></small> 
                                    {!! APFrmErrHelp::showErrors($errors, 'phone') !!}
                                </div>
                                <!-- <div class="form-check mb-2 is_watsapp_number">
                                    {!! Form::checkbox('is_watsapp_number', 'yes', $user->is_watsapp_number??'', array('class'=>'form-check-input', 'id'=>'is_watsapp_number')) !!}
                                    <label class="form-check-label" for="is_watsapp_number">Is this watsapp number.</label>
                                </div> -->
                                @if($user->employment_status=='experienced')
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Notice Period</label>
                                            {!! Form::select('notice_period', [''=>'Select']+$noticePeriod, $user->notice_period, array('class'=>'form-select required', 'id'=>'notice_period')) !!}
                                            <small class="form-text text-muted text-danger err_msg" id="err_notice_period"></small>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="container">
                            <div class="row mb-4 mt-3">
                                <div class="col-md-6 col-5">
                                    <a href="{{ route('experience')}}" class="btn p-0"><img draggable="false" src="{{asset('images/lefticon.png')}}"> Previous</a>
                                </div>
                                <div class="col-md-6 col-7 text-end">
                                    <button class="btn p-0" type="submit">Save & Continue  <img draggable="false" src="{{asset('images/righticon.png')}}"></button>
                                </div>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 80%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-3 align-self-center text-center cndte_mbile">
                <img draggable="false" src="{{asset('images/candidate_right.png')}}" alt="">
            </div>
        </div>
    </div>
</section>

@endsection
@push('scripts')
<script>
var baseurl = '{{ url("/") }}';
 var expected_salary = "{{$user->expected_salary??''}}";
 var employment_status = "{{$user->employment_status??''}}";
 var setcountry = '{{$user->phone}}';
 $('select#exp_in_year option:first, select#exp_in_month option:first, select#notice_period option:first').attr('disabled', true);
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" integrity="sha512-HWlJyU4ut5HkEj0QsK/IxBCY55n5ZpskyjVlAoV9Z7XQwwkqXoYdCIC93/htL3Gu5H3R4an/S0h2NXfbZk3g7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/formwizard/usiup@4h6i1.js') }}"></script>
@endpush