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
    $eduLevels = App\Helpers\DataArrayHelper::langEducationlevelsArray();
    $eduLevelids = App\Model\UserEducation::whereUserId(Auth::user()->id)->pluck('education_level_id')->toArray();
@endphp 
    <nav class="sidenavbar locked">
      <div class="logo_items flex">
        <i class="fa fa-close text-white" id="lock-icon" title="Unlock Sidenavbar"></i>
        <i class="fa fa-bars text-white" id="sidenavbar-close"></i>
          <text class="nav_image">
            <a href="{{url('/')}}"><img src="{{ asset('/') }}site_assets_1/logo1.png" alt="logo_img" /></a>
          </text> 
        </div>

      <div class="menu_container">        
        <!-- {{ (Request::is('home') || Request::is('education-details') || Request::is('experience-details') || Request::is('project-details') || Request::is('language-details') || Request::is('skill-details') || Request::is('career-info-details')|| Request::is('resume-details')) ? 'show' : '' }}  -->
        <div class="card card-body">            
          <div class="user d-flex">           
              <a>
                <div class="progressbar text-black useraccountsetting cursor-pointer fw-bolder" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="--value: {{$final_percentage}}">    
                  {{$final_percentage}}%                     
                </div>
              </a>
              <div>
                <span class="completion">Profile Completion </span>
                <span class="email"> {{Auth::user()->email}}</span>
              </div>
          </div>
          <a class="text-black text-center toggle" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
            <i class="fa fa-angle-down angle-toggle"></i> 
          </a>   
          <div class="collapse collapses" id="collapseExample">
            <div class="menu_items">
              <ul class="menu_item">
                <li class="item">
                  <a href="{{route('home')}}" class="link flex {{ (empty(Auth::user()->date_of_birth))? 'no_fillfield' : '' }}">
                    <img src="{{asset('images/sidebar/my_info.svg')}}" alt="">
                    <span>About Me</span>
                  </a>
                </li>
                <li class="item">
                  <a href="{{route('resume-details')}}" class="link flex {{ (count(Auth::user()->UserCvs)==0)? 'no_fillfield' : '' }}">
                    <img src="{{asset('images/sidebar/resume.svg')}}" alt="">
                    <span>Resume</span>
                  </a>
                </li>
                <li class="item">
                  <a href="{{route('education-details')}}" class="link flex {{ (count($eduLevelids)==0)? 'no_fillfield' : '' }}">
                    <img src="{{asset('images/sidebar/education.svg')}}" alt="">
                    <span>Education</span>
                  </a>
                </li>
                <li class="item">
                  <a href="{{route('experience-details')}}" class="link flex">
                    <img src="{{asset('images/sidebar/experience.svg')}}" alt="">
                    <span>Experience</span>
                  </a>
                </li>
                <li class="item">
                  <a href="{{route('project-details')}}" class="link flex {{ (count(Auth::user()->userProjects)==0)? 'no_fillfield' : '' }}">
                    <img src="{{asset('images/sidebar/project.svg')}}" alt="">
                    <span>Project</span>
                  </a>
                </li>
                <li class="item">
                  <a href="{{route('skill-details')}}" class="link flex {{ (count(Auth::user()->userSkills)==0)? 'no_fillfield' : '' }}">
                    <img src="{{asset('images/sidebar/skill.svg')}}" alt="">
                    <span>Skills</span>
                  </a>
                </li>
                <li class="item">
                  <a href="{{route('language-details')}}" class="link flex {{ (count(Auth::user()->userLanguages)==0)? 'no_fillfield' : '' }}">
                    <img src="{{asset('images/sidebar/language.svg')}}" alt="">
                    <span>Language known</span>
                  </a>
                </li>
                <li class="item">
                  <a href="{{route('career-info-details')}}" class="link flex {{ empty(Auth::user()->career_title)? 'no_fillfield' : '' }}">
                    <img src="{{asset('images/sidebar/career_info.svg')}}" alt="">
                    <span>Career Information</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="menu_items">
          <ul class="menu_item">
            <!-- <div class="menu_title flex">
              <span class="title">Dashboard</span>
              <span class="line"></span>
            </div> -->
            
            <li class="item">
              <a href="#" class="link flex">
                <img src="{{asset('images/sidebar/job_alerts.svg')}}" alt="">
                <span>Job Alerts</span>
              </a>
            </li>
            <li class="item">
              <a href="{{ route('applied-jobs') }}" class="link flex {{ Request::is('applied-jobs') ? 'active' : '' }}">
                
              <img src="{{asset('images/sidebar/applied_jobs.svg')}}" alt="">
                <span>Applied Jobs</span>
              </a>
            </li>
            <li class="item">
              <a href="{{ route('saved-jobs') }}" class="link flex {{ Request::is('saved-jobs') ? 'active' : '' }}">
                <img src="{{asset('images/sidebar/saved_jobs.svg')}}" alt="">
                <span>Saved jobs</span>
              </a>
            </li>
            <li class="item">
              <a href="#" class="link flex">
                <img src="{{asset('images/sidebar/message.svg')}}" alt="">
                <span>Messages</span>
              </a>
            </li>
            <li class="item">
              <a href="{{ route('accounts_settings') }}" class="link flex {{ Request::is('accounts_settings') ? 'active' : '' }}">
                <img src="{{asset('images/sidebar/account_setting.svg')}}" alt="">
                <span>Accounts Settings</span>
              </a>
            </li>
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
