@extends('layouts.app')

@section('content')

<div class="wrapper" >
    <style>
        .image-size{
            width: 17px;
            /* vertical-align: text-top; */
            margin-top: -2px;
        }
        .imagesz-2{
            width: 19px;
            vertical-align: text-bottom;
        }
        .japply-btn{
            border-color: #c8e8ef;
            background-color: #d5f4fb !important;
            padding: 0.46rem 0.85rem!important;
            font-size: 1rem;
        }
        .japply-btn:hover{
            opacity: 1;
            transition: none;
            border-color: #8ad6e7;
        }
        .japplied-btn {
            border-color: #c8e8ef;
            padding: 0.36rem 0.65rem!important;
        }
        .jdcarc{
            box-shadow: 0 2px 6px -2px rgb(0 106 194 / 20%);
            padding: 1.25rem 1.25rem .65rem  1.25rem !important
        }
        .abt-cmp{
            box-shadow: 0px 1px 6px -2px rgb(0 106 194 / 20%), 1px -1px 6px -2px rgb(0 106 194 / 20%);
        }
        .rjarti{
            border-bottom: 1px solid #eee;
        padding: 10px 0;
        }
        .jdcarc p{
            font-size: 14px;
            margin-bottom: 0.5rem;
        }

        .jdcarc .chip.clickable {
    /* cursor: pointer; */
}
.jdcarc .chip {
    margin-top: 10px;
    display: inline-block;
    margin-right: 10px;
    font-size: 14px!important;
    font-weight: 600;
    color: #333;
    border: 1px solid #4285f47a;
    border-radius: 14px;
    padding: 5px 12px;
    background-color: #48abf726;
}
ul{
    margin-bottom: 0.6rem;
}
.jobdesbcontar{
    font-size: 14px;
}
.jdcarc .cmpinfo-detail>label {
    font-size: 14px;
    font-weight: 400;
    color: #999;
    width: 110px;
    display: inline-block;
    vertical-align: top;
}
.poscls{
    margin: 8px 0 0 0 !important;
    color: #666666;
    font-size: 13px !important;
}

    #received_cnt{
        margin: 0 auto;
        /* box-shadow: 0 3px 10px rgb(0 0 0 / 10%); */
    }
    #received_cnt .main_assementcrd{
        margin-bottom: 0px;
    }
    #cdate_assesment li{
        margin-bottom: 15px;
    }   
    #cdate_assesment .cont_act{
        box-shadow: 0 3px 10px rgb(0 0 0 / 10%);
        padding: 15px 0px 0px 15px !important;
        margin-top: 20px;
        border-radius: 10px;

    }
    #cdate_assesment .profile_card{
        background-color: #F3F7FE !important;

    }

    #cdate_assesment .profile_card .ple_img{
        width: 45%;
        border-radius: 50%;
        padding: 20px;
        line-height: 1.3rem;
        height: 150px;
    }
    #cdate_assesment .profile_card{
        margin: 0 auto;
        border: 1px solid rgb(0 0 0 / 6%);
        border-radius: 10px;
        box-shadow: none;
        background-color: #eafbf1 !important;
    }

    #cdate_assesment::-webkit-scrollbar {
        display: none;
    }

    #cdate_assesment{
        overflow-y: overlay;
        height: 500px;
    }

    #cdate_assesment .profile_card .btnact_st{
        box-shadow: 0px 0px 3px 2px #d7d5d5;
        background-color: #fcfeff;
        padding: 0.5rem;
        background-color: #fff;
        border-radius: 0.25rem;
        max-width: 100%;
    }

    #cdate_assesment hr{
        height: 2px;
        background-color: #C4C4C4;
    }
    #cdate_assesment .fa-book{
        font-size: 30px;
    }
    #cdate_assesment .message_btn{
        width: fit-content;
        margin: 0 auto;
        background-color: #4285F4;
        color: #fff;
        border-radius: 20px;
        border: 1px solid #4285F4;
        padding: 5px 20px 5px 20px;
    }
    #cdate_assesment thead{
        background-color: #eafbf1 !important;
    }
    #cdate_assesment tbody{
        background-color: #fff;
    }
    #cdate_assesment .fa-phone, #cdate_assesment .fa-envelope, #cdate_assesment .fa-linkedin{
        align-items: center;
        width: 30px;
        background-color: #1572e8b5;
        height: 30px;
        justify-content: center;
        display: inline-grid;
        border-radius: 50%;
        border: 2px solid;
        font-size: 12px;
        color:#fff !important;

    }
   
    #cdate_assesment {
        height:300px;
        top: 0;
        bottom: 0;
        position: inherit;        
    }

    #cdate_assesment .table td{
        border-color: transparent !important;
    }
    #assessment .nav-tabs {
        border-bottom: 1px solid #efeffe;
        background-color: #EFF4FE;
        padding: 10px;
        border-bottom: none;
    }
    #assessment #applied-tab{
        margin-right: 120px;
    }
    #assessment .nav-link.active{
        border-bottom: 2px solid #ec584c !important;
        background-color: transparent;
        border-color:transparent;
        font-weight: bolder;
    }

    #assessment .nav-link{
        color: #000;
        border:transparent;
    }
    #cdate_assesment .assessment_card{
        border: 2px solid #4285F4;
        padding: 20px;
        border-radius: 5px;
        background-color: #fff !important;
    }
    #cdate_assesment .fa-info{
        background-color: #4285f4;
        width: 18px;
        align-items: center;
        justify-content: center;
        display: inline-flex;
        color: #fff;
        border-radius: 50%;
        height: 18px;
        font-size: 12px;
    }

    #cdate_assesment .fa-check, #cdate_assesment .fa-close{
        width: 25px;
        align-items: center;
        justify-content: center;
        display: inline-flex;
        color: #fff;
        border-radius: 50%;
        height: 25px;
        font-size: 12px;
    }

    #cdate_assesment .fa-check{
        background: #6CD038;
    }

    #cdate_assesment .fa-close{
        background: #FF5B5B;
    }

    .assessment_modal{
        max-width: 50%;
    }.assessment_modal .modal-content{
        padding: 10px;
        width: fit-content;
        background: #fff;
        height: auto;
    }.assessment_modal img{
        width: 100%;
    }.assessment_modal p{
        color: #808080;
        font-weight: bolder;
        font-size: 16px;
    }#screeningQuiz72ers3 .modal-header{
        background-color: #d5e4fd;
    }#screeningQuiz72ers3 .modal-header h3{
        font-weight: bolder;
    }#screeningQuiz72ers3 .modal-content{
        padding: 0px;
    }#screeningQuiz72ers3 .close{
        border: 0px;
        background: #fff;
        border-radius: 50%;
        width: 28px;
    }.assessment_modal .card{
        box-shadow: none;
    }
    .assessment_modal .next-btn{
        padding: 9px 20px;
    }
</style>
@include('layouts.header')
@include('layouts.side_navbar')

<div class="main-panel main-panel-custom">
    <div class="content">
        <div class="row">
            <div class="col-md-10">
            <div class="px-4 pt-4 pb-0 mt-3 mb-3">
                <div id="jasuccess"></div>
                <div class="card page-inner">
                    <div class="card-body jdcarc">
                        <div class="mb-1">
                            <div class="row">
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <h2 class="fw-bolder text-green-color jt-ellip">{{ ucwords($job->title) }}</h2>
                                    <h4 class="fw-bolder pb-2">{{ ucwords($job->company->name) }}.</h4>
                                </div>
                                <div class="col-md-4 col-sm-8 col-xs-12" style="text-align: -webkit-right;">
                                    <div class="d-flex align-items-center justify-content-end">
                                        @if($application_status==null)
                                        <label class="japplied-btn" id="japplied-btn" ><img class="imagesz-2" src="{{url('site_assets_1/assets/img/Shortlist.png')}}" alt="Applied"> <span class="fw-bolder fs-6">Applied</span></label>
                                        @elseif($application_status=='view' || $application_status=='consider')
                                        <label class="japplied-btn" id="japplied-btn" ><img class="imagesz-2" src="{{url('site_assets_1/assets/img/viewed.png')}}" alt="Viewed"> <span class="fw-bolder fs-6">Viewed</span></label>
                                        @elseif($application_status=='shortlist')
                                        <label class="japplied-btn" id="japplied-btn" ><img class="imagesz-2" src="{{url('site_assets_1/assets/img/Shortlist.png')}}" alt="Shortlist"> <span class="fw-bolder fs-6">Shortlisted</span></label>
                                        @elseif($application_status=='reject')
                                        <label class="japplied-btn" id="japplied-btn" ><img class="imagesz-2" src="{{url('site_assets_1/assets/img/Rejected.png')}}" alt="Rejected"> <span class="fw-bolder fs-6">Rejected</span></label>
                                        @else
                                            @if(count($job->screeningquiz)!=0)
                                                <button class="btn btn-lg p-1 shadow-sm bg-color-blue rounded-pill japply-btn " id="japplybtn" data-bs-toggle="modal" href="#screeningQuiz72ers3" role="button">
                                                    <img class="image-size" src="{{url('site_assets_1/assets/img/apply2.png')}}" alt="apply"> <span class="fw-bold">Apply</span>
                                                </button>
                                            @else
                                                <button class="btn btn-lg p-1 shadow-sm bg-color-blue rounded-pill japply-btn japplybtn" id="japplybtn">
                                                    <img class="image-size" src="{{url('site_assets_1/assets/img/apply2.png')}}" alt="apply"> <span class="fw-bold">Apply</span>
                                                </button>
                                            @endif
                                            
                                            <label class="japplied-btn">
                                                <img class="imagesz-2" src="{{url('site_assets_1/assets/img/Shortlist.png')}}" alt="Applied"> <span class="fw-bolder fs-6">Applied</span>
                                            </label>
                                        @endif
                                        {{-- <div class="mx-3">
                                            <img class="image-size" src="{{url('site_assets_1/assets/img/star_unfilled.png')}}" alt="bookmark">
                                            <img class="image-size" src="{{url('site_assets_1/assets/img/star_filled.png')}}" style="display:none" alt="bookmark">
                                        </div> --}}                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="row">
                                    <div class="col-md-3 col-sm-4 col-xs-12"><span class=""><img class="me-2 image-size" src="{{ url('site_assets_1/assets/img/side_nav_icon/experience.png') }}"></span> <text class="fw-bold">{{$job->experience_string}}</text></div>
                                    <div class="col-md-5 col-sm-4 col-xs-12"><span class=""><img class="me-2 image-size" src="{{ url('site_assets_1/assets/img/side_nav_icon/salary.png') }}"></span> <text class="fw-bold"> {{ trim($job->salary_string) ? $job->salary_string :'Not Disclosed'  }}</text></div>
                                    <div class="col-md-4 col-sm-4 col-xs-12"><span class=""><img class="me-2 image-size" src="{{ url('site_assets_1/assets/img/side_nav_icon/location.png') }}"></span>  <text class="fw-bold"> {{rtrim($job->work_locations, ", ")}}</text></div>
                                </div>
                                <div class="row mt-3 ">
                                    <p class="poscls">Posted {{ MiscHelper::timeSince($job->posted_date) }}</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-body jdcarc">
                        <div class="mb-1">
                            <h4 class="mb-2 text-green-color fw-bolder">Job Description</h4>
                            <div class="jobdesbcontar">{!! $job->description !!}</div>
                        </div>
                    </div>
                    @if(!empty($job->additional_description))
                    <div class="card-body jdcarc">
                        <div class="mb-1">
                            <label class="mb-2 text-green-color fw-bolder">Required Candidate Profile</label>
                            <div>{!! $job->additional_description !!}</div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="card-body jdcarc">
                        <div class="mb-1">
                            <label class="mb-2 text-green-color fw-bolder">Skills</label>
                            <div>
                                @php
                                    $skillarr = $job->skill?array_column(json_decode($job->skill), 'value'):null;
                                @endphp
                                @foreach($skillarr as $t)
                                    <label class="chip clickable"><span>{{$t}}</span></label>
                                @endforeach
                                @foreach($skillarr as $t)
                                    <label class="chip clickable"><span>{{$t}}</span></label>
                                @endforeach
                                {{-- <label class="chip clickable"><span>MySQL</span></label>
                                <label class="chip clickable"><span>MySQL</span></label>
                                <label class="chip clickable"><span>MySQL</span></label>
                                    --}}
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body jdcarc">
                        <div class="mb-1">
                            <label class="mb-2 text-green-color fw-bolder">Education</label>
                            <div><p class="jejed">{{$job->educationLevel->education_level??'Any Degree'}} @if($job->is_any_education_level !='yes' && $job->is_any_education=='yes') - (Any) @endif</p></div>
                            <div class="jejedtype">@if($job->is_any_education!='yes') <li class="mb-2">Specialization : {{ $job->getEducationTypesStr() }} </li>@endif</div>
                        </div>
                    </div>

                    <div class="card-body jdcarc">
                        <div class="mb-1">
                            <label class="mb-2 text-green-color fw-bolder">Job Type</label>
                            {{-- <ul>
                                @foreach($job->jobtypes as $types)
                                <li>{{$types->type->type}}</li>
                                @endforeach
                            </ul> --}}
                            <div class="mb-2 mx-3">
                                @php
                                $jtyv= '';
                                @endphp
                                @foreach($job->jobtypes as $types)
                                    @php
                                        $jt_v = $types->type->type;
                                        if($types->type_id == 1 || $types->type_id == 2 || $types->type_id == 4) {
                                            if($job->working_deadline && $job->working_deadline_period_id){
                                                $exle = $job->working_deadline .' '.$job->working_deadline_period_id.'(s)';
                                                $jt_v = $types->type->type ;
                                            }
                                        }else if($types->type_id == 5) {
                                            if($job->working_hours){
                                                $exl = $job->working_hours .' hour(s)';
                                                $jt_v = $types->type->type ;
                                            }
                                        }else{
                                            // $jt_v = $types->type->type ?? '';
                                        }
                                        $jtyv .=  $jt_v.', ';
                                    @endphp
                                    {{-- <p>{{$jt_v.', '}}</p> --}}
                                @endforeach
                            {{-- </ul> --}}
                            <text>{{rtrim($jtyv, ", ")}}</text>
                            @if(isset($exle)&&!empty($exle))<li>Contract length : {{$exle}}</li>@endif
                            @if(isset($exl)&&!empty($exl))<li>Part-time hours : {{$exl}} per week</li>@endif
                            </div>
                        </div>

                        @if(count($job->jobshifts)!=0)
                        <div class="mb-1">
                            <label class="mb-2 text-green-color fw-bolder">Job Shift</label>
                            <ul>
                                @foreach($job->jobshifts as $shifts)
                                <li>{{$shifts->shift->shift}}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                    
                    @if(!empty($job->benefits) || !empty($job->supplementals) || !empty($job->other_benefits))
                    <div class="card-body jdcarc">
                        @if(!empty($job->benefits))
                        <div class="mb-2">
                            <label class="mb-1 text-green-color fw-bolder">Cash Benefits</label>
                            <div><p>{{ rtrim($job->benefits,', ') }}</p></div>
                        </div>
                        @endif
                        @if(!empty($job->supplementals))
                        <div class="mb-2">
                            <label class="mb-1 text-green-color fw-bolder">Supplemental Pay</label>
                            <div><p>{{ $job->supplementals }}</p></div>
                        </div>
                        @endif
                        @if(!empty($job->other_benefits))
                        <div class="mb-2">
                            <label class="mb-1 text-green-color fw-bolder">Other Benefits</label>
                            <div><p>{{ $job->other_benefits }}</p></div>
                        </div>
                        @endif
                    </div>
                    @endif
                    
                    @if($job->walkin)
                    <div class="card-body jdcarc">
                        <div class="mb-2">
                            <label class="mb-2 fw-bolder text-green-color">Walk-in Details</label>
                            <div class="row">
                                @if($job->walkin)
                                <div>
                                    <p><b>From</b> {{ \Carbon\Carbon::parse($job->walkin->walk_in_from_date)->format('d F, Y')}} to {{ \Carbon\Carbon::parse($job->walkin->walk_in_to_date)->format('d F, Y')}}.@if($job->walkin->exclude_days) (Excluding {{$job->walkin->exclude_days}})@endif</p>
                                    <p><b>Time between : </b> {{ \Carbon\Carbon::parse($job->walkin->walk_in_from_time)->format('H:i A')}} to {{ \Carbon\Carbon::parse($job->walkin->walk_in_to_time)->format('H:i A')}}</p>
                                </div>
                                @endif
                                <div class="col-md-12 align-self-center d-flex">
                                    <div class="pe-1">
                                        <img class="image-size" src="{{url('site_assets_1/assets/img/job_description/contact_location.png')}}" alt="contact location">
                                    </div>
                                    <div>
                                        <p class="">
                                            {{$job->walkin->walk_in_location??''}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @endif
                 
                    @if($job->contact_person_details)
                    <div class="card-body jdcarc">
                        <div class="mb-1">
                            <div class="mb-2">
                                <label class="fw-bolder text-green-color">Contact Details</label>
                            </div>
                            <div class="row">                                
                                <div class="col-md-5 align-self-center d-flex">
                                    <div class="pe-1">
                                        <img class="image-size" src="{{url('site_assets_1/assets/img/job_description/contact_message.png')}}" alt="contact location">
                                    </div>
                                    <div>
                                        <h5 class="">
                                           <a href="mailto:{{ $job->contact_person_details->email??'' }}">{{ $job->contact_person_details->email??'' }}</a>
                                        </h5>    
                                    </div>
                                </div>
                                <div class="col-md-5 justify-content-center">
                                    <div class="d-flex">
                                        <div class="pe-1">
                                            <img class="image-size" src="{{url('site_assets_1/assets/img/job_description/contact_num.png')}}" alt="contact num">
                                        </div>
                                        <div>
                                        <h5 class="">
                                                <a href="tel:{{ $job->contact_person_details->phone_1 ??'' }}">{{ $job->contact_person_details->phone_1 ??'' }}</a>
                                            </h5>
                                            <h5 class="">
                                                <a href="tel:{{ $job->contact_person_details->phone_1 ??'' }}">{{ $job->contact_person_details->phone_2 ??'' }}</a>
                                            </h5>
                                           
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-md-4 d-flex justify-content-center"> --}}
                                    {{-- <div class="pe-1">
                                        <div class="bg-color-blue border p-2 rounded-pill">
                                            <img class="image-size" src="{{url('site_assets_1/assets/img/job_description/contact_message.png')}}" alt="contact message">
                                            <text class="fw-bolder">Send Message</text> 
                                        </div>   
                                    </div> --}}
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="abt-cmp card-body jdcarc">
                        <div class="mb-2">
                            @if(!empty($job->company->description))
                            <div class="mb-4">
                                <h5 class="mb-1 fw-bolder text-green-color">About Company<h5>
                                <p>{{ $job->company->description }}</p>
                            </div>
                            @endif
                            
                            <div class="">
                                <div class="mb-1 fw-bolder">Company Info</div>
                                <div class="cmpinfo-detail"><label><b>Website</b></label>
                                    <span><a href="{{ $job->company->website_url  ?? "#" }}" target="_blank" rel="nofollow">{{ $job->company->website_url ?? "-" }}</a></span>
                                </div>
                                @php
                                    $pincode= $job->company->pin_code ?? '';
                                    $pincode= !empty($pincode)? ', '.$pincode.'.' : '';
                                @endphp
                                <div class="row cmpinfo-detail">
                                    <div class="col-md-6">
                                        <label><b>Address</b></label>
                                        <span>{{ !empty($job->company->address) ? $job->company->address.' '.$job->company->location.$pincode : "-" }}</span>
                                    </div>    
                                    <div class="col-md-6">
                                        <div class="col-md-6 align-self-center text-end">
                                            <a href="{{url('company-view/'.$job->company->slug)}}"><label class="chip clickable mt-0 cursor-pointer"><span>View More</span></label></a>                                 
                                        </div>
                                    </div>    
                                </div> 
                            </div>
                            
                            <hr>
                            <div class="sharethis-inline-share-buttons"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    </div>
</div>

    <div class="modal fade" id="screeningQuiz72ers3" tabindex="-1" role="dialog" aria-labelledby="screeningQuiz72ers3Label2" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered assessment_modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLongTitle">Screening Questions</h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" id="screeningQuiz" action="{{route('job.apply', $job->slug)}}" method="post">
                    @csrf
                    {!! Form::hidden('is_login',null, array('id'=>'is_login')) !!}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6 col-md-6 align-self-center mobile_m">
                                <img src="{{asset('images/Screening.png')}}" alt="">
                            </div>
                            <div class="col-12 col-md-12 col-lg-6 align-self-center">
                                <section id="cdate_assesment">
                                    <div class="card ass_details p-2">
                                        <div class="row">
                                            {{-- Question --}}
                                            @foreach ($job->screeningquiz as $key => $quiz)
                                            <div class="col-md-12 quiz" data-bp="{{$quiz->breakpoint}}" data-dsw3w14="{{$quiz->quiz_code}}" data-dsw3w15="{{$quiz->answer_type}}">
                                                <p class="h3 mt-4 mb-2">{{$quiz->candidate_question}}</p>
                                                
                                                @if($quiz->answer_type=='text')
                                                    {{ Form::text('answer_'.$quiz->quiz_code, null, array('class'=>'form-control e1ex0nj0', 'id'=>'answer_'.$quiz->quiz_code, 'placeholder'=>__(' '))) }}
                                                @elseif($quiz->answer_type=='single')
                                                    @foreach (json_decode($quiz->candidate_options) as $key1 => $option)                           
                                                        <div class="form-check">
                                                            <input class="form-check-input e1ex0nj0" type="radio" name="answer_{{$quiz->quiz_code}}" value="{{ $option }}" id="answerradio{{$quiz->quiz_code}}_{{ $key1 }}" @if($key1==0) checked @endif>
                                                            <label class="form-check-label" for="answerradio{{$quiz->quiz_code}}_{{ $key1 }}">
                                                                {{ $option }}
                                                            </label>
                                                        </div>                                                
                                                    @endforeach
                                                @elseif($quiz->answer_type=='multiple')
                                                    @foreach (json_decode($quiz->candidate_options) as $key1 => $option)                           
                                                        <div class="form-check">
                                                            <input class="form-check-input e1ex0nj0" type="checkbox" name="answer_{{$quiz->quiz_code}}[]" value="{{ $option }}" id="answercheckbox{{$quiz->quiz_code}}_{{ $key1 }}">
                                                            <label class="form-check-label" for="answercheckbox{{$quiz->quiz_code}}_{{ $key1 }}">
                                                                {{ $option }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @elseif($quiz->answer_type=='textarea')
                                                    {{ Form::textarea('answer_'.$quiz->quiz_code, null, array('class'=>'form-control e1ex0nj0', 'id'=>'answer_'.$quiz->quiz_code, 'placeholder'=>__(' '))) }}
                                                @elseif($quiz->answer_type=='select')
                                                @php
                                                    $options = json_decode($quiz->candidate_options);
                                                    $options = array_combine($options, $options);
                                                @endphp
                                                    {{ Form::select('answer_'.$quiz->quiz_code, ['' => __('Select')]+$options??'', null, array('class'=>'form-select', 'id'=>'answer_'.$quiz->quiz_code)) }}
                                                @endif
                                                <span class="es2wa7s text-danger"> </span>

                                            </div>
                                            @endforeach
                                            <span class="es2wa7sd text-danger"> </span>

                                            {{-- // Question --}}
                                        </div>
                                    </div>                  
                                </section>    
                            </div>
                        </div>
                    </div>
                  
                    <div class="container">
                        <div class="d-grid gap-2 mx-3 mb-4 d-md-flex justify-content-md-between">
                            @if($breakpoint==null)
                                <a class="btn previous-btn skip-submit"> Skip and apply</a>
                            @endif
                            <a class="btn previous-btn" data-bs-dismiss="modal"> Skip</a>
                            <button type="button" class="btn next-btn submit">Submit and Apply</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=6315c4c30b5e930012a9c49e&product=inline-share-buttons' async='async'></script>
@php
    $applied = Auth::user()?(Auth::user()->isAppliedOnJob($job->id)??false):false;
@endphp
<script>
    var applied = '{{ $applied }}';
    var baseurl = '{{ url("/") }}/';
    var is_login = 1;
    var save_req_url = "{{ route('job.save', $job->slug) }}";
    var apply_req_url = "{{ route('job.apply', $job->slug) }}" ;

    //company header
    $('#myHeader').hide();

    window.onscroll = function() {myFunction()};

    var header = document.getElementById("myHeader");
    var sticky = header.offsetTop;

    function myFunction() {
    $('#myHeader').show();
    if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
    } else {
    $('#myHeader').hide();
        header.classList.remove("sticky");
    }
    } 
   
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/2e9ejr3/js/destail.e2k3eu0.js') }}"></script>

@endsection
