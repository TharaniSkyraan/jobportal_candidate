<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($titles as $title)     
        @php
            $job_title = $title->title;
            $type = \App\Model\JobType::whereHas('job', function($q) use ($job_title){
                    $q->whereTitle($job_title)->whereIsActive(1);
                })->where('type_id',$id)->count();
        @endphp   
        @if($type!=0)
            <url>
                <loc>{{ url('/') }}/{{$title->designation}}-jobs?jobtypeFGid={{$id}}</loc>
                <lastmod>{{ $title->created_at->tz('UTC')->toAtomString() }}</lastmod>
                <changefreq>daily</changefreq>
                <priority>0.8</priority>
            </url>
        @endif
    @endforeach
</urlset>