<div class="main-header">
	<header id="header" class="header header-unsets fixed-top bg-color-blue d-flex justify-content-center align-items-center">
		<!-- <button class="navbar-toggler sidenavv-toggler ml-auto" type="button">
			<i class="fa fa-bars" id="lock-icon1"></i>
		</button>  -->
		<div class="navbar-toggler sidenavv-toggler ml-auto" type="button">
			<i class="fa fa-bars" id="lock-icon" title="Unlock Sidenavbar"></i>
		</div>
		<div class="container-fluid container-xl d-flex align-items-center justify-content-end">
			{{-- <a href="{{ route('index') }}" class="logo d-flex align-items-center">
				<img draggable="false" src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" alt="logo" class="img-fluid">
			</a> --}}
			<div class="align-self-center switch-nav">
				<nav id="navbar" class="navbar">
						@if(Auth::check())
						<ul class="web-nav">
							<li><a class="nav-link ps-0" href="{{ route('index') }}">Get a Job</a></li>
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
												{{Auth::user()->getProfilePercentage()}}%                     
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
							<li><a class="nav-link scrollto" href="{{ route('index') }}">Get a Job </a></li>
							<li><a class="nav-link scrollto {{ (Route::is('login') )?'active':''}}" href="{{ route('login') }}">Sign in </a></li>
							<li class="mobile_m"><a>|</a></li>
							<li><a class="nav-link scrollto" href="https://employer.mugaam.com/" >Employer / Post a Job</a></li>
							{{-- <li><a class="nav-link scrollto {{ (Route::is('job.post_job') )?'active':''}}" href="{{ route('job.post_job') }}">Post Job</a></li> --}}
						
						</ul>
					@endif
					{{-- <div class="avatar-sm d-flex align-items-center mobile-nav-toggle-div">
						@if(Auth::user()->image)
							<img draggable="false" src="{{Auth::user()->image}}" alt="profile-img" class="rounded-circle h-100">
						@else
							<img draggable="false" src="{{ url('site_assets_1/assets/img/default_profile.jpg')}}" alt="profile-img" class="h-100 rounded-circle mx-2">
						@endif	
						<i class="fa-solid fa-ellipsis-vertical mobile-nav-toggle"></i>
					</div> --}}
				</nav>
			</div>
		</div>	
	</header>
</div>

