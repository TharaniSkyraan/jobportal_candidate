<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        @foreach ($locations as $location)  
            <loc>{{ url('/') }}/{{$designation}}-jobs-in-{{$location->city_slug}}</loc>
            <lastmod>{{ $location->update_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        @endforeach
    </url>
</urlset>