<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($blog as $row)
        <url>
            <loc>{{ url('/') }}/view-blog/{{$row->id}}/{{ $row->slug }}</loc>
            <lastmod>{{ $row->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>