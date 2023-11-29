@extends('jobs.app') 
@section('custom_styles')
<link href="{{ asset('css/hgtvwtiya.css')}}" rel="stylesheet">
@endsection
@section('content')

@include('layouts.header')

    <div class="sdad_aw">
        @if($job->is_active==3 || $job->is_active==2)
            <button class="mobile_apply expired" data-value="disabled"> {{ ($job->is_active==2)?'In-active':'Expired' }}</button>
        @else
            <button class="mobile_apply applyrs_btn japplybtn japply-btn" data-value="disabled"><img src="{{asset('images/detailpage/apply_icon.svg')}}" alt="apply-icon"><span> Apply </span></button>
            <button class="mobile_apply applied_bm japplied-btn"><img src="{{asset('images/detailpage/applied.svg')}}" alt="applied-icon"><span> Applied </span></button>
        @endif
    </div>
    <!-- sticky header -->
    <nav class="navbar jsky_hb navbar-expand-lg navbar-light">
        <div class="container-xl">
            <div class="card">
                <div class="row">
                    <div class="col-md-8 col-10 col-sm-8 col-lg-9 col-xl-9">
                        <table>
                            <tr>
                                <td>
                                    @php
                                        $logo = $job->company->company_image??asset('\site_assets_1\assets\img\industry.svg');
                                    @endphp

                                    <img src="{{$logo}}" alt="profile-image" class="profilestcky">
                                </td>
                                <td>
                                    <span>{{ ucwords($job->title) }}</span>
                                    <p class="m-0 pt-2">{{ ucwords($job->company_name??$job->company->name) }}.</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4 col-2 col-sm-4 col-lg-3 col-xl-3 align-self-center">
                        <div class="row">
                            <div class="col-md-6 col-sm-5 col-lg-6 col-xl-6 saved_jgb text-center align-self-center">

                            {{-- @php
                                    $is_fav = 'no';
                                    if((Auth::check() && Auth::user()->isFavouriteJob($job->slug)==true))
                                    {
                                        $is_fav = 'yes';
                                    }
                                @endphp
                                @if($is_fav=='yes')
                                    <div class="mb-0 text-center cursor-pointer favjob" data-fav='{{$is_fav}}'>
                                        <img src="{{asset('images/detailpage/savedj.svg')}}" alt="savedjobs" class="icon_rs chsizew" draggable="false"><span class="mblef"></span>
                                    </div>
                                @else
                                    <div class="text-center d mb-0 cursor-pointer favjob" data-fav='{{$is_fav}}'>
                                        <img src="{{asset('images/detailpage/unsavedj.svg')}}" alt="unsavedjobs" class="icon_rs chsizew" draggable="false"><span class="mblef"></span>
                                    </div>
                                @endif--}}
                            </div>
                            <div class="col-md-6 col-sm-7 col-lg-6 col-xl-6 text-end">
                                
                            @if($job->is_active==3 || $job->is_active==2)
                                <button class="expired" data-value="disabled">  {{ ($job->is_active==2)?'In-active':'Expired' }} </button>
                            @else
                                <button class="applyrs_btn japplybtn japply-btn" data-value="disabled"><img src="{{asset('images/detailpage/apply_icon.svg')}}" alt="apply-icon"><span> Apply </span></button>
                                <button class="applied_bm japplied-btn"><img src="{{asset('images/detailpage/applied.svg')}}" alt="applied-icon"><span> Applied </span></button>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <main class="resultjobwb">
        <div class="resulty-width1 mt-4 mb-4">
            <div class="mb-3 breadcrumbty cursor-pointer">
                <span><a href="{{url('/')}}" class="slug_brd text-dark"><img src="{{asset('images/detailpage/breadcrumb.svg')}}" alt="breadcrumb-arrow"> Back</a></span>
            </div>            
        </div>
        <div class="resulty-width2 mb-5">
            <div class="card pb-3">
                <div class="row">
                    <div class="col-md-9 col-lg-9 col-xl-10 col-sm-9">
                        <table>
                            <tr>
                                <td class="profile_clum">
                                    <div class="round_pf">
                                        <img src="{{$logo}}" alt="company-profile" class="companyty-pf" draggable="false">
                                    </div>
                                </td>
                                <td class="job_tlers">
                                    <span class="fw-bolder jb_tles">{{ ucwords($job->title) }}</span>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mt-3 mb-3 cam_nme">
                                                <span class="mgmw">{{ ucwords($job->company_name??$job->company->name) }}.</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4 col-5">
                                                    <div class="experian mgmw">
                                                        <img src="{{asset('images/detailpage/experience.svg')}}" alt="experience-icon" class="icon_rs" draggable="false"><span class="grayc">Experience :</span> {{$job->experience_string}}
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-7 hibaqmj">
                                                    <div class="salarian mgmw">
                                                        <img src="{{asset('images/detailpage/salary.svg')}}" alt="salary-icon" class="icon_rs" draggable="false"><span class="grayc">Salary :</span> {{ trim($job->hide_salary != 1)&&!empty($job->salary_string) ? $job->salary_string :'Not Disclosed'}}
                                                    </div>
                                                </div>
                                                @isset($job->num_of_positions)
                                                    <div class="col-md-3 col-5">
                                                        <div class="requiredn mgmw">
                                                            <img src="{{asset('images/detailpage/required.svg')}}" alt="required-icon" class="icon_rs" draggable="false"><span class="grayc">Required :</span> {{$job->num_of_positions}}
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-12 col-xl-12 col-12">
                                                    <div class="locationrs mgmw">
                                                        <img src="{{asset('images/detailpage/locate.svg')}}" alt="locate-icon" class="icon_rs" draggable="false"><span class="grayc">Location :</span> {{rtrim($job->work_locations, ", ")}} 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-3 col-lg-3 col-xl-2 apply_div col-sm-3 applybtnsticky">
                        
                        @if($job->is_active==3 || $job->is_active==2)
                            <div class="text-end mt-2">
                                <button class="applyrs_btn expired" data-value="disabled"> {{ ($job->is_active==2)?'In-active':'Expired' }}</button>
                            </div>
                        @else
                            <div class="text-end mt-2">
                                <button class="applyrs_btn japplybtn japply-btn" data-value="disabled"><img src="{{asset('images/detailpage/apply_icon.svg')}}" alt="apply-icon"> Apply</button>
                            </div>
                            <div class="text-end">
                                <button class="applied_bm japplied-btn"><img src="{{asset('images/detailpage/applied.svg')}}" alt="applied-icon">Applied</button>
                            </div>
                        @endif
                    </div>
                    
                    <div class="col-md-12 col-12">
                        <div class="row">
                            <div class="col-md-4 col-5 col-xl-4 col-lg-5 align-self-center">
                                <div class="postedrs_dt mgmw mb-0">
                                    <img src="{{asset('images/detailpage/posted_icon.svg')}}" alt="posted-date" class="icon_rs" draggable="false"><span class="mblef">Posted</span> {{ MiscHelper::timeSince($job->posted_date) }}
                                </div>
                            </div>
                            <div class="col-md-6 col-5 col-xl-5 col-lg-5 align-self-center">
                                @php $notice_period = $job->NoticePeriod !=null?$job->NoticePeriod->notice_period:'' @endphp
                                @if(!empty($notice_period) && $notice_period=='Immediate Join')
                                    <div class="immediate_ic mgmw mb-0">
                                        <img src="{{asset('images/detailpage/immediate.svg')}}" alt="immediate-join" class="icon_rs" draggable="false"> 
                                        @if($notice_period=='Immediate Join') Immediate <span class="mblef">Join</span> @else {{ ucwords($notice_period) }} @endif
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-2 col-2 col-xl-3 col-lg-3">
                                @php
                                    $is_fav = 'no';
                                    if((Auth::check() && Auth::user()->isFavouriteJob($job->slug)==true))
                                    {
                                        $is_fav = 'yes';
                                    }
                                @endphp
                                @if($is_fav=='yes')
                                    <div class="unsavgf_jbs mgmw mb-0 text-center cursor-pointer favjob" data-fav='{{$is_fav}}'>
                                        <img src="{{asset('images/detailpage/savedj.svg')}}" alt="savedjobs" class="icon_rs chsizew" draggable="false"><span class="mblef">Job saved</span>
                                    </div>
                                @else
                                    <div class="svdmh_jbs mgmw text-center d mb-0 cursor-pointer favjob" data-fav='{{$is_fav}}'>
                                        <img src="{{asset('images/detailpage/unsavedj.svg')}}" alt="unsavedjobs" class="icon_rs chsizew" draggable="false"><span class="mblef">Save Job</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card descriptions">
                <h4>
                    Job description
                </h4>
                <p class="m-0">
                    @php
                        $description = str_replace('<p>&nbsp;</p>', '', $job->description);
                        echo $description;
                    @endphp
                </p>
                @if(!empty($job->additional_description))
                    <h4>Required Candidate Profile</h4>
                    <p class="m-0">
                        {!! $job->additional_description !!}
                    </p>
                @endif
            </div>
            <div class="card keyboard_mcts">
                @php
                    if(Auth::check()){
                        $userSkill=explode(",",Auth::user()->getUserSkillsStr());
                    }else{
                        $userSkill=array();
                    }
                    $skillarr = $job->skill?array_column(json_decode($job->skill), 'value'):null;
                    $jobSkill=array_column(json_decode($job->skill), 'value');
                    $matched_skills = array_intersect($jobSkill,$userSkill);
                    $unmatched_skills = array_diff($jobSkill,$userSkill);
                @endphp
                @if(Auth::check() && count($matched_skills))
                <h4>
                    Keywords matching with your profile
                </h4>
                <p>Matching Skills to the Job Post</p>
                <div class="row">
                    <div class="col-md-9">
                        <div class="skils_prnt">
                            @foreach($matched_skills as $t)
                                <div class="skill_rnd">{{$t}}</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-3 text-center align-self-center">
                        <h3>Profile Match <span>{{Auth::user()->profileMatch($job->id)}}%</span></h3>
                    </div>
                </div>
                <div class="mt-3">
                    <p>Other extra skill sets you have include</p>
                    <div class="skils_prnt">
                        @foreach($unmatched_skills as $t)
                            <div class="key_rnd">{{$t}}</div>
                        @endforeach
                    </div>
                </div>
                @else
                <h4>
                    Skill 
                </h4>
                <div class="row">
                    <div class="col-md-12">
                        @php
                            $skillarr = $job->skill?array_column(json_decode($job->skill), 'value'):null;
                        @endphp
                        <div class="skils_prnt">
                            @foreach($skillarr as $t)
                                <div class="skill_rnd">{{$t}}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="card">
                <div>
                    <h4>Education</h4>
                    <div><p>{{$job->educationLevel->education_level??'Any Degree'}} @if($job->is_any_education_level !='yes' && $job->is_any_education=='yes') - (Any) @endif</p></div>
                    <div>@if($job->is_any_education!='yes') <li>Specialization : {{ $job->getEducationTypesStr() }} </li>@endif</div>
                </div>
            </div>
            <div class="card">
                <h4>Job Type</h4>
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
                <ul>
                    {{rtrim($jtyv, ", ")}}
                </ul>
                @if(isset($exle)&&!empty($exle))<li>Contract length : {{$exle}}</li>@endif
                @if(isset($exl)&&!empty($exl))<li>Part-time hours : {{$exl}} per week</li>@endif
                @if(count($job->jobshifts)!=0)
                    <h4 class="mt-1">Job Shift</h4>
                    <ul>
                        @foreach($job->jobshifts as $shifts)
                        <li>{{$shifts->shift->shift}}</li>
                        @endforeach
                    </ul>
                @endif
                @if(!empty($job->benefits) || !empty($job->supplementals) || !empty($job->other_benefits))
                    @if(!empty($job->benefits))
                        <h4>Cash Benefits</h5>
                        <div><span>{{ rtrim($job->benefits,', ') }}</span></div>
                    @endif
                    @if(!empty($job->supplementals))
                        <div class="mt-3">
                            <h4>Supplemental Pay</h5>
                            <div><span>{{ rtrim($job->supplementals,', ') }}</span></div>
                        </div>
                    @endif
                    @if(!empty($job->other_benefits))
                        <div class="mt-3">
                            <h4>Other Benefits</h5>
                            <div><span>{{ rtrim($job->other_benefits,', ') }}</span></div>
                        </div>
                    @endif
                @endif
            </div>
            @if($job->company->is_admin==0)
                <div class="card about_cmp">
                    @if(!empty($job->company->description))
                        <h4>
                            About Company / Organisation :
                        </h4>
                        <p>
                            {{ $job->company->description }}
                        </p>
                    @endif

                    @isset($job->company->website_url)
                        <h5>Website</h5>
                        <div class="mb-3">
                            <a href="{{ $job->company->website_url}}" target="_blank">{{ $job->company->website_url}}</a>
                        </div>
                    @endisset               
                    <div class="d-flex justify-content-between">
                        <div class="">
                            @if($job->company->fb_url || $job->company->linkedin_url || $job->company->insta_url )
                                <h5 class="mb-3"><span class="mblef">Other</span>Social media <span class="mblef">links</span></h5>
                                <div class="d-flex socialsimg">
                                    @isset($job->company->fb_url)<span><a href="{{$job->company->fb_url}}"><img src="{{asset('images/detailpage/facebook.svg')}}" alt="facebook-image"></a></span>@endif
                                    @isset($job->company->linkedin_url)<span><a href="{{$job->company->linkedin_url}}"><img src="{{asset('images/detailpage/linkedin.svg')}}" alt="linkedin-image"></a></span>@endif
                                    @isset($job->company->insta_url)<span><a href="{{$job->company->insta_url}}"><img src="{{asset('images/detailpage/instagram.svg')}}" alt="instagram-image"></a></span>@endif
                                    @isset($job->company->twitter_url)<span><a href="{{$job->company->twitter_url}}"><img src="{{asset('images/about/twitterx.png')}}" alt="twitter-image" class="w-50 px-1"></a></span>@endif
                                </div>
                            @endif
                        </div>
                        @isset($job->company)
                            <div class="align-self-end">
                                <div class="know_cmpany">
                                    <a href="{{url('company-view/'.$job->company->slug)}}" class="knowmr"><span>Know more <img src="{{asset('images/detailpage/know_mre.svg')}}" alt="know-more"></span></a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>                
            @endif

            @if($job->walkin || ($job->contact_person_details->morning_section_from && $job->contact_person_details->morning_section_to) || 
               ($job->contact_person_details->evening_section_from && $job->contact_person_details->evening_section_to) || 
               (!empty($job->contact_person_details->email)) ||
               (!empty($job->contact_person_details->phone_1)) ||
               (!empty($job->contact_person_details->phone_2)) ||
               (!empty($job->contact_person_details->phone_2)))

                <div class="card walkin_cd align-self-center">
                    @if($job->walkin)
                        <h4>Walk-in</h4>
                        <div>
                            <p><b>From </b>{{ \Carbon\Carbon::parse($job->walkin->walk_in_from_date)->format('d F, Y')}} to {{ \Carbon\Carbon::parse($job->walkin->walk_in_to_date)->format('d F, Y')}}.@if($job->walkin->exclude_days) (Excluding {{$job->walkin->exclude_days}})@endif</p>
                            <p><b>Time between: </b>{{ \Carbon\Carbon::parse($job->walkin->walk_in_from_time)->format('h:i A')}} to {{ \Carbon\Carbon::parse($job->walkin->walk_in_to_time)->format('h:i A')}}</p>
                            @if(!empty($job->walkin->walk_in_location))
                                <p>
                                    <table>
                                        <tr>
                                            <td class="d-block"><img src="{{asset('images/detailpage/locate.svg')}}" alt="location" class="icon_rs" draggable="false"></td>
                                            <td>
                                                <span>
                                                    {{ $job->walkin->walk_in_location }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </p>
                            @endif
                            
                            @if(isset($job->walkin->walk_in_google_map_url) && !empty($job->walkin->walk_in_google_map_url))
                                <p><b>Google link: </b><a href="{{$job->walkin->walk_in_google_map_url}}" target="_blank" class="text-primary">{{ $job->walkin->walk_in_google_map_url }}</a></p>
                            @endif
                        </div>
                    @endif

                    @if(($job->contact_person_details->morning_section_from && $job->contact_person_details->morning_section_to) || 
                    ($job->contact_person_details->evening_section_from && $job->contact_person_details->evening_section_to) || 
                    (!empty($job->contact_person_details->email)) ||
                    (!empty($job->contact_person_details->phone_1)) ||
                    (!empty($job->contact_person_details->phone_2)))
                    
                        <h4>Contact Detail</h4>

                        @if(($job->contact_person_details->morning_section_from && $job->contact_person_details->morning_section_to) || ($job->contact_person_details->evening_section_from && $job->contact_person_details->evening_section_to))
                            <p>
                                <b>Best Time to Contact :</b> 
                                @if( ($job->contact_person_details->morning_section_from && $job->contact_person_details->morning_section_to))
                                    {{ \Carbon\Carbon::parse($job->contact_person_details->morning_section_from)->format('h:i A')}} to
                                    {{ \Carbon\Carbon::parse($job->contact_person_details->morning_section_to)->format('h:i A') }}
                                @endif
                                @if( ($job->contact_person_details->evening_section_from && $job->contact_person_details->evening_section_to))
                                    {{ \Carbon\Carbon::parse($job->contact_person_details->evening_section_from)->format('h:i A') }} to 
                                    {{ \Carbon\Carbon::parse($job->contact_person_details->evening_section_to)->format('h:i A') }}
                                @endif
                            </p>
                        @endif
                        @if(!empty($job->contact_person_details->email))
                            <p>
                                <a href="mailto:{{ $job->contact_person_details->email??'' }}">
                                    <img src="{{asset('images/detailpage/email.svg')}}" alt="email-address" class="icon_rs">{{ $job->contact_person_details->email??'' }}
                                </a>
                            </p>
                        @endif
                        <div class="row">
                            @if((!empty($job->contact_person_details->name)))
                                <div class="col-md-6">
                                    <table>
                                        <tr>
                                            <td class="d-block"><img src="{{asset('images/detailpage/user.svg')}}" alt="call-icon" class="icon_rs" draggable="false"></td>
                                            <td>
                                                <span>
                                                    <div>{{ $job->contact_person_details->name }}</div>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @endif
                            <div class="col-md-6">
                                <table class="call_nhvcez">
                                    @php
                                        $pincode= $job->company->pin_code ?? '';
                                        $pincode= !empty($pincode)? ', '.$pincode.'.' : '';
                                    @endphp
                                    <tr>
                                        <td class="d-block"><img src="{{asset('images/detailpage/locate.svg')}}" alt="location" class="icon_rs" draggable="false"></td>
                                        <td>
                                            <span>
                                                {{ !empty($job->company->address) ? $job->company->address.' '.$job->company->location.$pincode : "-" }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            @if((!empty($job->contact_person_details->phone_1)) || (!empty($job->contact_person_details->phone_2)))
                                <div class="col-md-6">
                                    <table class="call_nhvcez">
                                        <tr>
                                            <td class="d-block"><img src="{{asset('images/detailpage/calls.svg')}}" alt="call-icon" class="icon_rs" draggable="false"></td>
                                            <td>
                                                <span>
                                                    @if(!empty($job->contact_person_details->phone_1))<div><a href="tel:{{ $job->contact_person_details->phone_1 }}">{{ $job->contact_person_details->phone_1 }}</a></div>@endif
                                                    @if(!empty($job->contact_person_details->phone_2))<div><a href="tel:{{ $job->contact_person_details->phone_2 }}">{{ $job->contact_person_details->phone_2 }}</a></div>@endif
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </main>
    <!-- view document -->
    <div class="modal fade" id="screenings" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="questionsdt">
                    <div class="first_mwe">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="open-jbwe">
                                    <img src="{{asset('images/detailpage/screens.svg')}}" alt="screening-image" draggable="false">
                                </div>
                            </div>
                            <div class="col-md-6 align-self-center">
                                <h1 class="fw-bolder mb-3">Screening Questions</h1>
                                <p>These questions will help the recruiter
                                    to filter your profile to next level of interview
                                </p>
                            </div>
                            <div class="col-md-7 col-6 align-self-center">
                                @if($breakpoint==null)
                                <div class="text-end space_hgtyu2">
                                    <p class="m-0 cursor-pointer previous-btn skip-submit">Skip & apply</p>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-5 col-6">
                                <div class="text-end space_hgtyu">
                                    <button>Attend & apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- preview docs -->
    <div class="modal fade" id="fullquestions" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <form class="form" id="screeningQuiz" action="{{route('job.apply', $job->slug)}}" method="post">
                    @csrf
                    {!! Form::hidden('is_login',null, array('id'=>'is_login')) !!}
                    <div class="container-xl">
                        <div class="header_mcv">
                            <div class="row">
                                <div class="col-md-5 col-2 col-sm-4 align-self-center">
                                    <button type="button" data-bs-dismiss="modal" aria-label="Close"><img src="{{asset('images/detailpage/back_vrd.svg')}}" alt="back icon"> <span class="jhnt5vfd">Back to job post</span></button>
                                </div>
                                <div class="col-md-7 col-10 col-sm-8">
                                    <a href=""><img src="{{asset('images/detailpage/logo.svg')}}" alt="logo-image" class="logo_mcv"></a>
                                </div>
                            </div>
                        </div>
                        <div class="content_mcv">
                            <div class="card">
                                <div class="text-center first_1mcv">
                                    <div class="mb-3">
                                        <img src="{{asset('images/detailpage/breakpoints_mcv.svg')}}" alt="break-points">
                                    </div>
                                    <p><strong>Break Point Questions</strong></p>
                                    <p><b>Note:</b> The Questions with the above sign are mandatory.</p>
                                </div>
                            </div>
                            <div class="quizs">
                                {{-- Question --}}
                                    @foreach ($job->screeningquiz as $key => $quiz)
                                        <div class="row">
                                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-2 text-end">
                                                @if($quiz->breakpoint=='yes')<img src="{{asset('images/detailpage/breakpoints_mcv.svg')}}" class="break-point" alt="break-points-{{$quiz->quiz_code}}">@endif
                                            </div>
                                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-11 col-10">
                                                <div class="quiz" data-bp="{{$quiz->breakpoint}}" data-dsw3w14="{{$quiz->quiz_code}}" data-dsw3w15="{{$quiz->answer_type}}">
                                                    <div class="mb-3">
                                                        <strong>{{$quiz->candidate_question}}</strong>
                                                    </div>
                                                    @if($quiz->answer_type=='text')
                                                        <div class="input_hgmtr mb-3">    
                                                            {{ Form::text('answer_'.$quiz->quiz_code, null, array('class'=>'form-control e1ex0nj0 w-auto', 'id'=>'answer_'.$quiz->quiz_code, 'placeholder'=>__(' '))) }}
                                                        </div>
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
                                                        <div class="mb-3 input_hgmtr">
                                                            {{ Form::textarea('answer_'.$quiz->quiz_code, null, array('class'=>'form-control e1ex0nj0', 'id'=>'answer_'.$quiz->quiz_code, 'placeholder'=>__(' '))) }}
                                                        </div>
                                                    @elseif($quiz->answer_type=='select')
                                                    @php
                                                        $options = json_decode($quiz->candidate_options);
                                                        $options = array_combine($options, $options);
                                                    @endphp
                                                        <div class="mb-3 input_hgmtr">
                                                            {{ Form::select('answer_'.$quiz->quiz_code, ['' => __('Select')]+$options??'', null, array('class'=>'form-select w-auto', 'id'=>'answer_'.$quiz->quiz_code)) }}
                                                        </div>
                                                    @endif
                                                    <span class="es2wa7s text-danger"> </span>
                                                </div>
                                            </div>
                                        </div>
                                    <hr/>
                                    @endforeach
                                {{-- // Question --}}

                                <div class="posin_hgmj">
                                    <button class="submit">Submit & Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('user.complete-profile-modal')

    <script>
        var reference_url = '{{ $job->reference_url }}';
        var is_admin = '{{ $job->company->is_admin }}';
        var applied = '{{ Auth::user()?(Auth::user()->isAppliedOnJob($job->id)??false):false }}';
        var baseurl = '{{ url("/") }}/';
        var is_login = '{{ Cookie::get("is_login") }}';
        var save_req_url = "{{ route('job.save', $job->slug) }}";
        var apply_req_url = "{{ route('job.apply', $job->slug) }}" ;
        var isscreening = "{{(count($job->screeningquiz)!=0)?'yes':'no'}}"; 
        //company header
        function boxtothetop() {
            var windowTop = $(window)
            .scrollTop();
            var top = ($('.applybtnsticky')
            .offset()
            .top)-40;
            if(windowTop > top) {
            $('.jsky_hb').addClass('sticky');
            } else {
            $('.jsky_hb').removeClass('sticky');
            }
            var bottom = $('.container').height() - $(window).height();
            if(windowTop > (parseInt(bottom)+180)) {
            $('.applybtnsticky').addClass('nonsticky');
            } else {
            $('.applybtnsticky').removeClass('nonsticky');
            }
        }
        $(function() {
            $(window)
            .scroll(boxtothetop);
            boxtothetop();
        });

        $(document).on('click', '.applyrs_btn', function(){
            $('#screenings').modal('show');
        });

        
        var backurl = document.referrer || baseurl;
        $('.slug_brd').attr('href', backurl);

    </script>
    <script type="text/javascript" src="{{ asset('site_assets_1/assets/2e9ejr3/js/destail.e2k3eu0.js') }}"></script>
@endsection

