<?php

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\User\ProfileController;

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
        
        Route::get('profile', [ProfileController::class, 'profile']);
        Route::get('educations', [ProfileController::class, 'educations']);
        Route::get('experiences', [ProfileController::class, 'experiences']);
        Route::get('projects', [ProfileController::class, 'projects']);
        Route::get('skills', [ProfileController::class, 'skills']);
        Route::get('languages', [ProfileController::class, 'languages']);
        Route::get('career_info', [ProfileController::class, 'career_info']);

        Route::get('profile_update', [ProfileController::class, 'profileUpdate']);
        Route::get('educations_update', [ProfileController::class, 'educationsUpdate']);
        Route::get('experiences_update', [ProfileController::class, 'experiencesUpdate']);
        Route::get('projects_update', [ProfileController::class, 'projectsUpdate']);
        Route::get('skills_update', [ProfileController::class, 'skillsUpdate']);
        Route::get('languages_update', [ProfileController::class, 'languagesUpdate']);
        Route::get('career_info_update', [ProfileController::class, 'career_infoUpdate']);
    });

});
  
?>