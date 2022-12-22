<?php

namespace App\Traits;

use App\Model\JobShift;

trait JobShifts
{

    private function storeJobShifts($request, $job_id)
    {
        if ($request->has('shifts')) {
            JobShift::where('job_id', '=', $job_id)->forceDelete();
            $shifts = is_array($request->input('shifts'))?$request->input('shifts'):explode(',',$request->input('shifts'));
            foreach ($shifts as $shift_id) {
                if($shift_id){                        
                    $jobShift = new JobShift();
                    $jobShift->job_id = $job_id;
                    $jobShift->shift_id = $shift_id;
                    $jobShift->save();
                }
            }
        }
    }

    private function DuplicateJobShifts($job_id, $new_job_id)
    {        
        JobShift::query()
            ->where('job_id',$job_id)
            ->each(function ($oldPost) use($new_job_id){
                $jobShift = $oldPost->replicate();
                $jobShift->job_id = $new_job_id;
                $jobShift->save();             
        }); 
    }

}
