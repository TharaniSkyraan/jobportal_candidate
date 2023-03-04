<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($types as $type)  
        <sitemap>
            <loc>{{ route('sitemapjobtypetitle', $type->id) }}</loc>
            <lastmod>{{ $type->created_at->tz('UTC')->toAtomString() }}</lastmod>
        </sitemap>
    @endforeach
</sitemapindex>