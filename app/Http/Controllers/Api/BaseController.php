<?php


namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{
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