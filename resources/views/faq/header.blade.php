<div class="main-header">
	<header id="header" class="header header-unsets fixed-top bg-color-blue d-flex justify-content-center align-items-center">
		<!-- <button class="navbar-toggler sidenavv-toggler ml-auto" type="button">
			<i class="fa fa-bars" id="lock-icon1"></i>
		</button>  -->
		<div class="navbar-toggler sidenavv-toggler ml-auto" type="button">
			<i class="fa fa-bars" id="lock-icon" title="Unlock Sidenavbar"></i>
		</div>
		<div class="container-fluid container-xl d-flex align-items-center justify-content-between">
			<a href="{{ route('index') }}" class="logo d-flex align-items-center">
				<img draggable="false" src="{{ asset('/') }}sitesetting_images/thumb/logo.svg" alt="logo" class="img-fluid logo" style="opacity: 0;">
				<img draggable="false" src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" alt="logo" class="img-fluid hd-logo" style="opacity: 0;">
			</a>
			<div class="align-self-center switch-nav">
				<nav id="navbar" class="navbar">
						@if(Auth::check())
						<ul class="web-nav">
							<li><a class="nav-link ps-0 pe-3 search-job-a d-none" href="{{ route('index') }}"><img draggable="false" src="{{asset('images/sidebar/search.png')}}" alt=""></a></li>
							<li><a class="nav-link ps-0 profile-pic" href="{{ route('index') }}"><span>Find Jobs</span></a></li>
							<li><a class="nav-link" href="{{ route('employer_messages') }}"><img draggable="false" src="{{asset('images/sidebar/msg.png')}}" alt=""></a></li>
							{{--<li><a class="nav-link" href="#"><img draggable="false" src="{{asset('images/sidebar/notification.png')}}" alt=""></a></li>--}}
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
										<div class="user d-flex {{ (Auth::user()->getProfilePercentage() < 40)? 'pending' : 'completed' }}">           
											<a>
												<div class="progressbar text-black useraccountsetting cursor-pointer fw-bolder" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="--value: {{Auth::user()->getProfilePercentage()}}">    
												{{Auth::user()->getProfilePercentage()}}%                     
												</div>
											</a>
											<div class="align-self-center mt-2">
												<span class="completion">Profile Complete</span>
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
							<li><a class="me-5 search-job-a d-none" href="{{ route('index') }}"><img draggable="false" src="{{asset('images/sidebar/search.png')}}" alt=""></a></li>
							<li><a class="pe-5 profile-pic" href="{{ route('index') }}"><span>Find Jobs</span></a></li>
							<li><a class="btn btn_c_si px-2 py-1 text-white me-5 {{ (Route::is('login') )?'active':''}}" href="{{ route('login') }}">Login</a></li>
							<li><a class="px-0" href="https://employer.mugaam.com/" target="_blank"> For Recruiter &nbsp; <img  draggable="false" src="{{asset('images/sidebar/forward.png')}}" alt=""></a></li>
						</ul>
					@endif
				</nav>
			</div>
		</div>	
	</header>
</div>

