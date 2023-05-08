@extends('layouts.app')

@section('custom_scripts')
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/userbasic.w2fr4ha2.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/chpg.er23fw.css')}}" rel="stylesheet">
<link href="{{asset('css/main_2.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
@section('content')
    
@include('layouts.header')

<style>
.hme_banner{
    background: url('{{asset('images/candidate_hpg.png')}}');
    background-size: cover;
    padding-bottom: 75px;
    background-repeat:no-repeat;
   
}

.candidate_img{
   background:url('{{asset('images/candidate_hpg_bg.png')}}');
    background-repeat: no-repeat;
    background-size: cover;
    padding-bottom: 110px;
    background-position: center;

}

@media(min-width: 280px) and (max-width: 767px)  {
    .candidate_img{
        background: url('{{asset('images/responsive_hpg_bg_infinity.png')}}');
        background-repeat: no-repeat !important;
        background-size: contain;
        background-position: center;
        width:100%;
        padding-bottom: 0px;

    }
}

.location .typeahead.dropdown-menu, .designation .typeahead.dropdown-menu{
    max-height: 188px !important;
    overflow: auto;
    display: block;         
    width: -webkit-fill-available;
    top: unset !important;
    left: unset !important;
}
    
@media (min-width: 768px) and (max-width: 1399px) {
    .designation .typeahead.dropdown-menu{
        margin-right: 59% !important;
    }
}

    
@media (min-width: 768px) and (max-width: 991px) {
    .location .typeahead.dropdown-menu{
        margin-right: 22% !important;
    }
}
@media (min-width: 992px) and (max-width: 1199px) {
    .location .typeahead.dropdown-menu{
        margin-right: 20.5% !important;
    }
}
@media (min-width: 1200px) and (max-width: 1399px) {
    .location .typeahead.dropdown-menu{
        margin-right: 19.8% !important;
    }
}
@media only screen and (max-width: 767px) {
    /* CSS rules for phones */
    .location .typeahead.dropdown-menu, .designation .typeahead.dropdown-menu{
        margin-right: 25px !important;
    }
    .location .typeahead.dropdown-menu{
        top: 120px !important;
    }
}

</style>
<!-- <div class="main-panel main-panel-custom"> -->
    <div class="content">
        
        <div class="page-inner myprofile_sec">
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session()->get('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

            
        <section id="homepage_stn">        

            <div class="container">
                <div class="hme_banner">
                    <div class="row">
                        <div class="col-md-5 col-6 col-lg-5 mobile_bnr align-self-center">

                            <img src="{{url('images/responsive_hpg_mobile.png')}}" alt="" width="100%">

                        </div>
                        <div class="col-md-4  col-6 col-lg-4  align-self-center">
                            <h1 class="mt-5">Begin your <br/><strong class="fw-bolder">Dream career.</strong></h1>

                            <p>
                                1000+ Jobs posted all over the world
                                <strong class="fw-bolder">Opportunities</strong>  waiting for your successfull start
                            </p>
                        </div>

                        <div class="col-md-2"></div>
                    </div>
                </div>
                

                <div class="search_hme mt-5">
                    <div class="card p-5 bg-primary">
                        <div class="row">
                        
                            <div class="col-md-5 designation">
                                {!! Form::search('designation', null, array('class'=>'form-control-2  typeahead', 'id'=>'designation',
                                'placeholder'=>__('Job title, keywords or company'),  'autocomplete'=>'off', 'spellcheck'=>'false' ) ) !!}
                                <span class="form-text text-white err_msg designation-error"></span>
                            </div>
                            <div class="col-md-5 location">
                                {!! Form::search('location', null, array('class'=>'form-control-2 typeahead', 'autocomplete'=>'off', 'id'=>'location', 'placeholder'=>__('On Location'),' aria-label'=>'On Location')) !!}
                                <span class="form-text text-white err_msg"></span>                        
                            </div>
                            <div class="col-md-2">
                                {!! Form::button('Search', array('class' => 'btn btn-success form-control ','id'=>'msearch_btn', 'type' => 'submit')) !!}                   
                            </div>
                        </div>
                    </div>
                
                    @php
                        $cacheData = Cookie::has('searchJobs') ? json_decode(Cookie::get('searchJobs')):array(); 
                        $cachedatas = array_reverse($cacheData); 
                    @endphp
                    @if(count($cachedatas)!=0)
                    <div class="content hometabcndte">
                        <ul class="nav nav-tabs" id="candsearchs" role="tablist">
                            <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="received-tab" data-bs-toggle="tab" data-bs-target="#popularsearch" type="button" role="tab" aria-controls="received" aria-selected="true">Popular searches</button>
                            </li>
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="suggested-tab" data-bs-toggle="tab" data-bs-target="#recentsearch" type="button" role="tab" aria-controls="suggested" aria-selected="false">Recent searches</button>
                            </li>
                        </ul>
                    </div>
                    @endif
                        
                    @if(1)
                    <div class="tab-content home_searchstab" id="pills-applied-jobs-list">
                        <div class="tab-pane active" id="popularsearch" role="tabpanel" aria-labelledby="popularsearch-tab">
                            <div class="popularser_hme mt-5">
                                <div class="row">
                                @forelse($titles as $title)
                                    <div class="col-md-4 col-lg-3 col-12">
                                        <div class="list_poplar cursor-pointer">
                                            <div class="resentsearch plerhvr titsearch" data-d="{{$title->title}}" data-l="">
                                                <div class="row">
                                                    <div class="col-10 text-start">{{$title->title}}</div>
                                                    <div class="col-2 text-end"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                        No data available
                                @endforelse
                                </div>
                            </div>
                        </div>

                        @if(count($cachedatas)!=0)
                        <div class="tab-pane" id="recentsearch" role="tabpanel" aria-labelledby="recentsearch-tab">
                            <div class="popularser_hme mt-5">
                                <div class="row">

                                @forelse($cachedatas as $key => $search)
                                    @if($key < 5 && ($search->designation !='' || $search->location !='')  )
                                    <div class="col-md-4 col-lg-3 col-12">
                                        <div class="list_poplar cursor-pointer">
                                            <div class="resentsearch plerhvr titsearch" data-d="{{$search->designation}}" data-l="{{$search->location}}">
                                                <div class="row">
                                                    <div class="col-10 text-start">{{$search->designation}} {{$search->location}}</div>
                                                    <div class="col-2 text-end align-self-center">
                                                        <i class="fa fa-history" aria-hidden="true"></i>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @empty
                                <div class="mb-5">  
                                    <text>No search till now</text>
                                </div>
                                @endforelse     
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    <div class="candidate_img text-center mt-5">
                        <div class="container">
                            <div class="candimg_parent">
                                <div class="row candimg_col">
                                    <div class="col-md col-lg align-self-center">
                                        <div class="mobile_bnr">
                                            <div class="row">
                                                <div class="col-4 text-end align-self-center col-lg">
                                                    <img src="{{asset('images/create_profile.png')}}">
                                                </div>
                                                <div class="col-8 col-lg">
                                                    <h2 class="fw-bolder mt-2">Create Profile</h2>
                                                    <p>Flow simple steps to create your profile</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="system_vw">
                                            <img src="{{asset('images/create_profile.png')}}">
                                            <h2 class="fw-bolder mt-2">Create Profile</h2>
                                            <p>Flow simple steps to create your profile</p>
                                        </div>
                                    </div>

                                    <div class="col-md arrow align-self-center">
                                        <img src="{{asset('images/home_arrow.png')}}">
                                    </div>  
                                        
                                    <div class="col-md">
                                        <div class="mobile_bnr">
                                            <div class="row">
                                                <div class="col-4 mbalgnsl text-end align-self-center col-lg">
                                                    <img src="{{asset('images/provode_info.png')}}">
                                                </div>
                                                <div class="col-8 col-lg">
                                                    <h2 class="fw-bolder mt-2">Provide the Required Info</h2>
                                                    <p>Your profile completeness is like your first introduction to the job.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="system_vw">
                                            <img src="{{asset('images/provode_info.png')}}">
                                            <h2 class="fw-bolder mt-2">Provide the Required Info</h2>
                                            <p>Your profile completeness is like your first introduction to the job.</p>
                                        </div>
                                    </div>
                                    <div class="col-md arrow align-self-center">
                                        <img src="{{asset('images/home_arrow.png')}}">
                                    </div>  
                                

                                    <div class="col-md align-self-center">
                                        <div class="mobile_bnr">
                                            <div class="row">
                                                <div class="col-4 text-end align-self-center col-lg">
                                                    <img src="{{asset('images/explore_opportunities.png')}}">
                                                </div>
                                                <div class="col-8 col-lg">
                                                    <h2 class="fw-bolder mt-2">Explore your Opportunities</h2>
                                                    <p>find more jobs, more Resumes in no time.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="system_vw">
                                            <img src="{{asset('images/explore_opportunities.png')}}">
                                            <h2 class="fw-bolder mt-2">Explore your Opportunities</h2>
                                            <p>find more jobs, more Resumes in no time.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    <div class="hmenear_job mt-5">
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <h2 class="fw-bolder">Jobs near you</h2>
                                <h2 class="fw-bolder">{{$ip_data['city']??''}}</h2>
                            </div>
                            <div class="col-md-6 col-6 text-end align-self-end">
                                <i id="passbtn" class="far fa-arrow-alt-circle-right cursor-pointer"></i>
                            </div>
                            <hr class="mt-1 mb-3"/>
                            
                            @if(count($near_job)!=0)
                                <div class="row">
                                    <h3 class="mb-3 fw-bold mt-3">Top job posts</h3>
                                    @foreach($near_job as $near)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card p-4 hm_gr cursor-pointer jobsearch">
                                                <h3 class="fw-bolder">{{$near->title}}</h3>
                                                <p>{{$near->company_name}}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if(count($recent_job)!=0)
                                <div class="row mt-3">
                                    <h3 class="mb-3 fw-bold">Recent posts</h3>
                                    @foreach($recent_job as $recent)
                                        <div class="col-md-6 col-lg-4">
                                            <a href="{{url('detail',$recent->slug)}}" class="text-dark">
                                                <div class="card p-4 hm_gy cursor-pointer">
                                                    <h3 class="fw-bolder">{{$recent->title}}</h3>
                                                    <p>{{$recent->company_name}}</p>
                                                    <p>Experience: {{$recent->experience_string}}</p>
                                                    <p>Salary: {{$recent->salary_string}}</p>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="home_pgecities mt-5">
                        <div class="row">
                            <div class="home_pgecities cities">
                                <div class="card-body wizard-tab">

                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs justify-content-between" id="candiftabs" role="tablist">
                                        @if(count($job_list)!=0)
                                        <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="received-tab" data-bs-toggle="tab" data-bs-target="#topjoblistings" type="button" role="tab" aria-controls="received" aria-selected="true">TOP JOB LISTINGS</button>
                                        </li>
                                        @endif
                                        <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="suggested-tab" data-bs-toggle="tab" data-bs-target="#topcities" type="button" role="tab" aria-controls="suggested" aria-selected="false">TOP CITIES</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="shortlisted-tab" data-bs-toggle="tab" data-bs-target="#topjobsector" type="button" role="tab" aria-controls="shortlisted" aria-selected="false">TOP JOB SECTORS</button>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content mt-5">
                                        @if(count($job_list)!=0)
                                        <div class="tab-pane active" id="topjoblistings" role="tabpanel" aria-labelledby="received-tab">
                                            <div class="caconsection-disabl" id="received-c">
                                                <div class="card-body candpcard" data-id="10" data-appstatus="view">
                                                    <div class="row">
                                                    @foreach($job_list as $joblist)
                                                        <div class="col-md-6 col-sm-6 col-lg-3 col-xs-6">
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
                                                        </div>
                                                        @endforeach
                                                    </div>                                         
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="tab-pane" id="topcities" role="tabpanel" aria-labelledby="suggested-tab">
                                            <div class="caconsection-disabl" id="suggested-c">
                                                <div class="card-body candpcard" data-id="10" data-appstatus="view">
                                                    <div class="row">
                                                    @foreach($top_cities as $cities)
                                                        <div class="col-md-6 col-sm-6 col-lg-3 col-xs-6">
                                                            <div class="card hm_grn cursor-pointer topcities">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <h3 class="fw-bolder">{{$cities->city}}</h3>
                                                                        <p>{{$cities->total_count}} + jobs</p>
                                                                    </div>
                                                                    <div class="col-6 d-flex align-items-center justify-content-center">
                                                                        <h5>View all</h5>
                                                                        <p class="align-items-center justify-content-center d-flex">&nbsp;&nbsp;&nbsp;<i class="far fa-arrow-alt-circle-right"></i></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    </div>                                                  
                                                </div>
                                            </div>
                                        </div>
                                    

                                        <div class="tab-pane" id="topjobsector" role="tabpanel" aria-labelledby="shortlisted-tab">
                                            <div class="caconsection-disabl" id="shortlisted-c">
                                                <div class="card-body candpcard" data-id="10" data-appstatus="view">
                                                    <div class="row">
                                                        @foreach($top_sector as $sector)
                                                        <div class="col-md-6 col-sm-6 col-lg-3 col-xs-6">
                                                            <div class="card hm_grn cursor-pointer topcities">
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <img src="{{url('images/hme_designing.png')}}" width="100%">
                                                                    </div>
                                                                    <div class="col-8 align-self-center">
                                                                        <h3 class="fw-bolder">{{$sector->industry}}</h3>
                                                                        <p>{{$sector->jobsearch_count}} + jobs
                                                                        <div class="test22"><i class="fas fa-angle-right"></i></div>
                                                                        </p>
                                                                        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>                                                       
                                                </div>
                                            </div>
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
                                    <img src="{{asset('images/homepg_advance.webp')}}" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <p class="fw-bolder">Plan your Work in advance</p>
                                        <p class="card-text text-truncate">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s...</p>
                                        <p class="hm_post">posted 18/10/2022</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <img src="{{asset('images/homepg_work.webp')}}" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <p class="fw-bolder">Tired of Work</p>
                                        <p class="card-text text-truncate">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s...</p>
                                        <p class="hm_post">posted 18/10/2022</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <img src="{{asset('images/homepg_employee.webp')}}" class="card-img-top" alt="...">
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
            </div>
        </section>
    </div>

            

<script type="text/javascript">   
    var baseurl = '{{ url("/") }}/';
    var current_city = "{{$ip_data['city']??''}}";
    
    var path1 = '{{ url("api/autocomplete/search_designation") }}';
    var path = '{{ url("api/autocomplete/search_location") }}';
</script>
{{-- @include('layouts.footer') --}}
@endsection

@section('footer')
    @include('layouts.footer')
@endsection

@section('custom_bottom_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" integrity="sha512-HWlJyU4ut5HkEj0QsK/IxBCY55n5ZpskyjVlAoV9Z7XQwwkqXoYdCIC93/htL3Gu5H3R4an/S0h2NXfbZk3g7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/1a9ve2/js/chpag.fquiv23.js') }}"></script>
@endsection
