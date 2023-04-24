<?php

Route:: get ('/email_template', function () {
    $job = App\Model\Job::find(1);
    $jobaapply = App\Model\Company::find(1);
    return new CompanyRegisteredMailable($jobaapply);
});

Route::get('sendotp', 'AjaxController@SendOtp');
Route::get('sendmessage', 'AjaxController@SendMessage');
Route::get('sendtestmail', 'AjaxController@SendTestMail');

Route::get('suggestedcandidate', function(){
    $today_date = Carbon\Carbon::now();
    $job = App\Model\JobSearch::whereActive('active')->where('expiry_date','<=', $today_date);
});

?>