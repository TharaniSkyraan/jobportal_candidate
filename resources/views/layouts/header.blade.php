<div class="main-header">
	<header id="header" class="header fixed-top bg-color-blue d-flex justify-content-center align-items-center">
		<div class="container-fluid container-xl d-flex align-items-center justify-content-between">
			<a href="{{ route('index') }}" class="logo d-flex align-items-center">
				<img src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" alt="logo" class="img-fluid">
				{{-- <span>Post a Job</span> --}}
			</a>
		<div>
		
		<nav id="navbar" class="navbar">
			<ul class="">
				@if(Auth::check())
					<li><a class="nav-link scrollto {{ (Route::is('index'))?'active':''}}" href="{{ route('index') }}">Find a Job</a></li>
				
					<li class="dropdown hidden-caret">
						<a class="dropdown-toggle nav-link profile-pic" data-bs-toggle="dropdown" href="#" id="dropdownMenuLink" aria-expanded="false">
							<div class="avatar-sm d-flex align-items-center">
							
								@if(Auth::user()->image)
									<img src="{{Auth::user()->image}}" alt="profile-img" class="rounded-circle h-100">
								@else
									<img src="{{ url('site_assets_1/assets/img/default_profile.jpg')}}" alt="profile-img" class="h-100 rounded-circle mx-2">
								@endif
								<text class="text-truncate-3 font-weight-bold">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</text>
							</div>
						</a>
				
						<ul class="dropdown-menu dropdown-menu-end dropdown-user fadeIn" aria-labelledby="dropdownMenuLink">
							<div class="dropdown-user-scroll scrollbar-outer">
								<!-- <li>
									<a class="dropdown-item" href="#"><i class="fa-solid fa-note-sticky px-1"></i> My Resume</a>
								</li> -->
								<li>
									@if(Auth::user()->is_active==1)
										<a class="dropdown-item" href="{{ route('my_profile') }}"><i class="fa-solid fa-user px-1 mx-2"></i> My Profile</a>
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
					<li></li>
					<li><a class="nav-link scrollto" href="{{ route('index') }}">Get a Job </a></li>
					<li><a class="nav-link scrollto {{ (Route::is('login') )?'active':''}}" href="{{ route('login') }}">Sign in </a></li>
					<li><a class="nav-link scrollto" href="javascript;:"> | </a></li>
					<li><a class="nav-link scrollto" href="#PostLink" >Employer / Post a Job</a></li>
					{{-- <li><a class="nav-link scrollto {{ (Route::is('job.post_job') )?'active':''}}" href="{{ route('job.post_job') }}">Post Job</a></li> --}}
				@endif
				
			</ul>
			<i class="bi bi-list mobile-nav-toggle"></i>
		</nav>
	
		</div>
	</header>
</div>