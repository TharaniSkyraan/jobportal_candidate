<?php

Route::get('/', 'Job\JobsController@searchIndex')->name('index');

// jobseeker main-search api routes starts..
Route::get('api/autocomplete/search_designation', 'AjaxController@getDesignation');
Route::get('api/autocomplete/search_designation_default', 'AjaxController@getDefaultDesignation');
Route::get('api/autocomplete/search_location', 'AjaxController@getLocation');
Route::get('api/autocomplete/search_location_default', 'AjaxController@getDefaultLocation');

Route::name('job.')->namespace('Job')->group(function () {
    Route::get('company-view/{slug}', 'JobsController@companydetail');

    Route::post('checkkeywords', 'JobsController@checkKeywords')->name('checkkeywords');
    Route::get('detail/{slug}', 'JobsController@jobDetail')->name('detail');
    Route::post('apply/{slug}', 'JobsController@ApplyJob')->name('apply');

    Route::post('save/{slug}', 'FavouriteJobController@SaveJob')->name('save');

    // Search
    Route::get('/{slug}', 'JobsController@search')->name('search');
    Route::post('/api/search', 'JobsController@searchJob')->name('search-job');
});
?>