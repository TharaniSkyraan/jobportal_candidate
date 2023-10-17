<?php


Route:: get ('/email_template', 'Controller@jobALert');

Route::get('sendotp', 'AjaxController@SendOtp');
Route::get('sendmessage', 'AjaxController@SendMessage');
Route::get('sendtestmail', 'AjaxController@SendTestMail');

Route::get('suggestedcandidate', function(){
    $today_date = Carbon\Carbon::now();
    $job = App\Model\JobSearch::whereActive('active')->where('expiry_date','<=', $today_date);
});


Route::get('blogs', 'BlogController@blogs');
Route::post('search-blogs', 'BlogController@searchs');
Route::get('view-blog/{id}/{slug}', 'BlogController@view')->name('view-blog');
Route::post('like-blog/{id}', 'BlogController@likeblog');

?>