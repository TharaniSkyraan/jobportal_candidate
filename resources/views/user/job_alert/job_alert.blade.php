@extends('layouts.app')
@section('custom_scripts')

<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery-ui.min.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery.tagsinput-revisited.css')}}" rel="stylesheet">	  
<link href="{{ asset('site_assets_1/assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/userbasic.w2fr4ha2.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/exp.rng.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="wrapper" >
	@include('layouts.dashboard_header')
	@include('layouts.side_navbar')

	
	<div class="main-panel main-panel-custom">
		<div class="content">
			<div class="page-inner">
                <div id="my_expernce2" class="mt-4">
                    <h4 class="mt-5 mb-3">Note :<span class="fw-bolder"> Maximum number of alerts reached. To add new you must remove existing alert. </span></h4>
                    
                    <div class="crdbxpl mt-5">
                        <div class="row">
                            <div class="col-7 px-4 align-self-center">Job Alert</div>
                            <div class="col-5 text-end"><button class="openForm addJobAlert" type="button" data-form="new">Add New <i class="fa fa-plus"></i></button></div>
                        </div>
                    </div>
                    
                    <div class="append-form-job_alert">
                        @if(count(Auth::user()->JobAlert) == 0)
                        <div class="text-center no_kmbq1">
                            <img draggable="false" src="{{ asset('images/profile/job_alert.svg')}}" height="250" width="250">
                            <div class="no_kmbq2">
                                No<br/>
                                <strong>”JOB Alerts”</strong>
                            </div>
                        </div>
                        @endif 
                    </div>
                    <!-- job_alert card-->
                    <div class="" id="job_alert_div"></div>
                    <!-- job_alert card end -->

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/select2/select2.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" integrity="sha512-HWlJyU4ut5HkEj0QsK/IxBCY55n5ZpskyjVlAoV9Z7XQwwkqXoYdCIC93/htL3Gu5H3R4an/S0h2NXfbZk3g7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
var baseurl = '{{ url("/") }}/';
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/dashboard/joalt!e2u1@1.js') }}"></script>
@endpush