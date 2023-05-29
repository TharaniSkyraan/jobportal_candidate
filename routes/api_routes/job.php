<?php

    use App\Http\Controllers\Api\Job\JobsController;
    use App\Http\Controllers\Api\Job\MyJobsController;

    Route::post('search-job', [JobsController::class, 'searchJob']);
    Route::get('jobdetail/{slug}', [JobsController::class, 'jobDetail']);
    Route::get('company-detail/{slug}', [JobsController::class, 'companyDetail']);

    Route::post('apply-job/{slug}', [MyJobsController::class, 'ApplyJob']);
    Route::post('save-job/{slug}', [MyJobsController::class, 'Savejob']);
    Route::get('applied-job-list', [MyJobsController::class, 'appliedJobsList']);
    Route::get('saved-job-list', [MyJobsController::class, 'savedJobsList']);

    

?>