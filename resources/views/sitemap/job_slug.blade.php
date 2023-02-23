<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        @foreach ($jobs as $job)  
            <loc>{{ url('/detail') }}/{{$job->job->slug}}</loc>
            <lastmod>{{ $job->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>always</changefreq>
            <priority>1.0</priority>
        @endforeach
    </url>
</urlset>