@extends('layouts.app')
@section('custom_scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{asset('css/candidate_wzrd.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/userbasic.w2fr4ha2.css')}}" rel="stylesheet">
<!--icons fa -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('content')

@php
    $country_id = (!empty($user->country_id))?$user->country_id:$ip_data->country_id;
    $country = \App\Model\Country::where('country_id',$country_id)->pluck('country')->first();
    dd($country);
@endphp
<section id="cndidate_wzrd">
    <div class="container">
        <div class="row">
            <div class="col-md-3 align-self-center text-center cndte_mbile">
                <img src="{{asset('images/candidate_left.png')}}" alt="">
            </div>
            <div class="col-md-6 card-size">
            <div class="scroll-page">
                <div class="card">
                    <!-- <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width:50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> -->
                        <div class="site2_logo mb-4 mt-3 text-center">
                            <a href="{{url('/')}}" class="href">
                                <img src="{{asset('images/footer_logo.png')}}" alt="logo">
                            </a>
                        </div>

                        <h1 class="fw-bolder text-center lvledticn mt-3 mb-4">
                            <div><img src="{{asset('images/career_info.png')}}">&nbsp;Career Info</div>
                        </h1>
                        {!! Form::open(array('method' => 'post', 'route' => array('career-info-save'), 'class' => 'form', 'onSubmit' => 'return validateCareerInfoForm()')) !!}
                        <div class="container">
                            <div class="mb-3">
                                <label for="career_title" class="form-label">@if($user->employment_status=='fresher') Jobs looking for @else Your designation @endif</label>
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
                            <div class="mb-3">
                                <label for="" class="form-label">City</label>
                                {!! Form::text('location', $user->location??null, array('class'=>'form-control-2 required typeahead', 'id'=>'location', 'placeholder'=>__('Enter your location'),' aria-label'=>'Enter your location')) !!}
                                <small class="form-text text-muted text-danger err_msg" id="err_location"></small>
                            </div>
                            

                            <div class="row mb-4 mt-5">
                                <div class="col-md-6 col-6">
                                    <a href="{{ route('experience')}}" class="btn"><img src="{{asset('images/lefticon.png')}}"> Previous</a>
                                </div>
                                <div class="col-md-6 col-6 text-end">
                                    <button class="btn" type="submit">Save & Continue  <img src="{{asset('images/righticon.png')}}"></button>
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
                <img src="{{asset('images/candidate_right.png')}}" alt="">
            </div>
        </div>
    </div>
</section>

@endsection
@push('scripts')
<script>
 var expected_salary = "{{$user->expected_salary??''}}";
 var employment_status = "{{$user->employment_status??''}}";
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/typehead/typeahead.bundle.js') }}"></script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/formwizard/usiup@4h6i1.js') }}"></script>
@endpush