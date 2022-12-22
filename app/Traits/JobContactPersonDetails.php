<?php

namespace App\Traits;
use App\Model\JobContactPersonDetail;

trait JobContactPersonDetails
{

    private function storeContactPersonDetails($request, $job_id)
    {
        
        
            JobContactPersonDetail::where('job_id', '=', $job_id)->forceDelete();
            
            $jobContactPerson = new JobContactPersonDetail();
            $jobContactPerson->name = $request->name;
            $jobContactPerson->job_id = $job_id;
            $jobContactPerson->employer_role_id = $request->has('myself_name')?$request->employer_role_id:0;
            $jobContactPerson->email = $request->email;
            $jobContactPerson->phone_1 = $request->full_number;
            $jobContactPerson->phone_2 = $request->full_number_1;
            $jobContactPerson->morning_section_from = $request->morning_section_from;            
            $jobContactPerson->morning_section_to   = $request->morning_section_to;            
            $jobContactPerson->evening_section_from = $request->evening_section_from;            
            $jobContactPerson->evening_section_to   = $request->evening_section_to; 
            $jobContactPerson->send_apply_notify   = $request->send_apply_notify??Null;            
            $jobContactPerson->send_day_report   = $request->send_day_report??Null;
            $jobContactPerson->shared_email_1 = $request->shared_email[0]??null;
            $jobContactPerson->shared_email_2 = $request->shared_email[1]??null;
            $jobContactPerson->shared_email_3 = $request->shared_email[2]??null;
            $jobContactPerson->shared_email_4 = $request->shared_email[3]??null;
            $jobContactPerson->shared_email_5 = $request->shared_email[4]??null;            
            $jobContactPerson->save();
    }
   
    private function DuplicateContactPersonDetails($job_id, $new_job_id)
    {
        JobContactPersonDetail::query()
            ->where('job_id',$job_id)
            ->each(function ($oldPost) use($new_job_id){
                $jobContactPerson = $oldPost->replicate();
                $jobContactPerson->job_id = $new_job_id;
                $jobContactPerson->save();             
        }); 
    }

}
