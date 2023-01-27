<?php

//sitemap for website inactive status

Route::get('/sitemap/link', 'SitemapController@index')->name('sitemap');

Route::get('/sitemap_job_slug', 'SitemapController@jobSlug');
Route::get('/sitemap_job_title', 'SitemapController@jobTitle');
Route::get('/sitemap_job_location', 'SitemapController@jobLocation');
Route::get('/sitemap_job_title_location', 'SitemapController@jobTitleLocation');
Route::get('/sitemap_job_title_location/{id}', 'SitemapController@jobTitleLocations');

Route::get('/sitemap_job_type', 'SitemapController@jobType');
Route::get('/sitemap_job_type_title', 'SitemapController@jobTypeTitle');
Route::get('/sitemap_job_type_title/{id}', 'SitemapController@jobTypeTitles');
Route::get('/sitemap_job_type_location', 'SitemapController@jobTypeLocation');
Route::get('/sitemap_job_type_location/{id}', 'SitemapController@jobTypeLocations');
Route::get('/sitemap_job_type_title_location', 'SitemapController@jobTypeTitleLocation');
Route::get('/sitemap_job_type_title_location/{designation}/{id}', 'SitemapController@jobTypeTitleLocations');
