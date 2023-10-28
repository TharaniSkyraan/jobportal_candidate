<?php

use App\Http\Controllers\AjaxController;
use App\Helpers\DataArrayHelper;

Route::post('education_level', [AjaxController::class,'suggestionEducationLevels']);
Route::post('education_types', [AjaxController::class,'suggestionEducationTypes']);
Route::post('institute', [AjaxController::class,'getInstitute']);
Route::post('cities', [AjaxController::class,'getCities']);
Route::post('countries', [AjaxController::class,'getCountries']);
Route::post('designations', [AjaxController::class, 'getDesignation']);
Route::post('skill_list', [AjaxController::class, 'GetSkills']);
Route::get('result_type', [AjaxController::class, 'GetResultType']);
Route::get('known_level', [AjaxController::class, 'GetLanguageLevel']);
Route::get('language', [AjaxController::class, 'GetLanguage']);

?>