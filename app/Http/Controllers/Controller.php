<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

define('SUCCESS', 200);
define('INACTIVEUSER', 403);
define('UNAUTHORIZED', 401);

class Controller extends BaseController
{

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    /**
     * 
     *  Generate Random user token
     * 
     */
    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * 
     *  Generate Random user token
     * 
     */
    public function generateRandomCode($length = 10) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    /**
     * 
     *  setLocale
     * 
     */
    public function setLocale(Request $request)
    {
        $locale = $request->input('locale');
        $return_url = $request->input('return_url');
        $is_rtl = $request->input('is_rtl');
        $localeDir = ((bool) $is_rtl) ? 'rtl' : 'ltr';

        session(['locale' => $locale]);
        session(['localeDir' => $localeDir]);

        return Redirect::to($return_url);
    }
	
    /**
     * 
     *  checkTime
     * 
     */
	public function checkTime()

    {
        $siteSetting = SiteSetting::findOrFail(1272);
        $t1 = strtotime( date('Y-m-d h:i:s'));
        $t2 = strtotime( $siteSetting->check_time );
        $diff = $t1 - $t2;
        $hours = $diff / ( 60 * 60 );
        if($hours>=1){
            $siteSetting->check_time = date('Y-m-d h:i:s');
            $siteSetting->update();
            Artisan::call('schedule:run');
            echo 'done';
        }else{
            echo 'not done';
        }

    }
	

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result='', $message='Success')
    {
    	$response = [
            'success' => true,
            'message' => $message,
            'data' => !empty($result)?$result:array()
        ];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
            'data' => !empty($errorMessages)?$errorMessages:array()
        ];

        return response()->json($response, $code);
    }
}
