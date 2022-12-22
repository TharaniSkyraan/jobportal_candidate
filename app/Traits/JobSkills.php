<?php

namespace App\Traits;

use App\Model\JobSkill;
use App\Model\Skill;

trait JobSkills
{

    private function storeJobSkills($request, $job_id)
    {
        
        if ($request->has('skills')) {
            JobSkill::where('job_id', '=', $job_id)->forceDelete();
            $skills = json_decode($request->skills);
          
            foreach ($skills as $skill) {                
                if(!empty($skill->id)){                       
                    $jobSkill = new JobSkill();
                    $jobSkill->job_id = $job_id;
                    $jobSkill->skill_id = $skill->id;
                    $jobSkill->save();
                }
            }
        }
    }

    private function DuplicateJobSkills($job_id, $new_job_id)
    {      
        JobSkill::query()
            ->where('job_id',$job_id)
            ->each(function ($oldPost) use($new_job_id){
                $jobSkill = $oldPost->replicate();
                $jobSkill->job_id = $new_job_id;
                $jobSkill->save();             
        }); 
    }

}
