<?php
    Route::get('/redirect_user/{from?}', 'Auth\LoginController@UserSwitchRedirect')->name('redirect-user');
    Route::any('accountverification', 'Auth\LoginController@accountVerification')->name('accountverification');

    Route::get('/verify_otp', 'Auth\LoginController@verifyOtp')->name('verify_otp');
    Route::post('resent_mail', 'Auth\LoginController@resentMail')->name('resentMail');
    Route::post('verify_signup', 'Auth\LoginController@VerifySignup')->name('verify_signup');

    /** Basic Info */
    Route::get('basic_info', 'Auth\RegisterController@basicInfo')->name('basic_info');
    Route::put('basic_info', 'Auth\RegisterController@basicInfoSave')->name('basic_info_save');

    /** Educations */
    Route::get('education', 'Auth\RegisterController@Education')->name('education');   
    Route::post('education', 'Auth\RegisterController@EducationSave')->name('education-save');  

    //** Experience */
    Route::get('experience', 'Auth\RegisterController@Experience')->name('experience');  
    Route::post('experience', 'Auth\RegisterController@ExperienceSave')->name('experience-save');  
    
    /** Career Info */
    Route::get('career_info', 'Auth\RegisterController@CareerInfo')->name('career-info'); 
    Route::post('career_info', 'Auth\RegisterController@CareerInfoSave')->name('career-info-save');  
   
    /** Skills */
    Route::get('skills', 'Auth\RegisterController@Skills')->name('skills');  
    Route::get('skills_data', 'AjaxController@SkillData')->name('get.skills.data');  

    Route::post('skills', 'Auth\RegisterController@SkillSave')->name('skills-save');  

    /**Resume Upload */
    Route::get('resume_upload', 'Auth\RegisterController@ResumeUpload')->name('resume_upload');  
    Route::any('resumeupdate', 'Auth\RegisterController@ResumeUpdate')->name('resume.update');

    // Complete signup
    Route::get('completed_signup', 'Auth\RegisterController@CompleteSignup')->name('completed_signup');  

    Route::namespace('User')->group(function () {

        /* * ******** user home page ************ */

        Route::get('home', 'UserController@index')->name('home');

        Route::post('profilePercentage', 'UserController@profilePercentage')->name('profile-percentage');
        
        
        Route::get('my_profile', 'UserController@myProfile')->name('my_profile');
        Route::post('profileupdate', 'UserController@ProfileUpdate')->name('profile.update');
        Route::post('send_request', 'UserController@SendRequest')->name('send-request');
        Route::post('verify_request', 'UserController@VerifyOtp')->name('verify-otp');
        Route::post('change-password', 'UserController@ChangePassword')->name('change-password');
        Route::put('my_profile', 'UserController@updateMyProfile')->name('my_profile_save');
        Route::put('career_info', 'UserController@updateCareer')->name('career_info_save');
        
        Route::view('/career-info-details','user.dashboard.career-info-details')->name('career-info-details');
        
        /** Educations */
        
        Route::view('/education-details','user.education.educations')->name('education-details');
        Route::post('get-education-form/{id?}', 'UserController@getFrontUserEducationForm')->name('get.education.form');
        Route::post('store-education/{id?}', 'UserController@storeFrontUserEducation')->name('store.education.form');
        Route::post('show-education', 'UserController@showUserEducationList')->name('show.education');
        Route::post('get-education-edit-form/{id?}', 'UserController@getFrontUserEducationEditForm')->name('get.education.edit.form');
        Route::put('update-education/{education_id}/{user_id?}', 'UserController@updateFrontUserEducation')->name('update.education');
        Route::delete('delete-education', 'UserController@deleteUserEducation')->name('delete.education');
        Route::post('undo-education', 'UserController@undoUserEducation')->name('undo.education');

        //** Experience */
        Route::get('/experience-details','UserController@ExpDetail')->name('experience-details');
        Route::post('employementstatus-update', 'UserController@employementStatusUpdate')->name('employementstatus-update');
        Route::post('show-experience', 'UserController@showUserExperienceList')->name('show.experience');
        Route::post('get-experience-form/{id?}', 'UserController@getFrontUserExperienceForm')->name('get.experience.form');
        Route::post('store-experience/{id?}', 'UserController@storeFrontUserExperience')->name('store.experience');
        Route::post('get-experience-edit-form/{id?}', 'UserController@getFrontUserExperienceEditForm')->name('get.experience.edit.form');
        Route::put('update-experience/{profile_experience_id}/{user_id?}', 'UserController@updateFrontUserExperience')->name('update.experience');
        Route::delete('delete-experience', 'UserController@deleteUserExperience')->name('delete.experience');
        Route::post('undo-experience', 'UserController@undoUserExperience')->name('undo.experience');

        /** Skills */
        Route::view('/skill-details','user.skill.skills')->name('skill-details');
        Route::post('show-skills/{id?}', 'UserController@showUserSkills')->name('show.skills');
        Route::post('get-skill-form/{id?}', 'UserController@getFrontUserSkillForm')->name('get.skill.form');
        Route::post('store-skill/{id?}', 'UserController@storeFrontUserSkill')->name('store.skill');
        Route::post('get-skill-edit-form/{id?}', 'UserController@getFrontUserSkillEditForm')->name('get.skill.edit.form');
        Route::put('update-skill/{skill_id}/{user_id?}', 'UserController@updateFrontUserSkill')->name('update.skill');
        Route::delete('delete-skill', 'UserController@deleteUserSkill')->name('delete.skill');
        Route::post('undo-skill', 'UserController@undoUserSkill')->name('undo.skill');

        /**Languages */
        Route::view('/language-details','user.language.languages')->name('language-details');
        Route::post('show-languages/{id?}', 'UserController@showUserLanguages')->name('show.languages');
        Route::post('get-language-form/{id?}', 'UserController@getFrontUserLanguageForm')->name('get.languages.form');
        Route::post('store-language/{id?}', 'UserController@storeFrontUserLanguage')->name('store.languages');
        Route::post('get-language-edit-form/{id?}', 'UserController@getFrontUserLanguageEditForm')->name('get.languages.edit.form');
        Route::put('update-language/{language_id}/{user_id?}', 'UserController@updateFrontUserLanguage')->name('update.languages');
        Route::delete('delete-language', 'UserController@deleteUserLanguage')->name('delete.languages');
        Route::post('undo-language', 'UserController@undoUserLanguage')->name('undo.languages');

        /**Projects */
        Route::view('/project-details','user.project.projects')->name('project-details');
        Route::post('show-projects/{id?}', 'UserController@showFrontUserProjects')->name('show.projects');
        Route::post('get-project-form/{id?}', 'UserController@getFrontUserProjectForm')->name('get.project.form');
        Route::post('store-project/{id?}', 'UserController@storeFrontUserProject')->name('store.project');
        Route::post('get-project-edit-form/{user_id?}', 'UserController@getFrontUserProjectEditForm')->name('get.project.edit.form');
        Route::put('update-project/{id}/{user_id?}', 'UserController@updateFrontUserProject')->name('update.project');
        Route::delete('delete-project', 'UserController@deleteUserProject')->name('delete.project');
        Route::post('undo-project', 'UserController@undoUserProject')->name('undo.project');
        
        /**Resume */
        Route::get('resume-details', 'UserController@showUserCvs')->name('resume-details');
        Route::post('store-front-profile-cv', 'UserController@storeUserCv')->name('store.front.profile.cv');
        Route::post('update-front-profile-cv', 'UserController@updateUserCv')->name('update.front.profile.cv');
        Route::delete('delete-front-profile-cv', 'UserController@deleteUserCv')->name('delete.front.profile.cv');
        Route::get('downloadcv/{cv_id}', 'UserController@downloadCv')->name('downloadcv');
        Route::post('make-default-cv', 'UserController@makeDefaultCv')->name('makedefaultcv');
        
        /**Job Alert */
        Route::get('/job-alert-details','UserController@JobAlertDetail')->name('job-alert-details');
        Route::post('show-job-alert', 'UserController@showJobAlertList')->name('show.job-alert');
        Route::post('get-job-alert-form/{id?}', 'UserController@getFrontJobAlertForm')->name('get.job-alert.form');
        Route::post('store-job-alert/{id?}', 'UserController@storeFrontJobAlert')->name('store.job-alert');
        Route::post('get-job-alert-edit-form/{id?}', 'UserController@getFrontJobAlertEditForm')->name('get.job-alert.edit.form');
        Route::put('update-job-alert/{job_alert_id}/{user_id}', 'UserController@updateFrontJobAlert')->name('update.job-alert');
        Route::delete('delete-job-alert', 'UserController@deleteJobAlert')->name('delete.job-alert');
        Route::post('undo-job-alert', 'UserController@undoJobAlert')->name('undo.job-alert');



        /** Account Setting */
        Route::get('accounts_settings', 'UserController@accountSettings')->name('accounts_settings');

        /** Applied Jobs */
        Route::get('applied-jobs', 'JobsController@appliedjobs')->name('applied-jobs');
        Route::post('/applied-jobs', 'JobsController@appliedJobsList')->name('applied-jobs-list');
        Route::get('/job-detail/{slug}', 'JobsController@JobDetail')->name('job-detail');
    
        /** Saved Jobs */
        Route::get('saved-jobs', 'JobsController@savedJobs')->name('saved-jobs');
        Route::post('/saved-jobs', 'JobsController@savedJobsList')->name('saved-jobs-list');

        
        Route::get('/messages/{mid?}', 'MessagesController@index')->name('employer_messages');
        Route::post('message_contact_list', 'MessagesController@messageContactList')->name('message-contact-list');
        Route::post('messagelist', 'MessagesController@messageList')->name('message-list');
        Route::post('message_send', 'MessagesController@messageSend')->name('message-send');
        Route::post('messagelisten', 'MessagesController@messageListen')->name('message-listen');
      
    });

    ?>