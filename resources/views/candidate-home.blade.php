@extends('layouts.app')

@section('custom_scripts')
<link href="{{ asset('site_assets_1/assets/vendor/select2/select2.min.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('site_assets_1/assets/date_flatpicker/flatpickr.min.css')}}">
<script src="{{ asset('site_assets_1/assets/date_flatpicker/flatpickr.js')}}"></script>
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/userbasic.w2fr4ha2.css')}}" rel="stylesheet">
<script  type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/typehead/typeahead.bundle.js') }}"></script>
<link href="{{asset('css/main_2.css')}}" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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

    .page-inner{
        background:#fff;
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

    .pfcmpletalert .fa-warning{
        color: #f9e955;
        font-size: 40px;
    }

    .pfcmpletalert{
        background:#F6F6F6;
        width: 60%;
        margin: 0 auto;
        position: absolute;
        padding:0px;
        
        border-radius:13px;
        margin-top: 10px;
        box-shadow:1px 1px 14px 0 rgb(18 38 63 / 20%) !important;
    }

    .pfcmpletalert .wrning{
        background:#D0DEF5;
        height: 60px;
        clip-path: polygon(0% 0%, 0% 280%, 100% 0%);
        border-top-left-radius: 13px;
        border-bottom-left-radius:13px;
        align-items: center;
        justify-content: center;
        display: flex;
    }

    .alert_prnt{
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #exampleModal .modal-content{

        background:#f3f7fe;
    }


</style>
@endsection
@section('content')
    
@include('layouts.header')


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
        <!--alert profile-->
        <!-- <div class="alert_prnt">
            <div class="alert pfcmpletalert alert-dismissible fade show" role="alert">
                <div class="row">
                    <div class="col-2 wrning text-center">
                        <i class="fa fa-warning"></i>
                    </div>
                    <div class="col-10 align-self-center">
                        <span>Increase your profile visibility to recruiters by completing your profile</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div> -->

        <!-- Button trigger modal -->
        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Launch demo modal
        </button> -->

        <!-- Modal -->
        <!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <h1 class="fw-bolder">Hi Skyraan</h1>
                            <h3 class="fw-bolder">Your Profile Completion is</h3>
                        </div>

                        <div class="mx-auto mb-3 progressbar useraccountsetting cursor-pointer fw-bolder" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="--value: 87">    
                            87%                     
                        </div>

                        <div class="mb-4">
                            <span class="text-center align-items-center justify-content-center d-flex">Complete your profile minimum 50% to apply for Jobs</span>
                        </div>

                        <h2 class="text-center text-primary fw-bolder">COMPLETE NOW</h2>

                    </div>
                </div>
            </div>
        </div> -->


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
                    
                        <div class="col-md-5">
                            {!! Form::search('designation', null, array('class'=>'form-control-2  typeahead', 'id'=>'designation',
                            'placeholder'=>__('Job title, keywords or company'),  'autocomplete'=>'off', 'spellcheck'=>'false' ) ) !!}
                            <span class="form-text text-white err_msg designation-error"></span>
                        </div>
                        <div class="col-md-5">
                            {!! Form::search('location', null, array('class'=>'form-control-2 typeahead', 'id'=>'location', 'placeholder'=>__('On Location'),' aria-label'=>'On Location')) !!}
                            <span class="form-text text-white err_msg"></span>                        
                        </div>
                        <div class="col-md-2">
                            {!! Form::button('Search', array('class' => 'btn btn-success form-control ','id'=>'msearch_btn', 'type' => 'submit')) !!}                   
                        </div>
                    </div>
                </div>

    
            <!-- <p class="text-center fw-bolder align-items-center justify-content-center d-flex accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne">Recent searches &nbsp;</p>


                <div id="collapseOne" class="mt-4" data-bs-parent="#myAccordion">
                    <div class="card-body text-center">
                        <div class="recent_searches">
                            <a href="#"><img src="{{asset('images/search_img.png')}}" width="18px"> &nbsp;new</a>
                            <a href="#"><img src="{{asset('images/search_img.png')}}" width="18px"> &nbsp;hello,new</a>
                            <a href="#"><img src="{{asset('images/search_img.png')}}" width="18px"> &nbsp;developer</a>
                            <a href="#"><img src="{{asset('images/search_img.png')}}" width="18px"> &nbsp;software</a>

                        </div>
                        
                    </div>
                </div> -->


                <!-- @if(1)
                <div class="rectsear_hme">
                    <div class="row">
                        <div class="col rectsear_col">
                            <h3 class="mb-2 fw-bolder">Popular searches</h3>
                            @forelse($titles as $title)
                                <div>
                                    <p class="text-dark resentsearch cursor-pointer mb-1" data-d="{{$title->title}}" data-l="">{{$title->title}}</p>
                                </div>
                            @empty
                                No data available
                            @endforelse
                        </div>
                        
                        <div class="col rectsear_col">
                            <h3 class="mb-2 fw-bolder">Recent searchess</h3>

                            @php
                                $cacheData = Cookie::has('searchJobs') ? json_decode(Cookie::get('searchJobs')):array(); 
                                $cachedatas = array_reverse($cacheData); 
                            @endphp

                            @forelse($cachedatas as $key => $search)
                                @if($key < 5 && ($search->designation !='' || $search->location !='')  )
                                    <div class="mb-1">
                                        <p class="mb-1 resentsearch cursor-pointer" data-d="{{$search->designation}}" data-l="{{$search->location}}">{{$search->designation}} {{$search->location}}</p>
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
                @endif -->

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

                    <div class="tab-pane" id="recentsearch" role="tabpanel" aria-labelledby="recentsearch-tab">
                        <div class="popularser_hme mt-5">
                            <div class="row">
                            @php
                                $cacheData = Cookie::has('searchJobs') ? json_decode(Cookie::get('searchJobs')):array(); 
                                $cachedatas = array_reverse($cacheData); 
                            @endphp

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
                            <h2 class="fw-bolder">{{$ip_data->city??''}}</h2>
                        </div>
                        <div class="col-md-6 col-6 text-end align-self-end">
                            <i id="passbtn" class="far fa-arrow-alt-circle-right cursor-pointer"></i>
                        </div>
                        <hr class="mt-1 mb-3"/>
                        
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
                    </div>
                </div>

                <div class="home_pgecities mt-5">
                    <div class="row">
                        <div class="home_pgecities cities">
                            <div class="card-body wizard-tab">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs justify-content-between" id="candiftabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="received-tab" data-bs-toggle="tab" data-bs-target="#topjoblistings" type="button" role="tab" aria-controls="received" aria-selected="true">TOP JOB LISTINGS</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="suggested-tab" data-bs-toggle="tab" data-bs-target="#topcities" type="button" role="tab" aria-controls="suggested" aria-selected="false">TOP CITIES</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="shortlisted-tab" data-bs-toggle="tab" data-bs-target="#topjobsector" type="button" role="tab" aria-controls="shortlisted" aria-selected="false">TOP JOB SECTORS</button>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content mt-5">
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

        <div class="hme_blogsectn mb-5">
            <div class="container">
            <h2 class="fw-bolder mb-4">Blog</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <img src="{{asset('images/homepg_advance.jpg')}}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h3 class="fw-bolder">Plan your Work in advance</h3>
                                <p class="card-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s...</p>
                                <p class="hm_post">posted 18/10/2022</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <img src="{{asset('images/homepg_work.jpg')}}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h3 class="fw-bolder">Tired of Work</h3>
                                <p class="card-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s...</p>
                                <p class="hm_post">posted 18/10/2022</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <img src="{{asset('images/homepg_employee.jpg')}}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h3 class="fw-bolder">How To face your fellow employess</h3>
                                <p class="card-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s...</p>
                                <p class="hm_post">posted 18/10/2022</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

<script type="text/javascript">   

    $("#passbtn").click(function(){
        var data ="{{$ip_data->city??''}}";
    search('',data);
    });

    $('.titsearch').on('click', function(){
        var designation =  $(this).attr('data-d');
        var location =  $(this).attr('data-l');
        search(designation,location);
    });

    $(".jobsearch").click(function(){

        var location ="{{$ip_data->city??''}}";

        $div = $(this).parent("div");

        id = $div.attr("class");

        position = $div.find(".fw-bolder").text();

        search(position, location);

    });
  
    $(".topcities").click(function(){

        $div = $(this).parent("div");

        id = $div.attr("class");

        position = $div.find(".fw-bolder").text();

        search('', position);

    });

    document.onkeyup = enter;
    function enter(e) {
        if (e.which == 13) {
            var myElement = document.getElementById('designation');
            var myElement1 = document.getElementById('location');
            if(myElement === document.activeElement || myElement1 === document.activeElement){
                $('#msearch_btn').trigger('click');
            }
        }
    } 

    $('.resentsearch').on('click', function(){
    search($(this).data('d'),$(this).data('l'));
    });

    function search(d, l){
        $('#designation').css('border','1px solid lightgray');
        $('.err_msg').html('');
        if(d != '' || l !=''){      
            $.post("{{ route('job.checkkeywords') }}", {designation: d, location: l, _method: 'POST', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    var l = '';
                    var d = '';
                if(response.d !=''){
                    d = 'd='+response.d;
                }
                if(response.l !=''){
                    if(response.d !=''){
                        l += '&';
                    }
                    l += 'l='+response.l;
                }
                url = '{{ url("/") }}/';
                window.location = url+response.sl+'?'+d+l;
            });
        }else{
            $('.designation-error').html('Please enter title, keyword or company');
            $('#designation').css('border','1px solid #f25961');
        }
    }

    $('#designation').on('keyup', function(){
        $('#designation').css('border','1px solid lightgray');
    });

    $('#msearch_btn').on('click', function(){
        //myElement Has Focus
    search($('#designation').val(),$('#location').val());
    });
</script>
{{-- @include('layouts.footer') --}}
@endsection

@section('footer')
@include('layouts.footer')

<script  type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/typehead/typeahead.bundle.js') }}"></script>

<script type="text/javascript">
    $(function(){
        var stocks = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: 'api/autocomplete/search_designation_default',
        remote: {
            url: "api/autocomplete/search_designation",
            replace: function(url, query) {
                return url + "?q=" + query;
            },        
            filter: function(stocks) {
                return $.map(stocks, function(data) {
                    return {
                        // tokens: data.tokens,
                        // symbol: data.symbol,
                        name: data.name
                    }
                });
            }
        }
    });
    
    stocks.initialize();
    $('#designation.typeahead').typeahead({
        hint: true,
        highlight: false,
        minLength: 1,
    },{
        name: 'stocks',
        displayKey: 'name',
        source: stocks.ttAdapter(),
        limit:Number.MAX_VALUE
        }); 
    });
    $(function(){
        var location_s = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: 'api/autocomplete/search_location_default',
        remote: {
            url: "api/autocomplete/search_location",
            replace: function(url, query) {
                return url + "?q=" + query;
            },        
            filter: function(stocks) {
                return $.map(stocks, function(data) {
                    return {
                        // tokens: data.tokens,
                        // symbol: data.symbol,
                        name: data.name
                    }
                });
            }
        }
    });
    
    location_s.initialize();
        $('#location.typeahead').typeahead({
        hint: true,
        highlight: false,
        minLength: 1,
    },{
        name: 'location_s',
        displayKey: 'name',
        source: location_s.ttAdapter(),
        limit:Number.MAX_VALUE
        }); 
    });
</script>

@endsection

@section('custom_bottom_scripts')
<script type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/select2/select2.min.js') }}"></script>

@endsection

@section('footer')
@include('layouts.footer')
@endsection
