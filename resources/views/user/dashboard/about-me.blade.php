@extends('layouts.pages.common_app')
@section('custom_scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
    <link rel="stylesheet" href="{{ asset('site_assets_1/assets/date_flatpicker/flatpickr.min.css')}}">
    <script src="{{ asset('site_assets_1/assets/date_flatpicker/flatpickr.js')}}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shortcut-buttons-flatpickr@0.1.0/dist/themes/light.min.css">
    <script src="https://cdn.jsdelivr.net/npm/shortcut-buttons-flatpickr@0.1.0/dist/shortcut-buttons-flatpickr.min.js"></script>
    <link href="{{ asset('css/about_me.css') }}" rel="stylesheet">
@endsection

@section('title') Mugaam - About me Page @endsection

@section('content')
<div class="wrapper" >
	@include('layouts.header.auth.dashboard_header')
	@include('layouts.sidenavbar.side_navbar')    
    @if(Session::has('message'))
        <script>toastr.success("{{ Session('message') }}");</script>
    @endif
	<div class="main-panel main-panel-custom lkdprw">
		<div class="content">
			<div class="page-inner">
                <div id="abt_meusr" class="mt-2">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img draggable="false" src="{{asset('images/sidebar/my_info.svg')}}">&nbsp;About me</h2>
                    </div>
                    <div class="card mt-4">
                        <div class="prof_bg">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-4 col-12">
                                    <div class="profilepictureappend">
                                        <div class="icnsuld" onclick="openModal();">
                                            <i class="fa fa-camera cursor-pointer editprofileicon"></i>    

                                            @if(Auth::user()->image)
                                                <img draggable="false" src="{{Auth::user()->image}}" alt="profile-img" class="savecompanyname updateprofilepicture">
                                            @else
                                                <img draggable="false" src="{{ url('site_assets_1/assets/img/default_profile.jpg')}}" alt="profile-img" class="savecompanyname updateprofilepicture">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-xs-8 col-12 align-self-center">
                                    <label for="exampleInputPassword1" class="form-label"> Email ID</label>
                                    <div class="row d-flex">
                                        <div class="col-11 fw-bolder" style="font-size: 15px">{{$user->email}}</div>
                                        <div class="col-1 p-0 m-0"><i class="fa-solid fa-check"></i></div>
                                    </div>
                                    <!-- <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label"> Phone number(optional)</label>
                                        <div class="fw-bolder">{{$user->phone??'None'}}</div>
                                    </div> -->
                                    <div class="col-md-12 text-end mt-2">
                                        <a href="{{route('accounts_settings')}}"><div class="fw-bolder d-flex align-items-end justify-content-end cursor-pointer jn_abtgfv1"><i class="fa-solid fa fa-key"></i>&nbsp;Account Settings</div></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {!! Form::model($user, array('method' => 'put', 'route' => array('my_profile_save'), 'id' => 'submitbasicinfoform',  'files'=>true)) !!}
                            <div class="row mt-5">                           
                                <div class="col-12">  
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
                                            <div class="{!! APFrmErrHelp::hasError($errors, 'first_name') !!}">
                                                <label for="first_name" class="form-label">First Name</label>
                                                {!! Form::text('first_name', $user->first_name, array('class'=>'form-control required', 'id'=>'first_name', 'placeholder'=>__('First Name'))) !!}
                                                <small class="form-text text-muted text-danger err_msg" id="err_first_name"></small>
                                            </div>                          
                                        </div>                          
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            {!! Form::text('last_name', null, array('class'=>'form-control required', 'id'=>'last_name', 'placeholder'=>__('Last Name'))) !!}
                                            <small class="form-text text-muted text-danger err_msg" id="err_last_name"></small>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
                                            <label for="date_of_birth" class=" col-form-label">Date of Birth</label>
                                            {!! Form::date('date_of_birth', ($user->date_of_birth)?\Carbon\Carbon::parse($user->date_of_birth)->format('d-m-Y'):null, array('class'=>'form-control required', 'id'=>'date_of_birth', 'min'=>'1900-01-02', 'placeholder'=>__('Date of Birth'), 'autocomplete'=>'off')) !!}
                                            <small class="form-text text-muted text-danger err_msg" id="err_date_of_birth"></small>
                                        </div>
                            
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
                                            <label for="marital_status_id" class=" col-form-label">Marital status</label>
                                            {!! Form::select('marital_status_id', [''=>__('Select Marital Status')]+$maritalStatuses, null, array('class'=>'form-select required', 'id'=>'marital_status_id')) !!}
                                            <small class="form-text text-muted text-danger err_msg" id="err_marital_status_id"></small>
                                        </div>
                                    </div>
                                    <label for="" class="form-label">Gender</label>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-4">
                                        @php
                                            $cgender = (!empty($user->gender)) ? $user->gender : '0';
                                        @endphp
                                        @foreach($genders as $key => $gender)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="gender{{$key}}" value="{{$key}}" @if($cgender == '0') @elseif($key==$cgender) checked @endif>
                                            <label class="form-check-label" for="gender{{$key}}">{{$gender}}</label>
                                        </div>
                                        @endforeach
                                        <div>
                                            <small class="form-text text-muted text-danger err_msg" id="err_gender"></small>
                                        </div>
                                    </div>
                    
                                </div>
                            </div>
                            <div class="d-flex justify-content-around mb-3">

                                <div class="text-center mt-2">
                                    <button class="btn btn-submit btn_c_s1" id="basic-info-submit-button" type="button">Save</button>
                                </div>
                            </div>
				
                        {!! Form::close() !!}

                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Company Profile modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" data-bs-backdrop="static" aria-hidden="true" data-bs-keyboard="false">
    <div class="modal-dialog  modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bolder">Profile picture</h4>
                <button type="button" class="btn-close profilemodalclose" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="text-center reset-modal">
                    <div class="text-center">
                        <small class="form-text text-muted text-danger err_msg  mb-4" id="err_image"></small>
                    </div>
                    <div class="profilepic-modal m-auto mb-4">
                        @if(Auth::user()->image !=null )
                        <img draggable="false" src="{{Auth::user()->image}}" alt="Img" class="profilepic__image w-100 h-100" id="profileImage">
                        @else  
                        <img draggable="false" src="{{ url('noupload.png') }}" alt="Img" class="profilepic__image w-100 h-100" id="profileImage">
                        @endif
                    </div>
                    <div id="preview-crop-image"></div>
                    <div id="upload-demo" style="display:none"></div>
                    <input type="file" id="choose-profile-pic" accept="image/*" style="display:none">
                    <small class="form-text text-muted text-danger err_msg" id="err_image"></small>
                    <label class="btn-block upload-image-label up_txt" for="choose-profile-pic" >Upload Image</label>
                    <label class="btn-block text-success btn-upload-image save_txt" style="display:none">save</label>
                    <label class="text-primary btn-block loading" type="button" disabled style="display:none">
                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        Uploading...
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    var baseurl = '{{ url("/") }}/';
    function openModal(){
		$('#profileModal').modal('show');
	} 
    $('select#marital_status_id option:first').attr('disabled', true);
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/dashboard/uprof!$6ew2.js') }}"></script>
@endpush
