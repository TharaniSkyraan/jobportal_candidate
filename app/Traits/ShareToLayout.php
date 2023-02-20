<?php

namespace App\Traits;

use View;
use App\Model\Seo;

trait ShareToLayout
{

    public function shareSeoToLayout($page,$d=null,$l=null)
    {
        $seo = SEO::where('seo.page_title', 'like', $page)->first();
        if($page=='job_search')
        {
            
            $tt = !empty($l)? ($d.' '.$l) : $d;
            $tt = ucwords($tt);
            $seo->seo_title = $tt .' Jobs and Vacancies - '.date("n F Y").' | Mugaam.com';
            $seo->seo_description = $tt .' Jobs and Vacancies - '.date("n F Y").' on Mugaam.com';
    
        }  
        view()->share('seo',$seo);
    }

}
