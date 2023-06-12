@extends('layouts.app')

@section('content')
<style>
  .preview_job{
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 4;
  }
  .preview_job p{
    font-size: 14px;
    margin-bottom: 0.5rem;
  }
  .image-size{
    width: 16px;
    /* vertical-align: text-top; */
    margin-top: -2px;
  }
  .imagesz-2{
    width: 21px;
    /* vertical-align: text-bottom; */
    margin-top: -2px;
  }
  .nav-link{
    font-size: 1.025rem !important;
  }
  .janoimg{
    width: 50%;    
  }.btnc1{
    line-height: 0;
    padding: 1.165rem 1.7rem;
    border-radius: 3px;
    transition: 0.5s;
    color: #fff;
    background: #4285F4;
    box-shadow: 0px 5px 25px rgb(65 84 241 / 30%);
}
.btnc1 span {
    /* font-family: "Nunito", sans-serif; */
    
	font-family: "Poppins";
    font-weight: 500;
    font-size: 14px;
    letter-spacing: 1px;
}
.btnc1:hover {
    color: #fff;
}
.nav-pills .nav-link {
    padding: 10px 30px;
}
</style>

<div class="wrapper" >
        
	@include('layouts.header')
	@include('layouts.side_navbar')
        
	<div class="main-panel main-panel-custom">
		<div class="content">
        <div class="row">
          <div class="col-md-12 col-lg-10 col-sm-12 col-xs-12">         
              <div class="px-4 pt-4 pb-0 mt-3 mb-3">
                  <div class="card-body wizard-tab" style="background-color:unset !important">
                      <ul class="nav nav-pills" id="pills-tab" role="tablist">
                          <li class="nav-item applicationStatus" role="all">
                              <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" data-type="all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">All</button>
                          </li>
                          <li class="nav-item applicationStatus" role="view">
                              <button class="nav-link" id="pills-viewed-tab" data-bs-toggle="pill" data-bs-target="#pills-viewed" data-type="view" type="button" role="tab" aria-controls="pills-viewed" aria-selected="false">Viewed</button>
                          </li>
                          <li class="nav-item applicationStatus" role="shortlist">
                              <button class="nav-link" id="pills-shortlisted-tab" data-bs-toggle="pill" data-bs-target="#pills-shortlisted" data-type="shortlist" type="button" role="tab" aria-controls="pills-shortlisted" aria-selected="false">Shortlisted</button>
                          </li>
                          {{-- <li class="nav-item applicationStatus" role="consider">
                              <button class="nav-link" id="pills-considered-tab" data-bs-toggle="pill" data-bs-target="#pills-considered" data-type="consider" type="button" role="tab" aria-controls="pills-considered" aria-selected="false">Considered</button>
                          </li> --}}
                          <li class="nav-item applicationStatus" role="reject">
                              <button class="nav-link" id="pills-rejected-tab" data-bs-toggle="pill" data-bs-target="#pills-rejected" data-type="reject" type="button" role="tab" aria-controls="pills-rejected" aria-selected="false">Rejected</button>
                          </li>
                      </ul>
                  </div>
                  <div class="tab-content" id="pills-applied-jobs-list">
                      <div class="p-4 mb-4 tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                          <div class="jobList allJobList">
                          </div>
                      </div>
                      <div class="p-4 mb-4 tab-pane fade" id="pills-viewed" role="tabpanel" aria-labelledby="pills-viewed-tab">
                          <div class="jobList viewedJobList">viewd</div>                                  
                      </div>
                      <div class="p-4 mb-4 tab-pane fade" id="pills-shortlisted" role="tabpanel" aria-labelledby="pills-shortlisted-tab">
                          <div class="jobList shortlistedJobList">shortlisted</div>                                  
                      </div>
                      {{-- <div class="p-4 mb-4 tab-pane fade" id="pills-considered" role="tabpanel" aria-labelledby="pills-considered-tab">
                          <div class="jobList consideredJobList">considered</div>                                  
                      </div> --}}
                      <div class="p-4 mb-4 tab-pane fade" id="pills-rejected" role="tabpanel" aria-labelledby="pills-rejected-tab">
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