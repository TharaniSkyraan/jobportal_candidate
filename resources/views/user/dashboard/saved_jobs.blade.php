@extends('layouts.app')

@section('content')
<style>
  .preview_job {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 4;
  }
  .preview_job p {
    font-size: 14px;
    margin-bottom: 0.5rem;
  }
  .image-size {
    width: 16px;
    /* vertical-align: text-top; */
    margin-top: -2px;
  }
  .imagesz-2 {
    width: 21px;
    /* vertical-align: text-bottom; */
    margin-top: -2px;
  }
  .nav-link {
    font-size: 1.025rem !important;
  }
  .janoimg {
    width: 50%;    
  }
  .btnc1 {
    line-height: 0;
    padding: 1.165rem 1.7rem;
    border-radius: 3px;
    transition: 0.5s;
    color: #fff;
    background: #4285F4;
    box-shadow: 0px 5px 25px rgb(65 84 241 / 30%);
  }
  .btnc1 span {
      font-family: "Nunito", sans-serif;
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
<style>
    .japply-btn {
        border-color: #4285f470;
        background-color: #48abf717 !important;
        padding: 0.35rem 0.6rem !important;
        font-size: 0.95rem;
    }
    .japply-btn:hover {
        opacity: 1;
        transition: none;
        border-color: #4285F4;
        background-color: #48abf72b !important;
    }
    .japplied-btn {
        border-color: #c8e8ef;
        padding: 0.36rem 0.65rem!important;
    }
</style>
    
<div class="wrapper">
        
	@include('layouts.dashboard_header')
	@include('layouts.side_navbar')
	<div class="main-panel main-panel-custom main-panel-customize">
		<div class="content">
        <div class="row">
          <div class="col-md-12 col-lg-10 col-sm-12 col-xs-12">         
            <div class="px-5 pt-4 pb-0 mt-3 mb-3">
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