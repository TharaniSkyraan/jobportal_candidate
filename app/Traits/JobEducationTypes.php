<?php

namespace App\Traits;

use App\Model\JobEducationType;

trait JobEducationTypes
{

    private function storeJobEducationTypes($request, $job_id)
    {
        if ($request->has('education_type_id')) {
            JobEducationType::where('job_id', '=', $job_id)->forceDelete();
            $education_types = is_array($request->input('education_type_id'))?$request->input('education_type_id'):explode(',',$request->input('education_type_id'));
            foreach ($education_types as $education_type_id) {
                if($education_type_id){
                    $jobEducationType = new JobEducationType();
                    $jobEducationType->job_id = $job_id;
                    $jobEducationType->education_type_id = $education_type_id;
                    $jobEducationType->save();
                }
            }
        }
    }
   
    private function DuplicateJobEducationTypes($job_id, $new_job_id)
    {
        JobEducationType::query()
            ->where('job_id',$job_id)
            ->each(function ($oldPost) use($new_job_id){
                $jobEducationType = $oldPost->replicate();  
                $jobEducationType->job_id = $new_job_id;
                $jobEducationType->save();             
        }); 
    }

}
