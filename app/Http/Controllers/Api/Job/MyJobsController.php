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
use App\Model\JobAnalytics;
use App\Model\JobQuizCandidateAnswer;
use App\Model\JobScreeningQuiz;
use App\Model\FavouriteJob;
use App\Model\JobAlert;
use App\Model\User;
use App\Http\Requests\Api\Job\SaveJobAlert;
use App\Traits\FetchJobsList;
use Carbon\Carbon;

class MyJobsController extends BaseController
{

    use JobTrait;

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function ApplyJob(Request $request, $job_slug)
    {
        
        $user_id = Auth::user()->id??710;
        $user = User::find($user_id);
        $job = Job::where('slug', 'like', $job_slug)->first();
        $message = "You have already applied for this job";
        if($user->isAppliedOnJob($job->id)==false)
        {
            $jobApply = new JobApply();
            $jobApply->user_id = $user_id;
            $jobApply->job_id = $job->id;
            $jobApply->percentage = $user->profileMatch($job->id);
            $jobApply->save();
            
            $jobanalytics =  new JobAnalytics();
            $jobanalytics->job_apply_id = $jobApply->id;
            $jobanalytics->job_id = $job->id;
            $jobanalytics->save();

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

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function appliedJobsList(Request $request)
    {      
        $user_id = Auth::user()->id??710;
        $user = User::find($user_id);
        $sortBy = $request->sortBy??'all';
        // shortlist // view
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
                             
        $appliedjobs = array_map(function ($appliedjob) use($user) {
            $job = Job::find($appliedjob['job_id']);
            $val = array(
                'id'=>$appliedjob['id'],
                'job_id'=>$job->id,
                'slug'=>$job->slug,
                'title'=>$job->title,
                'description'=>$job->description,
                'location'=>$job->work_locations,
                'company_image'=>$job->company->company_image??'',
                'company_name'=>$job->company->name??'',
                'experience'=>$job->experience_string,
                'salary'=>$job->salary_string,
                'immediate_join' => $job->NoticePeriod !=null?$job->NoticePeriod->notice_period:'',
                'is_favourite'=>$user->isFavouriteJob($job->slug),
                'job_type'=>$job->getTypesStr(),
                'skills'=>$job->getSkillsStr(),
                'posted_at'=>Carbon::parse($job->posted_date)->getTimestampMs(),
                'created_at'=>Carbon::parse($appliedjob['created_at'])->getTimestampMs(),                               
            );
            return $val;
        }, $jobs->toArray()['data']); 
        
        $response['jobs'] = $appliedjobs;
        $response['next_page'] = (!empty($jobs->nextPageUrl())?($jobs->currentPage()+1):"");
        $response['no_of_pages'] = $jobs->lastPage()??0;
        
        return $this->sendResponse($response);              

    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function Savejob(Request $request, $job_slug)
    {

        $save_as_fav = $request->fav;
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

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function savedJobsList(Request $request)
    {      
        $user_id = Auth::user()->id??710;
        $user = User::find($user_id);
        $sortBy = $request->sortBy;
        $orderBy = $request->orderBy;
        // 1 - active // 3 expired // 2 inactive
        $jobs = FavouriteJob::where('user_id',$user_id)
                            ->whereHas('job', function($q) use($sortBy, $orderBy){                                    
                                $q->where(function($q) use($sortBy){
                                    if($sortBy !='all')
                                    {  
                                        if($sortBy =='expired')
                                        {  
                                            $q->where('is_active',3);
                                        }else{
                                            $q->where('is_active','!=',3);
                                        }
                                    }
                                });
                            })->orderBy('created_at',$orderBy)
                             ->paginate(10);
                            
        $savedjobs = array_map(function ($savedjob) use($user) 
                        {
                            $job = Job::find($savedjob['job_id']);
                            $val = array(
                                'id'=>$savedjob['id'],
                                'job_id'=>$job->id,
                                'slug'=>$job->slug,
                                'title'=>$job->title,
                                'description'=>$job->description,
                                'location'=>$job->work_locations,
                                'company_image'=>$job->company->company_image??'',
                                'company_name'=>$job->company->name??'',
                                'experience'=>$job->experience_string,
                                'salary'=>$job->salary_string,
                                'immediate_join' => $job->NoticePeriod !=null?$job->NoticePeriod->notice_period:'',
                                'job_type'=>$job->getTypesStr(),
                                'skills'=>$job->getSkillsStr(),
                                'posted_at'=>Carbon::parse($job->posted_date)->getTimestampMs(),
                                'created_at'=>Carbon::parse($savedjob['created_at'])->getTimestampMs(),
                                'is_applied'=>$user->isAppliedOnJob($job->id),
                                'is_favourite' => $user->isFavouriteJob($job->slug)
                            );
                            return $val;
                        }, $jobs->toArray()['data']); 
        
        $response['jobs'] = $savedjobs;
        $response['next_page'] = (!empty($jobs->nextPageUrl())?($jobs->currentPage()+1):"");
        $response['no_of_pages'] = $jobs->lastPage()??0;
       
        return $this->sendResponse($response); 
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function savedJobsids()
    {     

        $slugs = Auth::user()->getFavouriteJobSlugsArray();
        
        $jobsids = Job::whereIn('slug',$slugs)->pluck('id')->toArray();

        $response['jobs'] = $jobsids;
       
        return $this->sendResponse($response); 

    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function Savejobalert(SaveJobAlert $request)
    {
        $id = $request->id;

        if($id){            
            $jobFav                     = JobAlert::find($id);
        }else{
            $jobFav                     = new JobAlert();
            $jobFav->user_id            = Auth::user()->id;
        }

        $jobFav->title              = $request->title;
        $jobFav->location           = $request->location;
        $jobFav->citylFGid          = $request->citylFGid;
        $jobFav->salaryFGid         = $request->salaryFGid;
        $jobFav->jobtypeFGid        = $request->jobtypeFGid;
        $jobFav->jobshiftFGid       = $request->jobshiftFGid;
        $jobFav->edulevelFGid       = $request->edulevelFGid;
        $jobFav->wfhtypeFid         = $request->wfhtypeFid;
        $jobFav->industrytypeGid    = $request->industrytypeGid;
        $jobFav->functionalareaGid  = $request->functionalareaGid;
        $jobFav->posteddateFid      = $request->posteddateFid;
        $jobFav->experienceFid      = $request->experienceFid;
        $jobFav->save();

        $message = "You have successfully saved this job";

        return $this->sendResponse($jobFav, $message);

    }
    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function JobalertList()
    {
        $user_id = Auth::user()->id??1;
        $user = User::find($user_id);
        $list = JobAlert::select('id','title','location','created_at')
                        ->whereUserId($user_id)
                        ->orderBy('created_at','asc')
                        ->paginate(10);
        
        $list->each(function ($job, $key) use($user) {
            $alert = JobAlert::find($job->id);
            $job['saved_at'] = Carbon::parse($job->created_at)->getTimestampMs();
            $job['industrytype'] = implode(",",$alert->getIndustryType());
            $job['functionalarea'] = implode(",",$alert->getFunctionalArea());
            $job['edulevel'] = implode(",",$alert->getEducationLevel());
            $job['jobtype'] = implode(",",$alert->getJobType());
            $job['jobshift'] = implode(",",$alert->getShift());
            $job['wfhtype'] = $alert->getWFH();
            $job['salary'] = $alert->getSalary();
            $job['posteddate'] = $alert->getDatePosted();
            $job['experience'] = $alert->experienceFid??'';

            $job['industrytypeGid'] = $alert->industrytypeGid??'';
            $job['functionalareaGid'] = $alert->functionalareaGid??'';
            $job['edulevelFGid'] = $alert->edulevelFGid??'';
            $job['jobtypeFGid'] = $alert->jobtypeFGid??'';
            $job['jobshiftFGid'] = $alert->jobshiftFGid??'';
            $job['wfhtypeFid'] = $alert->wfhtypeFid??'';
            $job['salaryFGid'] = $alert->salaryFGid??'';
            $job['posteddateFid'] = $alert->posteddateFid??'';
            $job['experienceFid'] = $alert->experienceFid??'';
        });
        $response['jobs'] = $list->items();
        $response['next_page'] = (!empty($list->nextPageUrl())?($list->currentPage()+1):"");
        $response['no_of_pages'] = $list->lastPage()??0;
       
        return $this->sendResponse($response);  
    }
    
    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function DeleteJobalert($id)
    {
        JobAlert::find($id)->delete();
        $message = "You have remove from job alert"; 
        return $this->sendResponse('', $message);
    }
    
}