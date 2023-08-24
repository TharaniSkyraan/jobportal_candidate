<style>
.sidenavbar.close{
		transform: translateX(-100px) !important;
	}
  .sidenavbar .user{
    margin: 12px 3px 12px 10px !important;
  }
  .sidenavbar .user span{
    margin:0px !important; 
  }
  .sidenavbar {
    background: #ffffff;
  }
  .nav_image #sidebar_logo_image{
    transform: translateX(-25%);
    width: 80%;
  }
  .actie img{
    filter: invert(76%) sepia(30%) saturate(3461%) hue-rotate(179deg) brightness(60%) contrast(91%) !important;
  }
</style>
<nav class="wrapper sidenavbar close">
  <div class="logo_items flex mt-0">
      <text class="nav_image">
        <a href="{{url('/')}}"><img draggable="false" src="{{ asset('/') }}site_assets_1/logo_24@2x.png" alt="logo_img" id="sidebar_logo" /></a>
        <a href="{{url('/')}}"><img draggable="false" src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" alt="logo_img" id="sidebar_logo_image" /></a>
      </text> 
      <i class="fa fa-horizontal-rule"></i>
    </div>
  <div class="menu_container">        
    @if(Auth::check())
      <div class="card">            
        <div class="user d-flex">           
          <div class="avatar-sm d-flex align-items-center">
            @if(Auth::user()->image)
              <img draggable="false" src="{{Auth::user()->image}}" alt="profile-img" class="rounded-circle h-100">
            @else
              <img draggable="false" src="{{ url('site_assets_1/assets/img/default_profile.jpg')}}" alt="profile-img" class="h-100 rounded-circle mx-2">
            @endif			
            <span class="text-truncate-3 font-weight-bold">{{Auth::user()->getName()}}<br><text>{{Auth::user()->candidate_id}}</text></span>
            <i class="fa fa-angle-down angle-toggle mob-arrow"></i> 
          </div>
        </div>
        <a class="text-black text-center toggle" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
        </a>   
      </div>
    @endif
    <div class="menu_items">
      <ul class="menu_item">
        <!-- <div class="menu_title flex">
          <span class="title">Dashboard</span>
          <span class="line"></span>
        </div> -->
        <li class="item">
          <a href="{{ url('/') }}" class="link flex active actie">
            <img draggable="false" src="{{asset('images/sidebar/home.svg')}}" alt="">
            <span>Home</span>
          </a>
        </li>
				@if(Auth::check())
        <li class="item">
          <a href="{{ route('home') }}" class="link flex active">
            <img draggable="false" src="{{asset('images/sidebar/user.svg')}}" alt="">
            <span>My Profile</span>
          </a>
        </li>
        <li class="item">
          <a href="javascript:void(0)" class="link flex active actie">
            <img draggable="false" src="{{asset('images/sidebar/bell.svg')}}" alt="">
            <span>Notification</span>
          </a>
        </li>
        <li class="item">
          <a href="{{route('employer_messages')}}" class="link flex active actie">
            <img draggable="false" src="{{asset('images/sidebar/msg.svg')}}" alt="">
            <span>Messages</span>
          </a>
        </li>
        <li class="item">
          <a class="link flex active actie" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();">
            <img draggable="false" src="{{asset('images/sidebar/lock.svg')}}" alt="">
            <span>Logout</span>
          </a>
        </li>
        @else
        <li class="item">
          <a href="{{route('login')}}" class="link flex active actie">
            <img draggable="false" src="{{asset('images/sidebar/lock.svg')}}" alt="">
            <span>Login</span>
          </a>
        </li>
        <li class="item">
          <a href="https://employer.mugaam.com/" class="link flex active">
            <img draggable="false" src="{{asset('images/sidebar/ind_org.svg')}}" alt="">
            <span>Employer</span>
          </a>
        </li>
        @endif
      </ul>

      <ul class="menu_item">
        <div class="menu_title flex">
          <span class="title"></span>
          <span class="line"></span>
        </div>
      </ul>
      <ul class="menu_item">
        <div class="menu_title flex">
          <span class="title"></span>
          <span class="line"></span>
        </div>
      </ul>
    </div>
  </div>
</nav>