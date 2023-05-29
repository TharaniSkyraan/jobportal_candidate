<?php

use App\Http\Controllers\Api\Auth\RegisterController;

Route::post('login', [RegisterController::class, 'login']);
Route::post('forget_password', [RegisterController::class, 'forgetPassword']);
Route::post('register', [RegisterController::class, 'register']);
Route::post('resent_otp', [RegisterController::class, 'resentOtp']);
Route::post('verify_otp', [RegisterController::class, 'verifyOTP']);

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
  
?>