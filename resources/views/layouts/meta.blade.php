@if(isset($seo))
    <meta name="title" content="{{ $seo->seo_title ?? ''}}">
    <meta name="description" content="{{ $seo->seo_description ?? ''}}"/>
    <link rel="canonical" href="{{ Request::url() ?? 'https://www.mugaam.com/'}}"/>
    @if(!empty($seo->seo_keywords))
    <meta name="keywords" content="{{ $seo->seo_keywords }}">
    <title>{{ $seo->seo_title ?? ''}}</title>
    @endif      
@endif
<meta name="google-site-verification" content="BzvgVIU65gOXHATWh24LSGse9TnNKNm57QaGkhrmpQs"/>