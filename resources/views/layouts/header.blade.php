<style>
	
@media(min-width: 280px) and (max-width: 600px){   
	.header .logo img {
		max-height: 60px;
		margin-right: 6px;
		margin-left: -10px;
	}
}
.profile-pic span{
	color: unset !important;
	font-size: 16px !important;
}
</style>
<div class="main-header">
	<header id="header" class="header fixed-top bg-color-blue d-flex justify-content-center align-items-center">
		<div class="container-fluid container-xl d-flex align-items-center">
		
			<div class="container-fluid container-xl d-flex align-items-center justify-content-between">
				<a href="{{ route('index') }}" class="logo d-flex align-items-center">
					<img draggable="false" src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" alt="logo" class="img-fluid">
					{{-- <span>Post a Job</span> --}}
				</a>
				@if(Route::is('job.search'))
					<div class="desktop_r mx-3">
						<div class="input-group b-0">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
							</div>
							
							<input type="text" id="search" class="form-control" placeholder="Search jobs in india" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" readonly aria-controls="offcanvasTop" value="{{ucwords(str_replace('-',' ',$slug))}}">
						</div>
						<div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
							<div class="offcanvas-body" id="search-canvas">
								<div class="container">
									<div class="mb-3 mt-3">
										{!! Form::search('mdesignation', $d, array('class'=>'form-control-2  typeahead', 'id'=>'mdesignation',
										'placeholder'=>__('Job title, keywords or company'),  'autocomplete'=>'off', 'spellcheck'=>'false' ) ) !!}
										<span class="form-text text-danger err_msg designation-error"></span>
									</div>
									<div class="mb-3">
										{!! Form::search('mlocation', $l, array('class'=>'form-control-2 typeahead', 'id'=>'mlocation', 'placeholder'=>__('On Location'),' aria-label'=>'On Location')) !!}
										<span class="form-text text-danger err_msg"></span>
									</div>
									<div class="row">
										<div class="col-4"></div>
										<div class="col-8 mb-4">
											<div class="row">
												<div class="col-6 text-center align-self-center">
													<a class="close_m" href="#" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</a>
												</div>
												<div class="col-6 align-self-center">
													{!! Form::button('Search', array('class' => 'btn search-button-bg ','id'=>'mobsearch_btn', 'type' => 'submit')) !!}                       
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endif	
			<div>			
			<div class="align-self-center">
				<nav id="navbar" class="navbar">
					@if(Auth::check())
						<ul class="web-nav">       
							{{-- <li><a class="nav-link scrollto {{ (Route::is('index'))?'active':''}}" href="{{ route('index') }}">Get a Job</a></li> --}}
							<li>
								<a class="nav-link" href="{{ route('employer_messages') }}"><img draggable="false" src="{{asset('images/sidebar/msg.png')}}" alt=""></a>
							</li>
							<li>
								<a class="nav-link" href="#"><img draggable="false" src="{{asset('images/sidebar/notification.png')}}" alt=""></a>
							</li>
							<li class="dropdown hidden-caret">
								<a class="dropdown-toggle nav-link profile-pic" data-bs-toggle="dropdown" href="#" id="dropdownMenuLink" aria-expanded="false">
									<div class="avatar-sm d-flex align-items-center">
										@if(Auth::user()->image)
											<img draggable="false" src="{{Auth::user()->image}}" alt="profile-img" class="rounded-circle h-100">
										@else
											<img draggable="false" src="{{ url('site_assets_1/assets/img/default_profile.jpg')}}" alt="profile-img" class="h-100 rounded-circle mx-2">
										@endif			
										<span class="text-truncate-3 font-weight-bold">{{Auth::user()->getName()}}<br><text>{{Auth::user()->candidate_id}}</text></span>
										<i class="fa fa-angle-down angle-toggle mob-arrow"></i> 
									</div>
								</a>
						
								<ul class="dropdown-menu dropdown-menu-end dropdown-user fadeIn" aria-labelledby="dropdownMenuLink">
									<div class="dropdown-user-scroll scrollbar-outer">
										<!-- <li>
											<a class="dropdown-item" href="#"><i class="fa-solid fa-note-sticky px-1"></i> My Resume</a>
										</li> -->          
										<div class="user d-flex {{ (Auth::user()->getProfilePercentage() < 40)? 'pending' : 'completed' }}">           
											<a>
												<div class="progressbar text-black useraccountsetting cursor-pointer fw-bolder" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="--value: {{Auth::user()->getProfilePercentage()}}">    
													{{Auth::user()->getProfilePercentage()}} %                     
												</div>
											</a>
											<div class="align-self-center mt-2">
												<span class="completion">Profile Completed</span>
											</div>
										</div>
										<hr>
										<li>
											@if(Auth::user()->is_active==1)
												<a class="dropdown-item" href="{{ route('home') }}"><i class="fa-solid fa-user px-1 mx-2"></i> My Profile</a>
											@else
												<a class="dropdown-item" href="{{ route('redirect-user') }}"><i class="fa-solid fa-user px-1 mx-2"></i> My Profile</a>
											@endif
										</li>
										<!-- <li>
											<a class="dropdown-item" href="#"><i class="fa-solid fa-circle-check px-1"></i> Applied jobs</a>
										</li>
										<li>
											<a class="dropdown-item" href="#"><i class="fa-solid fa-envelope px-1"></i> Message</a>
										</li>
										<li>
											<a class="dropdown-item" href="#"><i class="fa-solid fa-exclamation px-1"></i> Job Alerts</a>
										</li>
										<li>
											<a class="dropdown-item" href="#"><i class="fa-solid fa-star px-1"></i> Saved jobs</a>
										</li> -->
										<li>
											<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();"><i class="fas fa-sign-out-alt px-1 mx-2" ></i> Logout</a>
										</li>
										<form id="logout-form-header" action="{{ route('logout') }}" method="POST" style="display: none;">
											{{ csrf_field() }}
										</form>
									</div>
								</ul>
							</li>
						</ul>
					@elseif(!Auth::check())
						<ul class="">
							<li><a class="nav-link {{ (Route::is('login') )?'active':''}}" href="{{ route('login') }}">Sign in </a></li>
							@if(Route::is('job.search')=='')
							<li><a class="nav-link px-0 profile-pic" href="https://employer.mugaam.com/"><span>| &nbsp; Employer / </span>Post a Job</a></li>
							@endif
							{{-- <li><a class="nav-link scrollto {{ (Route::is('job.post_job') )?'active':''}}" href="{{ route('job.post_job') }}">Post Job</a></li> --}}
						</ul>
					@endif
				</nav>
			</div>
		</div>
	</header>
</div>

