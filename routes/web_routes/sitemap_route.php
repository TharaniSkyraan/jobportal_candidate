<?php

//sitemap for website inactive status

Route::get('/sitemap/link', 'SitemapController@index')->name('sitemap');

Route::get('/sitemapjobslug', 'SitemapController@jobSlug');
Route::get('/sitemapjobtitle', 'SitemapController@jobTitle');
Route::get('/sitemapjoblocation', 'SitemapController@jobLocation');
Route::get('/sitemapjobtitlelocation', 'SitemapController@jobTitleLocation');
Route::get('/sitemapjobtitlelocation/{id}', 'SitemapController@jobTitleLocations');

Route::get('/sitemapjobtype', 'SitemapController@jobType');
Route::get('/sitemapjobtypetitle', 'SitemapController@jobTypeTitle');
Route::get('/sitemapjobtypetitle/{id}', 'SitemapController@jobTypeTitles');
Route::get('/sitemapjobtypelocation', 'SitemapController@jobTypeLocation');
Route::get('/sitemapjobtypelocation/{id}', 'SitemapController@jobTypeLocations');
Route::get('/sitemapjobtypetitlelocation', 'SitemapController@jobTypeTitleLocation');
Route::get('/sitemapjobtypetitlelocation/{designation}/{id}', 'SitemapController@jobTypeTitleLocations');

?>