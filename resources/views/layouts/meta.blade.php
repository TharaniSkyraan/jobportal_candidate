
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
    
    @if($seo->page_title=='job_detail') 
        @php
            $result['@context']="http://schema.org/";
            $result['@type']="JobPosting";
            $result['title']=$job->title;
            $result['description']=$job->description;
            $result['datePosted'] = $job->posted_date;
            $result['validThrough'] = $job->expiry_date;
            $result['employmentType']='['.rtrim($jtyv, ", ").']';
            $result['skills']=$skillarr;
            $result['hiringOrganization']['@type']="Organization";
            $result['hiringOrganization']['name']=$job->company->name;
            if(!empty($job->company->profile_file_path))
            {
                $result['hiringOrganization']['logo']=$job->company->profile_file_path;
            }
            if(!empty($job->company->website_url))
            {
                $result['hiringOrganization']['sameAs']=$job->company->website_url;
            }
            $result['jobLocationType'] = "TELECOMMUTE";
            $result['applicantLocationRequirements']['@type'] = "Country";
            $result['applicantLocationRequirements']['name'] = "India";
            if(!empty($job->salary_from)&&!empty($job->salary_to)){
                $result['baseSalary']['@type'] = "MonetaryAmount";
                $result['baseSalary']['currency'] = $job->countrydetail->code??'INR';
                $result['baseSalary']['value']['@type'] = "QuantitativeValue";
                $result['baseSalary']['value']['minValue'] = $job->salary_from;
                $result['baseSalary']['value']['maxValue'] = $job->salary_to;
                $result['baseSalary']['value']['unitText'] = (isset($job->salaryPeriod->salary_period)?strtoupper(str_replace('ly','',$job->salaryPeriod->salary_period)):'MONTH');
            }       
            
            $result = json_encode($result);
        @endphp    
        <script type="application/ld+json">
            @php print_r($result); @endphp
        </script>
    @endif
    <meta name="robots" content="index, nofollow">  
    <meta name="google-site-verification" content="BzvgVIU65gOXHATWh24LSGse9TnNKNm57QaGkhrmpQs"/>
@endif

<!-- Twitter Meta Tags -->
{{-- <meta name="twitter:card" content="">
<meta property="twitter:domain" content="">
<meta property="twitter:url" content="">
<meta name="twitter:title" content="">
<meta name="twitter:description" content="">
<meta name="twitter:image" content=""> --}}