@extends('layouts.app')
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
                    <!-- <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width:50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> -->
                    <div class="site2_logo mb-4 mt-3 text-center">
                        <a href="{{url('/')}}" class="href">
                            <img src="{{asset('images/footer_logo.png')}}" alt="logo">
                        </a>
                    </div>

                    <h1 class="fw-bolder text-center lvledticn mt-3 mb-4">
                        <div><img src="{{asset('images/candidate_exp.png')}}">&nbsp;Experience</div>
                    </h1>

                    <h1 class="fw-bolder text-center">
                        I am
                    </h1>
                    {!! Form::open(array('method' => 'post', 'route' => array('experience-save'), 'class' => 'form')) !!}
                 
                    <div class="container">

                        <div class="row text-center">
                            <div class="col-md-6 col-6">
                                <input class="employment_status" type="radio" id="fresher" name="employment_status" style="display:none" value="fresher" @if($user->employment_status=='fresher' || $user->employment_status==null) checked @endif>
                                <label for="fresher">
                                    <div class="levtstge_fre">
                                    </div>
                                <div class="text-center fresher-text mt-3">A Fresher</div>

                                </label>
                               
                            </div>
                            <div class="col-md-6 col-6">
                                <input class="employment_status" type="radio" id="experienced" name="employment_status" style="display:none" value="experienced" @if($user->employment_status=='experienced') checked @endif>
                                <label for="experienced">
                                    <div class="levtstge_exp">
                                    </div>
                                <div class="text-center experience-text mt-3">Experienced</div>

                                </label>
                            </div>
                        </div>

                        <div class="row mb-4 mt-5">
                            <div class="col-md-5 col-5">
                                <a href="{{ route('education') }}" class="btn p-0"><img src="{{asset('images/lefticon.png')}}"> Previous</a >
                            </div>
                            <div class="col-md-7 col-7 text-end">
                                <button type="submit" class="btn p-0">Save & Continue  <img src="{{asset('images/righticon.png')}}"></button>
                            </div>
                        </div>
                    </div> 
                     {!! Form::close() !!}
                     <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
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
var baseurl = '{{ url("/") }}';
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/formwizard/usiup@4h6i1.js') }}"></script>
@endpush
