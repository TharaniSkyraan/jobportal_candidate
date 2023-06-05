<?php

namespace App\Http\Controllers\Api\Job;

use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Model\JobApply;
use App\Model\Job;
use App\Model\JobSearch;
use App\Model\Company;
use App\Model\User;
use App\Helpers\DataArrayHelper;
use App\Traits\FetchJobsList;
use App\Traits\BlockedKeywords;
use App\Model\ProfilePercentage;
use App\Model\JobScreeningQuiz;
use App\Http\Requests\Api\Job\JobSearchRequest;

class JobsController extends BaseController
{
    //
    use FetchJobsList, BlockedKeywords;

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id??710;        
        $user = User::find($user_id);
        $appliedjobs = JobApply::where('user_id',$user_id)
                        ->where('application_status',['view','shortlist','consider'])
                        ->take(3)
                        ->orderBy('created_at','desc')
                        ->get();
        $appliedlist = [];
        foreach($appliedjobs as $job)
        {
            if(isset($job->job))
            {                    
                $appliedlist[] = array(
                    'slug' => $job->job->slug,
                    'title' => $job->job->title??'Php Developer',
                    'company_name' => $job->job->company_name??'Skyraan',
                    'company_image' => $job->job->company->company_image??'',
                    'status' => $job->application_status,
                    'applied_at' => strtotime($job->created_at),
                    'status_updated_at' => strtotime($job->updated_at),
                );
            }
        }
        

        $jobs = $this->fetchJobs($user->career_title, '', [], 5);
        // $jobs = $this->fetchJobs('', '', [], 15);
        
        $jobs->each(function ($job, $key) use($user) {
            $jobc = Job::find($job->job_id);
            $job['company_image'] = $jobc->company->company_image??'';
            $job['job_type'] = $jobc->getTypesStr();
            $job['skills'] = $jobc->getSkillsStr();
            $job['posted_at'] = strtotime($jobc->posted_date);
            $job['is_applied'] = $user->isAppliedOnJob($job->job_id);
        });   
        $joblist = $jobs['joblist']->items();     

        $userData = array(
                'name' => $user->getName(),
                'final_percentage' => $user->getProfilePercentage(),
                'image' => $user->image,
                'career_title' => $user->career_title,
                'updated_at' => strtotime($user->updated_at),  
                'resume' => $user->getDefaultCv()->cv_file,            
                'location' => $user->location,            
            );

        $response = array(
                        'appliedlist' => $appliedlist, 
                        'jobs' => $joblist, 
                        'user' => $userData, 
                    );

        return $this->sendResponse($response);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchJob(JobSearchRequest $request)
    {

        $user_id = Auth::user()->id??710;
        $user = User::find($user_id);
        $filters = $jobs = $filter = $citylFGid  = $salaryFGid = $jobtypeFGid = $jobshiftFGid = $edulevelFGid = $wfhtypeFid = $industrytypeGid = $functionalareaGid = array();

        $sortBy = $request->sortBy??'relevance';
        $experienceFid = $request->experinceFv??'';
        $posteddateFid = $request->posteddateFid??'';
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
            $filter['posteddateFid']  = $posteddateFid;
            $filter['sortBy']  = $sortBy;
            
            $jobs = $this->fetchJobs($designation, $location, $filter, 15);
            
            $jobs->each(function ($job, $key) use($user) {
                $jobc = Job::find($job->job_id);
                $job['company_image'] = $jobc->company->company_image??'';
                $job['job_type'] = $jobc->getTypesStr();
                $job['skills'] = $jobc->getSkillsStr();
                $job['posted_at'] = strtotime($jobc->posted_date);
                $job['is_applied'] = $user->isAppliedOnJob($job->job_id);
            });   
            $joblist = $jobs['joblist']->items();     

            $joblist = $joblist;
            $filters = $jobs['filters'];
        
        }
        
        $response = array(
                        'designation' => $designation, 
                        'location' => $location,
                        'joblist' => $joblist,    
                        'next_page' => (!empty($jobs['joblist']->nextPageUrl())?($jobs['joblist']->currentPage()+1):""),
                        'filters' => $filters,
                        'sortBy' => $sortBy
                    );

        return $this->sendResponse($response);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function jobDetail($slug)
    {  
        
        $user_id = Auth::user()->id??710;
        $user = User::find($user_id);
        $job = Job::whereSlug($slug)->with(['screeningquiz'])->first(); 
        if($job==NULL){
            return $this->sendError('No Job Available.'); 
        }
        $jobs = $this->fetchJobs($job->title, '', [], 10);
        $jobs->each(function ($job, $key) use($user) {
            $jobc = Job::find($job->job_id);
            $job['company_image'] = $jobc->company->company_image??'';
            $job['location'] = $job->work_locations;
            $job['job_type'] = $jobc->getTypesStr();
            $job['skills'] = $jobc->getSkillsStr();
            $job['posted_at'] = strtotime($jobc->posted_date);
            $job['is_applied'] = $user->isAppliedOnJob($job->id);
            $job['skillmatches'] = $user->profileMatch($job->id);
        });   
        $joblist = $jobs['joblist']->items();     

        $breakpoint = JobScreeningQuiz::whereJobId($job->id)->whereBreakpoint('yes')->first();
        $response = array(
                'job' => $job, 
                'relevant_job' => $joblist, 
                'company_slug' => $job->company->slug??'', 
                'breakpoint' => $breakpoint
            );
        return $this->sendResponse($response);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
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
    
    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function advancedFilter()
    {
        $queries = JobSearch::whereIsActive(1);

        $filters = $this->getFilters($queries);
        return $this->sendResponse($filters);
    }

}
