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

