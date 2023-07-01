<?php

use App\Http\Controllers\AjaxController;
use App\Helpers\DataArrayHelper;

Route::get('education_level', [AjaxController::class,'suggestionEducationLevels']);
Route::post('education_types', [AjaxController::class,'suggestionEducationTypes']);
Route::post('institute', [AjaxController::class,'getInstitute']);
Route::post('cities', [AjaxController::class,'getCities']);
Route::post('countries', [AjaxController::class,'getCountries']);
Route::post('designations', [AjaxController::class, 'getDesignation']);
Route::post('skill_list', [AjaxController::class, 'GetSkills']);

?>