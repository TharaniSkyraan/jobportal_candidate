<style>
	@media(min-width: 280px) and (max-width: 600px){   
		.header .logo img {
			max-height: 60px;
			margin-right: 6px;
		}
	}
	@media(min-width: 280px) and (max-width: 767px){   
		#mugaam {
			display: none;
		}
	}
	.profile-pic span{
		color: unset !important;
		font-size: 16px !important;
	}
	.navbar-toggler{
		display: block !important;
	}
</style>
<div class="main-header">
	<header id="header" class="header header-unset fixed-top bg-color-blue d-flex justify-content-center align-items-center">
		<div class="container-fluid container-xl d-flex align-items-center justify-content-between">
			<a href="{{ route('index') }}" class="logo d-flex align-items-center">
				<img draggable="false" id="mugaam" src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" alt="logo" class="img-fluid">
			</a>
			<div class="desktop_r mx-3">			
				<button class="navbar-toggler m-0 p-0" type="button">
					<i class="fa fa-bars" id="locked-icon" title="Unlock Sidenavbar"></i>
				</button> 
				<div class="searchinput input-group b-0">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
					</div>
					<input type="text" id="search" class="form-control" placeholder="Search jobs in india" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" readonly aria-controls="offcanvasTop" value="{{ucwords(str_replace('-',' ',($slug??'')))}}">
				</div>		
				<div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
					<div class="offcanvas-body" id="search-canvas">
						<div class="container mt-4">
							<div class="row">
								<h3 style="text-align:left">Search Jobs</h3>
								<div class="col-12 mt-4">
									{!! Form::search('mdesignation', $d??null, array('class'=>'form-control-2  typeahead designation', 'id'=>'mdesignation', 'data-mdb-toggle'=>"tooltip", 'data-mdb-placement'=>"left", 'title'=>"Designation required",
									'placeholder'=>__('Job title, keywords or company'),  'autocomplete'=>'off', 'spellcheck'=>'false' ) ) !!}
								</div>
								<div class="col-12 mt-4">
									{!! Form::search('mlocation', $l??null, array('class'=>'form-control-2 typeahead location', 'id'=>'mlocation', 'placeholder'=>__('On Location'),' aria-label'=>'On Location')) !!}
								</div>
							</div>
							<div class="row mt-4">
								<div class="col-md-4 col-sm-4 col-3"></div>
								<div class="col-8 mb-4">
									<div class="row">
										<div class="col-6 text-center align-self-center">
											<a class="close_m" href="#" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</a>
										</div>
										<div class="col-6 align-self-center">
											{!! Form::button('Search', array('class' => 'btn btn_c_s1','id'=>'mobsearch_btn', 'type' => 'submit')) !!}                       
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>		
			</div>			
			<div class="align-self-center  profile-pic">
				<span>
					<nav id="navbar" class="navbar">
						@if(Auth::check())
							<ul class="web-nav">       
								<li>
									<a class="nav-link" href="{{ route('employer_messages') }}"><img draggable="false" src="{{asset('images/sidebar/msg.png')}}" alt=""></a>
								</li>
								<li>
									<a class="nav-link" href="#"><img draggable="false" src="{{asset('images/sidebar/notification.png')}}" alt=""></a>
								</li>
								<li class="dropdown hidden-caret">
									<a class="dropdown-toggle nav-link" data-bs-toggle="dropdown" href="#" id="dropdownMenuLink" aria-expanded="false">
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
														{{Auth::user()->getProfilePercentage()}} %                     
													</div>
												</a>
												<div class="align-self-center mt-2">
													<span class="completion">Profile Completed</span>
												</div>
											</div><hr>
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
								<li><a class="nav-link {{ (Route::is('login') )?'active':''}}" href="{{ route('login') }}">Sign in </a></li>
							</ul>
						@endif
					</nav>
				</span>
				
			</div>
		</div>
	</header>
</div>

<div class="overlay"></div>