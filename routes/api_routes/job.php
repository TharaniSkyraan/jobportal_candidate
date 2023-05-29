<?php

    use App\Http\Controllers\Api\Job\JobsController;
    use App\Http\Controllers\Api\Job\MyJobsController;

    Route::post('search-job', [JobsController::class, 'searchJob']);
    Route::get('job-detail/{slug}', [JobsController::class, 'jobDetail']);
    Route::get('company-detail/{slug}', [JobsController::class, 'companyDetail']);

    Route::middleware('auth:api')->group( function () {
        Route::post('apply-job/{slug}', [MyJobsController::class, 'ApplyJob']);
        Route::post('save-unsave-job/{slug}', [MyJobsController::class, 'Savejob']);
        Route::get('applied-job-list', [MyJobsController::class, 'appliedJobsList']);
        Route::get('saved-job-list', [MyJobsController::class, 'savedJobsList']);
    });

?>