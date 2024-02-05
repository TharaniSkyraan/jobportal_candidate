@extends('layouts.pages.jobs.search_app')

@section('content')

<div class="">

	@include('layouts.header.header')
    
    <div class="search-inp-sec">
        <div class="container-xl">
            <div class="row justify-content-center jhier_ngfey">
                <div class="col-xl-5 col-md-5 col-lg-5 col-sm-5 col-10 align-self-center designation p-0 m-0">
                    {!! Form::search('designation', $d, array('class'=>'form-control-2  typeahead', 'id'=>'designation', 'data-mdb-toggle'=>"tooltip", 'data-mdb-placement'=>"left", 'title'=>"Designation required",
                    'placeholder'=>__('Job title, keywords or company'),  'autocomplete'=>'off', 'spellcheck'=>'false' ) ) !!}
                </div>
                <div class="col-1 p-0 m-0 pre-d"><span class="pre">|</span></div>
                <div class="col-xl-5 col-md-5 col-lg-5 col-sm-5 align-self-center location p-0 m-0">
                    {!! Form::search('location', $l, array('class'=>'form-control-2 typeahead', 'id'=>'location', 'autocomplete'=>'off', 'placeholder'=>__('On Location'),' aria-label'=>'On Location')) !!}
                </div>
                <div class="col-xl-1 col-md-1 col-lg-1 col-sm-1 col-2 align-self-center p-0 m-0">                    
                    <button class='btn btn_c_se form-control px-0' id='msearch_btn'>
                        <i class="fa fa-search"></i>
                    </button>
                    {{-- {!! Form::button('Search', array('class' => 'btn search-button-bg ','id'=>'msearch_btn', 'type' => 'submit')) !!}                        --}}
                </div>
            </div>
        </div>
    </div>

    <div class="container-xl" id="tempskle" style="min-height: 100vh">
        <div class="row" id="search-res-containr" style="display:none">
            <div class="col-lg-3 col-md-0 col-sm-0 col-xs-0 desk-res-filter" >
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
                                <h4 class="fw-bold pl-8 FilterHeadtitle"><img draggable="false" alt="" src="{{ asset('site_assets_1/assets/img/side_nav_icon/filter.svg')}}" alt="" class="me-1">  Filters</h4>
                            </div>
                            <div class="jhn3y7m">
                                <ul class="nav nav-primary">
                                    <li class="nav-item active" >
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
                                    
                                    <li class="nav-item" >
                                        <a href="#salaryFilters" class="filterHeading" data-bs-toggle="collapse" aria-expanded="true" >
                                            <img draggable="false"  class="me-2" width="15px" src="{{url('site_assets_1/assets/img/side_nav_icon/salary.png')}}">
                                            <p class="fw-bold">Salary</p>
                                            <span class="caret"></span>
                                        </a>
                                        <div class="collapse filterContainer collapse show" id="salaryFilters" >
                                            <div class="dropdown_inner filterOptns" data-filter-id="salaryFGid">
                                            </div>
                                        </div>
                                    </li> 

                                    <li class="nav-item" >
                                        <a href="#experinceFilters" class="filterHeading" data-bs-toggle="collapse" aria-expanded="true">
                                        <img draggable="false"  class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/experience.png')}}">
                                            <p class="fw-bold">Experience</p>
                                            <span class="caret"></span>
                                        </a>
                                        <div class="collapse collapse show" id="experinceFilters">
                                            <div class="dropdown_inner filterOptns" data-filter-id="experinceFv">
                                                <div class="p-3">
                                                    <div class="range-wrap">
                                                        <div class="range-value rangeV"></div>
                                                        <input class="exp-range-slider" type="range" min="0" max="30" step="1">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="nav-item" >
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
                                    
                                    <li class="nav-item" >
                                        <a href="#edulevelFilters" class="filterHeading" data-bs-toggle="collapse" aria-expanded="true">
                                            <img draggable="false"  class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/level_of_education.png')}}">
                                            <p class="fw-bold">Level of Education</p>
                                            <span class="caret"></span>
                                        </a>
                                        <div class="collapse filterContainer collapse show" id="edulevelFilters" >
                                            <div class="dropdown_inner filterOptns" data-filter-id="edulevelFGid">
                                            </div>
                                        </div>
                                    </li>
                                    
                                    <li class="nav-item" >
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
                                    
                                    {{-- <li class="nav-item" >
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
                                    
                                    <li class="nav-item" >
                                        <a href="#industrytypeFilters" class="filterHeading"  data-bs-toggle="collapse" aria-expanded="true">
                                            <img draggable="false"  class="me-2" width="15px" src="{{url('site_assets_1/assets/img/side_nav_icon/industry.png')}}">
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
            </div>
            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                <div class="row mt-3 mb-2 mpiwth_gb">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-3 align-items-center d-flex filtershow">
                        <div class="filter_show">
                            <a class="fileter mobile" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                                <img draggable="false" alt="" src="{{ asset('site_assets_1/assets/img/side_nav_icon/filter.svg')}}" alt="" class="me-1">
                                <span>Filters</span> <i class="ms-1 fa fa-angle-down angle-toggle"></i>
                            </a>
                        </div>                        
                    </div>
                    <div class="col-xl-6 col-lg-6  col-md-4 col-sm-4 col-xs-4 col-5 align-self-center">
                        <h5 class="fmftxt fw-bold t_pgres"></h5>
                    </div>
                    <div class="col-xl-6 col-lg-6 p-0 col-md-4 col-sm-4 col-xs-4 col-4 align-items-center justify-content-end d-flex">
                        <label for="sortby"><img draggable="false" alt="" src="{{ asset('site_assets_1/assets/img/side_nav_icon/shortby.svg')}}" class="search-sortby" >  </label>
                        @php $arrDays = ['date'=> 'Recent' ,'immediate_join'=>'Immediate Join']; @endphp
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


<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" data-backdrop="false" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-body mob-res-filter">

  </div>
</div>
@include('user.complete-profile-modal')
<script>
    // $('.fileter.mobile').click(function(){
    //     $("#header").addClass('remove');
    // });
    
    // $(document).on('click', '.ok' , function(e){
    //     $("#header").removeClass('remove');
    // });

    // $(document).ready(function() {
    //     var elementPosition = $('.sidebar-style-2').offset();
    //     $(window).scroll(function() {
    //         if ($(window).scrollTop() > elementPosition.top) {
    //             $('.sidebar-style-2').addClass('added');
    //         } else {
    //             $('.sidebar-style-2').removeClass('added');
    //         }
    //     });
    // });
</script>

<script type="text/javascript">
var baseurl = '{{ url("/") }}/';
var is_login = '{{ Cookie::get("is_login") }}';
</script>
@endsection