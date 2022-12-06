@extends('layouts.app')

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
        padding: 130px 0 70px 0;
        /* background: linear-gradient(-45deg, #629bf6b1, #629AF6, #4285F4); */
        /* background: rgb(2,0,36); */
        /* background: linear-gradient(160deg, rgba(2,0,36,1) 0%, rgba(66,133,244,1) 0%, rgba(66,133,240,1) 100%); */
        background: url("{{ url('site_assets_1/assets/images/aero2.svg') }}") no-repeat left bottom,linear-gradient(160deg, rgba(2,0,36,1) 0%, rgba(66,133,244,1) 0%, rgba(66,133,240,1) 100%);
        /* background-size: contain; */
    }

        .bg-very-light-gray {
        background: #4285f11c;
        }
        .service-wrapper {
        padding: 25px;
        border: 1px solid #ededed;
        text-align: center;
        height: auto;
        width: 80%;
        position: relative;
        background-color: #fff;
        border-radius: 10px;
        -webkit-box-shadow: 0 2px 4px 0 rgb(0 0 0 / 20%);
        margin: 14px 0 26px;
        }

        .service-wrapper:hover {
        border: 1px solid #4285f0b3 !important;
        }

        .service-wrapper .service-icons {
        width: 80px;
        height: 80px;
        text-align: center;
        border: 1px solid #ededed;
        padding: 15px;
        margin: 0 auto 25px;
        border-radius: 8px;
        background: rgba(38, 174, 97, 0.1);
        }
        .service-wrapper img {
        max-width: 100%;
        height: auto;
        vertical-align: top;
        }
</style>
@endsection

@section('content')

<div class="">
	@include('layouts.header')
    
    <section>
    <div class="search-inp-sec">
        <div class="">
            <div class="row mx-auto container cusconta ">
                <div class="mb-4">
                    <h1 class="fw-bold text-white">Find your favourite job in no time!!</h1>
                </div>

                <div class="col-md-6 mb-3">
                    {!! Form::search('designation', null, array('class'=>'form-control-2  typeahead', 'id'=>'designation',
                    'placeholder'=>__('Job title, keywords or company'),  'autocomplete'=>'off', 'spellcheck'=>'false' ) ) !!}
                    {{-- <span class="icl-TextInput-icon iconRight" aria-hidden="true"><span class="" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" fill="none" aria-hidden="true"><defs></defs><path fill="#767676" fill-rule="evenodd" d="M11.4038 12.3048C10.7084 12.7451 9.88397 13 9 13c-2.48528 0-4.5-2.0147-4.5-4.5C4.5 6.01472 6.51472 4 9 4c2.4853 0 4.5 2.01472 4.5 4.5 0 .87711-.2509 1.6956-.6849 2.3876l3.5089 3.5089c.1952.1953.1952.5119 0 .7071l-.7071.7072c-.1953.1952-.5119.1952-.7071 0l-3.506-3.506zM11.5 8.5c0 1.38071-1.1193 2.5-2.5 2.5-1.38071 0-2.5-1.11929-2.5-2.5S7.61929 6 9 6c1.3807 0 2.5 1.11929 2.5 2.5z" clip-rule="evenodd"></path></svg></span></span> --}}
                    <span class="form-text text-white err_msg designation-error"></span>
                </div>

                <div class="col-md-4 mb-3">                    
                    {!! Form::search('location', null, array('class'=>'form-control-2 typeahead', 'id'=>'location', 'placeholder'=>__('On Location'),' aria-label'=>'On Location')) !!}
                    <span class="form-text text-white err_msg"></span>
                </div>
                <div class="col-md-1 mb-3 text-center">                    
                    {!! Form::button('Search', array('class' => 'btn search-button-bg ','id'=>'msearch_btn', 'type' => 'submit')) !!}                   
                </div>
            </div>
        </div>
    </div>

    @if(1)
    <div class="crsection">
        <div class="cusconta row mx-auto container pt-5 pb-5 justify-content-between">
            <div class="pcardsec card mb-4 col-md-5 col-sm-12 col-xs-12">
                <div class="rcsdiv">
                    <div class="mb-3">
                        <h3 class="fw-bolder">Trending Jobs</h3>
                    </div>
                    <div class="">
                        @forelse($titles as $title)
                        <div class="mb-2">
                            <text class="resentsearch cursor-pointer" data-d="{{$title->title}}" data-l="">{{$title->title}}</text>
                            {{-- <span><img src="{{url('site_assets_1/assets/img/arrow.77068bf0.png')}}"></span> --}}
                        </div>
                        @empty
                            No data available
                        @endforelse
                    </div>
                </div>   
                <div class="cuscard d-flex">
                    <div class="col align-self-center">
                        <text>Choose the right one</text><br>
                        <text>Create Jobs</text>
                    </div>
                    <div class="col frgnt">
                        <a href="{{ route('login')}}">
                            {!! Form::button('Post Your Job', array('class' => 'btn rcbtn', 'type' => 'button')) !!} 
                        </a>
                    </div>
                </div>
            </div>
            <div class="pcardsec card mb-4 col-md-5 col-sm-12 col-xs-12" >
                <div class="rcsdiv">
                    <div class="mb-3">
                        <h3 class="fw-bolder">Recent Searches</h3>
                    </div>
                    <div class="">
                        @php
                            $cacheData = Cookie::has('searchJobs') ? json_decode(Cookie::get('searchJobs')):array(); 
                            $cachedatas = array_reverse($cacheData); 
                        @endphp
                        @forelse($cachedatas as $key => $search)
                            @if($key < 5 && ($search->designation !='' || $search->location !='')  )
                                <div class="mb-1">
                                    <text class="mb-1 resentsearch cursor-pointer" data-d="{{$search->designation}}" data-l="{{$search->location}}">{{$search->designation}} {{$search->location}}</text>
                                    {{-- <span><img src="{{url('site_assets_1/assets/img/arrow.77068bf0.png')}}"></span> --}}
                                </div>
                            @endif
                        @empty
                        <div class="mb-5">  
                            <text>No search till now</text>
                        </div>
                        @endforelse                
                    </div>
                </div>

                <div class="cuscard d-flex ">
                    <div class="col align-self-center">
                        <text>Don't miss job opportunities</text><br>
                        <text>Find a dream job!!</text>
                    </div>
                    <div class="col frgnt ">
                        <a href="{{ route('login')}}">
                            {!! Form::button('Upload Resume', array('class' => 'btn rcbtn', 'type' => 'button')) !!} 
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    @endif
    </section>
    
    <section class="hero ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-md-7 heading-section text-center ftco-animate fadeInUp ftco-animated">
                {{-- <span class="subheading">Job Categories</span> --}}
                    <h2 class="mb-0">Top Categories</h2>
                </div>
            </div>
            <div class="row place-content-center">
                <div class="col-md-3 ftco-animate fadeInUp ftco-animated">
                    <ul class="category text-center">
                        <li>
                            <a href="javascript:void(0);" class="resentsearch" data-d="Web Development">Web Development<br><div class="number">354+</div> <i class="fa fa-angle-right"></i></a>
                        </li>
                        <li><a href="javascript:void(0);" class="resentsearch" data-d="Graphic Designer">Graphic Designer <br><div class="number">143+</div> <i class="fa fa-angle-right"></i></a></li>
                        <li><a href="javascript:void(0);" class="resentsearch" data-d="Multimedia">Multimedia <br><div class="number">100+</div> <i class="fa fa-angle-right"></i></a></li>
                        <li><a href="javascript:void(0);" class="resentsearch" data-d="Advertising">Advertising <br><div class="number">90+</div> <i class="fa fa-angle-right"></i></a></li>
                    </ul>
                </div>
                <div class="col-md-3 ftco-animate fadeInUp ftco-animated">
                    <ul class="category text-center">
                        <li><a href="javascript:void(0);" class="resentsearch" data-d="Online Tutoring">Online &amp; Tutoring <br><div class="number">100+</div> <i class="fa fa-angle-right"></i></a></li>
                        <li><a href="javascript:void(0);" class="resentsearch" data-d="Supply Chain">Supply Chain <br><div class="number">200+</div> <i class="fa fa-angle-right"></i></a></li>
                        <li><a href="javascript:void(0);" class="resentsearch" data-d="Social Media">Social Media <br><div class="number">300+</div> <i class="fa fa-angle-right"></i></a></li>
                        <li><a href="javascript:void(0);" class="resentsearch" data-d="Remote">Remote<br><div class="number">150+</div> <i class="fa fa-angle-right"></i></a></li>
                    </ul>
                </div>
                <div class="col-md-3 ftco-animate fadeInUp ftco-animated">
                    <ul class="category text-center">
                        <li><a href="javascript:void(0);" class="resentsearch" data-d="Data Science">Data Science<br><div class="number">400+</div> <i class="fa fa-angle-right"></i></a></li>
                        <li><a href="javascript:void(0);" class="resentsearch" data-d="Project Management">Project Management <br><div class="number">100+</div> <i class="fa fa-angle-right"></i></a></li>
                        <li><a href="javascript:void(0);" class="resentsearch" data-d="Banking and Finance">Banking &amp;Finance<br><div class="number">222+</div> <i class="fa fa-angle-right"></i></a></li>
                        <li><a href="javascript:void(0);" class="resentsearch" data-d="Office Admin">Office &amp; Admin <br><div class="number">123+</div> <i class="fa fa-angle-right"></i></a></li>
                    </ul>
                </div>
                <div class="col-md-3 ftco-animate fadeInUp ftco-animated">
                    <ul class="category text-center">
                        <li><a href="javascript:void(0);" class="resentsearch" data-d="Delivery Excutive">Delivery Excutive<br><div class="number">324+</div> <i class="fa fa-angle-right"></i></a></li>
                        <li><a href="javascript:void(0);" class="resentsearch" data-d="Customer Service">Customer Service <br><div class="number">564+</div> <i class="fa fa-angle-right"></i></a></li>
                        <li><a href="javascript:void(0);" class="resentsearch" data-d="Marketing Sales">Marketing &amp; Sales <br><div class="number">234+</div> <i class="fa fa-angle-right"></i></a></li>
                        <li><a href="javascript:void(0);" class="resentsearch" data-d="Software Development">Software Development <br><div class="number">425+</div> <i class="fa fa-angle-right"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-very-light-gray ftco-section">
        <div class="container">
            <div class="section-heading text-center">
                <h2 class="fw-bold">Our Best Services For You</h2>
                <p>Know your really worth and find the job that qualify your life.</p>
            </div>
            <div class="row mt-n1-9">
                <div class="col-md-6 col-lg-4 mt-1-9  mb-4">
                    <div class="service-wrapper">
                        <div class="service-icons">
                            <img src="{{url('site_assets_1/assets/images/static_pages//icon-19.png')}}" alt="...">
                        </div>
                        <h4 class="h5 mb-3 fw-bold">Job Search</h4>
                         <p class="mb-0 w-90 mx-auto">Looking for a job while studying, fresher or experienced? in search of the right job.</p> 
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mt-1-9  mb-4">
                    <div class="service-wrapper">
                        <div class="service-icons">
                            <img src="{{url('site_assets_1/assets/images/static_pages//icon-20.png')}}" alt="...">
                        </div>
                        <h4 class="h5 mb-3 fw-bold">Display Jobs</h4>
                         <p class="mb-0 w-90 mx-auto">Pick a job from the live list for your skill set.<br><br></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mt-1-9  mb-4">
                    <div class="service-wrapper">
                        <div class="service-icons">
                            <img src="{{url('site_assets_1/assets/images/static_pages//icon-18.png')}}" alt="...">
                        </div>
                        <h4 class="h5 mb-3 fw-bold">Achieve Your Dream Job</h4>
                         <p class="mb-0 w-90 mx-auto">Attend the scheduled job interview and you will be offered an interesting job position.</p> 
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- 
    <div class="row mt-4 mb-4 align-items-center">
        <div class="mt-3 mb-4">
            <div class="text-center mb-5"><h2 class="fw-bold">Top Recruiters</h2></div>
            <div class="top-recruiters">
                <div><img class="top-recruiters-img" src="{{url('site_assets_1/assets/img/google.jpg')}}"></div>
                <div><img class="top-recruiters-img" src="{{url('site_assets_1/assets/img/tata-logo-blue.png')}}"></div>
                <div><img class="top-recruiters-img" src="{{url('site_assets_1/assets/img/google.jpg')}}"></div>
                <div><img class="top-recruiters-img" src="{{url('site_assets_1/assets/img/tata-logo-blue.png')}}"></div>
                <div><img class="top-recruiters-img" src="{{url('site_assets_1/assets/img/tata-logo-blue.png')}}"></div>
            </div>
        </div>
    </div> -->
</div>
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