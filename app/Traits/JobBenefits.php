<?php

namespace App\Traits;

use App\Model\JobBenefit;

trait JobBenefits
{

    private function storeJobBenefits($request, $job_id)
    {
            JobBenefit::where('job_id', '=', $job_id)->forceDelete();
        if ($request->has('benefits') && !empty($request->benefits)) {
            $benefits = is_array($request->input('benefits'))?$request->input('benefits'):explode(',',$request->input('benefits'));

            foreach ($benefits as $benefit_id) {
                $jobBenefit = new JobBenefit();
                $jobBenefit->job_id = $job_id;
                $jobBenefit->benefit_id = $benefit_id;
                $jobBenefit->save();
            }
        }
    }
   
    private function DuplicateJobBenefits($job_id, $new_job_id)
    {
        JobBenefit::query()
            ->where('job_id',$job_id)
            ->each(function ($oldPost) use($new_job_id){
                $jobBenefit = $oldPost->replicate();
                $jobBenefit->job_id = $new_job_id;
                $jobBenefit->save();             
        }); 
    }

}
