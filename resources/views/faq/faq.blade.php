
@extends('layouts.pages.common_app')
@section('title') Mugaam - FAQ @endsection
@section('custom_scripts')        
  <link href="{{ asset('site_assets_1/assets/1a9ve2/css/faq!2&32.css')}}" rel="stylesheet">
@endsection
@section('content')

    @include('layouts.header.header')
    <div class="container">
      <div class="content">
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
            <div class="page-header justify-content-center  align-items-center mt-5 mb-1">
              <h2 class="page-title d-flex"> <img draggable="false" src="{{asset('images/m_svg/FAQ.svg')}}" class="dropdown" alt="..."> Frequently Asked Questions</h2>
            </div>
            <div id="content">
              <ul class="timeline catfaqs">
              </ul>
              <div id="nodatamsg"></div>
            </div>
          </div>
      </div>
    </div>
@endsection
@section('footer')
    @include('layouts.footer.footer')
@endsection
@section('custom_bottom_scripts')
  <script>
    var baseurl = '{{ url("/") }}/';
    var cat_key_from_url = '{{ $cat->slug }}';
    var is_empty_categorykey = '{{$ckey}}'; 
  </script>
  <script type="text/javascript" src="{{ asset('site_assets_1/assets/1a9ve2/js/faq!2&32.js') }}"></script>
@endsection


