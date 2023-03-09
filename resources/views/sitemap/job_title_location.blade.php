<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($titles as $title)  
        <sitemap> 
            <loc>{{ route('sitemapjobtitlelocation',$title->jkey) }}</loc>
            <lastmod>{{ $title->created_at->tz('UTC')->toAtomString() }}</lastmod>
        </sitemap>  
    @endforeach
</sitemapindex>
