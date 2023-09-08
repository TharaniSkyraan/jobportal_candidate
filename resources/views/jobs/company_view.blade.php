@extends('layouts.app')
@section('custom_styles')
<link href="{{ asset('site_assets_1/assets/cmpy/japplicant/css/jAk3jne9.css')}}" rel="stylesheet">
@endsection
@section('content')
@include('layouts.header')
<style>
    @media (min-width: 576px)
    {    
        .container-detail {
            max-width: 670px !important;
        }
    }
    @media (min-width: 768px)
    {    
        .container-detail {
            max-width: 960px !important;
        }
    }
    @media (min-width: 1200px)
    {    
        .container-detail {
            max-width: 1140px !important;
        }
    }
</style>
<?php 
    $arra=array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
?>  
<section id="companydetail">
    <div class="container container-detail mt-5">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 col-12">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 col-12">
                        <div class="page-title-list">
                            <ol class="breadcrumb d-inline-block mb-0">
                                <li class="breadcrumb-item d-inline-block"><a href="{{ route('index') }}" class="fw-bold" style="color: #1e2022;font-size:16px;text-decoration:none;">Home</a></li>
                                <li class="breadcrumb-item d-inline-block"><a href="{{url('detail',$breadcrumbs->slug)}}" class="fw-bold" style="color: #1e2022;font-size:16px;text-decoration:none;">{{$breadcrumbs->title}}</a></li>
                                <li class="breadcrumb-item d-inline-block active"><a class="text-primary " style="font-weight:bold;text-decoration:none;">{{$company->name}}</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 col-12">
                <div class="mx-auto pb-5 w-75">
                    <div class="content">
                        <ul class="nav nav-tabs justify-content-around" id="candiftabs" role="tablist">
                            <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="received-tab" data-bs-toggle="tab" data-bs-target="#aboutcompany" type="button" role="tab" aria-controls="received" aria-selected="true">About Company</button>
                            </li>
                            @if(count($company->gallery)!=0)
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="suggested-tab" data-bs-toggle="tab" data-bs-target="#gallery" type="button" role="tab" aria-controls="suggested" aria-selected="false">Gallery</button>
                            </li>
                            @endif
                            @if(count($company_jobs) != 0)
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="shortlisted-tab" data-bs-toggle="tab" data-bs-target="#activejobs" type="button" role="tab" aria-controls="shortlisted" aria-selected="false">Active jobs</button>
                            </li>
                            @endif
                            <!-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="considered-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="considered" aria-selected="false">Reviews
                            </li> -->
                        
                        </ul>
                    </div>
                </div>



                <div class="tab-content" id="pills-applied-jobs-list">
                    <div class="tab-pane active" id="aboutcompany" role="tabpanel" aria-labelledby="aboutcompany-tab">
                        <div class="card abtcmpycrd1 p-4">
                            <div class="row">
                                <div class="col-lg-10 col-md-12 col-xs-12 col-sm-12 col-12 col-xl-10">
                                    <div class="row">
                                        <div class="col-md-4 col-xl-2 align-self-center">
                                            <div class="card pf_imgsabt">
                                                @if(!empty($company->company_image))
                                                    <img draggable="false" src="{{$company->company_image}}" alt="{{$company->name}}" width="100%">
                                                @else
                                                    <img draggable="false" src="{{asset('noupload.png')}}" alt="{{$company->name}}" width="100%">
                                                @endif
                                            </div>
                                        </div>
                                       <div class="col-md-8 col-xl-10 px-2 text-left align-self-center">
                                            <h1 class="fw-bolder">{{$company->name}}</h1>
                                            <!-- <div class="ratings">
                                            <span class="review-count ">(12) &nbsp;</span>
                                                <i class="fa fa-star rating-color"></i>
                                                <i class="fa fa-star rating-color"></i>
                                                <i class="fa fa-star rating-color"></i>
                                                <i class="fa fa-star rating-color"></i>
                                                <i class="fa fa-star"></i>
                                                <a href="#" class=" text-center">&nbsp;&nbsp;&nbsp; 4.2 rating</a>
                                            </div>             -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-2 follow_btn3ws align-self-center text-center">
                                    <!-- <button class="btn bg-primary text-white rounded-pill" type="button">Following</button> -->
                                </div>                           
                            </div>
                        </div>

                        <div class="card detail_applierss2 px-5">
                            <div class="text-justify mb-4">
                                <h2 class="fw-bolder mt-3">About Company / Organization:</h2>
                                <p>{{$company->description}}</p>
                            </div>
                            <div class="comdetail2list">
                                <div class="row">
                                    @if($company->CEO_name != null)
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6 col-12">
                                        <p>CEO</p>
                                        <span class="fw-bolder">{{$company->CEO_name}} </span>
                                    </div>
                                    @endif
                                    @if($company->founded_on != null) 
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6 col-12">
                                        <p>Founded On</p>
                                        <span class="fw-bolder">{{ date('d',strtotime($company->founded_on)) }}th {{ $arra[intval(date('m',strtotime($company->founded_on)))-1]}} {{date('Y',strtotime($company->founded_on)) }} </span>
                                    </div>
                                    @endif
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6 col-12">
                                        <p>Current number of employees</p>
                                        <span class="fw-bolder">{{ $company->no_of_employees }}</span>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6 col-12">
                                        <p>Types of industry</p>
                                        <span class="fw-bolder">{{ DataArrayHelper::industryParticular($company->industry_id) }}</p>
                                    </div>
                                    @if($company->website_url != null)
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6 col-12">
                                        <p>Website</p>
                                        <span class="fw-bolder"><a href="$company->website_url">{{$company->website_url}} </a></span>
                                    </div>
                                    @endif
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6 col-12">
                                        <p>Social Media profiles</p>
                                        <h5 class="aboutcompany_heading1">
                                            <div class="socialmediaappend">
                                                @if(!empty($company->linkedin_url))
                                                    <a href="{{$company->linkedin_url}}" target="_blank">
                                                        <i class="fa fa-linkedin"></i>
                                                    </a> 
                                                @else
                                                    <i class="fa fa-linkedin noclrfa"></i>
                                                @endif   

                                                @if(!empty($company->insta_url))
                                                    <a href="{{$company->insta_url}}" target="_blank">
                                                        <i class="fa fa-instagram "></i>
                                                    </a>
                                                @else
                                                    <i class="fa fa-instagram noclrfa"></i> 
                                                @endif

                                                @if(!empty($company->fb_url))
                                                    <a href="{{$company->fb_url}}" target="_blank">
                                                        <i class="fa fa-facebook"></i>
                                                    </a>
                                                @else 
                                                    <i class="fa fa-facebook noclrfa"></i>
                                                @endif

                                                @if(!empty($company->twitter_url))
                                                    <a href="{{$company->twitter_url}}" target="_blank">
                                                        <i class="fa fa-twitter"></i>
                                                    </a> 
                                                @else
                                                    <i class="fa fa-twitter noclrfa"></i>
                                                @endif
                                            </div>
                                        </h5>
                                    </div>
                                    @if($company->address != null)
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6 col-12">
                                        <p>Address</p>
                                        <span class="fw-bolder">{{$company->address}} </span>
                                    </div>
                                    @endif
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6 col-12">
                                        <p>City</p>
                                        <span class="fw-bolder">{{ $company->location }}</span>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6 col-12">
                                        <p>Country</p>
                                        <span class="fw-bolder">{{ DataArrayHelper::countryParticular($company->country_id) }}</span>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6 col-12">
                                        <p>Pincode</p>
                                        <span class="fw-bolder">{{$company->pin_code}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                    @if(count($company->gallery)!=0)
                    <div class="tab-pane" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                        <div class="galaryappendcontent row"></div>
                    </div>
                    @endif
                    @if(count($company_jobs) != 0)
                        <div class="tab-pane" id="activejobs" role="tabpanel" aria-labelledby="review-tab">
                            <div class="row">
                                @foreach($company_jobs as $job)
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6 col-12">
                                        <a class="cursor-pointer text-dark" target="_blank" href="{{url('detail/'.$job->slug)}}">
                                            <div class="card jobsearch p-4">
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
                                                            <td>:&nbsp; {{rtrim($job->work_locations, ", ")}}</td>
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
            </div>              
        </section>
@endsection

@section('footer')
@include('layouts.footer')
<script src="{{ asset('rating-input/bootstrap4-rating-input.js') }}"></script>
<script src="https://use.fontawesome.com/5ac93d4ca8.js"></script>
<script>
    $.get("{{ route('getourcompanygallery',$company->id) }}")
    .done(function (response) 
    {// Get select
    
        if(response.data.length > 0)
        {
            
            $.each(response.data, function (i, data) 
            { 
                $('.galaryappendcontent').append(`<div class="col-md-4 col-xl-3 col-lg-3 col-sm-6 col-xs-6 col-12">
                            <div class="card zoom opacity savecompanyname" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <div class="text-center"><div class="box"> 
                                    <img draggable="false" class="card-img-top imgclass" src=`+data['image_exact_url']+`>
                                </div>
                                <div class="card-body"> 
                                    <h5 class="card-title text-start fw-bolder">`+data['title']+`</h5> 
                                    <p class="card-text text-start">`+data['description']+`</p> 
                                </div> 
                            </div>
                        </div>`);
            });

        }else{
            $('.galaryappendcontent').append('<span class="text-center fw-bolder">No Active Gallery</span>');
        }
    
    });

    $('.new_post').addClass('bg-lit-green-col');

    $('input[name=choose_job_post]').on('click', function() 
    {
        var val = $('input[name=choose_job_post]:checked').val(); 

        if(val == 'new'){ 
            $('.new_post').addClass('bg-lit-green-col');
            $('.old_post').removeClass('bg-lit-green-col');
        }else if(val == 'old'){
            $('.new_post').removeClass('bg-lit-green-col');
            $('.old_post').addClass('bg-lit-green-col');
        }
    });

</script>
@endsection