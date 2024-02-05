@extends('layouts.pages.common_app')

@section('custom_scripts')
  <link href="{{ asset('css/applied_jobs.css') }}" rel="stylesheet">
@endsection
@section('title') Mugaam - Applied Jobs Page @endsection
@section('content')

<div class="wrapper" >
        
	@include('layouts.header.auth.dashboard_header')
	@include('layouts.sidenavbar.side_navbar')
        
	<div class="main-panel main-panel-custom lkdprw">
		<div class="content">
        <div class="row">
          <div class="col-md-12 col-lg-10 col-sm-12 col-xs-12">         
              <div class="px-3 pt-4 pb-0 mt-3 mb-3">
                  <div class="card-body wizard-tab" style="background-color:unset !important">
                      <ul class="nav nav-tabs mb-3 border-0" role="tablist">
                        <li class="nav-item applicationStatus" role="all"><a class="nav-link" id="pills-all-tab" data-bs-toggle="tab" href="#all">All</a></li>
                        <li class="nav-item applicationStatus" role="view"><a class="nav-link" id="pills-viewed-tab" data-bs-toggle="tab" href="#viewed">Viewed</a></li>
                        <li class="nav-item applicationStatus" role="shortlist"><a class="nav-link" id="pills-shortlisted-tab" data-bs-toggle="tab" href="#shortlisted">Shortlisted</a></li>
                        <li class="nav-item applicationStatus" role="reject"><a class="nav-link" id="pills-rejected-tab" data-bs-toggle="tab" href="#rejected">Rejected</a></li>
                     </ul>
                  </div>
                  <div class="tab-content" id="pills-applied-jobs-list">
                      <div id="all" class="mb-4 tab-pane fade">
                          <div class="jobList allJobList">
                            jh
                          </div>
                      </div>
                      <div id="viewed" class="mb-4 tab-pane fade">
                          <div class="jobList viewedJobList">viewd</div>                                  
                      </div>
                      <div id="shortlisted" class="mb-4 tab-pane fade">
                          <div class="jobList shortlistedJobList">shortlisted</div>                                  
                      </div>
                      {{-- <div class="mb-4 tab-pane fade" id="pills-considered" role="tabpanel" aria-labelledby="pills-considered-tab">
                          <div class="jobList consideredJobList">considered</div>                                  
                      </div> --}}
                      <div id="rejected" class="mb-4 tab-pane fade">
                          <div class="jobList rejectedJobList">rejected</div>                                  
                      </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
          
<script>
  var baseurl = '{{ url("/") }}/';
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/apliedjob.!$23rw.js') }}"></script>
@endsection