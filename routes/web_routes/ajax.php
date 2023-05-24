<?php

Route::post('filter-default-cities-dropdown', 'AjaxController@filterDefaultCities')->name('filter.default.cities.dropdown');
Route::post('filter-default-cities-dropdown-countrywise', 'AjaxController@filterDefaultCitiesCountryWise')->name('filter.default.cities.dropdown.countrywise');
Route::post('filter-default-states-dropdown', 'AjaxController@filterDefaultStates')->name('filter.default.states.dropdown');
Route::post('filter-default-check-location', 'CompanyController@checklocation')->name('filter.default.location.validate');
Route::get('getourcompanygallery/{id?}', 'AjaxController@getourcompanygallery')->name('getourcompanygallery');
Route::get('getallgalariescompany', 'AjaxController@getAllGalariesCompany')->name('getAllGalariesCompany');
Route::post('getallgalariescompanyparticular', 'AjaxController@getAllGalariesCompanyParticular')->name('getAllGalariesCompanyParticular');
Route::get('deleteparticulargalary/{id?}', 'AjaxController@DeleteParticularGalary')->name('DeleteParticularGalary');
// Route::get('filter-default-countries-dropdown', 'AjaxController@filterDefaultCountries')->name('filter.default.countries.dropdown');
Route::post('filter-lang-cities-dropdown', 'AjaxController@filterLangCities')->name('filter.lang.cities.dropdown');
Route::post('filter-lang-states-dropdown', 'AjaxController@filterLangStates')->name('filter.lang.states.dropdown');
Route::post('suggestion-education-types-dropdown', 'AjaxController@suggestionEducationTypes')->name('suggestion.education.types.dropdown');
Route::post('filter-education-types-dropdown', 'AjaxController@filterEducationTypes')->name('filter.education.types.dropdown');
Route::post('filter-education-types-dropdown-multiselect', 'AjaxController@filterMultiselectEducationTypes')->name('filter.education.types.dropdown.multiselect');
Route::post('filter-default-sub-industry-dropdown', 'AjaxController@filterDefaultSubIndustries')->name('filter.default.sub.industries.dropdown');
Route::post('filter-sub-industry-dropdown', 'AjaxController@filterSubIndustries')->name('filter.sub.industries.dropdown');
Route::get('skillsdata', 'AjaxController@SkillDatas')->name('get.skills');  
Route::post('filter-options_value/{type?}', 'AjaxController@optionValue')->name('filter.option_value');

Route::get('api/autocomplete/search_city', 'AjaxController@getCity')->name('get.city');  
Route::get('api/autocomplete/search_institute', 'AjaxController@getInstitute');
Route::get('api/autocomplete/search_title', 'AjaxController@getTitle');

