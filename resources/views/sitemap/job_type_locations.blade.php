<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($locations as $location)  
        @php
            $job_location = $location->id;
            $type = \App\Model\JobType::whereHas('job', function($q) use ($job_location){
                    $q->whereHas('jobWorkLocation', function($q1) use ($job_location){
                        $q1->whereCityId($job_location);
                    });
                })->where('type_id',$id)->count();
        @endphp   
        @if($type!=0)      
            <url>
                <loc>{{ url('/') }}/jobs-in-{{$location->city_slug}}?jobtypeFGid={{$id}}</loc>
                <lastmod>{{ $location->created_at->tz('UTC')->toAtomString() }}</lastmod>
                <changefreq>daily</changefreq>
                <priority>0.8</priority>
            </url>
        @endif
    @endforeach
</urlset>