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
        background-color:#4285f4;
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

	@include('layouts.header')

    <div class="search-inp-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-lg-2 text-center mobile_m">
                    <img src="{{asset('images/search_banner.png')}}" alt="">
                </div>
                <div class="col-md-4 col-md-4 col-lg-4 align-self-center">
                    {!! Form::search('designation', $d, array('class'=>'form-control-2  typeahead', 'id'=>'designation',
                    'placeholder'=>__('Job title, keywords or company'),  'autocomplete'=>'off', 'spellcheck'=>'false' ) ) !!}
                    {{-- <span class="icl-TextInput-icon iconRight" aria-hidden="true"><span class="" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" fill="none" aria-hidden="true"><defs></defs><path fill="#767676" fill-rule="evenodd" d="M11.4038 12.3048C10.7084 12.7451 9.88397 13 9 13c-2.48528 0-4.5-2.0147-4.5-4.5C4.5 6.01472 6.51472 4 9 4c2.4853 0 4.5 2.01472 4.5 4.5 0 .87711-.2509 1.6956-.6849 2.3876l3.5089 3.5089c.1952.1953.1952.5119 0 .7071l-.7071.7072c-.1953.1952-.5119.1952-.7071 0l-3.506-3.506zM11.5 8.5c0 1.38071-1.1193 2.5-2.5 2.5-1.38071 0-2.5-1.11929-2.5-2.5S7.61929 6 9 6c1.3807 0 2.5 1.11929 2.5 2.5z" clip-rule="evenodd"></path></svg></span></span> --}}
                    <span class="form-text text-danger err_msg designation-error"></span>
                </div>
                <div class="col-md-4 col-md-4 col-lg-4 align-self-center">
                {!! Form::search('location', $l, array('class'=>'form-control-2 typeahead', 'id'=>'location', 'placeholder'=>__('On Location'),' aria-label'=>'On Location')) !!}
                        <span class="form-text text-danger err_msg"></span>
                </div>
                <div class="col-md-2 align-self-center">
                    {!! Form::button('Search', array('class' => 'btn search-button-bg ','id'=>'msearch_btn', 'type' => 'submit')) !!}                       
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
                                    <a href="#FilterCityl" class="filterHeading" data-bs-toggle="collapse" aria-expanded="true" >
                                        <img class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/location.png')}}">
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
                                        <img class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/salary.png')}}">
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
                                    <img class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/experience.png')}}">
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
                                        <img class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/job_by_shift.png')}}">
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
                                        <img class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/level_of_education.png')}}">
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
                                        <img class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/func_area.png')}}">
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
                                        <img class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/wfh.png')}}">
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
                                        <img class="me-2" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/industry.png')}}">
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
                </div>
            </div>
            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                <div class="row mt-1 mb-3">
                    <div class="col-lg-6 col-xs-12 align-self-center align-items-center d-inline justify-content-start">
                        <h5 class="fmftxt fw-bold t_pgres"></h5>									
                        {{-- <small class="ellipsis">1 - 20 of 379 jobs</small> --}}
                    </div>
                    <div class="col-lg-6 col-xs-12 align-items-center d-flex justify-content-end">Sort By : &nbsp;
                        @php $arrDays = ['relevance'=> 'Relevance' ,'date'=>'Date']; @endphp
                        {!! Form::select('sortby', [] + $arrDays, null, array('class'=>'form-select w-50', 'id'=>'sortby')) !!}
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
                            <img class="headerBitmap" src="{{ asset('site_assets_1/assets/images/register.ak6djA.png') }}" alt="Register">
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
                                {{-- <img class="headerBitmap" src="{{ asset('site_assets_1/assets/images/register.ak6djA.png') }}" alt="Register"> --}}
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
                                <img class="headerBitmap" src="{{ asset('site_assets_1/assets/images/register.ak6djA.png') }}" alt="Register">
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
                            <img class="no-result-img" src="{{ url('site_assets_1/assets/images/no-results-found.png') }}" alt="no-result-img" />
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

<script type="text/javascript">
var baseurl = '{{ url("/") }}/';
var is_login = '{{ Cookie::get("is_login") }}';
</script>

<script type="text/javascript" src="{{ asset('site_assets_1/assets/js/input_tag/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/1a9ve2/js/filters.51e7k9a1.js?v=1.114333') }}"></script>

<script  type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/typehead/typeahead.bundle.js') }}"></script>

<script type="text/javascript">

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
    
    $('#msearch_btn').on('click', function(){
        //myElement Has Focus
        $('.err_msg').html('');
        if($('#designation').val() != '' || $('#location').val() !=''){
            
            filterResetallActions();

            var designation = $('#designation').val();
            var location = $('#location').val();
            // let req_url = "/checkkeywords";

            $.ajax({
                url: '{{ route("job.checkkeywords") }}',
                type: 'POST',
                data : { "_token": '{{ csrf_token() }}', 'designation': designation, 'location': location },
                datatype: 'JSON',
                success: function(response){
                    // console.log(data)
                    let l = '';
                    let d = '';
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
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    // var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    // console.log(errorMsg)
                    // $('#content').html(errorMsg);
                }
            });

            // $.post("/checkkeywords", {designation: designation, location: location, _method: 'POST', _token: '{{ csrf_token() }}'})
            //     .done(function (response) {
            //         var l = '';
            //         var d = '';
            //     if(response.d !=''){
            //         d = 'd='+response.d;
            //     }
            //     if(response.l !=''){
            //         if(response.d !=''){
            //             l += '&';
            //         }
            //         l += 'l='+response.l;
            //     }
            //     window.location = "/"+response.sl+'?'+d+l;
            // });
        }else{
            $('.designation-error').html('Enter Your Designation');
        }
    });
</script>

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