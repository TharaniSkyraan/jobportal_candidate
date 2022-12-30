@extends('layouts.app')


@section('custom_scripts')
<style>
    .prof_bg .fa-key{
        background-color: #fff;
        width: 25px;
        height: 25px;
        color: #000;
        text-align: center;
        border-radius: 50%;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        display: flex;
        font-size: 12px;
    }

    #abt_meusr .card {
        padding: 30px;
    }

    #abt_meusr .prof_bg{
        padding: 20px;
        background: #cccccc29;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgb(0 0 0 / 20%);
    }
</style>
@endsection


@section('content')
<div class="wrapper" >
	@include('layouts.header')
	@include('layouts.side_navbar')

    @if(Session::has('message'))
        <script>toastr.success("{{ Session('message') }}");</script>
    @endif

	<div class="main-panel main-panel-custom">
		<div class="content">
			<div class="page-inner">
                <div id="abt_meusr" class="mt-4">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img src="{{asset('images/about_me.png')}}">&nbsp;About me</h2>
                    </div>

                    <div class="card mt-5">
                        <div class="prof_bg">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="profilepictureappend">
                                        @if(Auth::user()->image)
                                            <img src="{{Auth::user()->image}}" alt="profile-img" class="savecompanyname updateprofilepicture">
                                        @else
                                            <img src="{{ url('site_assets_1/assets/img/default_profile.jpg')}}" alt="profile-img" class="savecompanyname updateprofilepicture">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-9 align-self-center">
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label fw-bolder"> Email ID</label>
                                        <div class="fw-bolder d-flex align-items-center">{{$user->email}} &nbsp;<i class="fa-solid fa-check"></i></div>
                                    </div>
                                    <!-- <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label fw-bolder"> Phone number(optional)</label>
                                        <div class="fw-bolder">{{$user->phone??'None'}}</div>
                                    </div> -->
                                    <div class="col-md-12 text-end">
                                    <a href="{{route('accounts_settings')}}"><div class="fw-bolder d-flex align-items-end justify-content-end cursor-pointer"><i class="fa-solid fa fa-key"></i>&nbsp;Account Settings</div></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {!! Form::model($user, array('method' => 'put', 'route' => array('my_profile_save'), 'id' => 'submitbasicinfoform', 'class' => 'form', 'files'=>true)) !!}
                            <div class="row mt-5">
                                <div class="col-md-3 col-lg-3"></div>                            
                                <div class="col-md-9">  
                                    <div class="col-md-12 col-lg-10 mb-4">
                                        <div class="{!! APFrmErrHelp::hasError($errors, 'first_name') !!}">
                                            <label for="first_name" class="form-label fw-bolder">First Name</label>
                                            {!! Form::text('first_name', $user->first_name??$user->name, array('class'=>'form-control required', 'id'=>'first_name', 'placeholder'=>__('First Name'))) !!}
                                            <small class="form-text text-muted text-danger err_msg" id="err_first_name"></small>
                                        </div>                          
                                    </div>                          
                                    <div class="col-md-12 col-lg-10 mb-4 mt-3">
                                        <label for="last_name" class="form-label fw-bolder">Last Name</label>
                                        {!! Form::text('last_name', null, array('class'=>'form-control required', 'id'=>'last_name', 'placeholder'=>__('Last Name'))) !!}
                                        <small class="form-text text-muted text-danger err_msg" id="err_last_name"></small>
                                    </div>
                                    <div class="col-md-12 col-lg-10 mb-4">
                                        <label for="" class="form-label fw-bolder">Gender</label>
                                        @php $cgender = (!empty($user->gender))?$user->gender:2; @endphp
                                        @foreach($genders as $key => $gender)
                                        <div class="form-check form-check-inline ms-3">
                                            <input class="form-check-input" type="radio" name="gender" id="gender{{$key}}" value="{{$key}}" @if($key==$cgender) checked @endif>
                                            <label class="form-check-label" for="gender{{$key}}">{{$gender}}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="col-md-12 col-lg-10 mb-4">
                                        <label for="date_of_birth" class=" col-form-label fw-bolder">Date of Birth</label>
                                        {!! Form::date('date_of_birth', $user->date_of_birth??null, array('class'=>'form-control required', 'id'=>'date_of_birth', 'min'=>'1900-01-02', 'max'=>'2008-12-31', 'placeholder'=>__('Date of Birth'), 'autocomplete'=>'off')) !!}
                                        <small class="form-text text-muted text-danger err_msg" id="err_date_of_birth"></small>
                                    </div>
                        
                                    <div class="col-md-12 col-lg-10 mb-4">
                                        <label for="marital_status_id" class=" col-form-label fw-bolder">Marital status</label>
                                        {!! Form::select('marital_status_id', [''=>__('Select Marital Status')]+$maritalStatuses, null, array('class'=>'form-select required', 'id'=>'marital_status_id')) !!}
                                        <small class="form-text text-muted text-danger err_msg" id="err_marital_status_id"></small>
                                    </div>
                    
                                </div>
                            </div>
                            <div class="d-flex justify-content-around mb-3">

                                <div class="text-center mt-2">
                                    <button class="btn btn-submit bg-green-color" id="basic-info-submit-button" type="button">Save</button>
                                </div>
                            </div>
				
                        {!! Form::close() !!}

                    </div>  
                </div>



                <div class="text-center">

                </div>
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
var baseurl = '{{ url("/") }}/';
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/dashboard/uprof!$6ew2.js') }}"></script>
@endpush
