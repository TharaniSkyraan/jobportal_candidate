@extends('jobs.app')
@section('content')
@include('layouts.header')
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
        border-color: #4285f470;
        background-color: #48abf717 !important;
        padding: 0.46rem 0.85rem!important;
        font-size: 0.9rem;
    }
    .japply-btn:hover{
        opacity: 1;
        transition: none;
        border-color: #4285F4;
        background-color: #48abf72b !important;
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
        margin-bottom: 0.3rem;
    }
    .jdcarc .chip {
        margin-top: 10px;
        display: inline-block;
        margin-right: 10px;
        font-size: 14px!important;
        font-weight: 400;
        color: #333;
        border: 1px solid #4285f47a;
        border-radius: 14px;
        padding: 5px 12px;
        /* background-color: #effcff; */
        /* border-color: #4285F4; */
        background-color: #48abf726 !important;
    }
    ul{
        margin-bottom: 0.5rem;
    }
    ul li{
        line-height: 1.62;
        margin-bottom: 0.3rem;
        font-size: 14px;
    }
    .jobdesbcontar{
        font-size: 14px;
    }
    .jdcarc .cmpinfo-detail>label {
        font-size: 14px;
        font-weight: 400;
        color: #999;
        width: 90px;
        display: inline-block;
        vertical-align: top;
    }
    .poscls{
        margin: 8px 0 0 0 !important;
        color: #666666;
        font-size: 13px !important;
    }
    .main-header {
        background: #fff;
        min-height: 45px;
        width: 100%;
        position: sticky !important;
        z-index: 1046;
    }
    .header-space-search{
        margin-top:70px !important;
    }
    .text-truncate{
        -webkit-line-clamp: 3 !important;
        -webkit-box-orient: vertical !important;
        display: -webkit-box !important;
        white-space: break-spaces !important;
    }
    text{
        font-size: 15px;
    }
    
    /*company header css*/
    .top-container {
    padding: 30px;
    text-align: center;
    }
    
    .header {
    padding: 10px 16px;
    background: #4285f4f2;
    color: #f1f1f1;
    }
    
    .content {
    padding: 16px;
    }
    
    .sticky {
    position: fixed;
    top: 0;
    width: 100%;
    }
    
    .sticky + .content {
    padding-top: 102px;
    }#myHeader .card{
        margin-top: 12px;
    }.header#myHeader{
    height: 90px;
    }
    @media(max-width:767px){
        .header#myHeader{
            display:none !important;
        }
    }
    @media (min-width: 576px) and (max-width:767px)
    {    
      .container-detail {
          max-width: 665px !important;
      }
    }
    .fw-bold{
        font-weight:500 !important;
    }
</style>

<div class="header" id="myHeader">
    <div class="row">
        <div class="col-md-10 m-auto">
            <div class="card p-2">
                <div class="row">
                    <div class="col-6">
                        <div class="col-md-8 col-sm-8 col-xs-12 mx-2">
                            <h4 class=" text-green-color jt-ellip">{{ ucwords($job->title) }}</h4>
                            <h6 class=" text-dark m-0">{{ ucwords($job->company_name??$job->company->name) }}.</h6>
                        </div>
                    </div>
                    <div class="col-6 text-end align-self-center">
                        <div class="row">
                            <div class="col-10">
                                @if(count($job->screeningquiz)!=0 && $job->company->reference_url=='')
                                    <button class="btn btn-lg p-1 shadow-sm bg-color-blue rounded-pill japply-btn " id="japplybtn" data-bs-toggle="modal" href="#screeningQuiz72ers3" role="button">
                                        <img class="image-size" src="{{url('site_assets_1/assets/img/apply2.png')}}" alt="apply"> <span class="fw-bold">Apply</span>
                                    </button>
                                @else
                                    <button class="btn btn-lg p-1 shadow-sm bg-color-blue rounded-pill japply-btn japplybtn" id="japplybtn">
                                        <img class="image-size" src="{{url('site_assets_1/assets/img/apply2.png')}}" alt="apply"> <span class="fw-bold">Apply</span>
                                    </button>
                                @endif
                                
                                <label class="japplied-btn">
                                    <img class="imagesz-2" src="{{url('site_assets_1/assets/img/Shortlist.png')}}" alt="Applied"> <span class=" fs-6">Applied</span>
                                </label>
                            </div>
                            <div class="col-2 align-self-center text-center">
                                @php
                                $is_fav = 'no';
                                if((Auth::check() && Auth::user()->isFavouriteJob($job->slug)==true))
                                {
                                    $is_fav = 'yes';
                                }
                                @endphp
                                <div class="mx-3 favjob" data-fav='{{$is_fav}}'>                                        
                                    @if($is_fav=='yes')
                                        <img class="image-size1 cursor-pointer" src="{{url('site_assets_1/assets/img/star_filled.png')}}" alt="bookmark">
                                    @else
                                        <img class="image-size1 cursor-pointer" src="{{url('site_assets_1/assets/img/star_unfilled.png')}}" alt="bookmark">
                                    @endif
                                </div>          
                            </div>
                        </div>
                    </div>
                    <div class="col-6"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container container-detail mb-5">
    <div class="w-85 mx-auto header-space-search" >
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item jt-bc-ellip active" aria-current="page">{{ ucwords($job->title) }}</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 col-lg-9">
                <div class="card page-inner">
                    <div class="card-body jdcarc">
                        <div class="mb-1">
                            <div class="row">
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <h2 class=" text-green-color jt-ellip">{{ ucwords($job->title) }}</h2>
                                    <h4 class=" pb-2">{{ ucwords($job->company_name??$job->company->name) }}.</h4>
                                </div>
                                <div class="col-md-4 col-sm-8 col-xs-12" style="text-align: -webkit-right;">
                                    <div class="d-flex align-items-center justify-content-end">
                                        @if(count($job->screeningquiz)!=0 && $job->company->reference_url=='')
                                            <button class="btn btn-lg p-1 shadow-sm bg-color-blue rounded-pill japply-btn " id="japplybtn" data-bs-toggle="modal" href="#screeningQuiz72ers3" role="button">
                                                <img class="image-size" src="{{url('site_assets_1/assets/img/apply2.png')}}" alt="apply"> <span class="fw-bold">Apply</span>
                                            </button>
                                        @else
                                            <button class="btn btn-lg p-1 shadow-sm bg-color-blue rounded-pill japply-btn japplybtn" id="japplybtn">
                                                <img class="image-size" src="{{url('site_assets_1/assets/img/apply2.png')}}" alt="apply"> <span class="fw-bold">Apply</span>
                                            </button>
                                        @endif
                                        
                                        <label class="japplied-btn">
                                            <img class="imagesz-2" src="{{url('site_assets_1/assets/img/Shortlist.png')}}" alt="Applied"> <span class=" fs-6">Applied</span>
                                        </label>
                                        @php
                                        $is_fav = 'no';
                                        if((Auth::check() && Auth::user()->isFavouriteJob($job->slug)==true))
                                        {
                                            $is_fav = 'yes';
                                        }
                                        @endphp
                                        <div class="mx-3 favjob" data-fav='{{$is_fav}}'>                                        
                                            @if($is_fav=='yes')
                                                <img class="image-size1 cursor-pointer" src="{{url('site_assets_1/assets/img/star_filled.png')}}" alt="bookmark">
                                            @else
                                                <img class="image-size1 cursor-pointer" src="{{url('site_assets_1/assets/img/star_unfilled.png')}}" alt="bookmark">
                                            @endif
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-md-12 mt-3">
                                <div class="row">
                                    <div class="col-md-3 col-sm-4 col-xs-12 d-flex"><span class=""><img class="me-2 image-size" src="{{ url('site_assets_1/assets/img/side_nav_icon/experience.png') }}"></span> <text class="fw-bold">{{$job->experience_string}}</text></div>
                                    <div class="col-md-5 col-sm-5 col-xs-12 d-flex"><span class=""><img class="me-2 image-size" src="{{ url('site_assets_1/assets/img/side_nav_icon/salary.png') }}"></span> <text class="fw-bold">{{ trim($job->hide_salary != 1)&&!empty($job->salary_string) ? $job->salary_string :'Not Disclosed'}}</text></div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 d-flex"><span class=""><img class="me-2 image-size" src="{{ url('site_assets_1/assets/img/side_nav_icon/location.png') }}"></span>  <text class="fw-bold text-truncate">{{rtrim($job->work_locations, ", ")}}</text></div>
                                </div>
                                <div class="row mt-3 ">
                                    <p class="poscls">Posted {{ MiscHelper::timeSince($job->posted_date) }}</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-body jdcarc">
                        <div class="mb-1">
                            <h4 class="mb-3 text-green-color ">Job Description</h4>
                            <div class="jobdesbcontar">{!! $job->description !!}</div>
                        </div>
                    </div>
                    @if(!empty($job->additional_description))
                    <div class="card-body jdcarc">
                        <div class="mb-1">
                            <h4 class="mb-3 text-green-color ">Required Candidate Profile</h4>
                            <div>{!! $job->additional_description !!}</div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="card-body jdcarc">
                        <div class="mb-1">
                            <h4 class="mb-2 text-green-color ">Skills</h4>
                            <div>
                                @php
                                    $skillarr = $job->skill?array_column(json_decode($job->skill), 'value'):null;
                                @endphp
                                @foreach($skillarr as $t)
                                    <label class="chip clickable"><span>{{$t}}</span></label>
                                @endforeach
                                {{-- <label class="chip clickable"><span>MySQL</span></label>
                                <label class="chip clickable"><span>MySQL</span></label>
                                <label class="chip clickable"><span>MySQL</span></label> --}}
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body jdcarc">
                        <div class="mb-3">
                            <h4 class="mb-1 text-green-color ">Education</h4>
                            <div><p class="jejed">{{$job->educationLevel->education_level??'Any Degree'}} @if($job->is_any_education_level !='yes' && $job->is_any_education=='yes') - (Any) @endif</p></div>
                            <div class="jejedtype">@if($job->is_any_education!='yes') <li class="mb-2">Specialization : {{ $job->getEducationTypesStr() }} </li>@endif</div>
                        </div>
                    </div>

                    <div class="card-body jdcarc">
                        <div class="mb-3">
                            <h4 class="mb-1 text-green-color ">Job Type</h4>
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
                        <div class="mb-3">
                            <h4 class="mb-1 text-green-color ">Job Shift</h4>
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
                        <div class="mb-3">
                            <h4 class="mb-1 text-green-color ">Cash Benefits</h4>
                            <div><p>{{ rtrim($job->benefits,', ') }}</p></div>
                        </div>
                        @endif
                        @if(!empty($job->supplementals))
                        <div class="mb-3">
                            <h4 class="mb-1 text-green-color ">Supplemental Pay</h4>
                            <div><p>{{ rtrim($job->supplementals,', ') }}</p></div>
                        </div>
                        @endif
                        @if(!empty($job->other_benefits))
                        <div class="mb-3">
                            <h4 class="mb-1 text-green-color ">Other Benefits</h4>
                            <div><p>{{ rtrim($job->other_benefits,', ') }}</p></div>
                        </div>
                        @endif
                    </div>
                    @endif

                    @if($job->walkin)
                    <div class="card-body jdcarc">
                        <div class="mb-3">
                            <h4 class="mb-1  text-green-color">@if($job->walkin) Walk-In @else Contact Details @endif</h4>
                            <div class="row">
                                @if($job->walkin)
                                <div>
                                    <p><b>From </b>{{ \Carbon\Carbon::parse($job->walkin->walk_in_from_date)->format('d F, Y')}} to {{ \Carbon\Carbon::parse($job->walkin->walk_in_to_date)->format('d F, Y')}}.@if($job->walkin->exclude_days) (Excluding {{$job->walkin->exclude_days}})@endif</p>
                                    <p><b>Time between : </b>{{ \Carbon\Carbon::parse($job->walkin->walk_in_from_time)->format('H:i A')}} to {{ \Carbon\Carbon::parse($job->walkin->walk_in_to_time)->format('H:i A')}}</p>
                                </div>
                                @endif
                                <div class="col-md-12 align-self-center d-flex">
                                    <div class="pe-1">
                                        <img class="image-size" src="{{url('site_assets_1/assets/img/job_description/contact_location.png')}}" alt="contact location">
                                    </div>
                                    <div>
                                        <p class="">
                                            @if(isset($job->walkin->walk_in_location) && !empty($job->walkin->walk_in_location))
                                                {{$job->walkin->walk_in_location}}
                                            @endif
                                        </p>
                                        <p class="">
                                            @if(isset($job->walkin->walk_in_google_map_url) && !empty($job->walkin->walk_in_google_map_url))
                                                <b>Google Map URL :</b> {{$job->walkin->walk_in_google_map_url}}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                    </div>
                    @endif
                    
                    @if($job->contact_person_details && $job->company->is_admin==0)
                    <div class="card-body jdcarc">
                        <div class="mb-1">
                            <div class="mb-2">
                                <h4 class=" text-green-color">Contact Details</h4>
                            </div>
                            <div class="mb-2 row col-md-12 justify-content-between">                                
                                <div class="col-md-12 align-self-center d-flex">
                                    <div class="pe-1">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div>
                                        <h5 class="">
                                           <a>{{ $job->contact_person_details->name??'' }}</a>
                                        </h5>    
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2 row col-md-12 justify-content-between">                                
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
                                            <text class="">Send Message</text> 
                                        </div>   
                                    </div> --}}
                                {{-- </div> --}}
                            </div>
                            
                            <div class="d-flex justify-content-between" style="display: @if( ($job->contact_person_details->morning_section_from && $job->contact_person_details->morning_section_to)||($job->contact_person_details->evening_section_from && $job->contact_person_details->evening_section_to)){{'block'}}@else{{'none !important;'}}@endif">
                                <h4 class=" text-green-color">Best time to contact</h4>
                                {{-- <button class="edit-btn" data-form="job-contact-person-edit"><i class="fa-solid fa-pen-to-square text-green-color edit-icon"></i></button> --}}
                            </div>
                            <div class="row">                                
                                <div class="col-md-10 align-self-center d-flex">
                                    <div>
                                        @if( ($job->contact_person_details->morning_section_from && $job->contact_person_details->morning_section_to))
                                        <p class="jbbesttc_m">
                                            {{ \Carbon\Carbon::parse($job->contact_person_details->morning_section_from)->format('h:i A')}} to
                                            {{ \Carbon\Carbon::parse($job->contact_person_details->morning_section_to)->format('h:i A') }}
                                        </p>
                                        @endif
                                        @if( ($job->contact_person_details->evening_section_from && $job->contact_person_details->evening_section_to))
                                        <p class="jbbesttc_e">
                                            {{ \Carbon\Carbon::parse($job->contact_person_details->evening_section_from)->format('h:i A') }} to 
                                            {{ \Carbon\Carbon::parse($job->contact_person_details->evening_section_to)->format('h:i A') }}
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="abt-cmp card-body jdcarc">
                        <div class="mb-2">
                            @if(!empty($job->company->description))
                            <div class="mb-4">
                                <h4 class="mb-1  text-green-color">About Company<h4>
                                <p>{{ $job->company->description }}</p>
                            </div>
                            @endif
                            
                            <div class="">
                                <h5 class="mb-1  text-green-color">Company Info</h5>
                                @isset($job->company->website_url)
                                <div class="row col-md-12 cmpinfo-detail mb-2">
                                    <div class="col-md-12">
                                        <label><b>Website : </b></label>
                                        <span>
                                            <a href="{{ $job->company->website_url}}" target="_blank" rel="nofollow noreferer">{{ $job->company->website_url}}</a>
                                        </span>
                                    </div>
                                </div>
                                @endisset

                                <div class="row col-md-12 cmpinfo-detail">
                                    <div class="col-md-6">
                                        @if($job->company->is_admin==0)
                                        <label class="fw-bold">Address :</label>
                                        <span>
                                            @php
                                                $pincode= $job->company->pin_code ?? '';
                                                $pincode= !empty($pincode)? ', '.$pincode.'.' : '';
                                            @endphp
                                            <text>{{ !empty($job->company->address) ? $job->company->address.' '.$job->company->location.$pincode : "-" }}</text>
                                        </span>
                                        @endif
                                    </div>
                                    @isset($job->company)
                                        @if($job->company->is_admin==0)
                                        <div class="col-md-6 align-self-center text-end">
                                            <a href="{{url('company-view/'.$job->company->slug)}}"><label class="chip clickable mt-0 cursor-pointer"><span>View More</span></label></a>                                 
                                        </div>
                                        @elseif(isset($job->reference_url))
                                        <div class="col-md-6 align-self-center text-end">
                                            <a href="{{url('company-view/'.$job->company->slug)}}"><label class="chip clickable mt-0 cursor-pointer"><span>View More</span></label></a>                                 
                                        </div>
                                        @endif
                                    @endisset

                                </div> 
                                
                                <hr>
                                <div class="sharethis-inline-share-buttons"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(0)
            <div class="col-md-3">
                <div class="card ">
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="row mb-3">
                                <h4 class=" text-green-color"> Related Jobs </h4>
                                <div class="">
                                    <article class="rjarti mt-2">
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <h5 class="">{{ ucwords($job->title) }}</h5>
                                            <div class="fw-bold">{{ ucwords($job->company_name??$job->company->name) }}.</div>
                                            <div class="py-2 ">
                                                <span class="">
                                                    <img class="" width="15px" src="{{ url('site_assets_1/assets/img/side_nav_icon/salary.png') }}"></span>
                                                <span class="" style="font-size: 13px"> 2808 - 28116 / Annum</span>
                                            </div>
                                        </div>
                                    </article>
                                    <article class="rjarti mt-2">
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <h5 class="">{{ ucwords($job->title) }}</h5>
                                            <div class="fw-bold">{{ ucwords($job->company_name??$job->company->name) }}.</div>
                                            <div class="py-2 ">
                                                <span class="">
                                                    <img class="" width="15px" src="{{ url('site_assets_1/assets/img/side_nav_icon/salary.png') }}"></span>
                                                <span class="" style="font-size: 13px"> 2808 - 28116 / Annum</span>
                                            </div>
                                        </div>
                                    </article>
                                    <article class="rjarti mt-2">
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <h5 class="">{{ ucwords($job->title) }}</h5>
                                            <div class="fw-bold">{{ ucwords($job->company_name??$job->company->name) }}.</div>
                                            <div class="py-2 ">
                                                <span class="">
                                                    <img class="" width="15px" src="{{ url('site_assets_1/assets/img/side_nav_icon/salary.png') }}"></span>
                                                <span class="" style="font-size: 13px"> 2808 - 28116 / Annum</span>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                
                            </div>
                            <div class="float-end">
                                <a href="#" class=""> View All</a>
                            </div>
                            
                        </div>
            
                    </div>
                </div>
            </div>
            @endif
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
    var reference_url = '{{ $job->reference_url }}';
    var is_admin = '{{ $job->company->is_admin }}';
    var applied = '{{ $applied }}';
    var baseurl = '{{ url("/") }}/';
    var is_login = '{{ Cookie::get("is_login") }}';
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
