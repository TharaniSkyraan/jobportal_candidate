<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{url('/sitemapstaticpages.xml')}}</loc>
        <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{url('/sitemapjobslug.xml')}}</loc>
        <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{url('/sitemapjobtitle.xml')}}</loc>
        <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{url('/sitemapjoblocation.xml')}}</loc>
        <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{url('/sitemapjobtype.xml')}}</loc>
        <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
</sitemapindex>

