@forelse ($jobs as $applyjob)
    @php $job = $applyjob->job; @endphp
    <div class="card mb-4 p-1 job-list" data-jobid="{{$job->slug}}">
        <div class="card-body">
            <div class="row mb-1">
                <div class="col-xl-1 col-md-1 col-sm-1 col-xs-1 col-2 cmpprofile">
                    <div class="avatar-sm">
                        <img alt="{{ $job->title }}" draggable="false" class="rounded-circle h-100" src="{{ $job->company->company_image ?? asset('site_assets_1/assets/img/industry.svg') }}">
                    </div>
                </div>
                <div class="col-md-11 col-xl-11 col-sm-11 col-11">
                    <div class="dsf2lmq">
                        <h4 class="fw-bold text-green-color">{{ $job->title }}</h4>
                        <div class="mb-3 fw-bold">{{ $job->company_name??$job->company->name }}.</div>
                        <div class="row mb-3">
                            <div class="col-md-3 col-sm-4 col-xs-12"><span class=""><img draggable="false" class="me-2 image-size" src="{{ url('site_assets_1/assets/img/side_nav_icon/experience.png') }}"></span><text class="">{{ $job->experience_string }}</text></div>
                            <div class="col-md-5 col-sm-4 col-xs-12"><div><span class=""><img draggable="false" class="me-2 image-size" src="{{ url('site_assets_1/assets/img/side_nav_icon/salary.png') }}"></span><text class="">{{ trim($job->salary_string) ? $job->salary_string :'Not Disclosed' }}</text></div></div>
                            <div class="col-md-4 col-sm-4 col-xs-12"><div><span class=""><img draggable="false" class="me-2 image-size" src="{{ url('site_assets_1/assets/img/side_nav_icon/location.png') }}"></span><text class=""> {{ rtrim($job->work_locations, ", ") }}</text></div></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <h5 class="text-green-color fw-bold">Job Description </h5>
                <ul class="preview_job">
                    {!! $job->description !!}
                </ul>
            </div>
            <div class="d-flex mt-3 justify-content-between">
                <div>
                    @if($job->expiry_date < Carbon\Carbon::now())
                        <text class="text-danger"><i class="jpaicon bi-clock-history"></i> Expired<text> 
                    @else
                        <text>@if($job->is_active == 2) <span class="text-danger">Currently In-active</span> @else <i class="jpaicon bi-clock-history"></i> {{ \Carbon\Carbon::parse($applyjob->created_at)->diffForHumans() }} @endif</text> 
                    @endif
                </div>
                <div class="text-black-75">            
                    @if($applyjob->application_status==null) <text>Resume to be viewed</text>
                    @elseif($applyjob->application_status=='view' || $applyjob->application_status=='consider') <span><img draggable="false" class="imagesz-2" src="{{ url('site_assets_1/assets/img/viewed.png')}}" alt="viewed"> Resume viewed </span>
                    @elseif($applyjob->application_status=='shortlist') <span><img draggable="false" class="imagesz-2" src="{{ url('site_assets_1/assets/img/Shortlist.png')}}" alt="shortlisted"> Shortlisted </span>
                    @elseif($applyjob->application_status=='reject') <span><img draggable="false" class="imagesz-2" src="{{ url('site_assets_1/assets/img/Rejected.png')}}" alt="rejected"> Rejected </span> @endif
                </div>
                <div class="d-flex">
                    {{-- <div class="px-2">
                        <img draggable="false" class="image-size" src="{{url('site_assets_1/assets/img/star_unfilled.png')}}" alt="star">
                        <img draggable="false" class="image-size" src="{{url('site_assets_1/assets/img/star_filled.png')}}" style="display:none" alt="star">
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="d-flex justify-content-center">
        <div class="">
            <div class="text-center no_kmbq1 mb-4">
                <img draggable="false" class="janoimg" src="{{ url('images/profile/no_jobs.svg') }}" rel="nofollow">
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
        {{ $jobs->appends(request()->query())->links(); }}
    </div>
@endif   
<script>
    $('.job-list').click(function() {
        const aTag = document.createElement('a');
        aTag.rel = 'noopener';
        aTag.target = "_blank";
        aTag.href = '{{ url("detail") }}/'+$(this).data("jobid");
        aTag.click();
    });
</script>