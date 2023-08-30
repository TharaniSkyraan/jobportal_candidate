@extends('layouts.app')

@section('custom_scripts')
<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery-ui.min.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery.tagsinput-revisited.css')}}" rel="stylesheet">	  
<link href="{{ asset('site_assets_1/assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/vendor/selectize/selectize.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/userbasic.w2fr4ha2.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="wrapper" >
	@include('layouts.dashboard_header')
	@include('layouts.side_navbar')

	<div class="main-panel main-panel-custom main-panel-customize">
		<div class="content">
            <div class="page-inner">        
                <div id="language_knwn" class="mt-4">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img draggable="false" src="{{asset('images/sidebar/language.svg')}}">&nbsp;Languages Known</h2>
                    </div>

                    <div class="crdbxpl mt-5">
                        <div class="row">
                            <div class="col-7 px-4 align-self-center">Languages Known</div>
                            <div class="col-5 text-end"><button class="btn openForm addbtn" type="button" data-form="new">Add New <i class="fa fa-plus"></i></button></div>
                        </div>
                    </div>

                    <div class="append-card-language">
                        @if(count(Auth::user()->userLanguages) == 0)
                        <div class="text-center">
                            <img draggable="false" src="{{ asset('site_assets_1/assets/img/fresher.png')}}" height="250" width="250">
                        </div>
                        @endif 
                    </div>
                    
                    <!-- Language List card-->
                    <div class="" id="language_div"></div>                        
                    <!-- Language List card end -->

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/selectize/selectize.js')}}"></script>
<script  type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/typehead/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
var baseurl = '{{ url("/") }}/';
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/dashboard/ulang.!e52q)y6.js') }}"></script>
@endpush