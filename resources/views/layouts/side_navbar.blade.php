
  <!-- End of Header -->
  @if(Auth::check())
    <!-- Start Side Nav Bar -->
    <div class="sidebar sidebar-style-2 sidebar-bg" >
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <div class="user">
                <!-- <div class="avatar-sm float-left mr-2">
                  <img src="" alt="Img" class="avatar-img rounded-circle">
                </div> -->
                <div class="info">
                  
                  <div class="clearfix"></div>

                  <div class="navbar-card">
                    <!-- <div class="">
                      <div class="text-center mt-3">
                        <i class="fas fa-user-circle fa-2xl user-profile"></i>
                      </div>
                    </div> -->
                    @php
                      $percentage_profile = App\Model\ProfilePercentage::pluck('value','key')->toArray();
                      $percentage = $percentage_profile['user_basic_info'];
                      $user = Auth::user()??'';
                      $percentage += count($user->userEducation) > 0 ? $percentage_profile['user_education'] : 0;
                      $percentage += count($user->userExperience) > 0 ? $percentage_profile['user_experience'] : 0;
                      $percentage += count($user->userSkills) > 0 ? $percentage_profile['user_skill'] : 0;
                      $percentage += count($user->userProjects) > 0 ? $percentage_profile['user_project'] : 0;
                      $percentage += count($user->userLanguages) > 0 ? $percentage_profile['user_language'] : 0;
                      $percentage += ($user->countUserCvs() > 0) ? $percentage_profile['user_resume'] : 0;
                      $percentage += $user->image != null ? $percentage_profile['user_profile'] : 0;
                      
                      $final_percentage = $percentage > 100 ? 100 : $percentage;
                    @endphp
                    <div class="card-body text-center">
                      <div class="mx-auto progressbar useraccountsetting cursor-pointer" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="--value: {{$final_percentage}}">
                        @if( Auth::check() && Auth::user()->image !=null )
                          <img src="{{Auth::user()->image}}" alt="Img" class="avatar-img rounded-circle">
                        @else 
                          <img src="{{ url('site_assets_1/assets/img/default_profile.jpg')}}" alt="Img" class="avatar-img rounded-circle">
                        @endif
                      </div>
                      <div class="mt-1 progressbar" role="progressbar-after" style="--value: {{$final_percentage}}">
                      </div>
                      <div class="mt-3">
                        <text class="fw-bold">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</text><br>
                      </div>
                      <div class="mt-2">
                        <text class="">{{Auth::user()->email}}</text>
                      </div>
                      <div class="mt-2">
                        <text class="">{{Auth::user()->phone}}</text>
                      </div>
                    </div>
                   
                 
                    <!-- <label for="file-input">
                      <i class="fa-solid fa-camera profile-camera fa-xs"></i>
                    </label> -->
                    <!-- <input type="file" name="image" id="file-input" required style="display:none"  onchange="event.preventDefault(); document.getElementById('profile-upload').submit();"> -->
                    
                    <!-- <i class="fa-solid fa-camera profile-camera fa-xs"></i> -->
                    <!-- <i class="fa-solid fa-pen-to-square edit-profile" onclick="openModal();"></i> -->
                    
                 </div>
                  
                </div>
              </div>
              <ul class="nav nav-primary">                  
                  {{-- <li class="nav-item active" >
                      <a href="" class="collapsed" aria-expanded="false">
                          <i class="fas fa-user"></i>
                          <p>My Profile</p>
                      </a>
                  </li>               --}}
                  <li class="nav-item {{ Request::is('my_profile') ? 'active' : '' }}" >
                      <a href="{{ route('my_profile') }}" class="collapsed" aria-expanded="false">
                      <img class="me-3" width="17px" src="{{url('site_assets_1/assets/img/my_profile.png')}}">
                          <p>My accounts</p>
                      </a>
                  </li>
                  <li class="nav-item {{ Request::is('my_resume') ? 'active' : '' }}" >
                      <a href="{{ route('show.front.profile.cvs') }}" class="collapsed" aria-expanded="false">
                          <img class="me-3" width="17px" src="{{url('site_assets_1/assets/img/my_resume/resume.png')}}">
                          <p>My Resume</p>
                      </a>
                  </li>
                  <li class="nav-item {{ Request::is('applied-jobs') ? 'active' : '' }}" >
                      <a href="{{ route('applied-jobs') }}" class="collapsed" aria-expanded="false">
                        <img class="me-3" width="17px" src="{{url('site_assets_1/assets/img/side_nav_icon/applied_jobs.png')}}">
                        <p>Applied jobs</p>
                      </a>
                  </li>
                  <li class="nav-item {{ Request::is('saved-jobs') ? 'active' : '' }}" >
                      <a href="{{ route('saved-jobs') }}" class="collapsed" aria-expanded="false">
                        <img class="me-3" width="17px" src="{{url('site_assets_1/assets/img/side_nav_icon/fav.png')}}">
                        <p>Saved jobs</p>
                      </a>
                  </li>
                  <li class="nav-item {{ Request::is('accounts_settings') ? 'active' : '' }}" >
                      <a href="{{ route('accounts_settings') }}" class="collapsed" aria-expanded="false">
                      <img class="me-3" width="17px" src="{{url('site_assets_1/assets/img/side_nav_icon/acc_settings.png')}}">
                          <p>Accounts Settings</p>
                      </a>
                  </li>
                  <!-- <li class="nav-item">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();"
                     class="collapsed"aria-expanded="false">
                     <i class="fas fa-sign-out-alt"></i>
                     </i> {{__('Logout')}}</a>  
                    </li> -->
              </ul>
          </div>
      </div>
  </div>
  <!-- End of Navbar -->
  @elseif(Auth::guard('company')->check())
    <!-- Start Side Nav Bar -->
    <div class="sidebar sidebar-style-2 sidebar-bg" >
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <div class="user">
                <!-- <div class="avatar-sm float-left mr-2">
                  <img src="" alt="Img" class="avatar-img rounded-circle">
                </div> -->
                <div class="info">
                  
                  <div class="clearfix"></div>

                  <!-- <div class="navbar-card">
                    <div class="card-body text-center">
                      <div class="mx-auto progressbar companyaccountsetting cursor-pointer" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="--value: 100">
                        @if(Auth::guard('company')->user()->image !=null )
                          <img src="{{Auth::guard('company')->user()->image}}" alt="Img" class="avatar-img rounded-circle">
                        @else 
                          <img src="{{ url('site_assets_1/assets/img/default_profile.jpg')}}" alt="Img" class="avatar-img rounded-circle">
                        @endif
                      </div>
                      <div class="mt-1 progressbar" role="progressbar-after" style="--value: 100">
                      </div>
                      <div class="mt-3">
                        <text class="fw-bold">{{Auth::guard('company')->user()->employer_name}}</text><br>
                      </div>
                      <div class="mt-2">
                        <text class="">{{Auth::guard('company')->user()->email}}</text>
                      </div>
                      <div class="mt-2">
                        <text class="">{{Auth::guard('company')->user()->phone}}</text>
                      </div>
                    </div>
                  </div> -->

                  <!-- <div class="">
                      <p class="fw-bold">Industry/organisation</p>
                    <ul>
                      <li>About</li>
                      <li class="disabled">Documents</li>
                    </ul>
                    <div class="">
                      <a href="#">My Info</a>
                      <a href="#">Messages</a>
                      <a href="#">Sub-Users</a>
                      <a href="#">Wallet</a>
                      <a href="#">Subscriptions</a>
                      <a href="#">Account Settings</a>
                    </div>
                    

                  </div> -->
                  
                </div>
              </div>

    
             
              <ul class="nav nav-primary">  
                <div class="dropdown">
                  <li class="nav-item dropdown-toggle text-dark fw-bold">
                      Industry / organisation
                  </li>
                </div>

                <ul class="">  
                  <li class="nav-item">
                    <a class="nav-link " href="#">About</a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" href="#">Documents</a>
                  </li>
                </ul>

                <br/>

                <li class="nav-item {{ Request::is('company/my_profile') ? 'active' : '' }}" >
                    <a href="{{ route('company.my_profile') }}" class="collapsed" aria-expanded="false">
                    <!-- <img class="me-3" width="17px" src="{{url('site_assets_1/assets/img/my_profile.png')}}"> -->
                        <p>My Info</p>
                    </a>
                </li>

                <!-- <li class="nav-item {{ Request::is('company/accounts_settings') ? 'active' : '' }}" >
                    <a href="{{ route('company.accounts_settings') }}" class="collapsed" aria-expanded="false">
                        <p>Messages</p>
                    </a>
                </li>

                <li class="nav-item {{ Request::is('company/accounts_settings') ? 'active' : '' }}" >
                    <a href="{{ route('company.accounts_settings') }}" class="collapsed" aria-expanded="false">
                        <p>Sub-Users</p>
                    </a>
                </li>

                <li class="nav-item {{ Request::is('company/accounts_settings') ? 'active' : '' }}" >
                    <a href="{{ route('company.accounts_settings') }}" class="collapsed" aria-expanded="false">
                        <p>Wallet</p>
                    </a>
                </li>

                <li class="nav-item {{ Request::is('company/accounts_settings') ? 'active' : '' }}" >
                    <a href="{{ route('company.accounts_settings') }}" class="collapsed" aria-expanded="false">
                        <p>Subscriptions</p>
                    </a>
                </li> -->

                <li class="nav-item {{ Request::is('company/accounts_settings') ? 'active' : '' }}" >
                    <a href="{{ route('company.accounts_settings') }}" class="collapsed" aria-expanded="false">
                        <p>Account Settings</p>
                    </a>
                </li>
              </ul> 
          </div>
      </div>
  </div>
  
  @endif

  <script>
    $('.useraccountsetting').click(function() {
        const aTag = document.createElement('a');
        aTag.rel = 'noopener';
        aTag.href = '{{ route("accounts_settings") }}';
        aTag.click();
    });
    $('.companyaccountsetting').click(function() {
        const aTag = document.createElement('a');
        aTag.rel = 'noopener';
        aTag.href = '{{ route("company.accounts_settings") }}';
        aTag.click();
    });
  </script>