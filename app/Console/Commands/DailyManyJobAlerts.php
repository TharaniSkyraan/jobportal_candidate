<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\FetchJobsList;
use App\Traits\BlockedKeywords;
use App\Helpers\DataArrayHelper;
use Illuminate\Http\Request;
use App\Mail\JobAlertMailable;
use App\Model\JobAlert;
use App\Model\UserActivity;
use App\Model\User;
use Carbon\Carbon;
use Mail;


class DailyManyJobAlerts extends Command
{
    use FetchJobsList, BlockedKeywords;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'many:jobalert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Request $request)
    { 
     
        $from = Carbon::now()->subDays(7)->startOfDay();
        $to = Carbon::now()->endOfDay();
        $jobalerts = JobAlert::whereHas('user', function($q) use($from,$to){
                                $q->whereHas('UserActivity',function($q1) use($from,$to){
                                    $q1->where('last_active_at', '>=' ,$from)
                                        ->where('last_active_at', '<=' ,$to);
                                });
                            })->get();
        foreach($jobalerts as $jobalert)
        {

            $data = $jobalert;       
            $user = User::find($jobalert->user_id);
            $filters = $jobs = $filter = $citylFGid  = $salaryFGid = $jobtypeFGid = $jobshiftFGid = $edulevelFGid = $wfhtypeFid = $posteddateFid = array();
        
            $sortBy = 'relevance';
            $experienceFid = ($jobalert->experienceFid!=0)?$jobalert->experienceFid:'';
            $designation = $jobalert->title??'';
            $location = $jobalert->location??'';
            $limit = 6;
            $words = DataArrayHelper::blockedKeywords();
        
            $dbk = $this->checkTitleBlockedKeywords($designation, $words);
            $lbk = $this->checkLocationBlockedKeywords($location, $words);
        
            if($dbk != 'yes' && $lbk != 'yes'){
                
                if(!empty($jobalert->salaryFGid)){
                    $salaryFGid = explode(',',$jobalert->salaryFGid);
                }
                if(!empty($jobalert->jobtypeFGid)){
                    $jobtypeFGid = explode(',',$jobalert->jobtypeFGid);
                }
                if(!empty($jobalert->jobshiftFGid)){
                    $jobshiftFGid = explode(',',$jobalert->jobshiftFGid);
                }
                if(!empty($jobalert->edulevelFGid)){
                    $edulevelFGid = explode(',',$jobalert->edulevelFGid);
                }
                if(!empty($jobalert->wfhtypeFid)){
                    $wfhtypeFid = explode(',',$jobalert->wfhtypeFid);
                }
                if(!empty($jobalert->posteddateFid)){
                    $posteddateFid = explode(',',$jobalert->posteddateFid);
                }
                $appliedIds = $user->getAppliedJobIdsArray();
                $jobIds = (isset($user->UserActivity))?explode(',',$user->UserActivity->job_ids):array();
                $filter['experienceFid']  = $experienceFid;        
                $filter['citylFGid']  = count($citylFGid)!=0?',('.implode('|',$citylFGid).'),':'';
                $filter['jobtypeFGid']  = count($jobtypeFGid)!=0?',('.implode('|',$jobtypeFGid).'),':'';
                $filter['jobshiftFGid']  = count($jobshiftFGid)!=0?',('.implode('|',$jobshiftFGid).'),':''; 
                $filter['salaryFGid']  = $salaryFGid;
                $filter['edulevelFGid']  = $edulevelFGid;
                $filter['wfhtypeFid']  = $wfhtypeFid;
                $filter['posteddateFid']  = $posteddateFid;
                $filter['jobIds']  = array_merge($jobIds,$appliedIds);
                $filter['sortBy']  = $sortBy;
                $jobs = $this->fetchJobs($designation, $location, $filter, $limit);
                            
                $request['designation'] = $designation??'';
                $request['location'] = $location??'';
                $checkKeywords = $this->checkKeywords($request, $designation, $location);
                $jobs = $jobs['joblist']->items();
                $jobId = array_column($jobs, 'job_id');
                array_pop($jobId);
                UserActivity::updateOrCreate(['user_id' => $user->id],['job_ids'=>implode(',',array_merge($jobIds,$jobId))]);
                $slug = $checkKeywords['sl'];
                
         
                if($jobs->count()!=0){
                    Mail::send(new JobAlertMailable($data,$jobs,$slug,$limit));   
                } 
            }
        }
    }
    
}
