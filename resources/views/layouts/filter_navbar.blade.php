
<!-- Start Side Nav Bar -->
    <div class="sidebar sidebar-style-2" data-background-color="">
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
                
                <div class="text-center mt-5 d-flex justify-content-around">
                    <h4 class="fw-bold">Filter by</h4>
                    <span class="bg-color-blue px-1 align-self-start rounded-pill">
                    <i class="fa-solid fa-rotate-left"></i> <input class="border-0" style="background:unset;" type="reset" value="Reset">
                    </span>
                </div>
                <ul class="nav nav-primary">                  
                    <li class="nav-item active" >
                        <a href="#" data-bs-toggle="collapse" >
                            <img draggable="false" class="me-3" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/location.png')}}">
                            <p>Location</p>
                            <span class="caret"></span>
                        </a>
                            
                        <!-- <div class="collapse" id="test" > -->
                            <div class="row">
                                <div class="d-flex align-items-center">
                                    <select class="js-select2" multiple="multiple">
                                        <option value="O1" data-badge="">Option1</option>
                                        <option value="O2" data-badge="">Option2</option>
                                        <option value="O3" data-badge="">Option3</option>
                                        <option value="O4" data-badge="">Option4</option>
                                        <option value="O5" data-badge="">Option5</option>
                                        <option value="O6" data-badge="">Option6</option>
                                        <option value="O7" data-badge="">Option7</option>
                                        <option value="O8" data-badge="">Option8</option>
                                        <option value="O9" data-badge="">Option9</option>
                                        <option value="O10" data-badge="">Option10</option>
                                        <option value="O11" data-badge="">Option11</option>
                                        <option value="O12" data-badge="">Option12</option>
                                        <option value="O13" data-badge="">Option13</option>
                                    </select>
                                </div>
                            </div>
                        <!-- </div> -->
                    </li>   
                    
                    <li class="nav-item" >
                        <a href="#work_filter" data-bs-toggle="collapse" >
                            <img draggable="false" class="me-3" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/salary.png')}}">
                            <p>Salary</p>
                            <span class="caret"></span>
                        </a>
                            
                        <div class="collapse" id="work_filter" >
                            <div class="" style="margin-left:20px">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="2-4lakhs">
                                    <label class="form-check-label" for="2-4lakhs">
                                    2-4lakhs/annum
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="4-6lakhs">
                                    <label class="form-check-label" for="4-6lakhs">
                                    4-6lakhs/annum
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="6-8lakhs">
                                    <label class="form-check-label" for="6-8lakhs">
                                    6-8lakhs/annum
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="8-10lakhs">
                                    <label class="form-check-label" for="8-10lakhs">
                                    8-10lakhs/annum
                                    </label>
                                </div>
                            </div>      
                        </div>
                    </li> 

                    <li class="nav-item" >
                        <a href="#experience_filter" data-bs-toggle="collapse" >
                        <img draggable="false" class="me-3" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/experience.png')}}">
                            <p>Experience</p>
                            <span class="caret"></span>
                        </a>
                        
                        <div class="collapse" id="experience_filter" >
                            
                            <div class="custom-rangeslider">
                                <input class="custom-rangeInput" title="Percentage" id="range-slider1" type="range" min="0" max="15" value="0" step="1" data-tooltip="true" aria-controls="rangeTooltip rangeLabel" aria-live="polite">
                                <span class="custom-rangeslider__tooltip">0</span>
                                <span class="custom-rangeslider__label">
                                    <span class="custom-rangeslider__label-min">0</span>
                                    <span class="custom-rangeslider__label-max">15+</span>
                                </span>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item" >
                        <a href="#shift_filter" data-bs-toggle="collapse" >
                            <img draggable="false" class="me-3" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/job_by_shift.png')}}">
                            <p>Job by shifts</p>
                            <span class="caret"></span>
                        </a>
                        
                            <div class="collapse" id="shift_filter" >
                                <div class="" style="margin-left:20px">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="full-time">
                                        <label class="form-check-label" for="full-time">
                                        full-time
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="Part-time">
                                        <label class="form-check-label" for="Part-time">
                                        Part-time
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="work_from_home">
                                        <label class="form-check-label" for="work_from_home">
                                        Work from home
                                        </label>
                                    </div>
                                    
                                    <p class="show_more_job_shifts show_more">show more +</p>
                                </div>      
                            </div>
                    </li>

                    <li class="nav-item" >
                        <a href="#posted_filter" data-bs-toggle="collapse" >
                            <img draggable="false" class="me-3" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/posted_by.png')}}">
                            <p>Posted by</p>
                            <span class="caret"></span>
                        </a>
                        
                            <div class="collapse" id="posted_filter" >
                                <div class="" style="margin-left:20px">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="organisation_industry">
                                        <label class="form-check-label" for="organisation_industry">
                                        Organisation/Industry
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="consultancy">
                                        <label class="form-check-label" for="consultancy">
                                        Consultancy
                                        </label>
                                    </div>
                                </div>      
                            </div>
                    </li>

                    <li class="nav-item" >
                        <a href="#study_filter" data-bs-toggle="collapse" >
                            <img draggable="false" class="me-3" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/level_of_education.png')}}">
                            <p>Level of Education</p>
                            <span class="caret"></span>
                        </a>
                            
                        <div class="collapse" id="study_filter" >
                            <ul class="nav nav-collapse">	
                                <li class="">
                                    <a href="">
                                        <span class="sub-item">10th Standard</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="">
                                        <span class="sub-item">12th Standard</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="">
                                        <span class="sub-item">Under graduate</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="">
                                        <span class="sub-item">Post graduate</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="">
                                        <span class="sub-item">Ph.D</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> 

                    <li class="nav-item" >
                        <a href="#remote_filter" data-bs-toggle="collapse" >
                            <img draggable="false" class="me-3" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/designation.png')}}">
                            <p>Remote</p>
                            <span class="caret"></span>
                        </a>
                            
                        <div class="collapse" id="remote_filter" >
                            <ul class="nav nav-collapse">	
                                <li class="">
                                    <a href="">
                                        <span class="sub-item">Remote</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> 

                    <li class="nav-item" >
                        <a href="#industry_filter" data-bs-toggle="collapse" >
                            <img draggable="false" class="me-3" width="20px" src="{{url('site_assets_1/assets/img/side_nav_icon/industry.png')}}">
                            <p>Industry</p>
                            <span class="caret"></span>
                        </a>
                            
                        <div class="collapse" id="industry_filter" >
                            <ul class="nav nav-collapse">	
                                <li class="">
                                    <a href="">
                                        <span class="sub-item">IT</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="">
                                        <span class="sub-item">Non IT</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> 
                    
                </ul>
          </div>
      </div>
  </div>

  <script type="text/javascript" src="{{ asset('site_assets_1/assets/js/range_slider.js') }}"></script>
  <script>
      $("#hide_show_job_shifts").hide();
      $(".show_less").hide();
      $(".show_more").on("click",function(){
        $("#hide_show_job_shifts").show();
        $(".show_less").show();
        $(".show_more").hide();
      });
      $(".show_less").on("click",function(){
        $("#hide_show_job_shifts").hide();
        $(".show_less").hide();
        $(".show_more").show();
      });
  </script>
  <!-- End of Navbar -->