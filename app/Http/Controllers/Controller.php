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
     * 
     */
    function generateCandidate($counter) {
        return 'MUG-' . str_pad($counter, 3, '0', STR_PAD_LEFT);
    }
    /**
     * 
     * 
     */
    function generateMessageContactId($counter) {
        return 'MSG-' . str_pad($counter, 3, '0', STR_PAD_LEFT);
    }

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
	public function cvgen()

    {
      $cvs = \App\Model\UserCv::where('pdf_file','')->get();
      foreach($cvs as $cv){
        $UserCv =  \App\Model\UserCv::find($cv->id);
        if(!empty($cv->user->token)){
                
            $url = $cv->cv_file;
            $path = $cv->path;
            $fileExt = pathinfo($url, PATHINFO_EXTENSION);
            
            if($fileExt=='pdf'){
                $UserCv->pdf_path = $path??'';
                $UserCv->pdf_file = $url??'';
            }else{
                $localFilePath = \App\Helpers\DataArrayHelper::convertionext($url);
                if($localFilePath['real_path']!=''){                    
                    $pdf_path = "candidate/".$cv->user->token."/file/".time().'.pdf';
                    \Storage::disk('s3')->put($pdf_path, file_get_contents($localFilePath['real_path']));
                    $pdf_url = \Storage::disk('s3')->url($pdf_path);  
                    $UserCv->pdf_path = $pdf_path??'';
                    $UserCv->pdf_file = $pdf_url??'';
                    unlink(public_path($localFilePath['path']));  
                }  
            }
            $UserCv->save();

        }

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
