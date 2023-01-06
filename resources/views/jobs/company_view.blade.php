@extends('layouts.app')
@section('custom_styles')
<style>


#aboutcompany{
    border-radius: 20px;
   
}

#page-container, #header{
    background-color:#fff !important;
    box-shadow:none;
}

</style>

<link href="{{ asset('site_assets_1/assets/cmpy/japplicant/css/jAk3jne9.css')}}" rel="stylesheet">
@endsection
@section('custom_scripts')	  
@endsection

@section('content')
@include('layouts.header')
       
	@include('layouts.header')
    <?php 
    $arra=array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    ?>  

<section id="companydetail">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-12">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
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
            <div class="col-md-12">
                <div class="mx-auto pb-5 w-50">
                    <div class="content">
                        <ul class="nav nav-tabs justify-content-between" id="candiftabs" role="tablist">
                            <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="received-tab" data-bs-toggle="tab" data-bs-target="#aboutcompany" type="button" role="tab" aria-controls="received" aria-selected="true">About Company</button>
                            </li>
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="suggested-tab" data-bs-toggle="tab" data-bs-target="#gallery" type="button" role="tab" aria-controls="suggested" aria-selected="false">Gallery</button>
                            </li>
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="shortlisted-tab" data-bs-toggle="tab" data-bs-target="#activejobs" type="button" role="tab" aria-controls="shortlisted" aria-selected="false">Active jobs</button>
                            </li>
                            <!-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="considered-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="considered" aria-selected="false">Reviews
                            </li> -->
                        
                        </ul>
                    </div>
                </div>



                <div class="tab-content" id="pills-applied-jobs-list">
                    <div class="tab-pane active" id="aboutcompany" role="tabpanel" aria-labelledby="aboutcompany-tab">
                        <div class="card abtcmpycrd1 p-3">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 col-xl-10">
                                        <div class="row">
                                            <div class="col-md-4 col-xl-2 align-self-center">
                                                <div class="card pf_imgsabt">
                                                    @if(!empty($company->image))
                                                        <img src="{{$company->image}}" alt="{{$company->name}}" width="100%">
                                                    @else
                                                        <img src="{{asset('noupload.png')}}" alt="{{$company->name}}" width="100%">
                                                    @endif


                                                </div>
                                            </div>
                                            <div class="col-md-8 col-xl-10 px-2 text-left align-self-center">
                                                <h1 class="fw-bolder">{{$company->name}}</h1>

                                                <div class="ratings">
                                                <span class="review-count ">(12) &nbsp;</span>
                                                    <i class="fa fa-star rating-color"></i>
                                                    <i class="fa fa-star rating-color"></i>
                                                    <i class="fa fa-star rating-color"></i>
                                                    <i class="fa fa-star rating-color"></i>
                                                    <i class="fa fa-star"></i>
                                                    <a href="#" class=" text-center">&nbsp;&nbsp;&nbsp; 4.2 rating</a>
                                                </div>            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xl-2 follow_btn3ws align-self-center text-center">
                                        <button class="btn bg-primary text-white rounded-pill" type="button" onclick="ChangePhoneNumber();">Following</button>
                                    </div>                            
                                </div>
                            </div>
                        </div>

                    <div class="card detail_applierss2 p-3">
                        <div class="container">
                            <div class="text-justify mb-4">
                                <h2 class="fw-bolder mt-3">About Company / Organization:</h2>
                                <p>{{$company->description}}</p>

                            </div>

                            <div class="comdetail2list">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>CEO</p>
                                        <span class="fw-bolder">@if($company->CEO_name != null){{$company->CEO_name}} @else NIL @endif</span>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Founded On</p>
                                        <span class="fw-bolder">@if($company->founded_on != null) {{ date('d',strtotime($company->founded_on)) }}th {{ $arra[intval(date('m',strtotime($company->founded_on)))-1]}} {{date('Y',strtotime($company->founded_on)) }} @else NIL @endif</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p>Current number of employees</p>
                                        <span class="fw-bolder">{{ $company->no_of_employees }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Types of industry</p>
                                        <span class="fw-bolder">{{ DataArrayHelper::industryParticular($company->industry_id) }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p>Website</p>
                                        <span class="fw-bolder">@if($company->website_url != null){{$company->website_url}} @else NIL @endif</span>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Social Media profiles</p>
                                        <h5 class="aboutcompany_heading1"><div class="socialmediaappend"></div></h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p>Address</p>
                                        <span class="fw-bolder">@if($company->address != null){{$company->address}} @else NIL @endif </span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p>City</p>
                                        <span class="fw-bolder">{{ $company->location }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <p>State</p>
                                        <span class="fw-bolder">{{ DataArrayHelper::countryParticular($company->country_id) }}</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p>Country</p>
                                        <span class="fw-bolder">{{ DataArrayHelper::countryParticular($company->country_id) }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Pincode</p>
                                        <span class="fw-bolder">{{$company->pin_code}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  

                
                <div class="tab-pane" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                            <div class="galaryappendcontent row"></div>
                    </div>

                    <div class="tab-pane" id="activejobs" role="tabpanel" aria-labelledby="review-tab">
                        <div class="row">
                       

                       @if(count($company_jobs) != 0)
                            @foreach($company_jobs as $for)
                                    <div class="col-md-6">
                                        <a class="cursor-pointer text-dark" href="{{url('detail/'.$for->slug)}}">
                                            <div class="card jobsearch p-4">
                                                <div>
                                                    <h2 class="fw-bolder">{{$for->title}}</h2>
                                                    <p>{{$company->name}}</p></td>
                                                    <table>
                                                    <tr>
                                                        <td><p><strong class="fw-bolder">Experience &nbsp;</strong></td><td>:&nbsp; {{$for->experience}}</p></td></tr/>
                                                    <td><p><strong class="fw-bolder">Salary &nbsp;</strong></td><td>:&nbsp; {{$for->salary_from}}k to {{$for->salary_to}}k</p></td>
                                                    </table>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                            @endforeach
                       @else

                       <span class="text-center fw-bolder">No Active Jobs</span>

                       @endif
                       
                    </div>
                </div>   
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
                        if(data['description'].length > 30) 
                        {
                            str = data['description'].substring(0,30); 
                        }
                        else
                        {
                            str = data['description']; 
                        }

                        $('.galaryappendcontent')
                        .append(`  <div class="col-md-4 col-xl-3">
                                    <div class="card zoom opacity savecompanyname" onClick="viewdata(`+data["id"]+`)" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        <div class="text-center"><div class="box"> 
                                            <img class="card-img-top imgclass" src=`+data['image_exact_url']+`>
                                        </div>
                                        <div class="card-body"> 
                                            <h5 class="card-title text-start fw-bolder">`+data['title']+`</h5> 
                                            <p class="card-text text-start">`+str+`</p> 
                                        </div> 
                                    </div>
                                </div>`);
                    });

                }else{
                    $('.galaryappendcontent').append('<span class="text-center fw-bolder">No Active Gallery</span>');
                }
            
            });

        var socialvalues='';
            if('<?php echo $company->fb_url; ?>' != '')
            {
                socialvalues+='<a href="{{$company->fb_url}}" target="_blank" ><i class="fa fa-facebook"></i></a>'; 

            }
            else
            { 
                socialvalues+='<i class="fa fa-facebook noclrfa"></i>'; 

            }   
            
            
            if('<?php echo $company->twitter_url; ?>' != '')
            {
                socialvalues+='<a href="{{$company->twitter_url}}"><i href="{{$company->fb_url}}" target="_blank" class="fa fa-twitter"></i></a>'; 

            }
            else
            { 
                socialvalues+='<i class="fa fa-twitter noclrfa"></i>'; 

            }     


            if('<?php echo $company->linkedin_url; ?>' != '')
            {
                socialvalues+='<a href="{{$company->linkedin_url}}"><i href="{{$company->fb_url}}" target="_blank" class="fa fa-linkedin"></i></a>'; 

            }
            else
            { 
                socialvalues+='<i class="fa fa-linkedin noclrfa"></i>'; 

            }      
            
            
            if('<?php echo $company->insta_url; ?>' != '')
            {
                socialvalues+='<a href="{{$company->insta_url}}"><i href="{{$company->fb_url}}" target="_blank" class="fa fa-instagram "></i></a>'; 

            }       
            else
            {
                socialvalues+='<i class="fa fa-instagram noclrfa"></i>'; 

            }

        $('.socialmediaappend').html(socialvalues);
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