@extends('layouts.app')
@section('custom_scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('css/omsfeqx.css')}}">
    <title>Blog Page</title>
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search_side_navbar')
    <main id="view-blog">
        <div class="view-div">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{url('blogs')}}">Blogs</a></li>
                </ol>
            </nav>
           
            <div class="result_cnhgb">
                <h2 class="mt-4">{{$blog->title}}</h2>
                <div class="row blgv_tybw">
                    <div class="col-md-8">
                    <span class="grayc">{{ \Carbon\Carbon::parse($blog->created_at)->format('D jS, M Y') }}</span>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4">
                                <span class="like_view"><img src="@if(Auth::check())@if($like == null) {{asset('images/blogs/likes.svg')}} @else {{asset('images/blogs/liked.svg')}} @endif @else {{asset('images/blogs/likes.svg')}} @endif" alt="like-image"><span class="count_l">{{$count_l}}</span> likes</span>
                            </div>
                            <div class="col-md-4">
                                <div data-toggle="tooltip"            >
                                    <div id="example" rel="popover">
                                        <img src="{{asset('images/blogs/share.svg')}}" alt="share" draggable="false"> Share
                                    </div>
                                </div>
                            </div>
                            <div id="popover_share" style="display: none">
                                <span><a href="https://www.facebook.com/sharer/sharer.php?u={{url('view-blog',[$blog->id, $blog->slug])}}" target="_blank" class="share_social"><img src="{{asset('images/blogs/fb.svg')}}" alt="facebook-share"></a></span>
                                <span>&nbsp;&nbsp;&nbsp;<a href="https://wa.me/?text={{url('view-blog',[$blog->id, $blog->slug])}}" target="_blank" class="share_social"><img src="{{asset('images/blogs/whatsapp.svg')}}" alt="whatsapp-share"></a></span>
                                <span>&nbsp;&nbsp;&nbsp;<a href="https://twitter.com/intent/tweet?url={{url('view-blog',[$blog->id, $blog->slug])}}&text={{$blog->title}}" target="_blank" class="share_social"><img src="{{asset('images/blogs/twitter.svg')}}" alt="x-share"></a></span>
                                <span>&nbsp;&nbsp;&nbsp;<a href="https://www.linkedin.com/shareArticle?mini=true&url={{url('view-blog',[$blog->id, $blog->slug])}}" target="_blank" class="share_social"><img src="{{asset('images/blogs/linked_in.svg')}}" alt="linkedin-share"></a></span>
                            </div>
                            <div class="col-md-4">
                                <span class="reads_view"><img src="{{asset('images/blogs/readers.svg')}}" alt="read-image">{{$count_v}} Reads</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-section">
                    @php
                        $description = str_replace('<p>&nbsp;</p>', '', $blog->description);
                        echo $description;
                    @endphp
                </div>
                 <!--subscribe section-->
                <div class="subscribe_usr">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="look1_m">
                                    <img src="{{asset('images/blogs/subscribe1.svg')}}" draggable="false" alt="subscribe-image">
                                </div>
                            </div>
                            <div class="col-md-6 align-self-center">
                                <div class="text-center qgwuvsd">
                                    <h3><strong>Subscribe to our blogs</strong></h3>
                                    <p>Subscribe to our newsletters to get to know latest trends in the world of recruitment.</p>
                                    <input type="email" class="form-control" name="email" autocomplete="off" placeholder="Enter your mail ID">
                                    <div class="mt-3">
                                        <button>SUBSCRIBE</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="look2_m">
                                    <img src="{{asset('images/blogs/subscribe2.svg')}}" draggable="false" alt="subscribe-image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="blg-top list-blogs">
                    <div class="text-center">
                        <h2>More Blogs for You</h2>
                    </div>
                    <div class="row">
                        @foreach($more as $row)
                            @php
                                $formats = \Carbon\Carbon::parse($row->created_at)->format('D jS, M Y');
                                $count_v = \App\Model\BlogView::where('blog_id', $row->id)->count();
                                $count_l = \App\Model\BlogLike::where('blog_id', $row->id)->count();
                            @endphp
                            <div class="col-md-6">
                                <div class="card blg-top" id="{{$row->id}}">
                                    <a href="{{route('view-blog', [$row->id, $row->slug])}}">
                                        <div class="card-body p-0">
                                            <img src="{{$row->thumbnail_url}}" alt="{{$row->title}}" class="img-fluid" draggable="false" >
                                        </div>
                                    </a>
                                    <div class="card-footer">
                                        <a href="{{route('view-blog', [$row->id, $row->slug])}}">
                                            <h3>
                                                {{$row->title}}
                                            </h3>
                                            <p>{{$row->short_description}}</p>
                                        </a>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <a href="{{route('view-blog', [$row->id, $row->slug])}}">
                                                    <span class="grayc">{{$formats}}</span>
                                                </a>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <span class="likes_stns"><img src="{{asset('images/blogs/likes.svg')}}" alt="likes"><span class="count_l">{{$count_v}}</span> likes</span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <a href="{{route('view-blog', [$row->id, $row->slug])}}">
                                                            <div class="right-hover" style="display:none">
                                                                <img src="{{asset('images/blogs/right_s.svg')}}" alt="right-side-arrow">
                                                            </div>
                                                            <div class="right-hover">
                                                                <span class="readers"><img src="{{asset('images/blogs/readers.svg')}}" alt="readers">{{$count_l}} Reads</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>  
    
    <script>
         var baseUrl = "{{ config('app.url') }}";
        $(document).on('click', '.like_view', function(){
            var auth = "{{Auth::check()}}";
           if(auth == true){
                var path = '.like_view';
                like_blog('{{$blog->id}}', path);
           }else{
            window.location.href = "{{url('login')}}";
           }
        });

        $(document).ready(function() {
            $('img').attr('draggable', 'false');
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

        $(function()
        {
            $('[rel=popover]').popover({ 
                html : true, 
                content: function() 
                {
                    return $('#popover_share').html();
                }
            });
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $(function() {
            var tooltip = $('[data-toggle="tooltip"]').tooltip();

            if (window.innerWidth < 768) {
                tooltip.tooltip('disable');
            }
        });

        $(document).on('click', function(event) {

            var target = $(event.target);
            if (!target.closest('#popover_share').length) {
                
            }
        });

        $(document).on('click', '.likes_stns', function(){
           var id = $(this).closest('.card').attr('id');
           var path = '.card#'+id+' .likes_stns';
           like_blog(id, path);
        });
    </script>
@endsection
@section('footer')
    @include('layouts.footer')
@endsection