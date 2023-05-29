<?php

namespace App\Http\Controllers\Api\Job;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Model\JobApply;
use App\Model\Job;
use App\Helpers\DataArrayHelper;
use App\Traits\JobTrait;
use App\Events\JobApplied;
use App\Model\JobQuizCandidateAnswer;
use App\Model\JobScreeningQuiz;
use App\Model\FavouriteJob;

class MyJobsController extends BaseController
{

    use JobTrait;

    public function ApplyJob(Request $request, $job_slug)
    {
        
        $user = Auth::user();
        $user_id = $user->id;
        $job = Job::where('slug', 'like', $job_slug)->first();
        $message = "You have already applied for this job";
        if(Auth::user()->isAppliedOnJob($job->id)==false)
        {
            $jobApply = new JobApply();
            $jobApply->user_id = $user_id;
            $jobApply->job_id = $job->id;
            $jobApply->percentage = $user->profileMatch($job->id);
            $jobApply->save();
            if(count($job->screeningquiz)!=0 && !empty($request->skip_screening)){
                foreach($job->screeningquiz as $quiz){
                    $answerkey = 'answer_'.$quiz->quiz_code;
                    $data = new JobQuizCandidateAnswer();
                    $data->apply_id = $jobApply->id;
                    $data->job_screening_quiz_id = $quiz->id;
                    $data->answer = is_array($request[$answerkey]) ? implode(',', $request[$answerkey]) : $request[$answerkey];
                    $data->save();
                }
            }
            if($job->contact_person_details->send_apply_notify_email=='yes'){
                event(new JobApplied($job, $jobApply));
            }
            if($job->contact_person_details->send_apply_notify_mobile=='yes'){
                
                $phone = str_replace("+","",$job->contact_person_details->phone_1??'');
                $phone1 = str_replace("+","",$job->contact_person_details->phone_2??'');

                if(!empty($phone)){
                    $this->Notification($jobApply->id,$phone);
                }
                if(!empty($phone1)){
                    $this->Notification($jobApply->id,$phone1);
                }

            }

            $message = "You have successfully applied for this job";
       
        }

        return $this->sendResponse('', $message);
    }

    public function Savejob(Request $request, $job_slug)
    {

        $save_as_fav = $request->fav=='yes'? 'no' : 'yes';
        $user = Auth::user();
        $user_id = $user->id;
        $job = Job::where('slug', 'like', $job_slug)->first();

        if($save_as_fav == 'yes')
        {
                
            if(Auth::user()->isFavouriteJob($job_slug)==false)
            {
                    
                $jobFavourite = new FavouriteJob();
                $jobFavourite->user_id = $user_id;
                $jobFavourite->job_id = $job->id;
                $jobFavourite->job_slug = $job->slug;
                $jobFavourite->save();

            }
            $message = "You have successfully saved this job";

        }
        if($save_as_fav == 'no')
        {
                
            if(Auth::user()->isFavouriteJob($job_slug)==true){
                FavouriteJob::whereJobId($job->id)->whereUserId($user_id)->delete();
            }
            $message = "You have remove from saved job";
        }

        return $this->sendResponse('', $message);

    }

    public function appliedJobsList(Request $request)
    {      
        $user_id = Auth::user()->id;
        $sortBy = $request->sortBy??'all';
        $jobs = JobApply::where('user_id',$user_id)
                               ->where(function($q) use($sortBy){
                                    if($sortBy =='view'){                
                                        $q->whereIn('application_status',['view','consider']);
                                    }elseif($sortBy !='all'){           
                                        $q->whereApplicationStatus($sortBy);
                                    }
                               })->whereHas('job', function($q1){
                                    $q1->whereNotNull('slug');
                               })->orderBy('created_at','asc')
                                 ->paginate(10);
                   
        return $this->sendResponse($jobs);              

    }
    
    public function savedJobsList(Request $request)
    {      
        $user_id = Auth::user()->id;
        $jobs = FavouriteJob::where('user_id',$user_id)
                            ->orderBy('created_at','asc')
                            ->paginate(10);

        return $this->sendResponse($jobs);  
    }

}