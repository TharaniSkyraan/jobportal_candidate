@extends('layouts.app')
@section('custom_styles')
  <title>Mugaam - FAQ</title>
  <link href="{{ asset('site_assets_1/assets/1a9ve2/css/faq!2&32.css')}}" rel="stylesheet">
  <style>
    .navbar .dropdown ul {
      left: 0px;
    }
    @media(min-width: 400px) and (max-width: 767px){   
      .navbar .dropdown ul {
        left: 70px;
      }
    }
    @media(min-width: 280px) and (max-width: 400px){   
      .navbar .dropdown ul {
        left: 20px;
      }
    }
    .sidenavbar.sidenavbarfaq{
      z-index: 12;
    }.content .footer{
      z-index: 2;
      position: relative !important;
      left: 0px;
      margin-top: 85px;
    }
  </style>
@endsection
@section('content')
  <div class="wrapper" >        
    @include('faq.header')
    @include('faq.categorylist')
    <div class="main-panel main-panel-custom">
      <div class="content">
          <div class="page-header justify-content-center  align-items-center mt-5 mb-1">
            <h2 class="page-title d-flex"> <img draggable="false" src="{{asset('images/m_svg/FAQ.svg')}}" class="dropdown" alt="..."> Frequently Asked Questions</h2>
          </div>
          <div class="page-inner">
            <div class="ske">
                <div class="input-group">
                  <input class="form-control border-end-0 border" type="search" placeholder="Search queries here" id="search_input">
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
          @include('faq.footer') 
      </div>
    </div>
  </div>
@endsection
@section('custom_bottom_scripts')
  <script>
    var baseurl = '{{ url("/") }}/';
    var cat_key_from_url = '{{ $cat->slug }}';
    var is_empty_categorykey = '{{$ckey}}'; 
  </script>
  <script type="text/javascript" src="{{ asset('site_assets_1/assets/js/sidenavbarscript.js') }}"></script>
  <script type="text/javascript" src="{{ asset('site_assets_1/assets/1a9ve2/js/faq!2&32.js') }}"></script>
@endsection
