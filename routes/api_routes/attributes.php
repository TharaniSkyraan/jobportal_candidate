<?php

use App\Http\Controllers\AjaxController;

Route::post('education_types', [AjaxController::class,'suggestionEducationTypes']);
Route::post('cities', [AjaxController::class,'getCities']);
Route::post('countries', [AjaxController::class,'getCountries']);
Route::post('designations', [AjaxController::class, 'getDesignation']);
Route::post('skill_list', [AjaxController::class, 'GetSkills']);

?>