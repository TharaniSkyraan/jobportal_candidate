<?php

namespace App\Traits;

use App\Model\JobSupplemental;

trait JobSupplementals
{

    private function storeJobSupplementals($request, $job_id)
    {
        JobSupplemental::where('job_id', '=', $job_id)->forceDelete();
        if ($request->has('supplementals') && !empty($request->supplementals)) {
        
            $supplementals = is_array($request->input('supplementals'))?$request->input('supplementals'):explode(',',$request->input('supplementals'));

            foreach ($supplementals as $supplemental_id) {
                $jobSupplemental = new JobSupplemental();
                $jobSupplemental->job_id = $job_id;
                $jobSupplemental->supplemental_id = $supplemental_id;
                $jobSupplemental->save();
            }
        }
    }
   
    private function DuplicateJobSupplementals($job_id, $new_job_id)
    {
        JobSupplemental::query()
            ->where('job_id',$job_id)
            ->each(function ($oldPost) use($new_job_id){
                $jobSupplemental = $oldPost->replicate();
                $jobSupplemental->job_id = $new_job_id;
                $jobSupplemental->save();             
        }); 
    }
}
