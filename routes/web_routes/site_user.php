<?php
    Route::get('/redirect_user', 'Auth\LoginController@UserSwitchRedirect')->name('redirect-user');
    Route::any('accountverification', 'Auth\LoginController@accountVerification')->name('accountverification');

    Route::get('/verify_otp', 'Auth\LoginController@verifyOtp')->name('verify_otp');
    Route::post('resent_mail', 'Auth\LoginController@resentMail')->name('resentMail');
    Route::post('verify_signup', 'Auth\LoginController@VerifySignup')->name('verify_signup');

    /** Basic Info */
    Route::get('basic_info', 'Auth\RegisterController@basicInfo')->name('basic_info');
    Route::put('basic_info', 'Auth\RegisterController@basicInfoSave')->name('basic_info_save');

    /** Educations */
    Route::get('education', 'Auth\RegisterController@Education')->name('education');   

    //** Experience */
    Route::get('experience', 'Auth\RegisterController@Experience')->name('experience');  

    /** Skills */
    Route::get('skills', 'Auth\RegisterController@Skills')->name('skills');  
    Route::get('skills_data', 'AjaxController@SkillData')->name('get.skills.data');  

    /**Languages */
    Route::get('languages', 'Auth\RegisterController@Languages')->name('languages');  

    /**Resume Upload */
    Route::any('resumeupdate', 'Auth\RegisterController@ResumeUpdate')->name('resume.update');

    // Complete signup
    Route::get('completed_signup', 'Auth\RegisterController@CompleteSignup')->name('completed_signup');  

    Route::namespace('User')->group(function () {

        /* * ******** user home page ************ */

        Route::get('home', 'UserController@index')->name('home');

        Route::post('profilePercentage', 'UserController@profilePercentage')->name('profile-percentage');

        /** Educations */
        Route::post('get-education-form/{id?}', 'UserController@getFrontUserEducationForm')->name('get.education.form');
        Route::post('store-education/{id?}', 'UserController@storeFrontUserEducation')->name('store.education.form');
        Route::post('show-education/{id?}', 'UserController@showFrontUserEducation')->name('show.education');
        Route::post('get-education-edit-form/{id?}', 'UserController@getFrontUserEducationEditForm')->name('get.education.edit.form');
        Route::put('update-education/{education_id}/{user_id?}', 'UserController@updateFrontUserEducation')->name('update.education');
        Route::delete('delete-education', 'UserController@deleteUserEducation')->name('delete.education');
        Route::post('undo-education', 'UserController@undoUserEducation')->name('undo.education');

        //** Experience */
        Route::post('show-experience/{id?}', 'UserController@showFrontUserExperience')->name('show.experience');
        Route::post('get-experience-form/{id?}', 'UserController@getFrontUserExperienceForm')->name('get.experience.form');
        Route::post('store-experience/{id?}', 'UserController@storeFrontUserExperience')->name('store.experience');
        Route::post('get-experience-edit-form/{id?}', 'UserController@getFrontUserExperienceEditForm')->name('get.experience.edit.form');
        Route::put('update-experience/{profile_experience_id}/{user_id?}', 'UserController@updateFrontUserExperience')->name('update.experience');
        Route::delete('delete-experience', 'UserController@deleteUserExperience')->name('delete.experience');
        Route::post('undo-experience', 'UserController@undoUserExperience')->name('undo.experience');

        /** Skills */
        Route::post('show-skills/{id?}', 'UserController@showUserSkills')->name('show.skills');
        Route::post('get-skill-form/{id?}', 'UserController@getFrontUserSkillForm')->name('get.skill.form');
        Route::post('store-skill/{id?}', 'UserController@storeFrontUserSkill')->name('store.skill');
        Route::post('get-skill-edit-form/{id?}', 'UserController@getFrontUserSkillEditForm')->name('get.skill.edit.form');
        Route::put('update-skill/{skill_id}/{user_id?}', 'UserController@updateFrontUserSkill')->name('update.skill');
        Route::delete('delete-skill', 'UserController@deleteUserSkill')->name('delete.skill');
        Route::post('undo-skill', 'UserController@undoUserSkill')->name('undo.skill');

        /**Languages */
        Route::post('show-languages/{id?}', 'UserController@showUserLanguages')->name('show.languages');
        Route::post('get-language-form/{id?}', 'UserController@getFrontUserLanguageForm')->name('get.languages.form');
        Route::post('store-language/{id?}', 'UserController@storeFrontUserLanguage')->name('store.languages');
        Route::post('get-language-edit-form/{id?}', 'UserController@getFrontUserLanguageEditForm')->name('get.languages.edit.form');
        Route::put('update-language/{language_id}/{user_id?}', 'UserController@updateFrontUserLanguage')->name('update.languages');
        Route::delete('delete-language', 'UserController@deleteUserLanguage')->name('delete.languages');
        Route::post('undo-language', 'UserController@undoUserLanguage')->name('undo.languages');


        Route::get('my_profile', 'UserController@myProfile')->name('my_profile');
        Route::post('profileupdate', 'UserController@ProfileUpdate')->name('profile.update');
        Route::post('send_request', 'UserController@SendRequest')->name('send-request');
        Route::post('verify_request', 'UserController@VerifyOtp')->name('verify-otp');
        Route::post('change-password', 'UserController@ChangePassword')->name('change-password');
        Route::put('my_profile', 'UserController@updateMyProfile')->name('my_profile_save');

        Route::post('show-projects/{id?}', 'UserController@showFrontUserProjects')->name('show.projects');
        Route::post('get-project-form/{id?}', 'UserController@getFrontUserProjectForm')->name('get.project.form');
        Route::post('store-project/{id?}', 'UserController@storeFrontUserProject')->name('store.project');
        Route::post('get-project-edit-form/{user_id?}', 'UserController@getFrontUserProjectEditForm')->name('get.project.edit.form');
        Route::put('update-project/{id}/{user_id?}', 'UserController@updateFrontUserProject')->name('update.project');
        Route::delete('delete-project', 'UserController@deleteUserProject')->name('delete.project');
        Route::post('undo-project', 'UserController@undoUserProject')->name('undo.project');
        
        /* * *********************************** */
        Route::get('my_resume', 'UserController@showUserCvs')->name('show.front.profile.cvs');
        // Route::post('get-front-profile-cv-form/{id}', 'UserController@getFrontUserCvForm')->name('get.front.profile.cv.form');
        Route::post('store-front-profile-cv', 'UserController@storeUserCv')->name('store.front.profile.cv');
        // Route::post('get-front-profile-cv-edit-form/{user_id}', 'UserController@getFrontUserCvEditForm')->name('get.front.profile.cv.edit.form');
        Route::post('update-front-profile-cv', 'UserController@updateUserCv')->name('update.front.profile.cv');
        Route::delete('delete-front-profile-cv', 'UserController@deleteUserCv')->name('delete.front.profile.cv');
        Route::get('downloadcv/{cv_id}', 'UserController@downloadCv')->name('downloadcv');
        Route::post('make-default-cv', 'UserController@makeDefaultCv')->name('makedefaultcv');
        
        Route::get('accounts_settings', 'UserController@accountSettings')->name('accounts_settings');

        // Route::get('my_resume', function(){
        //     return view('user.dashboard.my_resume');
        // })->name('my_resume');

        Route::get('applied-jobs', 'JobsController@appliedjobs')->name('applied-jobs');
        Route::post('/applied-jobs', 'JobsController@appliedJobsList')->name('applied-jobs-list');
        Route::get('/job-detail/{slug}', 'JobsController@JobDetail')->name('job-detail');
    
        Route::get('saved-jobs', 'JobsController@savedJobs')->name('saved-jobs');
        Route::post('/saved-jobs', 'JobsController@savedJobsList')->name('saved-jobs-list');

    });