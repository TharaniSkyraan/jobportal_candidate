@extends('layouts.pages.common_app')
@section('title') Mugaam - My Resume Page @endsection
@section('content')
<div class="wrapper" >
	@include('layouts.header.auth.dashboard_header')
	@include('layouts.sidenavbar.side_navbar')
<style>
@media (min-width: 280px) and (max-width: 767px){
    .replace-resume{
        margin-top:0px !important;
    }
}

@media (max-width: 467px){

}.sjhiqum{
    font-weight: 600;
    text-align:center;
    padding-bottom: 15px;
}.sjhiqum span{
    font-weight: 400;
}#my_resme .form-switch span{
    font-weight:900;
    font-size:12px;
}.form-check.form-switch{
    margin-bottom:0rem;
}
</style>
	<div class="main-panel main-panel-custom">
		<div class="content">
			<div class="page-inner">
                <div id="my_resme" class="mt-3">
                    <div class="text-center ttleicn">
                        <h2><img draggable="false" src="{{asset('images/sidebar/resume.svg')}}">&nbsp;My Resume</h2>
                    </div>
                    <div class="card mt-4">
                        <span class='sjhiqum'>Resume (<span class="m-1">You can keep up to 2 resumes</span>)</span>
                        <!-- resume store 1 -->
                        <div class="row mt-3 resume{{$resume1->id}}">
                            <div class="col-lg-6 col-md-8 col-sm-8 col-8">
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <a href="javascript:void(0);" data-aci="{{$resume1->id??''}}" class="download-resume text-dark text-decoration-underline cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="Considered to be the default Resume!"><i class="fa fa-download"></i> Resume-1</a>    
                                        &nbsp;&nbsp;&nbsp;                               
                                        <span class="form-check form-switch">
                                            <input class="form-check-input" type="radio" data-value="1" name="primary" value="{{$resume1->id}}" @if($resume1->is_default==1) checked @endif>
                                            <span class="form-check-label primeinfo1" @if($resume1->is_default==0) style="display:none;" @else style="font-size: 12px;font-weight: 900;" @endif>Primary</span>  
                                        </span>                         
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-4 col-4 col-sm-4 col-xs-12">
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <span class="cursor-pointer prime1" data-bs-toggle="modal" data-bs-target="#resume_upload_modal" onClick="Replace({{$resume1->id}});" aria-hidden="true" @if($resume1->is_default==1) style="display:none" @endif>
                                            <i class="fa fa-refresh"></i>
                                            &nbsp;<span>Replace</span>
                                        </span>
                                        <span class="prime1 mx-2" @if($resume1->is_default==1) style="display:none" @endif>
                                            <i class="fa fa-trash cursor-pointer" onClick="deleteResumes({{$resume1->id}});"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($resume2!=null)
                            <!-- resume store 2 -->
                            <div class="row mt-3 resume{{$resume2->id}}">
                                <div class="col-lg-6 col-8 col-md-8 col-sm-8">
                                    <div class="row">
                                        <div class="col-12 d-flex">   
                                            <a href="javascript:void(0);" data-aci="{{$resume2->id??''}}" class="download-resume text-dark text-decoration-underline">
                                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Considered to be the default Resume!"><i class="fa fa-download"></i> Resume-2</span>
                                            </a>&nbsp;&nbsp;&nbsp;
                                            <span class="form-check form-switch">
                                                <input class="form-check-input" type="radio" data-value="2" name="primary" value="{{$resume2->id}}" @if($resume2->is_default==1) checked @endif>
                                                <span class="form-check-label primeinfo2" @if($resume2->is_default==0) style="display:none;" @else style="font-size: 12px;font-weight: 900;" @endif>Primary</span>                                                      
                                            </span>
                                        </div>     
                                    </div>     
                                </div>     

                                <div class="col-lg-6 col-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="row">
                                        <div class="col-12 replace-resume d-flex">
                                            <span class="cursor-pointer prime2" data-bs-toggle="modal" data-bs-target="#resume_upload_modal" onClick="Replace({{$resume2->id}});" aria-hidden="true" @if($resume2->is_default==1) style="display:none" @endif>
                                                <i class="fa fa-refresh"></i>
                                                &nbsp;<span>Replace</span>
                                            </span>
                                            <span class="prime2 mx-2" @if($resume2->is_default==1) style="display:none" @endif>
                                                <i class="fa fa-trash cursor-pointer" onClick="deleteResumes({{$resume2->id}});"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>                        
                        @endif

                        <div class="col-md-12 mt-5 text-center upload-resume" @if($resume2!=null) style="display:none;" @endif>
                            <table>
                                <th><a class="text-decoration-underline" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#resume_upload_modal"  onClick="Replace();">Upload Resume</a></th>
                                <th><i class="fas fa-arrow-up"></i></th>
                            </table>     
                        </div>
                    </div>

                    {{-- <div class="card mt-5">
                        <span class="fw-bolder">Cover Letter( <span class="fw-normal">optional</span> )</span>

                        <div class="col-md-12 mt-5 text-center">
                            <table>
                                <th><a class="text-decoration-underline" href="">Upload Resume</a></th>
                                <th><i class="fas fa-arrow-up"></i></th>
                            </table>     
                        </div>                    
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
</div>

@include('user.resume_upload_modal')
@endsection

@push('scripts')
<script type="text/javascript">
    var baseurl = '{{ url("/") }}';
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/dashboard/ucv.6@e5t1qa.js') }}"></script>
@endpush
