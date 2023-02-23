<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        @foreach ($titles as $title)  
            <loc>{{ url('/sitemapjobtitlelocation') }}/{{$title->designation}}</loc>
            <lastmod>{{ $title->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        @endforeach
    </url>
</urlset>