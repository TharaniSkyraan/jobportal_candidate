<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
    @foreach ($titles as $title)  
        @foreach ($types as $type)  
            <loc>{{ url('/sitemapjobtypetitlelocation') }}/{{$title->designation}}/{{$type->id}}</loc>
            <lastmod>{{ $type->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        @endforeach
    @endforeach
    </url>
</urlset>