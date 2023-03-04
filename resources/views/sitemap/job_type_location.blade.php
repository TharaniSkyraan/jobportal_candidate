<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    @foreach ($types as $type)  
    <sitemap>  
        <loc>{{ route('sitemapjobtypelocation', $type->id) }}</loc>
        <lastmod>{{ $type->created_at->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
    @endforeach
</urlset>