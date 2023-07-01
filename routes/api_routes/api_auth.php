<?php

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\User\UserController;

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
    Route::get('skill', [RegisterController::class, 'skills']);
    Route::post('skill_save', [RegisterController::class, 'skillSave']);
    Route::post('upload_resume', [RegisterController::class, 'uploadResume']);
    
    Route::prefix('user')->group(function () {
        
        Route::get('profile/{json}', [UserController::class, 'myProfile']);
        Route::get('educations/{json}', [UserController::class, 'educations']);
        Route::get('experiences/{json}', [UserController::class, 'experiences']);
        Route::get('projects/{json}', [UserController::class, 'projects']);
        Route::get('skills/{json}', [UserController::class, 'skills']);
        Route::get('languages/{json}', [UserController::class, 'languages']);
        Route::get('career_info/{json}', [UserController::class, 'career_info']);

        Route::get('profile_update/{json}', [UserController::class, 'profileUpdate']);
        Route::get('educations_update/{json}', [UserController::class, 'educationsUpdate']);
        Route::get('experiences_update/{json}', [UserController::class, 'experiencesUpdate']);
        Route::get('projects_update/{json}', [UserController::class, 'projectsUpdate']);
        Route::get('skills_update/{json}', [UserController::class, 'skillsUpdate']);
        Route::get('languages_update/{json}', [UserController::class, 'languagesUpdate']);
        Route::get('career_info_update/{json}', [UserController::class, 'career_infoUpdate']);
    
    });

});
  
?>