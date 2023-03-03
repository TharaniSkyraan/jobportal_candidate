<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>            
        <url>
            <loc>{{url('/sitemapstaticpages.xml')}}</loc>
            <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
        </url>            
        <url>
            <loc>{{url('/sitemapjobslug.xml')}}</loc>
            <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
        </url>            
        <url>
            <loc>{{url('/sitemapjobtitle.xml')}}</loc>
            <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
        </url>            
        <url>
            <loc>{{url('/sitemapjoblocation.xml')}}</loc>
            <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
        </url>            
        <url>
            <loc>{{url('/sitemapjobtitlelocation.xml')}}</loc>
            <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
        </url>            
        <url>
            <loc>{{url('/sitemapjobtype.xml')}}</loc>
            <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
        </url>            
        <url>
            <loc>{{url('/sitemapjobtypelocation.xml')}}</loc>
            <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
        </url>            
        <url>
            <loc>{{url('/sitemapjobtypetitle.xml')}}</loc>
            <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
        </url>            
        <url>
            <loc>{{url('/sitemapjobtypetitlelocation.xml')}}</loc>
            <lastmod>{{ Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
        </url>
    </sitemap>
</sitemapindex>

