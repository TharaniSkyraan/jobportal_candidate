<?php

namespace App\Helpers;

use Request;

class RegexHelper
{

    public static function DescTrim($content=''){

        if(!empty($content)){
            $content = trim($content);
            $content = preg_replace('/\r/', ' ', $content );
            $content = preg_replace('/\n/', ' ', $content );
            $content = preg_replace('/\t/', ' ', $content );
            $content = preg_replace('/\s\s+/', ' ', $content );
            $content = trim($content);
        }
        
        return $content;
    }

}