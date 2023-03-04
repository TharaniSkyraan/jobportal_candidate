<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($titles as $title) 
        @foreach($title->jobtypes as $type)  
        <sitemap> 
            <loc>{{ route('sitemapjobtypetitlelocation', [$title->designation,$type->type_id]) }}</loc>
            <lastmod>{{ $type->created_at->tz('UTC')->toAtomString() }}</lastmod>
        </sitemap>
        @endforeach
    @endforeach
</sitemapindex>