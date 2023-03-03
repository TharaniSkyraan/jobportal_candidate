<?php

//sitemap for website inactive status

Route::get('/sitemap/link.xml', 'SitemapController@index')->name('sitemap');

Route::get('/sitemapstaticpages.xml', 'SitemapController@staticPages');
Route::get('/sitemapjobslug.xml', 'SitemapController@jobSlug');
Route::get('/sitemapjobtitle.xml', 'SitemapController@jobTitle');
Route::get('/sitemapjoblocation.xml', 'SitemapController@jobLocation');
Route::get('/sitemapjobtitlelocation.xml', 'SitemapController@jobTitleLocation');
// dynamic
Route::get('/sitemapjobtitlelocation/{id}/link.xml', 'SitemapController@jobTitleLocations')->name('sitemapjobtitlelocation');
Route::get('/sitemapjobtype.xml', 'SitemapController@jobType');
Route::get('/sitemapjobtypetitle.xml', 'SitemapController@jobTypeTitle');
// dynamic
Route::get('/sitemapjobtypetitle/{id}/link.xml', 'SitemapController@jobTypeTitles')->name('sitemapjobtypetitle');
Route::get('/sitemapjobtypelocation.xml', 'SitemapController@jobTypeLocation');
// dynamic
Route::get('/sitemapjobtypelocation/{id}/link.xml', 'SitemapController@jobTypeLocations')->name('sitemapjobtypelocation');
Route::get('/sitemapjobtypetitlelocation.xml', 'SitemapController@jobTypeTitleLocation');
// dynamic
Route::get('/sitemapjobtypetitlelocation/{designation}/{id}/link.xml', 'SitemapController@jobTypeTitleLocations')->name('sitemapjobtypetitlelocation');

?>