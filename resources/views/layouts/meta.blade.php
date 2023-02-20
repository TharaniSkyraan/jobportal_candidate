
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />        
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@if(isset($seo))
    <title>{{ $seo->seo_title ?? ''}}</title>
    <meta name="title" content="{{ $seo->seo_title ?? ''}}">
    <meta name="description" content="{{ $seo->seo_description ?? ''}}"/>
    @if(!empty($seo->seo_keywords))
    <meta name="keywords" content="{{ $seo->seo_keywords }}">
    @endif   
    <meta name="robots" content="index, nofollow">  
    <link rel="canonical" href="{{ Request::url() ?? 'https://www.mugaam.com/'}}"/>
    @if($seo->page_title=='job_serach') 
    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="{{ Request::url() ?? 'https://www.mugaam.com/'}}">
    <meta property="og:type" content="">
    <meta property="og:title" content="{ $seo->seo_title ?? ''}}">
    <meta property="og:description" content="{{ $seo->seo_description ?? ''}}">
    <meta property="og:image" content="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}">
    <meta property="og:locale" content="en_US"/> 
    @endif
@endif

<meta name="google-site-verification" content="BzvgVIU65gOXHATWh24LSGse9TnNKNm57QaGkhrmpQs"/>


<!-- Twitter Meta Tags -->
{{-- <meta name="twitter:card" content="">
<meta property="twitter:domain" content="">
<meta property="twitter:url" content="">
<meta name="twitter:title" content="">
<meta name="twitter:description" content="">
<meta name="twitter:image" content=""> --}}