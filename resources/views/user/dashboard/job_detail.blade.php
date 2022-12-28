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
                                <div class="cmpinfo-detail"><label><b>Address</b></label>
                                    <span>{{ !empty($job->company->address) ? $job->company->address.' '.$job->company->location.$pincode : "-" }}</span>
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
<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=6315c4c30b5e930012a9c49e&product=inline-share-buttons' async='async'></script>

@endsection
