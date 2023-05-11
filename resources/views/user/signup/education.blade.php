@extends('layouts.app')
<style>
ul.typeahead.dropdown-menu {
    max-height: 188px !important;
    overflow: auto;
    display: block;
    margin-right: 25px;
    width: -webkit-fill-available;
}
li {
    font-family: 'Nunito', sans-serif !important;
}
</style>
@section('custom_scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{asset('css/candidate_wzrd.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
<!--icons fa -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@endsection

@section('content')

<section id="cndidate_wzrd">
    <div class="container">
        <div class="row">
            <div class="col-md-3 align-self-center text-center cndte_mbile">
                <img src="{{asset('images/candidate_left.png')}}" alt="">
            </div>
            <div class="col-md-6 card-size">
                <div class="card lgncard1">
                    <div class="site2_logo mb-4 mt-3 text-center">
                        <a href="{{url('/')}}" class="href">
                            <img src="{{asset('images/footer_logo.png')}}" alt="logo">
                        </a>
                    </div>

                    
                    <h1 class="fw-bolder text-center lvledticn mt-3 mb-4">
                        <div><img src="{{asset('images/candidate_educ.png')}}">&nbsp;Education</div>
                    </h1>
                    {!! Form::open(array('method' => 'post', 'route' => array('education-save'), 'class' => 'form', 'onSubmit' => 'return validateAccountForm()')) !!}
                        {!! Form::hidden('id', $education->id??null) !!}
                        <div class="container">
                            <div class="mb-4">
                                <label for="exampleInputEmail1" class="form-label grytxtv">Highest level of Qualification</label>
                                {!! Form::select('education_level_id', [''=>__('Select Education')]+$educationLevels, $education->education_level_id??null, array('class'=>'form-select required', 'id'=>'education_level_id')) !!}
                                <small class="help-block form-text text-muted text-danger err_msg education_level_id-error" id="err_education_level_id"></small> 
                            </div>

                            <div class="mb-4 education_type_div" @if(empty($education->education_type)) style="display:none;" @endif>
                                <label for="exampleInputEmail1" class="form-label grytxtv">Education</label>
                                {!! Form::text('education_type', $education->education_type??null, array('class'=>'form-control required typeahead', 'id'=>'education_type', 'placeholder'=>__('Select education type'),'autocomplete'=>'off')) !!}
                                <small class="form-text text-muted text-danger err_msg" id="err_education_type"></small>
                                <small class="help-block form-text text-muted text-danger err_msg education_type-error" id="err_education_type"></small> 
                            </div>

                            <div class="mb-5 text-end">
                                <button class="btn p-0" type="submit">Save & Continue <img src="{{asset('images/righticon.png')}}"></button>
                            </div>
                        </div>
                     {!! Form::close() !!}
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
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
<script type="text/javascript">
var baseurl = '{{ url("/") }}';
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" integrity="sha512-HWlJyU4ut5HkEj0QsK/IxBCY55n5ZpskyjVlAoV9Z7XQwwkqXoYdCIC93/htL3Gu5H3R4an/S0h2NXfbZk3g7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/formwizard/usiup@4h6i1.js') }}"></script>
@endpush