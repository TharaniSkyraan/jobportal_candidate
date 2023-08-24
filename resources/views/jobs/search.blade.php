@extends('jobs.app')

@section('custom_styles')
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/filters.w2fr4ha2.css')}}" rel="stylesheet">
<style>
    input[type="search"]::-webkit-search-cancel-button {
        -webkit-appearance: none;
        height: 1em;
        width: 1em;
        border-radius: 50em;
        background: url("{{ url('site_assets_1/assets/images/close-btn.svg') }}") no-repeat 50% 50%;
        background-size: contain;
        opacity: 0;
        pointer-events: none;
    }  
    input[type="search"]:focus::-webkit-search-cancel-button {
        opacity: .6;
        pointer-events: all;
        cursor: pointer;
        font-size:14px;
    }
    .search-inp-sec{
        padding: 95px 0 20px 0;
        background-color:#3b77db;
        /* background: linear-gradient(-45deg, #629bf6b1, #629AF6, #4285F4); */
        /* background: rgb(2,0,36); */
        /* background: linear-gradient(160deg, rgba(2,0,36,1) 0%, rgba(66,133,244,1) 0%, rgba(66,133,240,1) 100%); */
        /* background: url("{{ url('images/search_banner.png') }}") no-repeat left 50px,linear-gradient(160deg, rgba(2,0,36,1) 0%, rgba(66,133,244,1) 0%, rgba(66,133,240,1) 100%); */
        /* background-size: contain; */
    }.search-inp-sec .mobile_m img{
        width:130px;
    }
    @media(min-width: 280px) and (max-width: 767px){
        .search-inp-sec .mobile_m{
            display: none;
        }.search-inp-sec{
            padding: 105px 0 20px 0;
        }.search-inp-sec input, .search-inp-sec button{
            margin-bottom:20px;
        }.search-inp-sec button{
            display: flex;
            margin: 0 auto;
        }
    }
    @media(min-width: 768px) and (max-width: 1300px){
        .search-inp-sec img{
            width: 100%;;
        }.search-inp-sec{
            padding: 100px 0 30px 0;
        }

    }    
</style>
@endsection

@section('content')

<div class="" >

	@include('layouts.search_page_header')
	@include('layouts.search_side_navbar')

    <div class="mobilesearchpg" ></div>
    <div class="search-inp-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-lg-2 text-end mobile_m">
                    <img draggable="false"  src="{{asset('images/search_banner.png')}}" alt="">
                </div>
                <div class="col-md-4 col-md-4 col-lg-4 align-self-center designation p-0 m-0">
                    {!! Form::search('designation', $d, array('class'=>'form-control-2  typeahead', 'id'=>'designation', 'data-mdb-toggle'=>"tooltip", 'data-mdb-placement'=>"left", 'title'=>"Designation required",
                    'placeholder'=>__('Job title, keywords or company'),  'autocomplete'=>'off', 'spellcheck'=>'false' ) ) !!}
                </div>
                <div class="col-1 p-0 m-0 pre-d"><span class="pre">|</span></div>
                <div class="col-md-4 col-md-4 col-lg-4 align-self-center location p-0 m-0">
                    {!! Form::search('location', $l, array('class'=>'form-control-2 typeahead', 'id'=>'location', 'autocomplete'=>'off', 'placeholder'=>__('On Location'),' aria-label'=>'On Location')) !!}
                </div>
                <div class="col-md-1 align-self-center p-0 m-0">                    
                    <button class='btn btn_c_se form-control' id='msearch_btn'>
                        <i class="fa fa-search"></i>
                    </button>
                    {{-- {!! Form::button('Search', array('class' => 'btn search-button-bg ','id'=>'msearch_btn', 'type' => 'submit')) !!}                        --}}
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-3 mb-5" id="tempskle" style="min-height: 100vh">
        <div class="row" id="search-res-containr" style="display:none">
            <div class="col-lg-3 col-md-0 col-sm-0 col-xs-0" >
                <div class="sidebar sidebar-style-2" >
                    <div class="card ">
                        <div class="sidebar_content_2">
                            {{-- <div class="text-center mt-3 d-flex justify-content-between px-4">
                                <h3 class="fw-bold ">Filter by</h3>
                                <a class="blue-text applied-link">
                                    <span class="fw-bold">Applied(1)</span>
                                </a>
                            </div> --}}
                            <div class="filterHeading bgWhite br4">
                                {{-- <i class="jpicon jpicon-filter"></i> --}}
                                <h4 class="fw-bold pl-8" id="FilterHeadtitle">All Filters</h4>
                            </div>

                            <ul class="nav nav-primary">
                                <li class="nav-item active mb-3" >
                                    <a href="#FilterCitylo" class="filterHeading" data-bs-toggle="collapse" aria-expanded="true" >
                                        <img draggable="false"  class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/location.png')}}">
                                        <p class="fw-bold">Location</p>
                                        <span class="caret"></span>
                                    </a>
                                    <div class="collapse filterContainer collapse show" id="FilterCitylo" >
                                        <div class="dropdown_inner filterOptns" data-filter-id="citylFGid">
                                        </div>      
                                    </div>
                                </li>
                                
                                <li class="nav-item mb-3" >
                                    <a href="#salaryFilters" class="filterHeading" data-bs-toggle="collapse" aria-expanded="true" >
                                        <img draggable="false"  class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/salary.png')}}">
                                        <p class="fw-bold">Salary</p>
                                        <span class="caret"></span>
                                    </a>
                                    <div class="collapse filterContainer collapse show" id="salaryFilters" >
                                        <div class="dropdown_inner filterOptns" data-filter-id="salaryFGid">
                                        </div>
                                    </div>
                                </li> 

                                <li class="nav-item mb-3" >
                                    <a href="#experinceFilters" class="filterHeading" data-bs-toggle="collapse" aria-expanded="true">
                                    <img draggable="false"  class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/experience.png')}}">
                                        <p class="fw-bold">Experience</p>
                                        <span class="caret"></span>
                                    </a>
                                    <div class="collapse collapse show" id="experinceFilters">
                                        <div class="dropdown_inner filterOptns" data-filter-id="experinceFv">
                                            <div class="p-3">
                                                <div class="range-wrap">
                                                    <div class="range-value" id="rangeV"></div>
                                                    <input id="exp-range-slider" type="range" min="0" max="30" step="1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="nav-item mb-3" >
                                    <a href="#jobtypeFilters" class="filterHeading" data-bs-toggle="collapse" aria-expanded="true">
                                        <img draggable="false"  class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/job_by_shift.png')}}">
                                        <p class="fw-bold">Job Type</p>
                                        <span class="caret"></span>
                                    </a>
                                    <div class="collapse filterContainer collapse show" id="jobtypeFilters" >
                                        <div class="dropdown_inner filterOptns" data-filter-id="jobtypeFGid">
                                        </div>
                                    </div>
                                </li>
                                
                                <li class="nav-item mb-3" >
                                    <a href="#edulevelFilters" class="filterHeading" data-bs-toggle="collapse" aria-expanded="true">
                                        <img draggable="false"  class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/level_of_education.png')}}">
                                        <p class="fw-bold">Education Level</p>
                                        <span class="caret"></span>
                                    </a>
                                    <div class="collapse filterContainer collapse show" id="edulevelFilters" >
                                        <div class="dropdown_inner filterOptns" data-filter-id="edulevelFGid">
                                        </div>
                                    </div>
                                </li>
                                
                                <li class="nav-item mb-3" >
                                    <a href="#functionalareaFilters" class="filterHeading"  data-bs-toggle="collapse" aria-expanded="true">
                                        <img draggable="false"  class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/func_area.png')}}">
                                        <p class="fw-bold">Functional Area</p>
                                        <span class="caret"></span>
                                    </a>
                                    <div class="collapse filterContainer collapse show" id="functionalareaFilters" >
                                        <div class="dropdown_inner filterOptns" data-filter-id="functionalareaGid">
                                        </div>
                                    </div>
                                </li>
                                
                                {{-- <li class="nav-item mb-3" >
                                    <a href="#wfhtypeFilter" class="filterHeading" data-bs-toggle="collapse" aria-expanded="true">
                                        <img draggable="false"  class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/wfh.png')}}">
                                        <p class="fw-bold">Work From Home</p>
                                        <span class="caret"></span>
                                    </a>
                                    <div class="collapse filterContainer collapse show" id="wfhtypeFilter" >
                                        <div class="dropdown_inner filterOptns" data-filter-id="wfhtypeFid">
                                        </div>      
                                    </div>
                                </li> --}}
                                
                                <li class="nav-item mb-3" >
                                    <a href="#industrytypeFilters" class="filterHeading"  data-bs-toggle="collapse" aria-expanded="true">
                                        <img draggable="false"  class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/industry.png')}}">
                                        <p class="fw-bold">Industry</p>
                                        <span class="caret"></span>
                                    </a>
                                    <div class="collapse filterContainer collapse show" id="industrytypeFilters" >
                                        <div class="dropdown_inner filterOptns" data-filter-id="industrytypeGid">
                                        </div>   
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                <div class="row mt-1 mb-3">
                    <div class="col-lg-4  col-md-4 col-sm-4 col-xs-4 col-5 align-items-center d-flex">
                        <h5 class="fmftxt fw-bold t_pgres"></h5>
                    </div>
                    <div class="col-lg-8  col-md-8 col-sm-8 col-xs-8 col-7 align-items-center justify-content-end d-flex">
                        Sort By :  @php $arrDays = ['relevance'=> 'Relevance' ,'date'=>'Date']; @endphp
                        {!! Form::select('sortby', [] + $arrDays, null, array('class'=>'form-select', 'id'=>'sortby')) !!}
                    </div>
                </div>
                <div class="job-list">
                </div>
            </div>
            
            @if(0)
            <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                <div class="">
                    @if(Auth::check())
                    <section class="registrationContainer bgWhite mb-3" data-id="Register">
                        <div class="registrationHeader">
                            <p class="headline">Discover jobs across popular roles</p>
                            <img draggable="false"  class="headerBitmap" src="{{ asset('site_assets_1/assets/images/register.ak6djA.png') }}" alt="Register">
                            <p class="message">Select a role and we'll show you relevant jobs for it!
                            </p>
                        </div>
                        {{-- <div class="registrationBody">
                            <div class="registerButton "><a class="registerText btn-get-started" href="{{ route('postjob') }}">Post Job</a></div>
                        </div> --}}
                    </section>
                    
                    @elseif(Auth::check())
                        <section class="registrationContainer bgWhite mb-3" data-id="Register">
                            <div class="registrationHeader">
                                <p class="headline">Find quality applicants</p>
                                {{-- <img draggable="false"  class="headerBitmap" src="{{ asset('site_assets_1/assets/images/register.ak6djA.png') }}" alt="Register"> --}}
                                <p class="message">List your required skills for the job so relevant candidates apply.
                                </p>
                            </div>
                            <div class="registrationBody">
                                <div class="registerButton "><a class="registerText btn-get-started" href="#Postlink">Post Job</a></div>
                            </div>
                        </section>
                    @else
                        <section class="registrationContainer bgWhite mb-3" data-id="Register">
                            <div class="registrationHeader">
                                <p class="headline">Get Personalised Job Recommendations</p>
                                <img draggable="false"  class="headerBitmap" src="{{ asset('site_assets_1/assets/images/register.ak6djA.png') }}" alt="Register">
                                <p class="message">Registering gives you the benefit to browse &amp; apply variety of jobs based on your preferences
                                </p>
                            </div>
                            <div class="registrationBody">
                                <div class="registerButton "><a class="registerText btn-get-started" href="{{ route('login') }}">Upload Resume</a></div>
                            </div>
                        </section>
                    @endif
                    
                </div>
            </div>
            @endif
        </div>

        <div class="row" id="no-res-res-containr" style="display: none">
            <div class="col-lg-12 text-center " id="no-result-c" >
                <div class="card w-100 mx-auto">
                    <div class="">
                        <div>
                            <img draggable="false"  class="no-result-img" src="{{ url('site_assets_1/assets/images/no-results-found.png') }}" alt="no-result-img" />
                        </div>
                    </div>
                    <h4 class="fw-bolder">
                        No result found
                    </h4>
                    <p>We could not find jobs matching your search criteria.</p>
                    <p><a href="javascript:history.go(-1);" >Return to previous page </a> </p>

                </div>
            {{-- <div class="col-lg-2 text-center">
                
            </div> --}}
        </div>

	</div>

</div>


<div class="filter_show">
    <a class="fileter mobile" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"><i class="fa fa-filter"></i></a>
</div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-body">
    <div class="card">
        <div class="card-title">
            <h4 class="fw-bold pl-8" id="FilterHeadtitle">Filter Jobs</h4>
        </div>
        <div class="card-body">
            <div class="sidebar_content_2 bg-transparent">
                <ul class="nav nav-primary">
                    <li class="nav-item active mb-3" >
                        <a href="#FilterCityl" class="filterHeading" data-bs-toggle="collapse" aria-expanded="true" >
                            <img draggable="false"  class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/location.png')}}">
                            <p class="fw-bold">Location</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse filterContainer collapse show" id="FilterCityl" >
                            <div class="dropdown_inner filterOptns" data-filter-id="citylFGid">
                            </div>      
                        </div>
                    </li>
                    
                    <li class="nav-item mb-3" >
                        <a href="#salaryFilter" class="filterHeading" data-bs-toggle="collapse" aria-expanded="true" >
                            <img draggable="false"  class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/salary.png')}}">
                            <p class="fw-bold">Salary</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse filterContainer collapse show" id="salaryFilter" >
                            <div class="dropdown_inner filterOptns" data-filter-id="salaryFGid">
                            </div>
                        </div>
                    </li> 

                    <li class="nav-item mb-3" >
                        <a href="#experinceFilter" class="filterHeading" data-bs-toggle="collapse" aria-expanded="true">
                        <img draggable="false"  class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/experience.png')}}">
                            <p class="fw-bold">Experience</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse collapse show" id="experinceFilter">
                            <div class="dropdown_inner filterOptns" data-filter-id="experinceFv">
                                <div class="p-3">
                                    <div class="range-wrap">
                                        <div class="range-value" id="rangeV"></div>
                                        <input id="exp-range-slider" type="range" min="0" max="30" step="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item mb-3" >
                        <a href="#jobtypeFilter" class="filterHeading" data-bs-toggle="collapse" aria-expanded="true">
                            <img draggable="false"  class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/job_by_shift.png')}}">
                            <p class="fw-bold">Job Type</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse filterContainer collapse show" id="jobtypeFilter" >
                            <div class="dropdown_inner filterOptns" data-filter-id="jobtypeFGid">
                            </div>
                        </div>
                    </li>
                    
                    <li class="nav-item mb-3" >
                        <a href="#edulevelFilter" class="filterHeading" data-bs-toggle="collapse" aria-expanded="true">
                            <img draggable="false"  class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/level_of_education.png')}}">
                            <p class="fw-bold">Education Level</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse filterContainer collapse show" id="edulevelFilter" >
                            <div class="dropdown_inner filterOptns" data-filter-id="edulevelFGid">
                            </div>
                        </div>
                    </li>
                    
                    <li class="nav-item mb-3" >
                        <a href="#functionalareaFilter" class="filterHeading"  data-bs-toggle="collapse" aria-expanded="true">
                            <img draggable="false"  class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/func_area.png')}}">
                            <p class="fw-bold">Functional Area</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse filterContainer collapse show" id="functionalareaFilter" >
                            <div class="dropdown_inner filterOptns" data-filter-id="functionalareaGid">
                            </div>
                        </div>
                    </li>
                    
                    {{-- <li class="nav-item mb-3" >
                        <a href="#wfhtypeFilter" class="filterHeading" data-bs-toggle="collapse" aria-expanded="true">
                            <img draggable="false"  class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/wfh.png')}}">
                            <p class="fw-bold">Work From Home</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse filterContainer collapse show" id="wfhtypeFilter" >
                            <div class="dropdown_inner filterOptns" data-filter-id="wfhtypeFid">
                            </div>      
                        </div>
                    </li> --}}
                    
                    <li class="nav-item mb-3" >
                        <a href="#industrytypeFilter" class="filterHeading"  data-bs-toggle="collapse" aria-expanded="true">
                            <img draggable="false"  class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/industry.png')}}">
                            <p class="fw-bold">Industry</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse filterContainer collapse show" id="industrytypeFilter" >
                            <div class="dropdown_inner filterOptns" data-filter-id="industrytypeGid">
                            </div>   
                        </div>
                    </li>
                    
                </ul>
            </div>
        </div>
        <div class="card-footer">
           <div class="row">
            <div class="col-6 text-center">
                <button class="cancel filterReset">Reset</button>
            </div>
            <div class="col-6 text-center">
                <button class="ok" data-bs-dismiss="offcanvas" aria-label="Close">Ok</button>
            </div>
           </div>
        </div>
    </div>
    
  </div>
</div>

@include('user.complete-profile-modal')
<script>
    $('.fileter.mobile').click(function(){
        $("#header").addClass('remove');
    });
    
    $('.ok').click(function(){
        $("#header").removeClass('remove');
    });
    
</script>

<script type="text/javascript">
var baseurl = '{{ url("/") }}/';
var is_login = '{{ Cookie::get("is_login") }}';
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/js/input_tag/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/1a9ve2/js/filters.51e7k9a1.js?v=1.114333') }}"></script>
<script  type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/typehead/typeahead.bundle.js') }}"></script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/1a9ve2/js/sercpag.fquiv23.js') }}"></script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/js/searchsidenavbarscript.js') }}"></script>
@endsection