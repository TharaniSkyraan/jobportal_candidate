<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($titles as $title) 
        @php $job_title = $title->title;
             $types = \App\Model\JobType::whereHas('job', function($q) use ($job_title){
                $q->whereTitle($job_title)->whereNotNull('location')->whereIsActive(1);
             })->groupBy('type_id')->pluck('type_id')->toArray();
        @endphp
        @if(count($types) !=0)
            @foreach($types as $type)  
            <sitemap> 
                <loc>{{ route('sitemapjobtypetitlelocation', [$title->jkey,$type]) }}</loc>
                <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
            </sitemap>
            @endforeach
        @endif
    @endforeach
</sitemapindex>