<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Auth;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {

        $route = $request->route();

        if($route != null){

            $prefix = $route->getPrefix()??'';
        
            if ($request->expectsJson() && str_contains($prefix, 'api')) {

                $uri_params = explode('/',$route->uri());
                $uri_last_param = end($uri_params);
                
                if(Auth::user()==null) {

                    if($uri_last_param=='profile'){
                        $response = ['success' => false, 'message' => 'Unauthorization', 'data'=>[['user'=>[],'genders'=>[],'maritalStatuses'=>[]]]];

                    }else{
                        $response = ['success' => false, 'message' => 'Unauthorization', 'data'=>[]];
                    }
                    return response()->json($response, 200);
                }else{
                    $response = ['success' => false, 'message' => 'Something went wrong, Try Again.', 'data'=>[]];
                    return response()->json($response, 403);
                }
    
            }
        }

        return parent::render($request, $exception);
    }
}
