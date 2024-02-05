@extends('layouts.pages.common_app')
@section('custom_scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{asset('css/candidate_wzrd.css')}}" rel="stylesheet">

<!--icons fa -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@endsection

@section('content')

<section id="cndidate_wzrd">
    <div class="container">
        <div class="row">
            <div class="col-md-3 align-self-center text-center cndte_mbile">
                <img draggable="false" src="{{asset('images/candidate_left.png')}}" alt="">
            </div>
            <div class="col-md-6 card-size">
                <div class="card">
                    <!-- <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width:50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> -->
                    <div class="site2_logo mb-2 mt-3 text-center">
                        <a href="{{url('/')}}" class="href">
                            <img draggable="false" src="{{asset('images/footer_logo.png')}}" alt="logo">
                        </a>
                    </div>
                    <h1 class="fw-bolder text-center lvledticn mt-2 mb-4">
                        <div class="mb-3">Upload Resume</div>
                        <p class="text-center">Upload your resume and start your Job search...</p>
                    </h1>

                    {!! Form::open(array('method' => 'post', 'route' => array('resume.update'),  'enctype'=>"multipart/form-data", 'onSubmit' => 'return validateFile()')) !!}
                        <div class="container">
                            <div class="loadflebrd">
                                <div class="box text-center">
                                    <img draggable="false" src="{{asset('images/upload_img.png')}}" width="35%" class="p-1 file_upld file_upload"> 
                                    <div  class="cursor-pointer file_upld">Drop your Resume here or Browse
                                    </div>  
                                    <div class="grayc">Supported files - Doc, Docx, PDF, RTF <br>(2MB limited)</div>
                                    <input type="file" class="d-none" id="file" name="file" accept=".doc,.docx,.pdf,.rtf">
                                </div>   
                            </div>
                            <div class="text-center">
                                <span class="help-block form-text text-danger err_msg file-error"></span>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row mb-4 mt-5">
                                <div class="col-md-6 col-5">
                                    <a href="{{ route('skills')}}" class="btn p-0"><img draggable="false" src="{{asset('images/lefticon.png')}}"> Previous</a>
                                </div>
                                <div class="col-md-6 col-7 text-end">
                                    <button class="btn p-0" type="submit">Save & Continue  <img draggable="false" src="{{asset('images/righticon.png')}}"></button>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="col-md-3 align-self-center text-center cndte_mbile">
                <img draggable="false" src="{{asset('images/candidate_right.png')}}" alt="">
            </div>
        </div>
    </div>
</section>
@endsection
@section('custom_bottom_scripts')
<script>
var baseurl = '{{ url("/") }}';
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/formwizard/usiup@4h6i1.js') }}"></script>
@endsection