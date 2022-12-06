@extends('layouts.app')
@section('custom_scripts')
<link href="{{ asset('site_assets_1/assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('site_assets_1/assets/date_flatpicker/flatpickr.min.css')}}">
<script src="{{ asset('site_assets_1/assets/date_flatpicker/flatpickr.js')}}"></script>
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/userbasic.w2fr4ha2.css')}}" rel="stylesheet">
<script  type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/typehead/typeahead.bundle.js') }}"></script>
<link href="{{asset('css/candidate_wzrd.css')}}" rel="stylesheet">

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
            <div class="col-md-6">
                <div class="card lgncard1">
                    <div class="site2_logo mb-4 mt-3 text-center">
                        <a href="{{url('/')}}" class="href">
                            <img src="{{asset('images/footer_logo.png')}}" alt="logo">
                        </a>
                    </div>

                        
                        <h1 class="fw-bolder text-center lvledticn mt-3 mb-4">
                           <div><img src="{{asset('images/candidate_educ.png')}}">&nbsp;Education</div>
                        </h1>


                    <div class="container">
                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label grytxtv">Highest level of Qualification</label>
                            <select class="form-select" aria-label="Default select example">
                                <option selected>UG(Under Graduate)</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label grytxtv">Name of Degree</label>
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Bachelor of Engineering</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>


                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label grytxtv">Major Subject</label>
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Computer Science</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>

                        <div class="mb-5 text-end">
                            <span>Save & Continue <img src="{{asset('images/righticon.png')}}"></span>
                        </div>
                    </div>
                     <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
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