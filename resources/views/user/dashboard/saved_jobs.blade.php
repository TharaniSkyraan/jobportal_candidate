@extends('layouts.app')
@section('custom_scripts')
  <link href="{{ asset('css/applied_jobs.css') }}" rel="stylesheet">
@endsection
@section('title') Mugaam - Saved Jobs Page @endsection
@section('content')

<div class="wrapper">
        
	@include('layouts.dashboard_header')
	@include('layouts.side_navbar')
	<div class="main-panel main-panel-custom lkdprw">
		<div class="content">
        <div class="row">
          <div class="col-md-12 col-lg-11 col-sm-12 col-xs-12">         
            <div class="pt-4 pb-0 mt-3 mb-3">
                <div class="jobList allJobList">
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
        
@include('user.complete-profile-modal')  
<script>
  var baseurl = '{{ url("/") }}/';
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/savjob.e2k3eu0.js') }}"></script>
@endsection