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


<style>
    .levtstge_fre{
        background:url('{{asset('images/fresher_inactive.png')}}');
        background-size: cover;
    background-position: center;
    }

    .levtstge_fre:hover{
        background:url('{{asset('images/fresher_active.png')}}');
        background-size: cover;
        background-position: center;
    }

    .levtstge_fre:focus {
        background:url('{{asset('images/fresher_active.png')}}');
        background-size: cover;
        background-position: center;

    }
</style>

@section('content')

<section id="cndidate_wzrd">
    <div class="container">
        <div class="row">
            <div class="col-md-3 align-self-center text-center cndte_mbile">
                <img src="{{asset('images/candidate_left.png')}}" alt="">
            </div>
            <div class="col-md-6">
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
                        <div><img src="{{asset('images/skills.png')}}">&nbsp;Skills</div>
                    </h1>

                    <div class="container">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Your Skills</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <small id="emailHelp" class="form-text"></small>
                        </div>   

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label mb-3">Suggestion skills</label>
                            <div>
                            <span class="skls_cdte">
                                <span class="tag-text">Day shift</span>
                                <button type="button" class="tag-plus"><i class="fa fa-plus"></i></button>
                            </span>
                            </div>
                            
                        </div>   
                    </div>

                    <div class="row mb-4 mt-5">
                        <div class="col-md-6">
                            <span><img src="{{asset('images/lefticon.png')}}"> Previous</span>
                        </div>
                        <div class="col-md-6 text-end">
                            <span>Save & Continue  <img src="{{asset('images/righticon.png')}}"></span>
                        </div>
                    </div>
                    <div class="progress mt-3">
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 95%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
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