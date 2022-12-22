<?php

namespace App\Traits;
use App\Model\JobWalkIn;

trait JobWalkInInfo
{

    private function storeWalkinDetails($request, $job_id)
    {
        
        if ($request->has('walk_in_check') ) {

            JobWalkIn::where('job_id', '=', $job_id)->forceDelete();
            $JobWalkIn = new JobWalkIn();
            $JobWalkIn->job_id = $job_id;
            $JobWalkIn->walk_in_from_date = $request->input('walk_in_from_date');
            $JobWalkIn->walk_in_to_date = $request->input('walk_in_to_date');
            $JobWalkIn->walk_in_from_time = $request->input('walk_in_from_time');
            $JobWalkIn->walk_in_to_time = $request->input('walk_in_to_time');
            $JobWalkIn->walk_in_location = $request->input('walk_in_location');
            $JobWalkIn->walk_in_google_map_url = $request->input('walk_in_google_map_url')?$request->input('walk_in_google_map_url'):null;
            $JobWalkIn->exclude_days = $request->input('exclude_days')?implode(',',$request->input('exclude_days')):null;
            $JobWalkIn->save();
        }
        else{
            JobWalkIn::where('job_id', '=', $job_id)->forceDelete();
        }
    }

    private function DuplicateWalkinDetails($job_id, $new_job_id)
    {        
        JobWalkIn::query()
            ->where('job_id',$job_id)
            ->each(function ($oldPost) use($new_job_id){
                $JobWalkIn = $oldPost->replicate();
                $JobWalkIn->job_id = $new_job_id;
                $JobWalkIn->save();             
        }); 
    }

}
