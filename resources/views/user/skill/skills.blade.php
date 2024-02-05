@extends('layouts.pages.common_app')
@section('custom_scripts')
    <link href="{{ asset('site_assets_1/assets/css/input_tag/jquery-ui.min.css')}}" rel="stylesheet">
    <link href="{{ asset('site_assets_1/assets/css/input_tag/jquery.tagsinput-revisited.css')}}" rel="stylesheet">	  
    <link href="{{ asset('site_assets_1/assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('site_assets_1/assets/vendor/selectize/selectize.css')}}" rel="stylesheet">
    <link href="{{ asset('site_assets_1/assets/1a9ve2/css/userbasic.w2fr4ha2.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('site_assets_1/assets/date_flatpicker/flatpickr.min.css')}}">
    <script src="{{ asset('site_assets_1/assets/date_flatpicker/flatpickr.js')}}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
@endsection
@section('title') Mugaam - My Skills Page @endsection
@section('content')
<div class="wrapper" >
	@include('layouts.header.auth.dashboard_header')
	@include('layouts.sidenavbar.side_navbar')

	<div class="main-panel main-panel-custom">
		<div class="content">
			<div class="page-inner">
                <div id="my_expernce2" class="mt-3">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img draggable="false" src="{{asset('images/sidebar/skill.svg')}}">&nbsp;My skills</h2>
                    </div>

                    <div class="crdbxpl mt-4 mb-5">
                        <div class="row">
                            <div class="col-7 px-4 align-self-center">Skill</div>
                            <div class="col-5 text-end addSkills"><button class="openForm" type="button" data-form="new">Add New <i class="fa fa-plus"></i></button></div>
                        </div>
                    </div>

                    <div class="append-form-skill" id="append-form-skill"></div>

                    <!-- Skill List card-->
                    <div class="" id="skill_div"></div>                        
                    <!-- Skill List card end -->

                </div>
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
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/dashboard/uski!e8u)y6.js') }}"></script>
@endpush