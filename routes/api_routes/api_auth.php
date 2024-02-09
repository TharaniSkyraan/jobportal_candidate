<?php

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\User\UserController;

Route::post('login', [RegisterController::class, 'login']);
Route::post('forget_password', [RegisterController::class, 'forgetPassword']);
Route::post('register', [RegisterController::class, 'register']);
Route::post('resent_otp', [RegisterController::class, 'resentOtp']);
Route::post('verify_otp', [RegisterController::class, 'verifyOTP']);
Route::get('profile_summary/{id}', [UserController::class, 'profileSummary']);

Route::middleware('auth:api')->group( function () {

    Route::get('logout', [RegisterController::class, 'logout']);
    Route::get('delete_account', [RegisterController::class, 'deleteAccount']);
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
        Route::get('about', [UserController::class, 'about']);
        Route::get('educations', [UserController::class, 'educations']);
        Route::get('experiences', [UserController::class, 'experiences']);
        Route::get('projects', [UserController::class, 'projects']);
        Route::get('skills', [UserController::class, 'skills']);
        Route::get('languages', [UserController::class, 'languages']);
        Route::get('cvs', [UserController::class, 'cvs']);
        Route::get('career_info', [UserController::class, 'career_info']);

        Route::post('profile_update', [UserController::class, 'profileUpdate']);
        Route::post('educations_update', [UserController::class, 'educationsUpdate']);
        Route::post('experiences_update', [UserController::class, 'experiencesUpdate']);
        Route::post('projects_update', [UserController::class, 'projectsUpdate']);
        Route::post('skills_update', [UserController::class, 'skillsUpdate']);
        Route::post('languages_update', [UserController::class, 'languagesUpdate']);
        Route::post('cvs_update', [UserController::class, 'cvsUpdate']);
        Route::post('career_info_update', [UserController::class, 'career_infoUpdate']);
        Route::post('about_update', [UserController::class, 'aboutUpdate']);
    
        Route::post('educations_delete', [UserController::class, 'deleteUserEducation']);
        Route::post('experiences_delete', [UserController::class, 'deleteUserExperience']);
        Route::post('projects_delete', [UserController::class, 'deleteUserProject']);
        Route::post('skills_delete', [UserController::class, 'deleteUserSkill']);
        Route::post('languages_delete', [UserController::class, 'deleteUserLanguage']);
        Route::post('cvs_delete', [UserController::class, 'deleteUserCv']);

        Route::post('educations_undo', [UserController::class, 'undoUserEducation']);
        Route::post('experiences_undo', [UserController::class, 'undoUserExperience']);
        Route::post('projects_undo', [UserController::class, 'undoUserProject']);
        Route::post('skills_undo', [UserController::class, 'undoUserSkill']);
        Route::post('languages_undo', [UserController::class, 'undoUserLanguage']);
        Route::get('cvs_download/{id}', [UserController::class, 'downloadCv']);
        Route::get('cvs_primary/{id}', [UserController::class, 'makeDefaultCv']);

    
    });

});
  
?>