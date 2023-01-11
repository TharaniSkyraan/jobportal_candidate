<div class="main-header">
	<header id="header" class="header fixed-top bg-color-blue d-flex justify-content-center align-items-center">
		
		<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
			<i class="fa-solid fa-ellipsis-vertical"></i>
		</button> 
		<div class="container-fluid container-xl d-flex align-items-center justify-content-between">

		{{-- <span>Post a Job</span> --}}
			
		@if(Route::is('job.search')?'active':'')
					<div class="mobile_r">
						<a href="{{ route('index') }}" class="logo d-flex align-items-center">
							<img src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" alt="logo" class="img-fluid">
						</a>
					</div>
					<div class="desktop_r mx-3">
						<div class="input-group b-0">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
							</div>
							
							<input type="search" id="search" class="form-control" placeholder="Search jobs in india" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">
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
				@else
				<a href="{{ route('index') }}" class="logo d-flex align-items-center">
					<img src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" alt="logo" class="img-fluid">
				</a>
				@endif




			
				
		<div class="align-self-center">
			<nav id="navbar" class="navbar">
				<ul class="">
					@if(Auth::check())
						<li><a class="nav-link scrollto {{ (Route::is('index'))?'active':''}}" href="{{ route('index') }}">Get a Job</a></li>
					
						<li class="dropdown hidden-caret">
							<a class="dropdown-toggle nav-link profile-pic" data-bs-toggle="dropdown" href="#" id="dropdownMenuLink" aria-expanded="false">
								<div class="avatar-sm d-flex align-items-center">
								
									@if(Auth::user()->image)
										<img src="{{Auth::user()->image}}" alt="profile-img" class="rounded-circle h-100">
									@else
										<img src="{{ url('site_assets_1/assets/img/default_profile.jpg')}}" alt="profile-img" class="h-100 rounded-circle mx-2">
									@endif								
									<text class="text-truncate-3 font-weight-bold">{{Auth::user()->first_name??Auth::user()->name}} {{Auth::user()->last_name}}</text>
								</div>
							</a>
					
							<ul class="dropdown-menu dropdown-menu-end dropdown-user fadeIn" aria-labelledby="dropdownMenuLink">
								<div class="dropdown-user-scroll scrollbar-outer">
									<!-- <li>
										<a class="dropdown-item" href="#"><i class="fa-solid fa-note-sticky px-1"></i> My Resume</a>
									</li> -->
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
					@elseif(!Auth::check())

						<li><a class="nav-link scrollto" href="{{ route('index') }}">Get a Job </a></li>
						<li><a class="nav-link scrollto {{ (Route::is('login') )?'active':''}}" href="{{ route('login') }}">Sign in </a></li>
						<li class="mobile_m"><a>|</a></li>
						<li><a class="nav-link scrollto" href="https://employer.mugaam.com/" >Employer / Post a Job</a></li>
						{{-- <li><a class="nav-link scrollto {{ (Route::is('job.post_job') )?'active':''}}" href="{{ route('job.post_job') }}">Post Job</a></li> --}}
					@endif
					
				</ul>
				<i class="bi bi-list mobile-nav-toggle"></i>
			</nav>
		</div>
	</header>
</div>

