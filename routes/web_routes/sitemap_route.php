<?php

//sitemap for website inactive status

Route::get('/sitemap.xml', 'SitemapController@index')->name('sitemap');

Route::get('/sitemapstaticpages.xml', 'SitemapController@staticPages');
Route::get('/sitemapjobslug.xml', 'SitemapController@jobSlug');
Route::get('/sitemapjobtitle.xml', 'SitemapController@jobTitle');
Route::get('/sitemapjoblocation.xml', 'SitemapController@jobLocation');
Route::get('/sitemapjobtype.xml', 'SitemapController@jobType');


Route::get('/sitemapjobtitlelocation.xml', 'SitemapController@jobTitleLocation');
Route::get('/sitemapjobtitlelocation/{id}/link.xml', 'SitemapController@jobTitleLocations')->name('sitemapjobtitlelocation');

Route::get('/sitemapjobtypetitle.xml', 'SitemapController@jobTypeTitle');
Route::get('/sitemapjobtypetitle/{id}/link.xml', 'SitemapController@jobTypeTitles')->name('sitemapjobtypetitle');

Route::get('/sitemapjobtypelocation.xml', 'SitemapController@jobTypeLocation');
Route::get('/sitemapjobtypelocation/{id}/link.xml', 'SitemapController@jobTypeLocations')->name('sitemapjobtypelocation');

Route::get('/sitemapjobtypetitlelocation.xml', 'SitemapController@jobTypeTitleLocation');
Route::get('/sitemapjobtypetitlelocation/{designation}/{id}/link.xml', 'SitemapController@jobTypeTitleLocations')->name('sitemapjobtypetitlelocation');

?>