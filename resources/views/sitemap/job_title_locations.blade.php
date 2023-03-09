<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($locations as $location)  
        @php
            $designation = $job->designation;
            $title = $job->title;
            $job_location = $location->id;
            $title = \App\Model\Job::whereHas('jobWorkLocation', function($q1) use ($job_location){
                        $q1->whereCityId($job_location);
                    })->whereTitle($title)
                      ->whereIsActive(1)
                      ->count();
        @endphp   
        @if($title!=0)  
            <url>
                <loc>{{ url('/') }}/{{$designation}}-jobs-in-{{$location->city_slug}}</loc>
                <lastmod>{{ $location->created_at->tz('UTC')->toAtomString() }}</lastmod>
                <changefreq>daily</changefreq>
                <priority>0.8</priority>
            </url>
        @endif
    @endforeach
</urlset>