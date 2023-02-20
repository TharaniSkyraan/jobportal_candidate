<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{url('/sitemapjobtitle')}}</loc>
        <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
        <loc>{{url('/sitemapjoblocation')}}</loc>
        <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
        <loc>{{url('/sitemapjobtitlelocation')}}</loc>
        <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
        <loc>{{url('/sitemapjobtype')}}</loc>
        <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
        <loc>{{url('/sitemapjobtypelocation')}}</loc>
        <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
        <loc>{{url('/sitemapjobtypetitle')}}</loc>
        <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
        <loc>{{url('/sitemapjobtypetitlelocation')}}</loc>
        <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
        <loc>{{url('/sitemapjobslug')}}</loc>
        <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
        <loc>{{url('/sitemapstaticpages')}}</loc>
        <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
</sitemapindex>

