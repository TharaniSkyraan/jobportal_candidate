<?php

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\User\UserController;

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
        
        Route::get('profile', [UserController::class, 'profile']);
        Route::get('educations', [UserController::class, 'educations']);
        Route::get('experiences', [UserController::class, 'experiences']);
        Route::get('projects', [UserController::class, 'projects']);
        Route::get('skills', [UserController::class, 'skills']);
        Route::get('languages', [UserController::class, 'languages']);
        Route::get('career_info', [UserController::class, 'career_info']);

        Route::get('profile_update', [UserController::class, 'profileUpdate']);
        Route::get('educations_update', [UserController::class, 'educationsUpdate']);
        Route::get('experiences_update', [UserController::class, 'experiencesUpdate']);
        Route::get('projects_update', [UserController::class, 'projectsUpdate']);
        Route::get('skills_update', [UserController::class, 'skillsUpdate']);
        Route::get('languages_update', [UserController::class, 'languagesUpdate']);
        Route::get('career_info_update', [UserController::class, 'career_infoUpdate']);
    
    });

});
  
?>