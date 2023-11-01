@extends('layouts.app')

@section('custom_scripts')
    <title>Mugaam - Blogs</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('css/omsfeqx.css')}}">
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search_side_navbar')
    <main id="blogs_pgn">
        <div class="slide-blogs">
            <div class="slider_first p-0">
                <div id="breadcrumbs">
                    <div id="knjh_jhyt"></div>
                    <div class="item_brds">
                        <a href="{{url('/')}}"><span>Home</span></a>
                        <a href="{{url('blogs')}}"><span class="breadcrumb-item active">> Blogs</span></a>
                    </div>
                </div>
                <div class="owl-carousel owl-theme">
                    @foreach($sliders as $row)
                        @php
                            $formats = \Carbon\Carbon::parse($row->created_at)->format('D jS, M Y');
                        @endphp
                        <a href="{{route('view-blog', [$row->id, $row->slug])}}">
                            <article class="item">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="imagebnrs" style="background-image:url('{{$row->thumbnail_url}}')">
                                            <div class="child_1">
                                                <div class="captions">
                                                    <h2 class="text-capitalize">{{$row->title}}</h2>
                                                    <p>{{$row->short_description}}</p>
                                                    <p class="m-0">{{$formats}} </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="blog-container">
            <div class="blg-top list-blogs">
                <div class="text-center">
                    <h2>More Blogs for You</h2>
                </div>
                <div class="blg-top search_hbcf">
                    <input type="text" class="form-control" id="blog-search" placeholder="Search Blogs" autocomplete="off"> 
                    <button class="vgr_mnwen"><img src="{{asset('images/blogs/search.svg')}}" alt="search-icon"><span class="mjmhwq">Search</span></button>
                </div> 
                <div class="row show_hwtn blg-top"></div>
            </div>
            <!--subscribe section-->
            <div class="subscribe_usr">
                <div class="card">
                    <div class="row">
                        <div class="col-xl-3 col-lg-2 col-md-2">
                            <div class="look1_m">
                                <img src="{{asset('images/blogs/subscribe1.svg')}}" draggable="false" alt="subscribe-image">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-8 col-md-8 align-self-center">
                            <div class="text-center qgwuvsd">
                                <h3><strong>Subscribe to our blogs</strong></h3>
                                <p>Subscribe to our newsletters to get to know latest trends in the world of recruitment.</p>
                                <input type="email" class="form-control" name="email" autocomplete="off" placeholder="Enter your mail ID">
                                <div class="mt-3">
                                    <button>SUBSCRIBE</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2">
                            <div class="look2_m">
                                <img src="{{asset('images/blogs/subscribe2.svg')}}" draggable="false" alt="subscribe-image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>               
    <script type="text/javascript">  
         var baseUrl = "{{ config('app.url') }}";
        
        $(document).ready(function() {
            $('.slider_first .owl-carousel').owlCarousel({
                items: 2,
                nav: false,
                dots: true,
                loop: true,
                mouseDrag: false,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    1200: {
                        items: 1
                    },
                    1600: {
                        items: 1
                    }
                },
                autoplay: true, 
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                animateIn: 'fadeIn',
                animateOut: 'fadeOut'
            });
        });
        $(document).ready(function() {
            var elementPosition = $('.search_hbcf').offset();
            $(window).scroll(function() {
                if ($(window).scrollTop() > elementPosition.top) {
                    $('.search_hbcf').addClass('added');
                } else {
                    $('.search_hbcf').removeClass('added');
                }
            });

        });
        search_blog('all', 'undefined');
        $(document).on('click', '.vgr_mnwen', function(){
            var value = $('#blog-search').val();
            if (value.trim() === '' ) {
                $('#blog-search')[0].setCustomValidity('Input cannot be empty.');
                $('#blog-search')[0].reportValidity();
                return false;  
            }else{
                page = 'undefined';
                search_blog(value, page);
            }
        });
        $(document).on('keyup', '#blog-search', function(){
            var value = $('#blog-search').val();
            if (value.trim() === '' ) {
                search_blog('all', 'undefined');
            }
        });

        $('#blog-search').on('keydown', function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                $('.vgr_mnwen').click();
            }
        });


        function search_blog(value, page)
        {
            if(value == 'all'){
                var value = '';
            }
            $.ajax({
                type: 'post',
                url: "{{ url('search-blogs') }}",
                data: { value: value, page: page },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) 
                {
                    var element = $(data).closest('.not_fnfi').length;
                    var length = $('.show_hwtn .card').length;
                    if(element == 1 && page != 'undefined'){
                    }else{
                        if(page == 'undefined' && value.trim() != ''){
                            $('.show_hwtn').html(data);
                        }else if(value == '' && page == 'undefined'){
                            $('.show_hwtn').html(data);
                        }else{
                            if(length == 0){
                                $('.show_hwtn').html(data);
                            }else{
                                $('.show_hwtn').append(data);
                            }
                        }
                        setTimeout(() => {
                            $('.top-placeholder').removeClass('top-placeholder');
                            $('.placeholder1').removeClass('placeholder1');
                            $('.opacity-0').removeClass('opacity-0');
                        }, 200);
                       
                    }
                        
                },
                error: function(data) {
                }
            });
        }

        var docsLoaded = false;
        $(window).scroll(function() {
            var targetDivs = $('.show_hwtn .card:last');
            var windowHeight = $(window).height();
            var scrollTop = $(window).scrollTop();
            
            targetDivs.each(function() {
                var targetDiv = $(this);
                var targetOffset = targetDiv.offset().top;
                
                if (scrollTop + windowHeight >= targetOffset && !docsLoaded) {
                    if (targetDiv.attr('id')) {
                        var idin = $('.lastids:last').attr('id');
                        var page = targetDiv.attr('id');
                        if (idin >= page) {
                            var value = $('#blog-search').val();
                            search_blog(value, page);
                            docsLoaded = true;

                        }
                    }
                }
            });
        });

        $(document).on('click', '.likes_stns', function(){
            var auth = "{{Auth::check()}}";
           if(auth == true){
                var id = $(this).closest('.card').attr('id');
                var path = '.card#'+id+' .likes_stns';
                like_blog(id, path);
           }else{
                window.location.href = "{{url('login')}}";
           }
        });


        function like_blog(id, path){
            $.ajax({
                type:'post',
                url:'{{url("like-blog")}}/'+id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(data){
                    if(data[0] == 1){
                        $(path+' img').attr('src', baseUrl+'/images/blogs/liked.svg')
                    }else{
                        $(path+' img').attr('src', baseUrl+'/images/blogs/likes.svg')
                    }
                    $(path+' .count_l').html(data[1]);
                },
                error:function(data){

                }
            });
        }


    </script> 
@endsection
@section('footer')
    @include('layouts.footer')
@endsection