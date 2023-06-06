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
     * return Success json response.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id??710;        
        $user = User::find($user_id);
        $appliedjobs = JobApply::where('user_id',$user_id)
                        ->whereIn('application_status',['view','shortlist','consider'])
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
        
        $jobs['joblist']->each(function ($job, $key) use($user) {
            $jobc = Job::find($job->job_id);
            $job['company_image'] = $jobc->company->company_image??'';
            $job['job_type'] = $jobc->getTypesStr();
            $job['skills'] = $jobc->getSkillsStr();
            $job['posted_at'] = strtotime($jobc->posted_date);
            $job['is_applied'] = $user->isAppliedOnJob($job->job_id);
            $job['is_favourite'] = $user->isFavouriteJob($job->slug);
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
                        'jobs' => $joblist, 
                        'user' => $userData, 
                        'appliedlist' => $appliedlist
                    );

        return $this->sendResponse($response);
    }

    /**
     * return Success json response.
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
            $citylFGid = $request->citylFGid;
            $salaryFGid = $request->salaryFGid;
            $jobtypeFGid = $request->jobtypeFGid;
            $jobshiftFGid = $request->jobshiftFGid;
            $edulevelFGid = $request->edulevelFGid;
            $wfhtypeFid = $request->wfhtypeFid;
            $industrytypeGid = $request->industrytypeGid;
            $functionalareaGid = $request->functionalareaGid;

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
            
            $jobs['joblist']->each(function ($job, $key) use($user) {
                $jobc = Job::find($job->job_id);
                $job['company_image'] = $jobc->company->company_image??'';
                $job['job_type'] = $jobc->getTypesStr();
                $job['skills'] = $jobc->getSkillsStr();
                $job['posted_at'] = strtotime($jobc->posted_date);
                $job['is_applied'] = $user->isAppliedOnJob($job->job_id);
                $job['is_favourite'] = $user->isFavouriteJob($job->slug);
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
     * return Success json response.
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
        $exclude_days = isset($job->walkin->exclude_days)?'(Excluding'. $job->walkin->exclude_days.')':'';
        $job_skill_id = $job->getSkillsArray();
        $skills = DataArrayHelper::langSkillsArray();

        dd($skills);
        
        $jobd = array(
            'id'=>$job->id,
            'slug'=>$job->slug,
            'title'=>$job->title,
            'description'=>$job->description,
            'location'=>$job->work_locations,
            'company_image'=>$job->company->company_image??'',
            'company_name'=>$job->company->name??'',
            'experience'=>$job->experience_string,
            'salary'=>$job->salary_string,
            'job_type'=>$job->getTypesStr(),
            'skills'=>$job->getSkillsArray(),
            'supplementals'=>$job->supplementals,
            'benefits'=>$job->benefits,
            'education_level'=>$job->getEducationLevel('education_level'),
            'education_type'=>$job->getEducationTypesStr(),
            'posted_at'=>strtotime($job->posted_date),
            'is_applied'=>$user->isAppliedOnJob($job->id),
            'is_favourite'=>$user->isFavouriteJob($job->slug),
            'walkin' => isset($job->walkin)?'yes':'no',
            'walkin_date' => (isset($job->walkin)?(Carbon::parse($job->walkin->walk_in_from_date)->format('d F, Y').' to '.Carbon::parse($job->walkin->walk_in_to_date)->format('d F, Y')).$exclude_days:''),
            'walkin_time' => (isset($job->walkin)?(Carbon::parse($job->walkin->walk_in_from_time)->format('H:i A').' to '.Carbon::parse($job->walkin->walk_in_to_time)->format('H:i A')):''),
            'contact_name'=>$job->contact_person_details->name??'',
            'contact_email'=>$job->contact_person_details->email??'',
            'contact_phone'=>$job->contact_person_details->phone_1??'',
            'contact_alternative'=>$job->contact_person_details->phone_2??'',
       
        );

        $jobs = $this->fetchJobs($job->title, '', [], 10);
        $jobs['joblist']->each(function ($job, $key) use($user) {
            $jobc = Job::find($job->job_id);
            $job['company_image'] = $jobc->company->company_image??'';
            $job['location'] = $job->work_locations;
            $job['job_type'] = $jobc->getTypesStr();
            $job['skills'] = $jobc->getSkillsStr();
            $job['posted_at'] = strtotime($jobc->posted_date);
            $job['is_applied'] = $user->isAppliedOnJob($job->id);
            $job['is_favourite'] = $user->isFavouriteJob($job->slug);
            $job['skillmatches'] = $user->profileMatch($job->id);
        });   
        $joblist = $jobs['joblist']->items();     

        $breakpoint = JobScreeningQuiz::whereJobId($job->id)->whereBreakpoint('yes')->first();
        $response = array(
                'job' => $jobd, 
                'relevant_job' => $joblist, 
                'company_slug' => $job->company->slug??'', 
                'breakpoint' => $breakpoint??''
            );
        return $this->sendResponse($response);
    }

    /**
     * return Success json response.
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
     * return Success json response.
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
