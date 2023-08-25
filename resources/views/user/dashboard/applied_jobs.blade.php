@extends('layouts.app')

@section('custom_scripts')
<link href="{{ asset('css/applied_jobs.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="wrapper" >
        
	@include('layouts.dashboard_header')
	@include('layouts.side_navbar')
        
	<div class="main-panel main-panel-custom main-panel-customize">
		<div class="content">
        <div class="row">
          <div class="col-md-12 col-lg-10 col-sm-12 col-xs-12">         
              <div class="px-4 pt-4 pb-0 mt-3 mb-3">
                  <div class="card-body wizard-tab" style="background-color:unset !important">
                      <ul class="nav nav-pills" id="pills-tab" role="tablist">
                          <li class="nav-item applicationStatus mb-4" role="all">
                              <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" data-type="all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">All</button>
                          </li>
                          <li class="nav-item applicationStatus mb-4" role="view">
                              <button class="nav-link" id="pills-viewed-tab" data-bs-toggle="pill" data-bs-target="#pills-viewed" data-type="view" type="button" role="tab" aria-controls="pills-viewed" aria-selected="false">Viewed</button>
                          </li>
                          <li class="nav-item applicationStatus mb-4" role="shortlist">
                              <button class="nav-link" id="pills-shortlisted-tab" data-bs-toggle="pill" data-bs-target="#pills-shortlisted" data-type="shortlist" type="button" role="tab" aria-controls="pills-shortlisted" aria-selected="false">Shortlisted</button>
                          </li>
                          {{-- <li class="nav-item applicationStatus mb-4" role="consider">
                              <button class="nav-link" id="pills-considered-tab" data-bs-toggle="pill" data-bs-target="#pills-considered" data-type="consider" type="button" role="tab" aria-controls="pills-considered" aria-selected="false">Considered</button>
                          </li> --}}
                          <li class="nav-item applicationStatus mb-4" role="reject">
                              <button class="nav-link" id="pills-rejected-tab" data-bs-toggle="pill" data-bs-target="#pills-rejected" data-type="reject" type="button" role="tab" aria-controls="pills-rejected" aria-selected="false">Rejected</button>
                          </li>
                      </ul>
                  </div>
                  <div class="tab-content" id="pills-applied-jobs-list">
                      <div class="mb-4 tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                          <div class="jobList allJobList">
                          </div>
                      </div>
                      <div class="mb-4 tab-pane fade" id="pills-viewed" role="tabpanel" aria-labelledby="pills-viewed-tab">
                          <div class="jobList viewedJobList">viewd</div>                                  
                      </div>
                      <div class="mb-4 tab-pane fade" id="pills-shortlisted" role="tabpanel" aria-labelledby="pills-shortlisted-tab">
                          <div class="jobList shortlistedJobList">shortlisted</div>                                  
                      </div>
                      {{-- <div class="mb-4 tab-pane fade" id="pills-considered" role="tabpanel" aria-labelledby="pills-considered-tab">
                          <div class="jobList consideredJobList">considered</div>                                  
                      </div> --}}
                      <div class="mb-4 tab-pane fade" id="pills-rejected" role="tabpanel" aria-labelledby="pills-rejected-tab">
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

$(document).ready(function () {
  let activeappStatus = '';
  let applicationStatus = '';
  let page = '';
  $(".applicationStatus").on("click", function() {
    applicationStatus = $(this).attr('role');
    if(applicationStatus != activeappStatus){
      fetch_data(1);
    }
      
  });
  $(document).on('click', '.pagination a', function(event){
    event.preventDefault(); 
    page = $(this).attr('href').split('page=')[1];
    fetch_data(page);
  });

  function fetch_data(page)
  { 

      activeappStatus = $('ul li button.active').data('type');
      $('.jobList').html(''); 
      $.ajax({
        type: "POST",
        url: "{{ route('applied-jobs-list') }}?page="+page,
        data: {'sortBy': activeappStatus,"_token": "{{ csrf_token() }}"},
        datatype: 'json',
        beforeSend:function(){
          $('.jobList').addClass('is-loading');
        },
        success: function (json) {
          if(activeappStatus == 'all'){
            $('.allJobList').html(json.html);
          }
          else if(activeappStatus == 'view'){
            $('.viewedJobList').html(json.html);
          }
          else if(activeappStatus == 'shortlist'){
            $('.shortlistedJobList').html(json.html);
          }
          else if(activeappStatus == 'consider'){
            $('.consideredJobList').html(json.html);
          }
          else if(activeappStatus == 'reject'){
            $('.rejectedJobList').html(json.html);
          }

          $('.jobList').removeClass('is-loading');

        }
    });
    
  }
  fetch_data(1);  

});
</script>
@endsection