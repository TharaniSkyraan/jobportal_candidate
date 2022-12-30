<?php

namespace App\Helpers;

use Request;

class MiscHelper
{

    public static function getLangQueryStr()
    {
        $queryString = '?lang=';
        if (!empty(Request::getQueryString())) {
            parse_str(Request::getQueryString(), $queryStringArray);
            if (Request::has('lang'))
                unset($queryStringArray['lang']);
            $queryString = http_build_query($queryStringArray);
            $queryString = (empty($queryString)) ? '?lang=' : '?' . $queryString . '&lang=';
        }
        return $queryString;
    }

    public static function getLang($lang = '')
    {
        if (Request::has('lang')) :
            $lang = Request::query('lang');
        endif;
        return ($lang != '') ? $lang : config('default_lang');
    }

    public static function getLangDirection($lang = '')
    {
        $lang = ($lang != '') ? $lang : config('default_lang');
        $arr = \App\Model\Language::select('languages.iso_code')->where('is_rtl', '=', 1)->active()->pluck('languages.iso_code')->toArray(); //array('ar', 'az', 'dv', 'he', 'ku', 'fa', 'ur');
        $direction = 'ltr';
        if (Request::has('lang') && in_array(Request::query('lang'), $arr)):
            $direction = 'rtl';
        elseif (in_array($lang, $arr)):
            $direction = 'rtl';
        endif;
        return $direction;
    }

    public static function getNumOffices()
    {
        $array = ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20'];
        return $array;
    }

    public static function getNumPositions()
    {
        $array = ['0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30'];
        return $array;
    }

    public static function getNumEmployees()
    {
        $array = ['1-10' => '1-10', '11-50' => '11-50', '51-100' => '51-100', '101-200' => '101-200', '201-300' => '201-300', '301-600' => '301-600', '601-1000' => '601-1000', '1001-1500' => '1001-1500', '1501-2000' => '1501-2000', '2001-2500' => '2001-2500', '2501-3000' => '2501-3000', '3001-3500' => '3001-3500', '3501-4000' => '3501-4000', '4001-4500' => '4001-4500', '4501-5000' => '4501-5000', '5000+' => '5000+'];
        return $array;
    }

    public static function getNumExpYears()
    {
        $array = ['0' => 'Years', '1' => '1 year', '2' => '2 years', '3' => '3 years', '4' => '4 years', '5' => '5 years', '6' => '6 years', '7' => '7 years', '8' => '8 years', '9' => '9 years', '10' => '10 years', '11' => '11 years', '12' => '12 years', '13' => '13 years', '14' => '14 years', '15' => '15 years', '16' => '16 years', '17' => '17 years', '18' => '18 years', '19' => '19 years', '20' => '20 years', '21' => '21 years', '22' => '22 years', '23' => '23 years', '24' => '24 years', '25' => '25 years', '26' => '26 years', '27' => '27 years', '28' => '28 years', '29' => '29 years', '30' => '30 years'];
        return $array;
    }

    public static function getNumExpMonths()
    {
        $array = ['0' => 'Months', '1' => '1 month', '2' => '2 months', '3' => '3 months', '4' => '4 months', '5' => '5 months', '6' => '6 months', '7' => '7 months', '8' => '8 months', '9' => '9 months', '10' => '10 months', '11' => '11 months'];
        return $array;
    }

    public static function getEstablishedIn()
    {
        $array = array();
        for ($counter = date('Y'); $counter > 1917; $counter--) {
            $array[$counter] = $counter;
        }
        return $array;
    }

    public static function getSalaryDD()
    {
        $array = ['5000' => '5,000', '6000' => '6,000', '7000' => '7,000', '8000' => '8,000', '9000' => '9,000', '10000' => '10,000', '11000' => '11,000', '12000' => '12,000', '13000' => '13,000', '14000' => '14,000', '15000' => '15,000', '16000' => '16,000', '17000' => '17,000', '18000' => '18,000', '19000' => '19,000', '20000' => '20,000', '25000' => '25,000', '30000' => '30,000', '35000' => '35,000', '40000' => '40,000', '45000' => '45,000', '50000' => '50,000', '60000' => '60,000', '70000' => '70,000', '80000' => '80,000', '90000' => '90,000', '100000' => '100,000', '125000' => '125,000', '150000' => '150,000', '175000' => '175,000', '200000' => '200,000', '250000' => '250,000', '300000' => '300,000', '350000' => '350,000', '400000' => '400,000', '450000' => '450,000', '500000' => '500,000', '550000' => '550,000', '600000' => '600,000', '600001' => '600,000+'];
        return $array;
    }

    public static function getCcExpiryYears()
    {
        $array = array();
        for ($counter = date('Y'); $counter < date('Y') + 50; $counter++) {
            $array[$counter] = $counter;
        }
        return $array;
    }

    public static function timeSince_2($date) {
        
        $curr_time = \Carbon\Carbon::now('UTC')->timestamp;
        $date = strtotime($date);
        $sec = abs(($curr_time - ($date)));
        $interval = ($sec/31536000);

        if ($interval > 1) {
            return floor($interval) . " years ago";
        }
        $interval = $sec / 2592000;
        if ($interval > 1) {
            return "30+ days ago";
            //return Math.floor(interval) + " months ago";
        }
        $interval = $sec / 86400;
        if ($interval > 1) {
            return floor($interval). " days ago ";
        }
        $interval = $sec / 3600;
        if ($interval > 1) {
            return floor($interval) . " hours ago";
        }
        $interval = $sec / 60;
        if ($interval > 1) {
            return floor($interval) . " minutes ago";
        }
        return floor($sec) . " seconds ago";

    }

    public static function timeSince($date){
        $res = "30+ days ago";
        $curr_time_sec = \Carbon\Carbon::now('UTC')->timestamp;
        $date_sec = strtotime($date);

        $diff = abs(($curr_time_sec - ($date_sec)));
        
        // Time difference in seconds
        $sec=$diff;
        $min = round($diff / 60 );
        $hrs = round($diff / 3600);
        $days= round($diff / 86400 );
        // Convert time difference in weeks
        // $weeks     = round($diff / 604800);
        // Convert time difference in months
        // $mnths     = round($diff / 2600640 );
        // Convert time difference in years
        // $yrs     = round($diff / 31207680 );
        // Check for seconds
        if($sec < 60) {
            $res="$sec seconds ago";
        }
        else if($min < 60) {
            if($min==1) {
                $res="1 minute ago";
            }
            else {
                $res="$min minutes ago";
            }
        }
        else if($hrs < 24) {
            if($hrs == 1) { 
                $res="1 hour ago";
            }
            else {
                $res="$hrs hours ago";
            }
        }
        else if($days < 31) {
            if($days == 1) {
                $res="1 day ago";
            }
            else {
                $res="$days days ago";
            }
        }
        else {
            $res="30+ days ago";
        }
        
        return $res;
    }
}
