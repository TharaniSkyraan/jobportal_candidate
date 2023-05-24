<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\WebServiceController;
use App\Http\Controllers\AjaxController;

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

Route::post('login', [RegisterController::class, 'login']);
Route::post('forget_password', [RegisterController::class, 'forgetPassword']);
Route::post('register', [RegisterController::class, 'register']);
Route::post('resent_otp', [RegisterController::class, 'resentOtp']);
Route::post('verify_otp', [RegisterController::class, 'verifyOTP']);
Route::post('education_types', [AjaxController::class,'suggestionEducationTypes']);
Route::post('cities', [AjaxController::class,'getCities']);
Route::post('countries', [AjaxController::class,'getCountries']);
Route::post('designations', [AjaxController::class, 'getDesignation']);
Route::post('skill_list', [AjaxController::class, 'GetSkills']);

Route::middleware('auth:api')->group( function () {
  Route::get('education', [RegisterController::class, 'education']);
  Route::post('education_save', [RegisterController::class, 'educationSave']);
  Route::get('experience', [RegisterController::class, 'experience']);
  Route::post('experience_save', [RegisterController::class, 'experienceSave']);
  Route::get('career_info', [RegisterController::class, 'careerInfo']);
  Route::post('career_info_save', [RegisterController::class, 'careerInfoSave']);
  Route::get('skill', [RegisterController::class, 'skill']);
  Route::post('skill_save', [RegisterController::class, 'skillSave']);
  Route::post('upload_resume', [RegisterController::class, 'uploadResume']);
});
