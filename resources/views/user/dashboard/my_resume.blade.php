@extends('layouts.app')

@section('custom_scripts')

@endsection


@section('content')


<div class="wrapper" >
        
	@include('layouts.header')
	@include('layouts.side_navbar')

	<div class="main-panel main-panel-custom">
        <div class="content m-4">
            <div class="page-header">
                <h4 class="page-title"></h4>
            </div>
            <div class="page-inner">

                <!-- description -->
                {{-- <div class="col-md-10">
                    <label for="" class="form-label fw-bolder text-green-color">Your Description</label>
                    <div class="form-group mb-3" id="div_your_description">
                        {!! Form::textarea('your_description', null, array('class'=>'form-control required', 'id'=>'your_description', 'rows'=>4, 'placeholder'=>__('Your Description'))) !!}
                        <small class="form-text text-muted text-danger err_msg" id="err_your_description"></small>
                        {!! APFrmErrHelp::showErrors($errors, 'your_description') !!}
                    </div>
                </div> --}}

                <!-- resume -->
                <div class="col-md-10">
                    <label for="" class="form-label fw-bolder mb-2 text-green-color">Resume (You can keep upto 2 resumes)</label>
                    
                    <!-- resume store 1 -->
                    <div class="row mb-4 resume{{$resume1->id}}">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12">
                            <a href="javascript:void(0);" data-aci="{{$resume1->id??''}}" class="download-resume"><img src="{{url('site_assets_1/assets/img/my_resume/resume.svg')}}" style="width:15px" class="img-fluid"> Resume </a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12">
                            <div class="row">
                                <div class="col-md-5 col-sm-5 col-xs-5 col-5">
                                    <div class="d-flex">
                                        <img src="{{url('site_assets_1/assets/img/my_resume/info.svg')}}" style="width:17px" class="img-fluid mx-2" data-bs-toggle="tooltip" title="Primary resume will be used to apply for job posts by default">
                                        
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="radio" data-value="1"  name="primary" value="{{$resume1->id}}" @if($resume1->is_default==1) checked @endif >
                                            @if($resume1->is_default==1)<span class="form-check-label primeinfo1">primary</span>@endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-5 col-xs-5 col-5 prime1" @if($resume1->is_default==1) style="display:none" @endif >
                                    <span class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#resume_upload_modal" onClick="Replace({{$resume1->id}});">
                                        <img src="{{url('site_assets_1/assets/img/my_resume/replace.svg')}}" style="width:15px" class="img-fluid"> 
                                        Replace
                                    </span>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-2 col-2 prime1" @if($resume1->is_default==1) style="display:none" @endif>
                                    <img src="{{url('site_assets_1/assets/img/my_resume/delete.svg')}}" class="img-fluid cursor-pointer" style="width:15px" onClick="deleteResumes({{$resume1->id}});">
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($resume2!=null)
                    <!-- resume store 2 -->
                    <div class="row mb-4 resume{{$resume2->id}}">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12">
                            <a href="javascript:void(0);" data-aci="{{$resume2->id??''}}" class="download-resume"> <img src="{{url('site_assets_1/assets/img/my_resume/resume.svg')}}" style="width:15px" class="img-fluid"> Resume-1 </a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12">
                            <div class="row">
                                <div class="col-md-5 col-sm-5 col-xs-5 col-5">
                                    <div class="d-flex">
                                        <img src="{{url('site_assets_1/assets/img/my_resume/info.svg')}}" style="width:17px" class="img-fluid mx-2" data-bs-toggle="tooltip" title="Primary resume will be used to apply for job posts by default">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="radio" data-value="2" name="primary" value="{{$resume2->id}}" @if($resume2->is_default==1) checked @endif >
                                            @if($resume2->is_default==1)<span class="form-check-label primeinfo2" style="display:none">primary</span>@endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-5 col-xs-5 col-5 prime2" @if($resume2->is_default==1) style="display:none" @endif>
                                    <span class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#resume_upload_modal"  onClick="Replace({{$resume2->id}});">
                                        <img src="{{url('site_assets_1/assets/img/my_resume/replace.svg')}}" style="width:15px" class="img-fluid"> 
                                        Replace
                                    </span>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-2 col-2 prime2" @if($resume2->is_default==1) style="display:none" @endif>
                                    <img src="{{url('site_assets_1/assets/img/my_resume/delete.svg')}}" class="img-fluid cursor-pointer" style="width:15px" onClick="deleteResumes({{$resume2->id}});">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

            
                <div class="col-md-8 upload-resume" @if($resume2!=null) style="display:none;" @endif>
                    <div class="justify-content-md-end">
                        <a href="javascript:void(0);"class="" data-bs-toggle="modal" data-bs-target="#resume_upload_modal"  onClick="Replace();">Upload Resume <img src="{{url('site_assets_1/assets/img/my_resume/upload.svg')}}" width="3%" class="img-fluid"></a>
                    </div>
                </div>
                
                <!-- cover letter -->
                {{-- <div class="col-md-8">
                    <label for="" class="form-label fw-bolder mb-4 text-green-color">Cover letter (Optional)</label>
                    
                    <div class="justify-content-md-end">
                        <a href="#"class="">Upload Cover letter</a>
                        <img src="{{url('site_assets_1/assets/img/my_resume/upload.svg')}}" width="3%" class="img-fluid">
                                
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

</div>

@include('user.resume_upload_modal')

@endsection
@section('custom_bottom_scripts')
@endsection

@push('scripts')
<script type="text/javascript">
var baseurl = '{{ url("/") }}';
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/dashboard/ucv.6@e5t1qa.js') }}"></script>
@endpush
