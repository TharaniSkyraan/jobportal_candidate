@extends('layouts.app')

@section('content')
<div class="wrapper" >
	@include('layouts.header')
	@include('layouts.side_navbar')

	<div class="main-panel main-panel-custom">
		<div class="content">
			<div class="page-inner">
                <div id="my_resme" class="mt-4">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img src="{{asset('images/candidate_educ.png')}}">&nbsp;My Resume</h2>
                    </div>

                    <div class="card mt-5">
                        <span class="fw-bolder">Resume( <span class="fw-normal">You can keep up to 2 resumes</span> )</span>
                        
                        
                        <!-- resume store 1 -->
                        <div class="row mt-3 resume{{$resume1->id}}">
                            <div class="col-md-4 mb-3">
                                <a href="javascript:void(0);" data-aci="{{$resume1->id??''}}" class="download-resume text-dark text-decoration-underline cursor-pointer">Resume-1</a>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-2 align-self-center"><i class="fa fa-info"></i></div>
                                            <div class="col-10">
                                                <span class="form-check form-switch">
                                                    <input class="form-check-input" type="radio" data-value="1" name="primary" value="{{$resume1->id}}" @if($resume1->is_default==1) checked @endif>
                                                    <span class="form-check-label primeinfo1" @if($resume1->is_default!=1) style="display:none;" @endif>primary</span>                                    
                                                </span>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-8 prime1" @if($resume1->is_default==1) style="display:none" @endif >
                                                <span class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#resume_upload_modal" onClick="Replace({{$resume1->id}});" aria-hidden="true">
                                                    <i class="fa fa-refresh"></i>
                                                    &nbsp;Replace
                                                </span>
                                            </div>
                                            <div class="col-4 prime1" @if($resume1->is_default==1) style="display:none" @endif>
                                                <span>
                                                    <i class="fa fa-trash cursor-pointer" onClick="deleteResumes({{$resume1->id}});"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($resume2!=null)
                            <!-- resume store 2 -->
                            <div class="row mt-3 resume{{$resume2->id}}">
                                <div class="col-md-4 mb-3">
                                    <a href="javascript:void(0);" data-aci="{{$resume2->id??''}}" class="download-resume text-dark text-decoration-underline">Resume-2</a>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-2 align-self-center"><i class="fa fa-info"></i></div>
                                                <div class="col-10">
                                                    <span class="form-check form-switch">
                                                        <input class="form-check-input" type="radio" data-value="2" name="primary" value="{{$resume2->id}}" checked="">
                                                         <span class="form-check-label primeinfo2" @if($resume2->is_default!=1) style="display:none;" @endif>primary</span>                                                      
                                                    </span>
                                                </div>
                                            </div>                                        
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-8 prime2" @if($resume2->is_default==1) style="display:none" @endif>
                                                    <span class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#resume_upload_modal" onClick="Replace({{$resume2->id}});" aria-hidden="true">
                                                        <i class="fa fa-refresh"></i>
                                                        &nbsp;Replace
                                                    </span>
                                                </div>
                                                <div class="col-4 prime2" @if($resume2->is_default==1) style="display:none" @endif>
                                                    <span>
                                                        <i class="fa fa-trash cursor-pointer" onClick="deleteResumes({{$resume2->id}});"></i>
                                                    </span>
                                                </div>
                                            </div>
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
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/dashboard/ucv.6@e5t1qa.js') }}"></script>
@endpush
