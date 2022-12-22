<?php

namespace App\Traits;

use App\Model\JobWorkLocation;
use App\Model\City;

trait JobWorkLocations
{

    private function storeJobWorkLocations($request, $job_id)
    {
        if($request->work_from_home!='permanent'){
                
            if ($request->has('location')) {
                $locations = json_decode($request->location);

                JobWorkLocation::whereNotIn('city',array_column($locations,'value'))
                               ->where('job_id', '=', $job_id)->forceDelete();

                foreach ($locations as $location) {     

                    if(!empty($location->id) && JobWorkLocation::whereJobId($job_id)->whereCityId($location->id)->doesntExist()){       
                        $work_location = City::where('city_id',$location->id)->lang()->active()->sorted()->first();

                        $jobWorkLocation = new JobWorkLocation();
                        $jobWorkLocation->job_id = $job_id;
                        $jobWorkLocation->city = $work_location->city;
                        $jobWorkLocation->location = $work_location->getLocation();
                        $jobWorkLocation->city_id = $work_location->city_id;
                        $jobWorkLocation->state_id = $work_location->state_id;
                        $jobWorkLocation->country_id = $work_location->state->country_id;
                        $jobWorkLocation->save();

                    }

                }

            }
            
        }

    }
    

    private function DuplicateJobWorkLocations($job_id, $new_job_id)
    {
        
        JobWorkLocation::query()
            ->where('job_id',$job_id)
            ->each(function ($oldPost) use($new_job_id){
                $jobWorkLocation = $oldPost->replicate();
                $jobWorkLocation->job_id = $new_job_id;
                $jobWorkLocation->save();             
        }); 

    }

}
