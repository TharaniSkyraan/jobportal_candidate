<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('site_assets_1/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('site_assets_1/assets/1a9ve2/css/api/common.css')}}">
    <link rel="stylesheet" href="{{ asset('site_assets_1/assets/1a9ve2/css/api/cantybfw.css')}}">
    <title>Candidate</title>
  </head>
  <body>
<div class="cantybfw">
        <div class="detailsn1">
            <div class="space-width">
                <div class="profile-d">
                    
                    <div class="hgvwnema">
                        <div class="prf d-flex">
                            <div class="profile">
                                <img src="{{ $user->image??asset('images/profile/profile_placeholder.svg') }}" alt="profile-image">
                            </div>
                            <div class="ps-3">
                                <h3>{{$user->getName()}}</h3>
                                @if(!empty($user->getGender('gender')) || !empty($user->getAge())) 
                                    <h6> @if(!empty($user->getGender('gender'))) {{$user->getGender('gender')}}, @endif 
                                        {{$user->getAge()}} </h6> 
                                @endif
                                <p>{{ $user->email }}</p>
                                <p>{{ $user->phone }}</p>
                                <p>{{ $user->location }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Myself -->
                    @if(!empty($user->summary))
                    <div class="hgvwnema myself">
                        <h6 class="my-2">About Myself</h6>
                        <div class="mb-4">
                            <div class="text-desc">
                                {{$user->summary}}.
                            </div>  
                        </div>  
                    </div>
                    @endif
                    
                    @if(count($user->userEducation)!=0) 
                        <!-- Education -->
                        <div class="hgvwnema education">
                            <h6 class="my-4">Education</h6>
                            <div class="mb-3">
                                @forelse($user->userEducation as $education)
                                    @php
                                        $educa =  $education->getEducationLevel('education_level') . (($education->getEducationType('education_type')!='' || $education->education_type!='')? ' - ' : ' ') . $education->getEducationType('education_type');
                                        $year = (!empty($education->from_year) && !empty($education->to_year))?\Carbon\Carbon::parse($education->from_year)->Format('M Y') . ' - '. ($education->pursuing!='yes'? \Carbon\Carbon::parse($education->to_year)->Format('M Y') : 'Still Pursuing'):'';
                                        $percentage = ($education->percentage!=''? $education->getResultType('result_type') . ': ' . $education->percentage : ' ' );
                                        $location =  ($education->institution!=''?ucwords($education->institution).', ':'') . ($education->location!=''?$education->location:'');
                                    @endphp
                                    <address class="mt-3">
                                        <h5 class="fw-bold">{{$educa}}</h5>
                                        @if(!empty($location)) <p>{{$location}}.</p> @endif
                                        @if(!empty($year))<p>{{$year}}.</p> @endif
                                        @if(!empty($education->percentage))
                                        <p>{{$percentage}}</p>
                                        @endif
                                    </address>                                    
                                    @empty 
                                @endforelse
                            </div> 
                        </div>
                    @endif
                    
                    @if(count($user->userExperience)!=0)
                        <!-- Experience -->
                        <div class="hgvwnema experience">
                            <h6 class="my-4">Experiences</h6>
                            <div class="mb-5">
                                @foreach($user->userExperience as $experience)
                                    @php
                                        $date = \Carbon\Carbon::parse($experience->date_start)->Format('M Y') . ' - '. ($experience->is_currently_working!=1? \Carbon\Carbon::parse($experience->date_end)->Format('M Y') : 'Currently working');
                                        $exp_used_tools = array_filter(explode(',',$experience->used_tools));
                                    @endphp 
                                    <address class="mt-3">
                                        <h5 class="fw-bold">{{$experience->title}}</h5>
                                        <p>{{$experience->company}}, {{ $experience->location }}.</p>
                                        @if(!empty($date)) <p>{!! $date !!}</p> @endif
                                    </address>

                                    <h6 class="fw-bold">Job Description</h6>
                                    <div class="text-desc">
                                        {!! $experience->description !!}
                                    </div>  
                                    @if(!empty($experience->used_tools))
                                        <h6 class="fw-bold text-dark">Tools / software used</h6>
                                        <p>{{$experience->used_tools}}</p>
                                    @endif
                                @endforeach
                            </div>  
                        </div>
                    @endif
                    @if(count($user->userProjects)!=0)
                        <!-- Project -->
                        <div class="hgvwnema project">
                            <h6 class="my-4">Projects</h6>
                            <div class="mb-3">
                                @foreach ($user->userProjects as $project)      
                                    @php
                                        $date = '';                
                                        if ($project->is_on_going == 1){
                                            $date = $project->date_start != null ? \Carbon\Carbon::parse($project->date_start)->Format('M Y').' - Currently ongoing' : "Currently ongoing";
                                        }else{
                                            $start_date = $project->date_start != null ? \Carbon\Carbon::parse($project->date_start)->Format('M Y')  : "";
                                            $end_date = $project->date_end != null ? " - ".\Carbon\Carbon::parse($project->date_end)->Format('M Y')  : "";
                                            $date = $start_date . $end_date;
                                        }
                                
                                    @endphp 
                                    <address class="mt-3">
                                        <h5 class="fw-bold">{{ $project->name }}</h5>
                                        <p>@if(!empty($project->getCompany('company'))){{ $project->getCompany('company') }} ,@endif @if(!empty($project->location)){{ $project->location }}.@endif</p>
                                        @if(!empty($project->date_start) || !empty($project->date_end)) <p>{{ $date }}.</p> @endif
                                    </address>

                                    <h6 class="fw-bold">Job Description</h6>
                                    <div class="text-desc">
                                        {!! $project->description !!}
                                    </div>   
                                    @if(!empty($project->url))
                                    <h6 class="fw-bold text-dark">Project Link</h6>
                                    <p> <a href="{{$project->url}}" target="_blank">{{$project->url}}</a> </p>
                                    @endif
                                    @if(!empty($project->used_tools))
                                        <h6 class="fw-bold text-dark">Tools / software used</h6>
                                        <p>{{$project->used_tools}}</p>
                                    @endif
                                @endforeach
                            </div> 
                        </div>
                    @endif
                    
                    @if(count($user->userSkills)!=0)
                        <!-- Skills -->
                        <div class="hgvwnema skill">
                            <div class="mb-3">
                                <h6 class="my-4">Skills</h6>
                                <div class="row">
                                    @foreach($user->userSkills as $skill)
                                        @if(isset($skill->skill->is_active) && $skill->skill->is_active==1)
                                            @php
                                                $date =  (!empty($skill->start_date)?\Carbon\Carbon::parse($skill->start_date)->Format('M Y'):'').(!empty($skill->end_date)?\Carbon\Carbon::parse($skill->end_date)->Format('M Y'):'');
                                                if(!empty($skill->start_date) && !empty($skill->end_date)){ 
                                                    $date = 'Practicing From '. \Carbon\Carbon::parse($skill->start_date)->Format('M Y').' - '.\Carbon\Carbon::parse($skill->end_date)->Format('M Y');
                                                } 
                                                if(!empty($date)){
                                                    $date = $date . ($skill->is_currently_working=='yes'?'( Currently Working )':'');
                                                }
                                            @endphp
                                            <div class="col-6">
                                                <h5 class="fw-bold">{{ $skill->getSkill('skill') }}</h5>
                                                <p>@if($skill->getLevel('language_level')!='') {{ $skill->getLevel('language_level') }}, @endif  @if(!empty($skill->start_date) || !empty($skill->end_date)){{ $date }}.@endif</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                            </div> 
                        </div>
                    @endif
                    
                    @if(count($user->userLanguages)!=0)
                        <!-- Language -->
                        <div class="mb-3 language">
                            <h6>Languages Known</h6>
                            <table class="text-center">
                                <thead>
                                    <td>Language</td>
                                    <td>Proficiency level</td>
                                    <td>Read</td>
                                    <td>Speak</td>
                                    <td>Write</td>
                                </thead>
                                <tbody>
                                    @foreach ($user->userLanguages as $language)
                                    <tr>
                                        <td><strong>{{ $language->getLanguage('lang') }}</strong></td>
                                        <td>{{ $language->getLanguageLevel('language_level') }}</td>
                                        <td>@if($language->read == "yes")<i class="fa fa-check"></i>@endif</td>
                                        <td>@if($language->speak == "yes")<i class="fa fa-check"></i>@endif</td>
                                        <td>@if($language->write == "yes")<i class="fa fa-check"></i>@endif</td>
                                    </tr>
                                    @endforeach  
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="hgvwnema mt-3">
                        <p>I hereby declare that all the information furnished above is true to the best of my knowledge. </p>
                        <p class="text-end">Yours Faithfully<br>{{$user->getName()}} </p>
                    </div>
                </div>
            </div>            
        </div>
    </div>
  
  </body>
</html>