<?php

    use App\Http\Controllers\Api\Job\JobsController;
    use App\Http\Controllers\Api\Job\MyJobsController;

    Route::middleware('auth:api')->group( function () {
            
        Route::get('index', [JobsController::class, 'index']);
        Route::get('advanced_filter', [JobsController::class, 'advancedFilter']);
        Route::post('search-job', [JobsController::class, 'searchJob']);
        Route::get('job-detail/{slug}', [JobsController::class, 'jobDetail']);
        Route::get('company-detail/{slug}', [JobsController::class, 'companyDetail']);

        Route::post('apply-job/{slug}', [MyJobsController::class, 'ApplyJob']);
        Route::post('save-unsave-job/{slug}', [MyJobsController::class, 'Savejob']);
        Route::post('applied-job-list', [MyJobsController::class, 'appliedJobsList']);
        Route::post('saved-job-list', [MyJobsController::class, 'savedJobsList']);
        Route::post('saved-job-alert', [MyJobsController::class, 'Savejobalert']);
        Route::get('job-alert-list', [MyJobsController::class, 'JobalertList']);
        Route::get('delete-job-alert/{id}', [MyJobsController::class, 'DeleteJobalert']);

    });

?>