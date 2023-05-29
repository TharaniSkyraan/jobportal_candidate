<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
  

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */


 $real_path = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'api_routes' . DIRECTORY_SEPARATOR;

 include_once($real_path . 'api_auth.php');

 include_once($real_path . 'auth_user.php');
 
 include_once($real_path . 'attributes.php');
 
 include_once($real_path . 'job.php');


