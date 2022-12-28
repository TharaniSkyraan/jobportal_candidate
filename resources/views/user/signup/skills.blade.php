@extends('layouts.app')
@section('custom_scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{asset('css/candidate_wzrd.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/css/input_tag/tagify.css')}}" rel="stylesheet">

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

                    @php 
                        $user_skills = old('skills')? explode(',', old('skills')) : $user->skill;
                    @endphp     
                    {!! Form::open(array('method' => 'post', 'route' => array('skills-save'), 'class' => 'form', 'onSubmit' => 'return validateSkillForm()')) !!}
                    <div class="container">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Your Skills</label>
                            {!! Form::text('skills', $user_skills, array('class'=>'form-control', 'id'=>'skills', 'placeholder'=>__('Select Skills'))) !!}
                            <small class="form-text text-muted text-danger err_msg" id="err_skills"></small>  
                        </div>   

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label mb-3">Suggestion skills</label>
                            <div class="mb-3">
                            @foreach ($skills as $key => $skill)                                
                                <label class="skls_cdte">
                                    <label class="tag-text add-sug">{{$skill}} <button type="button" class="tag-plus" data-sid="{{$key}}" data-sval="{{$skill}}"><i class="fa fa-plus"></i></button></label>
                                </label>
                            @endforeach
                            </div>   

                        </div>   
                        <div class="row mb-4 mt-5">
                            <div class="col-md-6">
                                <a href="{{ route('career-info') }}" class="btn"><img src="{{asset('images/lefticon.png')}}"> Previous</a>
                            </div>
                            <div class="col-md-6 text-end">
                                <button class="btn" type="submit">Save & Continue  <img src="{{asset('images/righticon.png')}}"></button>
                            </div>
                        </div>
                    </div>
                    
                    {!! Form::close() !!}
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 90%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
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
@section('custom_bottom_scripts')
<script type="text/javascript">
var baseurl = '{{ url("/") }}';
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/js/input_tag/jQuery.tagify.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/formwizard/usiup@4h6i1.js') }}"></script>
@endsection