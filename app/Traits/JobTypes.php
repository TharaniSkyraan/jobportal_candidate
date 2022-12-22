<?php

namespace App\Traits;

use App\Model\JobType;

trait JobTypes
{

    private function storeJobTypes($request, $job_id)
    {
        if ($request->has('type_id')) {
            JobType::where('job_id', '=', $job_id)->forceDelete();
            $types = is_array($request->input('type_id'))?$request->input('type_id'):explode(',',$request->input('type_id'));
            foreach ($types as $type_id) {
                if($type_id){
                    $jobType = new JobType();
                    $jobType->job_id = $job_id;
                    $jobType->type_id = $type_id;
                    $jobType->save();
                }
                
            }
        }
    }
    
    private function DuplicateJobTypes($job_id, $new_job_id)
    {
        JobType::query()
            ->where('job_id',$job_id)
            ->each(function ($oldPost) use($new_job_id){
                $jobType = $oldPost->replicate();
                $jobType->job_id = $new_job_id;
                $jobType->save();             
        }); 
    }

}
