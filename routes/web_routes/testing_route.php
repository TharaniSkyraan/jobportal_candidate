<?php
use App\Mail\CompanyRegisteredMailable;
Route::prefix('job/employer')->name('job.employer.')->group(function () {
    // Route:: get ('/home', function () {
    //     return view('jobportal_employer.home');
    // })->name('home');
    // Route::get('my_profile', 'Company\CompanyController@companyProfile')->name('my_profile');

    Route::get('mail_template', function(){
        return view('emails.mail_template');
    });

    
});

Route:: get ('/email_template', function () {
    $job = App\Model\Job::find(1);
    $jobaapply = App\Model\Company::find(1);
    return new CompanyRegisteredMailable($jobaapply);
    // return view('vendor.laravel-user-verification.email');
});

Route::get('sendotp', 'AjaxController@SendOtp');
Route::get('sendmessage', 'AjaxController@SendMessage');
Route::get('sendtestmail', 'AjaxController@SendTestMail');

Route::get('suggestedcandidate', function(){
    $today_date = Carbon\Carbon::now();
    $job = App\Model\JobSearch::whereActive('active')->where('expiry_date','<=', $today_date);
});



/***
 ***jayavel routes
 ***/

Route::get('screening1', function(){
    return view('company.jobs.screening1');
});



/**
 * demo routes
 **/

Route::view('page1','demo.page1');
Route::view('page2','demo.page2');
Route::view('page3','demo.page3');
Route::view('page4','demo.page4');
Route::view('page5','demo.page5');
Route::view('page6','demo.page6');
Route::view('page7','demo.page7');
Route::view('page8','demo.page8');



//user profile pages
Route::view('sidebar','demo.sidebar');
Route::view('about-me','demo.about-me');
Route::view('my-education','demo.my-education');
Route::view('my-experience','demo.my-experience');
Route::view('my-experience-choose','demo.my-experience-choose');
Route::view('my-experience1','demo.my-experience1');
Route::view('my-experience2','demo.my-experience2');
Route::view('my-experience3','demo.my-experience3');
Route::view('my-projects','demo.my-projects');
Route::view('my-projects1','demo.my-projects1');
Route::view('my-skills','demo.my-skills');
Route::view('my-skills1','demo.my-skills1');
Route::view('language-known','demo.language-known');
Route::view('language-known1','demo.language-known1');
Route::view('my-resume','demo.my-resume');
Route::view('my-resume1','demo.my-resume1');
