<?php

namespace App\Http\Controllers\Api\Job;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Model\JobApply;
use App\Model\Job;
use App\Model\JobSearch;
use App\Helpers\DataArrayHelper;
use App\Traits\FetchJobsList;
use App\Traits\BlockedKeywords;
use App\Model\JobScreeningQuiz;
use App\Http\Requests\Api\Job\JobSearchRequest;

class JobsController extends BaseController
{
    //
    use FetchJobsList, BlockedKeywords;

    public function searchJob(JobSearchRequest $request)
    {

        $filters = $jobs = $filter = $citylFGid  = $salaryFGid = $jobtypeFGid = $jobshiftFGid = $edulevelFGid = $wfhtypeFid = $industrytypeGid = $functionalareaGid = array();

        $sortBy = $request->sortBy??'relevance';
        $experienceFid = $request->experinceFv??'';
        $designation = $request->designation??'';
        $location = $request->location??'';
        $words = DataArrayHelper::blockedKeywords();

        $dbk = $this->checkTitleBlockedKeywords($designation, $words);
        $lbk = $this->checkLocationBlockedKeywords($location, $words);

        if($dbk == 'yes' && $lbk == 'yes'){
            $joblist = JobSearch::where('id',0)->paginate(15);
            $filters = array();
        }else{
            if(isset($request->citylFGid)){
                $citylFGid = explode(',',$request->citylFGid);
            }
            if(isset($request->salaryFGid)){
                $salaryFGid = explode(',',$request->salaryFGid);
            }
            if(isset($request->jobtypeFGid)){
                $jobtypeFGid = explode(',',$request->jobtypeFGid);
            }
            if(isset($request->jobshiftFGid)){
                $jobshiftFGid = explode(',',$request->jobshiftFGid);
            }
            if(isset($request->edulevelFGid)){
                $edulevelFGid = explode(',',$request->edulevelFGid);
            }
            if(isset($request->wfhtypeFid)){
                $wfhtypeFid = explode(',',$request->wfhtypeFid);
            }
            if(isset($request->industrytypeGid)){
                $industrytypeGid = explode(',',$request->industrytypeGid);
            }
            if(isset($request->functionalareaGid)){
                $functionalareaGid = explode(',',$request->functionalareaGid);
            }
            $filter['experienceFid']  = $experienceFid;        
            $filter['citylFGid']  = count($citylFGid)!=0?',('.implode('|',$citylFGid).'),':'';
            $filter['jobtypeFGid']  = count($jobtypeFGid)!=0?',('.implode('|',$jobtypeFGid).'),':'';
            $filter['jobshiftFGid']  = count($jobshiftFGid)!=0?',('.implode('|',$jobshiftFGid).'),':''; 
            $filter['salaryFGid']  = $salaryFGid;
            $filter['edulevelFGid']  = $edulevelFGid;
            $filter['wfhtypeFid']  = $wfhtypeFid;
            $filter['industrytypeGid']  = $industrytypeGid;
            $filter['functionalareaGid']  = $functionalareaGid;
            $filter['sortBy']  = $sortBy;
            
            $jobs = $this->fetchJobs($designation, $location, $filter, 15);

            $joblist = $jobs['joblist'];           
            $filters = $jobs['filters'];

        }
        
        if(Auth::check()){
            $datas = $joblist->toArray();
            $jobids = array_column($datas['data'], 'job_id');
            $appliedjodids = JobApply::where('user_id',Auth::user()->id)->whereIn('job_id',$jobids)->pluck('job_id')->toArray();
        }
        
        $response = array(
                        'designation' => $designation, 
                        'location' => $location,
                        'joblist' => $joblist,    
                        'appliedJobids' => $appliedjodids??array(),                           
                        'filters' => $filters,
                        'sortBy' => $sortBy
                    );

        return $this->sendResponse($response);
    }

    public function jobDetail($slug)
    {  
        
        $job = Job::whereSlug($slug)->first(); 
        if($job==NULL){
            return $this->sendError('No Job Available.'); 
        }
        unset($job->job_work_location);
        unset($job->jobbenefits);
        unset($job->jobsupplementals);
        $breakpoint = JobScreeningQuiz::whereJobId($job->id)->whereBreakpoint('yes')->first();
        $response = array(
                'job' => $job, 
                'company_slug' => $job->company->slug??'', 
                'breakpoint' => $breakpoint
            );
        return $this->sendResponse($response);
    }

    public function companyDetail($slug)
    {
        $companies= Company::where('slug', $slug)->pluck('id')->first();
        $company = Company::find($companies);
        $company_jobs=$company->getOpenJobs();

        $response = array(
            'company' => $company, 
            'company_jobs' => $company_jobs,
        );
        return $this->sendResponse($response);
    }
    

}
