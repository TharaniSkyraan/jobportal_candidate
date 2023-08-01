<?php
/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

 // Real Path 

$real_path = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'web_routes' . DIRECTORY_SEPARATOR;

include_once($real_path . 'sitemap_route.php');

include_once($real_path . 'testing_route.php');

/* * ******** //Modified By Tharani******* */

Route::get('/check-time', 'Controller@checkTime')->name('check-time');

Route::post('set-locale', 'Controller@setLocale')->name('set.locale');

/* * ******** Sociallite ****************** */
Route::get('signinorsignup/{provider}', 'Auth\LoginController@redirectToProvider');

Route::any('signinorsignup/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

/**  ******** Sociallite End ************** */


/* * ******** User Auth ****************** */
include_once($real_path . 'site_user.php');

Auth::routes();

Route::view('/contact-us','contact_us')->name('contact-us');
Route::get('/faq/{ckey?}', 'ContactController@faqindex')->name('faq');
Route::post('/faqData', 'ContactController@getFaqData')->name('faq-data');
Route::post('contact-us-insert', 'ContactController@ContactInsert')->name('contact.insert');
Route::view('/about-us','about_us')->name('about-us');
Route::view('/about-company','about_company')->name('about-company');
Route::view('/cookie-policy','cookie_policy')->name('cookie-policy');
Route::view('/privacy-policy','privacy_policy')->name('privacy-policy');
Route::view('/terms-of-use','terms_of_use')->name('terms-of-use');



/* * ******** TypeAheadController ********* */
Route::get('typeahead-currency_codes', 'TypeAheadController@typeAheadCurrencyCodes')->name('typeahead.currency_codes');


/* * ******** AjaxController *************** */
include_once($real_path . 'ajax.php');

// Cache Clear
Route::get('/clear-cache', function () {
  $exitCode = Artisan::call('config:clear');
  $exitCode = Artisan::call('cache:clear');
  $exitCode = Artisan::call('config:cache');
  return 'DONE'; //Return anything
});

//Developer defined routes
Route::get('/dev-cvparser','CVParserController@index');
// Modified By Sound ************ */

Route::get('robots.txt', function () {
    return response(file_get_contents(public_path('robots.txt')), 200, [
        'Content-Type' => 'text/plain'
    ]);
});
/* * ******** JobController **************** */
include_once($real_path . 'job.php');

//Developer defined routes
// Route::get('/axejpdevr/truncate','Devdefined\DbClearController@allTableTruncate');
// Modified By Sound ************ */




/* * ****** // Modified By Tharani************ */









