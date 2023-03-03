<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($locations as $location)   
        <url>     
            <loc>{{ url('/') }}/{{$designation}}-jobs-in-{{$location->city_slug}}?jobtypeFGid={{$id}}</loc>
            <lastmod>{{ $location->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>