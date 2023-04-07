<?php

namespace App\Traits;

use View;
use App\Model\Seo;

trait ShareToLayout
{

    public function shareSeoToLayout($page,$d=null,$l=null,$cn=null)
    {
        $seo = SEO::where('seo.page_title', 'like', $page)->first();
        if($page=='job_search')
        {
            $tt = !empty($l)? ($d.' '.$l) : $d;
            $tt = ucwords($tt);
            $seo->seo_title = $tt .' Jobs and Vacancies - '.date("d F Y").' | Mugaam.com';
            $seo->seo_description = $tt .' Jobs and Vacancies - '.date("d F Y").' on Mugaam.com';
        }  
        if($page=='job_detail')
        {
            $ttset = $d .' - '. $cn .' - '. $l ;
            $seo->seo_title = $ttset . ' | Mugaam.com';
            $seo->seo_description = 'Job Description for '.$d.' in '.$cn.' in '.$l.'. Apply Now!';
        }
        view()->share('seo',$seo);
    }

}
