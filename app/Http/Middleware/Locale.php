<?php

namespace App\Http\Middleware;

use App\Traits\GeoIPService;
use Closure, Session, View;
use Auth;
use Cookie;

class Locale
{

    use GeoIPService;
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

        if(Session::has('ip_config')==false)
        {
            // $ip = $request->ip();
            $ip = '183.82.250.192';

            $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip??'183.82.250.192'));    
       
            if($ip_data == null || $ip_data->geoplugin_countryName == null)
            {
                $ipData = $this->getCity($ip??'183.82.250.192');
            }else{
              
                $ipData = array(
                    'geoplugin_city' => $ip_data->geoplugin_city??'',
                    'geoplugin_regionName' => $ip_data->geoplugin_regionName??'',
                    'geoplugin_regionCode' => $ip_data->geoplugin_regionCode??'',
                    'geoplugin_countryName' => $ip_data->geoplugin_countryName??'',
                    'geoplugin_countryCode' => $ip_data->geoplugin_countryCode??'',
                    'geoplugin_postalcode' => '',
                    'geoplugin_latitude' => $ip_data->geoplugin_latitude??'',
                    'geoplugin_longitude' => $ip_data->geoplugin_longitude??''
                );
               
            }

            if($ipData && $ipData['geoplugin_countryName'] != null)
            {
                $city = \App\Model\City::where('city',$ipData['geoplugin_city'])
                                        ->where('is_default', '=', 1)
                                        ->first();
                
                $ipData['ip']         = $ip;
                $ipData['city_id']    = $city->id??'';
                $ipData['state_id']   = $city->state_id??'';
                $ipData['country_id'] = $city->state->country_id??'';

                $ipData['city']       = $city->city??'';
                $ipData['state']      = $city->state->state??'';
                $ipData['country']    = $city->country->country??'';
                
                view()->share('ip_data',$ipData);
                session(['ip_config' => $ipData]);
            }

        }else
        {
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
