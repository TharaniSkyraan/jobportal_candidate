@forelse ($jobs as $savedjob)
    @php $job = $savedjob->job; @endphp
        <div class="card mb-4 p-1 job-list" data-jobid="{{$job->slug}}">
            <div class="card-body m-1">
                <div class="row mb-1">
                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-1 col-1 cmpprofile">
                        <div class="avatar-sm">
                            <img alt="Web developer" draggable="false" class="rounded-circle h-100" src="http://localhost/candidate/site_assets_1/assets/img/industry.svg">
                        </div>
                    </div>

                    <div class="col-xl-11 col-lg-11 col-md-11 col-sm-11 col-xs-11 col-12">
                        <div class="dsf2lmq">
                            <div class="d-flex">                                
                                <div class="jtle-jcmp">
                                    <h4 class="fw-bold text-green-color">{{ $job->title }}</h4>
                                    <div class="mb-3 fw-bold">{{ $job->company_name??$job->company->name }}.</div>
                                </div>
                                @if($job->expiry_date > Carbon\Carbon::now())
                                    @if(Auth::user()->isAppliedOnJob($job->id))                
                                        <label class="japplied-btn">
                                            <button class="btn p-1 px-2 shadow-sm rounded-pill">
                                                <img draggable="false" class="imagesz-2" src="{{ asset('site_assets_1/assets/img/Shortlist.png')}}" alt="applied"> 
                                                <span class="fw-bold">Applied</span>
                                            </button>
                                        </label>
                                    @elseif($job->is_active==1)
                                        @if(count($job->screeningquiz)!=0 || !empty($job->reference_url))
                                            <label class="japply-btn">
                                                <button class="btn p-1 px-2 shadow-sm bg-color-blue rounded-pill japplybtnredir" id="japplybtn">
                                                    <img draggable="false" class="image-size" src="{{ asset('site_assets_1/assets/img/apply2.png')}}" alt="apply"> 
                                                    <span>Apply</span>
                                                </button>
                                            </label>
                                        @else
                                            <label class="japply-btn">
                                                <button class="btn p-1 px-2 shadow-sm bg-color-blue rounded-pill japplybtn" id="japplybtn">
                                                    <img draggable="false" class="image-size" src="{{ asset('site_assets_1/assets/img/apply2.png')}}" alt="apply">
                                                    <span> Apply</span>
                                                </button>
                                            </label>
                                        @endif
                                    @endif
                                @else
                                    @if(Auth::user()->isAppliedOnJob($job->id))                    
                                        <label class="japplied-btn">
                                            <button class="btn p-1 px-2 shadow-sm rounded-pill">
                                                <img draggable="false" class="imagesz-2" src="{{ asset('site_assets_1/assets/img/Shortlist.png')}}" alt="applied"> 
                                                <span class="fw-bold">Applied</span>
                                            </button>
                                        </label>
                                    @endif
                                @endif
                            </div>
                            <div class="row mb-3">
                                <div class="col-xl-4 col-lg-4 col-md-5 col-sm-5 col-xs-12 col-12 d-flex mb-2"><span class=""><img draggable="false" class="me-2 image-size" src="{{ url('site_assets_1/assets/img/side_nav_icon/experience.png') }}"></span><text class="">{{ $job->experience_string }}</text></div>
                                <div class="col-xl-4 col-lg-4 col-md-7 col-sm-7 col-xs-12 col-12 d-flex mb-2"><div><span class=""><img draggable="false" class="me-2 image-size" src="{{ url('site_assets_1/assets/img/side_nav_icon/salary.png') }}"></span><text class="">{{ trim($job->salary_string) ? $job->salary_string :'Not Disclosed' }}</text></div></div>
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 col-12 d-flex mb-2">
                                    <div><span class=""><img draggable="false" class="me-2 image-size" src="{{ url('site_assets_1/assets/img/side_nav_icon/location.png') }}"></span><text class="">@if($job->work_locations != null) {{ rtrim($job->work_locations, ", ") }} @else Remote @endif</text></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="jdesc">
                    <h5 class="text-green-color fw-bold">Job Description </h5>
                    <ul class="preview_job p-0">
                        {!! $job->description !!}
                    </ul>
                </div>
                <div class="d-flex mt-2 justify-content-between jepiry">
                    @if($job->expiry_date < Carbon\Carbon::now())
                        <div><text class="text-danger"><i class="jpaicon bi-clock-history"></i> Expired<text> </div>
                    @elseif($job->is_active==2)
                        <div><text class="text-danger"><i class="jpaicon bi-clock-history"></i> Currently In-active<text> </div>
                    @else
                        <div><text>Posted : <i class="jpaicon bi-clock-history"></i> {{ \Carbon\Carbon::parse($job->created_at)->diffForHumans() }}</text> </div>
                    @endif
                    <div class="text-black-75">            
                    </div>
                    @php
                        $is_fav = 'no';
                        if((Auth::check() && Auth::user()->isFavouriteJob($job->slug)==true))
                        {
                            $is_fav = 'yes';
                        }
                    @endphp
                    <div class="d-flex">
                        <label class="favjob" data-slug="{{ $job->slug }}"><button class="btn p-1 px-2 shadow-sm rounded-pill cursor-pointer"> <img draggable="false" class="image-size cursor-pointer" src="{{ asset('site_assets_1/assets/img/star_filled.png')}}" alt="bookmark"> <span>Saved</span></button></label>
                    </div>
                </div>
            </div>
        </div>
    @empty
    <div class="d-flex justify-content-center">
        <div class="">
            <div class="text-center no_kmbq1 mb-4">
                <img draggable="false" class="janoimg" src="{{ url('images/profile/favour_jobs.svg') }}" rel="nofollow">
                <div class="no_kmbq2">
                    No<br/>
                    <strong>"Jobs found"</strong>
                </div>
            </div>
        </div>
    </div>
@endforelse
@if($jobs->total())
    <div class="d-flex justify-content-center mt-5">
        {{ $jobs->appends(request()->query())->links('pagination::bootstrap-5'); }}
    </div>
@endif   


