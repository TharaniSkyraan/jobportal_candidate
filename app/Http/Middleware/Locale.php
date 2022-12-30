<?php

namespace App\Http\Middleware;

use Closure, Session, View;
use Auth;
use Cookie;

class Locale
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        
        if(Session::has('ip_config')==false){
            $client  = @$_SERVER['HTTP_CLIENT_IP'];
            $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
            $remote  = @$_SERVER['REMOTE_ADDR'];
            $result  = array('country'=>'', 'city'=>'');
            if(filter_var($client, FILTER_VALIDATE_IP)){
                $ip = $client;
            }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
                $ip = $forward;
            }else{
                $ip = $remote;
            }
            $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));    
            dd($ip_data);
            if($ip_data && $ip_data->geoplugin_countryName != null){
                
                // $country = $ip_data->geoplugin_countryName;
                // $state = $ip_data->geoplugin_regionName;
                // $city = $ip_data->geoplugin_city;
                $city = \App\Model\City::where('city',$ip_data->geoplugin_city)->where('is_default', '=', 1)->first();
                $ip_data->city_id = $city->id??'';
                $ip_data->state_id = $city->state_id??'';
                $ip_data->country_id = $city->state->country_id??'';
                view()->share('ip_data',$ip_data);
            }else{
                $city = \App\Model\City::where('id',131618)->first();
                $city->geoplugin_city = 'Coimbatore';
                $city->geoplugin_regionName = 'Tamil Nadu';
                $city->geoplugin_countryName = 'India';
                $city->geoplugin_countryCode = 'IN';
                view()->share('ip_data',$city);
            }
            session(['ip_config' => $city]);
        }else{
            view()->share('ip_data',Session::get('ip_config'));
        }

        if (Session::has('locale')) {
            app()->setLocale(Session::get('locale'));
        }
		else
		{            
			if (null !== $lang = \App\Model\Language::where('is_default', '=', 1)->first()) {
				if ($lang !== null) {
					app()->setLocale($lang->iso_code);
					if((bool) $lang->is_rtl){					
						session(['localeDir' => 'rtl']);
					}else{
						session(['localeDir' => 'ltr']);
					}		
				}
        	}			
		}

        if(Auth::check() || Auth::check()){
            Cookie::queue('is_login', 1, 120);
        }else{
            Cookie::queue('is_login', 0, 120);
        }
        return $next($request);
    }

}
