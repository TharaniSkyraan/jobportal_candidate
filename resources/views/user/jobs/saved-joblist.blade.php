
@forelse ($jobs as $savedjob)
@php $job = $savedjob->job; @endphp
<div class="card mb-4 p-1 job-list" data-jobid="{{$job->slug}}">
    <div class="card-body m-1">
        <div class="row mb-1">
            <div class="col-md-6 col-sm-8 col-xs-12"><h4 class="fw-bold text-green-color">{{ $job->title }}</h4></div>
        </div>
        <div class="mb-3 fw-bold">{{ $job->company->name??'' }}.</div>
        <div class="row mb-3">
            <div class="col-md-3 col-sm-4 col-xs-12"><span class=""><img class="me-2 image-size" src="{{ url('site_assets_1/assets/img/side_nav_icon/experience.png') }}"></span><text class="">{{ $job->experience_string }}</text></div>
            <div class="col-md-5 col-sm-4 col-xs-12"><div><span class=""><img class="me-2 image-size" src="{{ url('site_assets_1/assets/img/side_nav_icon/salary.png') }}"></span><text class="">{{ trim($job->salary_string) ? $job->salary_string :'Not Disclosed' }}</text></div></div>
            <div class="col-md-4 col-sm-4 col-xs-12"><div><span class=""><img class="me-2 image-size" src="{{ url('site_assets_1/assets/img/side_nav_icon/location.png') }}"></span><text class=""> {{ rtrim($job->work_locations, ", ") }}</text></div></div>
        </div>
        <div class="mb-2">
            <h5 class="text-green-color fw-bold">Job Description </h5>
            <ul class="preview_job">
                {!! $job->description !!}
            </ul>
        </div>
        <div class="d-flex mt-3 justify-content-between">
            <div><text><i class="jpaicon bi-clock-history"></i> {{ \Carbon\Carbon::parse($savedjob->created_at)->diffForHumans() }}</text> </div>
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
                <div class="px-2 favjob" data-slug="{{ $job->slug }}">    
                    <img class="image-size1 cursor-pointer" src="{{url('site_assets_1/assets/img/star_filled.png')}}" alt="bookmark">
                </div>
            </div>
        </div>
    </div>
</div>
@empty
<div class="d-flex justify-content-center mt-5">
    <div class="">
        <div class="text-center mb-4">
            <img class="janoimg" src="{{ url('site_assets_1/assets/img/no_results.svg') }}" rel="nofollow">
        </div>
        <div class="text-center">
            <h4>No Jobs found </h4>
            <a href="{{ url('/') }}" class="btn btnc1 mt-4">
                Find Jobs
            </a>
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
      aTag.href = '{{ url("job-detail") }}/'+$(this).data("jobid");
      aTag.click();
  });
      
  $('.favjob').click(function(e) {
    e.stopPropagation();
    // alert(jobidv)
    btn = $(this);
    jobUnsave(btn);
  });
</script>



