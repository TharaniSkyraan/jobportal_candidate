@if(isset($seo))
    <meta name="title" content="{{ $seo->seo_title ?? ''}}">
    <meta name="description" content="{{ $seo->seo_description ?? ''}}"/>
    <link rel="canonical" href="{{ Request::url() ?? 'https://www.mugaam.com/'}}"/>
    @if(!empty($seo->seo_keywords))
        <meta name="keywords" content="{{ $seo->seo_keywords }}">
        <title>{{ $seo->seo_title ?? ''}}</title>
    @endif      
@endif
<!-- Facebook Meta Tags -->
<!-- <meta property="og:url" content="">
<meta property="og:type" content="">
<meta property="og:title" content="">
<meta property="og:description" content="">
<meta property="og:image" content="">
<meta property="og:locale" content="en_US"/> -->

<!-- Twitter Meta Tags -->
<!-- <meta name="twitter:card" content="">
<meta property="twitter:domain" content="">
<meta property="twitter:url" content="">
<meta name="twitter:title" content="">
<meta name="twitter:description" content="">
<meta name="twitter:image" content=""> -->