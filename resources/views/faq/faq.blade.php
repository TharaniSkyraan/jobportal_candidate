@extends('layouts.app')

@section('custom_scripts')
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/faq!2&32.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="wrapper" >        
  @include('faq.header')
  @include('faq.categorylist')
    <div class="main-panel main-panel-custom">
      <div class="content">
          <div class="page-header justify-content-center mt-5 mb-1">
            <h2 class="page-title d-flex"> <img src="{{asset('images/m_svg/FAQ.svg')}}" class="dropdown" alt="..."> Frequently Asked Questions</h2>
          </div>
			    <div class="page-inner">
              <div class="ske">
                  <div class="input-group">
                    <input class="form-control border-end-0 border" type="search" placeholder="Search your queries here" id="search_input">
                    <span class="input-group-append">
                        <button class="btn bg-white border-start-0 border ms-n5" type="button" id="search">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                 </div>              
              </div>

              <div id="content">
                <h3 id="bi_activ_ct">{{ $cat->faq_category}}</h3>
                  <ul class="timeline catfaqs">
                  </ul>
                  <div id="nodatamsg"></div> 
              </div>
          </div>
      </div>
	  </div>
</div>
@endsection

@section('footer')
@include('layouts.footer')
<!-- action srcip starts-->
<script>
  var baseurl = '{{ url("/") }}/';
  var cat_key_from_url = '{{ $cat->slug }}';
  var is_empty_categorykey = '{{$ckey}}';
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<script src="http://devanswer.com/codes/files/prefixfree.min.js"></script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/1a9ve2/js/faq!2&32.js') }}"></script>

@endsection
