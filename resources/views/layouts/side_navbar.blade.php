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
<!-- Start Side Nav Bar -->
<div id="user_sbar">
    <div class="sidebar sidebar-style-2 sidebar-bg" >
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="user_card">
                    <div class="row">
                        <div class="col-4 align-self-center">
                            <div class="mx-auto progressbar useraccountsetting cursor-pointer fw-bolder" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="--value: {{$final_percentage}}">    
                                {{$final_percentage}}%                     
                            </div>
                        </div>
                        <div class="col-8 align-self-center">
                            <div class="pf_cfont text-white fw-bolder">Profile Completion</div> 
                            <div class="pf_cfont text-white text-center">
                                <a class="text-white dropdown-toggle" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="{{ (Request::is('my_profile') || Request::is('education-details') || Request::is('experience-details') || Request::is('project-details') || Request::is('language-details') || Request::is('skill-details') || Request::is('career-info-details')) ? 'true' : 'false' }}" aria-controls="collapseExample">
                                    My info
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="collapse {{ (Request::is('home') || Request::is('education-details') || Request::is('experience-details') || Request::is('project-details') || Request::is('language-details') || Request::is('skill-details') || Request::is('career-info-details')|| Request::is('resume-details')) ? 'show' : '' }}" id="collapseExample">
                <div class="card card-body">
                    <div class="row mb-3 {{ (empty(Auth::user()->date_of_birth))? 'no_fillfield' : '' }}">
                        <div class="col-10">
                            <div class="sideb_icn">
                                <img src="{{asset('images/candidate_educ.png')}}" alt="">
                                <a href="{{ route('home') }}">&nbsp;About me</a>
                            </div>                            
                        </div>
                        <div class="col-2 align-self-center text-center">
                            <i class="{{ (empty(Auth::user()->date_of_birth))? 'fa fa-plus' : 'fa fa-check' }}"></i>
                        </div>
                    </div>
                    <div class="click_side2">
                        <div class="row mb-3 {{ (count(Auth::user()->UserCvs)==0)? 'no_fillfield' : '' }}">
                            <div class="col-10">
                                <div class="sideb_icn">
                                    <img src="{{asset('images/candidate_exp.png')}}" alt="">
                                    <a href="{{ route('resume-details') }}">&nbsp;My Resume</a>
                                </div>
                            </div>
                            <div class="col-2 align-self-center text-center">
                                <i class="{{ (count(Auth::user()->UserCvs)==0)? 'fa fa-plus' : 'fa fa-check' }}"></i>
                            </div>
                        </div>
                    </div>

                    <div class="click_side1">
                        <div class="row mb-3 {{ (count($eduLevelids)==0)? 'no_fillfield' : '' }}">
                            <div class="col-10">
                                <div class="sideb_icn">
                                    <img src="{{asset('images/candidate_exp.png')}}" alt="">
                                    @if(Request::is('education-details'))
                                    <a href="javascript:;">&nbsp;My Education</a>
                                    @else
                                    <a href="{{ route('education-details') }}">&nbsp;My Education</a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-2 align-self-center text-center">
                                <i class="{{ (count($eduLevelids)==0)? 'fa fa-plus' : 'fa fa-check' }}"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="side_rgt" style="{{(Request::is('education-details')) ? '' : 'display:none' }}">
                        @foreach ($eduLevels as $key => $eduLevel)                              
                            <div class="row mb-3 {{ (!in_array($key, $eduLevelids)) ? 'no_fillfield' : '' }}" >
                                <div class="col-10">
                                    <div class="sideb_icn">
                                        <a href="javascript:;">&nbsp;{{$eduLevel}}</a>
                                    </div>
                                </div>
                                <div class="col-2 align-self-center text-center">
                                    <i class="{{ (!in_array($key, $eduLevelids)) ? 'fa fa-plus' : 'fa fa-check' }}"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="click_side2">
                        <div class="row mb-3 {{ (count(Auth::user()->userExperience)==0)? 'no_fillfield' : '' }}">
                            <div class="col-10">
                                <div class="sideb_icn">
                                    <img src="{{asset('images/candidate_exp.png')}}" alt="">
                                    <a href="{{ route('experience-details') }}">&nbsp;My Experience</a>
                                </div>
                            </div>
                            <div class="col-2 align-self-center text-center">
                                <i class="{{ (count(Auth::user()->userExperience)==0)? 'fa fa-plus' : 'fa fa-check' }}"></i>
                            </div>
                        </div>
                    </div>

                    <div class="click_side2">
                        <div class="row mb-3 {{ (count(Auth::user()->userProjects)==0)? 'no_fillfield' : '' }}">
                            <div class="col-10">
                                <div class="sideb_icn">
                                    <img src="{{asset('images/candidate_exp.png')}}" alt="">
                                    <a href="{{ route('project-details') }}">&nbsp;My Projects</a>
                                </div>
                            </div>
                            <div class="col-2 align-self-center text-center">
                                <i class="{{ (count(Auth::user()->userProjects)==0)? 'fa fa-plus' : 'fa fa-check' }}"></i>
                            </div>
                        </div>
                    </div>

                    <div class="click_side2">
                        <div class="row mb-3 {{ (count(Auth::user()->userSkills)==0)? 'no_fillfield' : '' }}">
                            <div class="col-10">
                                <div class="sideb_icn">
                                    <img src="{{asset('images/candidate_exp.png')}}" alt="">
                                    <a href="{{ route('skill-details') }}">&nbsp;My Skills</a>
                                </div>
                            </div>
                            <div class="col-2 align-self-center text-center">
                                <i class="{{ (count(Auth::user()->userSkills)==0)? 'fa fa-plus' : 'fa fa-check' }}"></i>
                            </div>
                        </div>
                    </div>

                    <div class="click_side2">
                        <div class="row mb-3 {{ (count(Auth::user()->userLanguages)==0)? 'no_fillfield' : '' }}">
                            <div class="col-10">
                                <div class="sideb_icn">
                                    <img src="{{asset('images/candidate_exp.png')}}" alt="">
                                    <a href="{{ route('language-details') }}">&nbsp;Languages known</a>
                                </div>
                            </div>
                            <div class="col-2 align-self-center text-center">
                                <i class="{{ (count(Auth::user()->userLanguages)==0)? 'fa fa-plus' : 'fa fa-check' }}"></i>
                            </div>
                        </div>
                    </div>

                    <div class="click_side2">
                        <div class="row mb-3 {{ empty(Auth::user()->career_title)? 'no_fillfield' : '' }}">
                            <div class="col-10">
                                <div class="sideb_icn">
                                    <img src="{{asset('images/candidate_exp.png')}}" alt="">
                                    <a href="{{ route('career-info-details') }}">&nbsp;Career Info</a>
                                </div>
                            </div>
                            <div class="col-2 align-self-center text-center">
                                <i class="{{ empty(Auth::user()->career_title)? 'fa fa-plus' : 'fa fa-check' }}"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <ul class="nav nav-primary">                 
            <li class="nav-item {{ Request::is('applied-jobs') ? 'active' : '' }}" >
                <a href="{{ route('applied-jobs') }}" class="collapsed" aria-expanded="false">
                <img class="me-3" width="17px" src="{{url('images/applied_jobs.png')}}">
                    <p>Applied Jobs</p>
                </a>
            </li>
            {{-- <li class="nav-item" >
                <a href="#" class="collapsed" aria-expanded="false">
                    <img class="me-3" width="17px" src="{{url('images/messages.png')}}">
                    <p>Messages</p>
                </a>
            </li>
            <li class="nav-item" >
                <a href="#" class="collapsed" aria-expanded="false">
                    <img class="me-3" width="17px" src="{{url('images/job_alerts.png')}}">
                    <p>Job Alerts</p>
                </a>
            </li> --}}
            <li class="nav-item {{ Request::is('saved-jobs') ? 'active' : '' }}" >
                <a href="{{ route('saved-jobs') }}" class="collapsed" aria-expanded="false">
                    <img class="me-3" width="17px" src="{{url('images/saved_jobs.png')}}">
                    <p>Saved jobs</p>
                </a>
            </li>
            {{-- <li class="nav-item {{ Request::is('accounts_settings') ? 'active' : '' }}" >
                <a href="{{ route('accounts_settings') }}" class="collapsed" aria-expanded="false">
                <img class="me-3" width="17px" src="{{url('images/account_settings.png')}}">
                    <p>Accounts Settings</p>
                </a>
            </li> --}}
        </ul>
    </div>
</div>

<!-- End of Navbar -->
<script>
    $('.useraccountsetting').click(function() {
        const aTag = document.createElement('a');
        aTag.rel = 'noopener';
        aTag.href = '{{ route("accounts_settings") }}';
        aTag.click();
    });

    //collapse menu hide show
    $('.click_side1').click(function(){
        $('.side_rgt').toggle();
    });
</script>