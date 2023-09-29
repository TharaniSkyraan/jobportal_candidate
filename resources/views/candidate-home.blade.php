@extends('layouts.app')

@section('custom_scripts')
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/userbasic.w2fr4ha2.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/chpg.er23fw.css')}}" rel="stylesheet">
<link href="{{asset('css/main_2.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.8/slick.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.8/slick-theme.min.css">
@endsection
@section('content')
<style>
.carousel{
  width:95%;
  margin:0px auto;
}
.slick-slide{
  margin:10px;
}
.slick-slide img{
  /* width:100%;
  border: 2px solid #eee; */
  display: unset;
}
.slick-prev, .slick-next{
  color:#000;
}
.slick-prev:before, .slick-next:before{
  color:#000;
}
.slick-disabled {
  display: none !important;
}

.slick-prev:before ,
.slick-next:before {color: #d4d4d4 !important;font-size: 30px;}

</style>
@include('layouts.header')
@include('layouts.search_side_navbar')
    <div class="content">
        
        <div class="myprofile_sec">
            <!--alert profile-->
            @if(Auth::check())
                @if(Auth::user()->getProfilePercentage() < 80)
                    <div class="alert_prnt">
                        <div class="alert pfcmpletalert alert-dismissible fade show" role="alert">
                            <div class="row">
                                <div class="col-2 wrning text-center">
                                    <img draggable="false" src="{{ asset('images/warning.png')}}">
                                </div>
                                <div class="col-9 align-self-center">
                                    <span>Increase your profile visibility to recruiters by completing your profile</span>
                                </div>
                                <div class="col-1 align-self-center">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    </div> 
                @endif
            @endif
        </div>

        <section id="homepage_stn">

            <div class="hme_banner">
                <div class="text-center pt-5">
                    <h1>Begin your <br/><strong class="fw-bolder">Dream career.</strong></h1>
                    <h3>
                       <span class="fw-lighter"> 1000+ Jobs posted all over the world </span><br/>
                        <strong class="fw-bolder">Opportunities waiting for your successfull start</strong> 
                    </h3>
                </div>
                <div class="search_hme ">
                    <div class="card bg-primary sarchtopcrad">
                        <div class="row">
                            <div class="col-xl-5 col-md-5 col-lg-5 col-sm-5 col-10 align-self-center designation p-0 m-0">
                                {!! Form::search('designation', null, array('class'=>'form-control-2  typeahead', 'autocomplete'=>'off', 'id'=>'designation', 'data-mdb-toggle'=>"tooltip", 'data-mdb-placement'=>"left", 'title'=>"Designation required",
                                'placeholder'=>__('Job title, keywords or company'), 'spellcheck'=>'false' ) ) !!}
                            </div>
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 p-0 m-0 pre-d align-self-center"><span class="pre">|</span></div>
                            <div class="col-xl-5 col-md-5 col-lg-5 col-sm-5 col-5 align-self-center location p-0 m-0">
                                {!! Form::search('location', null, array('class'=>'form-control-2 typeahead', 'id'=>'location', 'autocomplete'=>'off','placeholder'=>__('On Location'),' aria-label'=>'On Location')) !!}
                            </div>
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-2 align-self-center p-0 m-0">                    
                                <button class='btn btn_c_se form-control px-0' id='msearch_btn'>
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $cacheData = Cookie::has('searchJobs') ? json_decode(Cookie::get('searchJobs')):array(); 
                $cachedatas = array_reverse($cacheData); 
            @endphp
            <div class="popular_recent_src_hme">
                @if(count($cachedatas)!=0)
                    <div class="reserch text-center mt-3">
                        <div class="container">
                            <h3 class="ps-2 mb-4">RECENT SEARCHES</h3>
                            @forelse($cachedatas as $key => $search)
                                @if($key < 3 && ($search->designation !='' || $search->location !='')  )
                                    <label class="cursor-pointer resentsearch plerhvr titsearch px-2 mx-1 py-1 mt-1 border border-1 rounded-pill shadow-sm" data-d="{{$search->designation}}" data-l="{{$search->location}}">
                                        <span class="">
                                            <img src="{{ asset('images/home/search-icon.png') }}">
                                        </span>
                                        <span class="">{{$search->designation}} {{$search->location}}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif   

                <div class="container">
                    <div class="popularser_card mt-4 text-center">
                        <h3 class="ps-2 mb-4">POPULAR JOB</h3>
                        @forelse($titles as $title)
                        <label class="cursor-pointer resentsearch plerhvr titsearch border border-1 rounded-pill shadow-sm" data-d="{{$title->title}}" data-l="">
                            <span class="">
                                <i class="fa fa-hand-pointer-o pe-1" aria-hidden="true"></i>
                            </span>
                            <span class="">{{$title->title}}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="candidate_img text-center mt-5">
                    <div class="container">
                        <div class="candimg_parent">
                            <div class="row candimg_col">
                                <h3 class="mb-5">EASY TO FIND JOBS IN <strong>”3 SIMPLE STEPS”</strong></h3>
                                <div class="col-md col-lg align-self-center">
                                    <div class="mobile_bnr">
                                        <div class="row">
                                            <div class="col-4 text-end align-self-center col-lg">
                                                <img draggable="false" src="{{asset('images/create_profile.png')}}">
                                            </div>
                                            <div class="col-8 col-lg">
                                                <h2 class="fw-bolder mt-2">Create Profile</h2>
                                                <p>Flow simple steps to create your profile</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="system_vw">
                                        <img draggable="false" src="{{asset('images/create_profile.png')}}">
                                        <h2 class="fw-bolder mt-2">Create Profile</h2>
                                        <p>Flow simple steps to create your profile</p>
                                    </div>
                                </div>
                                <div class="col-md arrow align-self-center">
                                    <img draggable="false" src="{{asset('images/home_arrow.png')}}">
                                </div>                                  
                                <div class="col-md">
                                    <div class="mobile_bnr">
                                        <div class="row">
                                            <div class="col-4 mbalgnsl text-end align-self-center col-lg">
                                                <img draggable="false" src="{{asset('images/provode_info.png')}}">
                                            </div>
                                            <div class="col-8 col-lg">
                                                <h2 class="fw-bolder mt-2">Provide the Required Info</h2>
                                                <p>Your profile completeness is like your first introduction to the job.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="system_vw">
                                        <img draggable="false" src="{{asset('images/provode_info.png')}}">
                                        <h2 class="fw-bolder mt-2">Provide the Required Info</h2>
                                        <p>Your profile completeness is like your first introduction to the job.</p>
                                    </div>
                                </div>
                                <div class="col-md arrow align-self-center">
                                    <img draggable="false" src="{{asset('images/home_arrow.png')}}">
                                </div> 
                                <div class="col-md align-self-center">
                                    <div class="mobile_bnr">
                                        <div class="row">
                                            <div class="col-4 text-end align-self-center col-lg">
                                                <img draggable="false" src="{{asset('images/explore_opportunities.png')}}">
                                            </div>
                                            <div class="col-8 col-lg">
                                                <h2 class="fw-bolder mt-2">Explore your Opportunities</h2>
                                                <p>find more jobs, more Resumes in no time.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="system_vw">
                                        <img draggable="false" src="{{asset('images/explore_opportunities.png')}}">
                                        <h2 class="fw-bolder mt-2">Explore your Opportunities</h2>
                                        <p>find more jobs, more Resumes in no time.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nearbyjob">
                <div class="container">
                    <div class="hmenear_job mt-5">
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <h1>Jobs near you</h1>
                                <h2>{{$ip_data['city']??''}}</h2>
                            </div>
                            <div class="col-md-6 col-6 text-end align-self-end">
                                <i id="passbtn" class="far fa-arrow-alt-circle-right cursor-pointer"></i>
                            </div>
                        </div>
                        <hr class="mt-1 mb-3"/>
                        
                        @if(count($near_job)!=0)
                        <h3 class="mb-3 fw-bold mt-3">Top job posts</h3>
                        <div class="carousel">
                            @foreach($near_job as $near)
                            <div class="card p-4 hm_gr cursor-pointer jobsearch">
                                <h3 class="jobsearchtitle"><img src="{{asset('site_assets_1/assets/img/side_nav_icon/title.png')}}"width="7px" class="me-2 ms-1" draggable="false" alt=""> {{$near->title}}</h3>
                                <p><img src="{{asset('site_assets_1/assets/img/side_nav_icon/industry.png')}}" class="image-size" draggable="false" alt=""> {{$near->company_name}}</p>
                            </div>  
                            {{-- <div class="card p-4 hm_gr cursor-pointer jobsearch">
                                <h3 class="jobsearchtitle">{{$near->title}}</h3>
                                <p>{{$near->company_name}}</p>
                            </div> --}}
                            @endforeach
                        </div>
                        @endif

                        @if(count($recent_job)!=0)
                            <div class="mt-3">
                                <h3 class="mb-3 fw-bold">Recent posts</h3>
                                <div class="carousel">
                                    @foreach($recent_job as $recent)
                                        <div class="card p-4 hm_gy cursor-pointer">
                                            <a href="{{url('detail',$recent->slug)}}" class="text-dark">
                                                <h3><img src="{{asset('site_assets_1/assets/img/side_nav_icon/title.png')}}" width="7px" class="me-2 ms-1" draggable="false" alt=""> {{$recent->title}}</h3>
                                                <p><img src="{{asset('site_assets_1/assets/img/side_nav_icon/industry.png')}}" class="image-size" draggable="false" alt=""> {{$recent->company_name}}</p>
                                                <p><img src="{{asset('site_assets_1/assets/img/side_nav_icon/experience.png')}}" class="image-size" draggable="false" alt=""> {{$recent->experience_string}}</p>
                                                <p><img src="{{asset('site_assets_1/assets/img/side_nav_icon/location.png')}}" class="image-size" draggable="false" alt=""> {{$recent->location}}</p>
                                                <p><img src="{{asset('site_assets_1/assets/img/side_nav_icon/salary.png')}}" class="image-size" draggable="false" alt=""> {{$recent->salary_string}}</p>
                                            </a> 
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="container">
                    <div class="home_pgecities mt-5">
                        <div class="row">
                            <div class="home_pgecities cities">
                                <div class="card-body wizard-tab">
                                    <!-- Nav tabs -->
                                    <h2 class="mb-3 mt-3 text-center fw-bolder">TOP</h2>
                                    <ul class="nav nav-tabs justify-content-around" id="candiftabs" role="tablist">
                                        @if(count($job_list)!=0)
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="received-tab" data-bs-toggle="tab" data-bs-target="#topjoblistings" type="button" role="tab" aria-controls="received" aria-selected="true"> JOB LISTINGS</button>
                                        </li>  
                                        @endif
                                        @if(count($top_cities)!=0)
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link @if(count($job_list)==0) active @endif" id="suggested-tab" data-bs-toggle="tab" data-bs-target="#topcities" type="button" role="tab" aria-controls="suggested" aria-selected="false">CITIES</button>
                                        </li>
                                        @endif
                                        @if(count($top_sector)!=0)
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link @if(count($job_list)==0 && count($top_cities)==0) active @endif" id="shortlisted-tab" data-bs-toggle="tab" data-bs-target="#topjobsector" type="button" role="tab" aria-controls="shortlisted" aria-selected="false">JOB SECTORS</button>
                                        </li>
                                        @endif
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content mt-3">
                                        @if(count($job_list)!=0)
                                            <div class="tab-pane active" id="topjoblistings" role="tabpanel" aria-labelledby="received-tab">
                                                <div class="caconsection-disabl" id="received-c">
                                                    <div class="card-body candpcard" data-id="10" data-appstatus="view">
                                                        <div class="carousel-top">
                                                            @foreach($job_list as $joblist)
                                                                <div class="card hm_grn cursor-pointer jobsearch">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <h3 class="fw-bolder">{{$joblist->title}}</h3>
                                                                            <p>{{$joblist->total_count}} + jobs</p>
                                                                        </div>
                                                                        <div class="col-4 d-flex justify-content-center">
                                                                            <p>&nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"></i></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>                                         
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if(count($top_cities)!=0)
                                            <div class="tab-pane @if(count($job_list)==0) active @endif" id="topcities" role="tabpanel" aria-labelledby="suggested-tab">
                                                <div class="caconsection-disabl" id="suggested-c">
                                                    <div class="card-body candpcard" data-id="10" data-appstatus="view">
                                                        <div class="carousel-top">
                                                        @foreach($top_cities as $cities)
                                                            <div class="card hm_grn cursor-pointer topcities">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <h3 class="fw-bolder city">{{$cities->city}}</h3>
                                                                        <p>{{$cities->total_count}} + jobs</p>
                                                                    </div>
                                                                    <div class="col-6 d-flex align-items-center justify-content-center">
                                                                        <h5>View all</h5>
                                                                        <p class="align-items-center justify-content-center d-flex">&nbsp;&nbsp;&nbsp;<i class="far fa-arrow-alt-circle-right"></i></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        </div>                                                  
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if(count($top_sector)!=0)
                                            <div class="tab-pane @if(count($job_list)==0 && count($top_cities)==0) active @endif" id="topjobsector" role="tabpanel" aria-labelledby="shortlisted-tab">
                                                <div class="caconsection-disabl" id="shortlisted-c">
                                                    <div class="card-body candpcard" data-id="10" data-appstatus="view">
                                                        <div class="carousel-top">
                                                            @foreach($top_sector as $sector)
                                                                <div class="card hm_grn cursor-pointer topsector">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <img draggable="false" src="{{url('images/hme_designing.png')}}" width="100%">
                                                                        </div>
                                                                        <div class="col-8 align-self-center">
                                                                            <h3 class="fw-bolder sector">{{$sector->industry}}</h3>
                                                                            <p>{{$sector->jobsearch_count}} + jobs
                                                                            <div class="test22"><i class="fas fa-angle-right"></i></div>
                                                                            </p>
                                                                        </div>                                                                    
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="hme_blogsectn mb-5">
                <div class="container">
                    <h2 class="fw-bolder mb-4">Blog</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <img draggable="false" src="{{asset('images/homepg_advance.webp')}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="fw-bolder">Plan your Work in advance</p>
                                    <p class="card-text text-truncate">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s...</p>
                                    <p class="hm_post">posted 18/10/2022</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <img draggable="false" src="{{asset('images/homepg_work.webp')}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="fw-bolder">Tired of Work</p>
                                    <p class="card-text text-truncate">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s...</p>
                                    <p class="hm_post">posted 18/10/2022</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <img draggable="false" src="{{asset('images/homepg_employee.webp')}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="fw-bolder">How To face your fellow employess</p>
                                    <p class="card-text text-truncate">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s...</p>
                                    <p class="hm_post">posted 18/10/2022</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </section>
    </div>
    <script type="text/javascript">   
        var baseurl = '{{ url("/") }}/';
        var current_city = "{{$ip_data['city']??''}}";
        
        var path1 = '{{ url("api/autocomplete/search_designation") }}';
        var path = '{{ url("api/autocomplete/search_location") }}';
        $(document).ready(function(){
            $('.carousel').slick({
                slidesToShow: 3,
                // slidesToScroll: 3,
                infinite: false,
                // dots:true,
                // centerMode: true,
                responsive: [
                    {
                        breakpoint: 1000,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 575,
                        settings: {
                            slidesToShow: 1,
                        }
                    }                
                ]
            });   
            $('.carousel-top').slick({
                slidesToShow: 4,
                // slidesToScroll: 3,
                infinite: false,
                // dots:true,
                // centerMode: true,
                responsive: [
                    {
                        breakpoint: 1000,
                        settings: {
                            slidesToShow: 4,
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 575,
                        settings: {
                            slidesToShow: 1,
                        }
                    }                
                ]
            });
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                $('.carousel-top').slick('setPosition');
            });
            
        });
   </script>
    
@endsection

@section('footer')
    @include('layouts.footer')
@endsection

@section('custom_bottom_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" integrity="sha512-HWlJyU4ut5HkEj0QsK/IxBCY55n5ZpskyjVlAoV9Z7XQwwkqXoYdCIC93/htL3Gu5H3R4an/S0h2NXfbZk3g7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/1a9ve2/js/chpag.fquiv23.js') }}"></script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/js/searchsidenavbarscript.js') }}"></script>
{{-- <script rel="text/javascript" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> --}}
<script rel="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.8/slick.min.js"></script>
@endsection
