<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
@foreach ($titles as $title)  
    <sitemap>
        <loc>{{ route('sitemapjobtitlelocation',$title->designation) }}</loc>
        <lastmod>{{ $title->created_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </sitemap>  
@endforeach