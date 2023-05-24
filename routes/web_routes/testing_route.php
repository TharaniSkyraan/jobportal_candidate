<?php
use App\Mail\AlertJobsMail;
Route:: get ('/email_template', function () {
    $job = App\Model\Job::get();
    $jobaapply = App\Model\Company::find(1);
    return new AlertJobsMail($job);
});

Route::get('sendotp', 'AjaxController@SendOtp');
Route::get('sendmessage', 'AjaxController@SendMessage');
Route::get('sendtestmail', 'AjaxController@SendTestMail');

Route::get('suggestedcandidate', function(){
    $today_date = Carbon\Carbon::now();
    $job = App\Model\JobSearch::whereActive('active')->where('expiry_date','<=', $today_date);
});

?>