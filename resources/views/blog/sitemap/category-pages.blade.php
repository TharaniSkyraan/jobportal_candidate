<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    @for($i=1; $count >= $i; $i++)
        <url>
            <loc>{{ url('/') }}/blog-sitemap/{{$i}}</loc>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endfor
</urlset>