<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($titles as $title) 
        @foreach ($types as $type)  
        <sitemap> 
            <loc>{{ route('sitemapjobtypetitlelocation', [$title->designation,$type->id]) }}</loc>
            <lastmod>{{ $type->created_at->tz('UTC')->toAtomString() }}</lastmod>
        </sitemap>
        @endforeach
    @endforeach
</urlset>