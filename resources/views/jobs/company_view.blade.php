@extends('layouts.app')
@section('custom_styles')
    <link href="{{ asset('css/hjb2wrli.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" rel="stylesheet" />
@endsection
@section('content')
@section('title'){{$breadcrumbs->title}} - {{$company->name}} @endsection
@include('layouts.header')
    @php 
        $arra=array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    @endphp

    <div class="gallerypg">
       <a href="{{url('detail',$breadcrumbs->slug)}}" class="text-dark">
            <div class="breadcrumb">
                <span><span class="rnhv_g">< </span>&nbsp; Back</span>
            </div>
       </a> 
        <div class="space-width">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#aboutcmp">About Company</a></li>
                @if(count($company_jobs) != 0)<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#activejobs">Active Jobs</a></li>@endif
                @if(count($company->gallery)!=0)<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#gallery">Gallery</a></li>@endif
            </ul>
            <div class="tab-content">
                <div id="aboutcmp" class="tab-pane fade">
                    <table>
                        <tr>
                            <td>
                                <div class="profile_cmp">
                                    <img src="@if(!empty($company->company_image)) {{$company->company_image}} @else {{asset('noupload.png')}} @endif" alt="{{$company->name}}" draggable="false"></td>
                                </div>
                            <td>
                                <div class="dtml">
                                    <h2>{{$company->name}}</h2>
                                    <div><img src="{{asset('images/about/location.svg')}}" alt="location-icon">{{ $company->location }}</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="descrip">
                        <div class="pt_hwsp">
                            <h4 class="mb-3">About Company / Organisation :</h4>
                            <p>{{$company->description}}</p>
                        </div>

                        <div class="row">
                            @if($company->CEO_name != null)
                                <div class="col-md-4 mkwra">
                                    <div class="card">
                                        <span>CEO</span>
                                        <h3>{{$company->CEO_name}}</h3>
                                    </div>
                                </div>
                            @endif
                            @if($company->founded_on != null) 
                                <div class="col-md-4 mkwra">
                                    <div class="card">
                                        <span>Founded on</span>
                                        <h3>{{ date('d',strtotime($company->founded_on)) }}th {{ $arra[intval(date('m',strtotime($company->founded_on)))-1]}} {{date('Y',strtotime($company->founded_on)) }}</h3>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-4 mkwra">
                                <div class="card">
                                    <span>Current Number of employess</span>
                                    <h3>{{ $company->no_of_employees }}</h3>
                                </div>
                            </div>
                            <div class="col-md-4 mkwra">
                                <div class="card">
                                    <span>Type of industry</span>
                                    <h3>{{ DataArrayHelper::industryParticular($company->industry_id) }}</h3>
                                </div>
                            </div>
                            @if($company->website_url != null)
                                <div class="col-md-4 mkwra">
                                    <div class="card">
                                        <span>Website</span>
                                        <a href="{{$company->website_url}}"><h3>{{$company->website_url}}</h3></a>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($company->fb_url) || !empty($company->insta_url) || !empty($company->linkedin_url) || !empty($company->twitter_url))
                                <div class="col-md-4 mkwra">
                                    <div class="card">
                                        <span>Social Media profiles</span>
                                        <span class="sclicnm">                                    
                                            @if(!empty($company->fb_url))<a href="{{$company->fb_url}}"><img src="{{asset('images/about/facebook.svg')}}" alt="facebook-icon" draggable="false"></a>@endif
                                            @if(!empty($company->insta_url))<a href="{{$company->insta_url}}"><img src="{{asset('images/about/instagram.svg')}}" alt="instagram-icon" draggable="false"></a>@endif
                                            @if(!empty($company->linkedin_url))<a href="{{$company->linkedin_url}}"><img src="{{asset('images/about/linkedin.svg')}}" alt="linkedin-icon" draggable="false"></a>@endif
                                            @if(!empty($company->twitter_url))<a href="{{$company->twitter_url}}"><img src="{{asset('images/about/twitterx.png')}}" class="twitter-img" alt="twitter-icon" draggable="false"></a>@endif
                                        </span>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-12 mkwra">
                                <div class="card mdlstb">
                                    <strong>Location Details</strong>
                                    <h5>Address</h5>
                                    <div class="row">
                                        <div class="col-12">
                                            <h3>{{ $company->address }}</h3>
                                        </div>
                                        <div class="col-6">
                                            <h5>City</h5>
                                            <h3>{{ $company->location }}</h3>
                                        </div>
                                        <div class="col-6">
                                            <h5>State</h5>
                                            <h3>Tamilnadu</h3>
                                        </div>
                                        <div class="col-6">
                                            <h5>Country</h5>
                                            <h3>{{ DataArrayHelper::countryParticular($company->country_id) }}</h3>
                                        </div>
                                        <div class="col-6">
                                            <h5>Pincode</h5>
                                            <h3>{{$company->pin_code}}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="activejobs" class="tab-pane fade">
                    @if(count($company_jobs) != 0)
                        <div class="tab-pane" id="activejobs" role="tabpanel" aria-labelledby="review-tab">
                            <div class="row">
                                @foreach($company_jobs as $job)
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6 col-12">
                                        <a class="cursor-pointer text-dark" target="_blank" href="{{url('detail/'.$job->slug)}}">
                                            <div class="card jobsearch p-3">
                                                <div>
                                                    <h2 class="fw-bolder">{{$job->title}}</h2>
                                                    <p>{{$company->name}}</p></td>
                                                    <table>
                                                        <tr>
                                                            <td><strong>Experience &nbsp;</strong></td>
                                                            <td>:&nbsp; {{$job->experience_string}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Salary &nbsp;</strong></td>
                                                            <td>:&nbsp; {{ trim($job->hide_salary != 1)&&!empty($job->salary_string) ? $job->salary_string :'Not Disclosed'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Location &nbsp;</strong></td>
                                                            <td><h6 class="mjn_kjwe"> :&nbsp; {{rtrim($job->work_locations, ", ")}}</h6></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach     
                            </div>
                        </div>  
                    @endif 
                </div>
                <div id="gallery" class="tab-pane fade">
                    <div class="row sp_gt5 amhbgally">
                    </div>
                </div>
            </div>
        </div>
    </div>


     <!-- preview gallery -->
     <div class="modal fade" id="previewgallery" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="close_m" data-bs-dismiss="modal" aria-label="Close"><img src="{{asset('images/about/close_arw.svg')}}" alt="close-icon"></div>
                <div class="open-images">

                </div>
            </div>
        </div>
    </div>
    
    
    <script>
        var cmp_url = "{{ route('getourcompanygallery',$company->id) }}";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script type="text/javascript" src="{{ asset('site_assets_1/assets/2e9ejr3/js/destail.cmpy.js') }}"></script>


@endsection

@section('footer')
    @include('layouts.footer')
@endsection