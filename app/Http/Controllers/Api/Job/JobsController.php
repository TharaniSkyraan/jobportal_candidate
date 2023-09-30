<?php

namespace App\Http\Controllers\Api\Job;

use DB;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Model\UserActivity;
use App\Model\JobApply;
use App\Model\Job;
use App\Model\JobSearch;
use App\Model\Companygalary;
use App\Model\Company;
use App\Model\User;
use App\Helpers\DataArrayHelper;
use App\Traits\FetchJobsList;
use App\Traits\BlockedKeywords;
use App\Model\ProfilePercentage;
use App\Model\JobScreeningQuiz;
use App\Model\JobWorkLocation;
use App\Http\Requests\Api\Job\JobSearchRequest;
use App\Model\Industry;

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
                        ->take(4)
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
                    'applied_at' => Carbon::parse($job->created_at)->getTimestampMs(),
                    'status_updated_at' => Carbon::parse($job->updated_at)->getTimestampMs(),
                );
            }
        }

        $jobs = $this->fetchJobs($user->career_title, '', [], 5);
        
        $jobs['joblist']->each(function ($job, $key) use($user) {
            $jobc = Job::find($job->job_id);
            $job['company_image'] = $jobc->company->company_image??'';
            $job['job_type'] = $jobc->getTypesStr();
            $job['skills'] = $jobc->getSkillsStr();
            $job['posted_at'] = Carbon::parse($jobc->posted_date)->getTimestampMs();
            $job['is_applied'] = $user->isAppliedOnJob($job->job_id);
            $job['is_favourite'] = $user->isFavouriteJob($jobc->slug);
        });   
        $joblist = $jobs['joblist']->items();     

        $userData = array(
                'name' => $user->getName(),
                'final_percentage' => $user->getProfilePercentage(),
                'image' => $user->image,
                'career_title' => $user->career_title,
                'updated_at' => Carbon::parse($user->updated_at)->getTimestampMs(),  
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
    public function fresherIndex()
    {
        $top_cities = JobWorkLocation::whereHas('job',function($q){
                                        $q->where('work_from_home','!=','permanent')
                                          ->whereIsActive(1);
                                    })
                                    ->select('city','city_id', DB::raw('count(`job_id`) as total_count'))
                                    ->groupBy('city_id')
                                    ->groupBy('city')
                                    ->havingRaw("total_count != 0")
                                    ->orderBy('total_count','DESC')
                                    ->limit(10)
                                    ->get();
        
        $top_cities->each(function ($tcity, $key) {
            $sector = Industry::whereHas('jobsearch', function($q) use($tcity){
                            $q->where('city', 'REGEXP', $tcity->city_id);
                        })->withCount('jobsearch')
                        ->orderBy('jobsearch_count','DESC')
                        ->havingRaw("jobsearch_count != 0")
                        ->limit(3)
                        ->get();
            $sector->makeHidden(['lang','industry_id','is_active','sort_order','is_default','created_at','updated_at']);
            
            $tcity['sectors'] = $sector;
        });                                
        
        $top_cities->makeHidden(['city_id','total_count']);

        $sectors = Industry::withCount('jobsearch')
                            ->orderBy('jobsearch_count','DESC')
                            ->havingRaw("jobsearch_count != 0")
                            ->limit(15)
                            ->get();
        $sectors->makeHidden(['lang','industry_id','is_active','sort_order','is_default','created_at','updated_at']);

        $response = array(
            'top_cities' => $top_cities,
            'sectors' => $sectors
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
        if(Auth::check()){
            UserActivity::updateOrCreate(['user_id' => Auth::user()->id],['last_active_at'=>Carbon::now()]);
        }

        $user_id = Auth::user()->id??710;
        $user = User::find($user_id);
        $filters = $jobs = $filter = $citylFGid  = $salaryFGid = $jobtypeFGid = $jobshiftFGid = $edulevelFGid = $wfhtypeFid = $industrytypeGid = $functionalareaGid = $posteddateFid = array();

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
            if(isset($request->posteddateFid)){
                $posteddateFid = explode(',',$request->posteddateFid);
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
            
            $jobs = $this->fetchJobs($designation, $location, $filter, 0);
            
            $jobs['joblist']->each(function ($job, $key) use($user) {
                $jobc = Job::find($job->job_id);
                $job['company_image'] = $jobc->company->company_image??'';
                $job['job_type'] = $jobc->getTypesStr();
                $job['skills'] = $jobc->getSkillsStr();
                $job['posted_at'] = Carbon::parse($jobc->posted_date)->getTimestampMs();
                $job['is_applied'] = $user->isAppliedOnJob($job->job_id);
                $job['is_favourite'] = $user->isFavouriteJob($jobc->slug);
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
                        'sortBy' => $sortBy,
                        'no_of_pages' => $jobs['joblist']->lastPage()??0
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
        $jobapplied = JobApply::whereJobId($job->id)
                              ->whereUserId($user_id)
                              ->first();
        $exclude_days = isset($job->walkin->exclude_days)?'(Excluding'. $job->walkin->exclude_days.')':'';
        $job_skill_id = explode(',',$job->getSkillsStr());
        $skills = explode(',',$user->getUserSkillsStr('skill'));
        $skill = array_intersect($job_skill_id,$skills);
        $shortlist = (isset($jobapplied->application_status)?(!empty($jobapplied->application_status)?$jobapplied->application_status:''):'');
        $applied_at = (isset($jobapplied->created_at)?(!empty($jobapplied->created_at)?$jobapplied->created_at:''):'');
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
            'skills'=>$job->getSkillsStr(),
            'match_skills'=>implode(',',$skill),
            'supplementals'=>$job->supplementals,
            'benefits'=>$job->benefits,
            'education_level'=>$job->getEducationLevel('education_level'),
            'education_type'=>$job->getEducationTypesStr(),
            'posted_at'=>Carbon::parse($job->posted_date)->getTimestampMs(),
            'immediate_join' => $job->NoticePeriod !=null?$job->NoticePeriod->notice_period:'',
            'walkin' => isset($job->walkin)?'yes':'no',
            'walkin_date' => (isset($job->walkin)?(Carbon::parse($job->walkin->walk_in_from_date)->format('d F, Y').' to '.Carbon::parse($job->walkin->walk_in_to_date)->format('d F, Y')).$exclude_days:''),
            'walkin_time' => (isset($job->walkin)?(Carbon::parse($job->walkin->walk_in_from_time)->format('H:i A').' to '.Carbon::parse($job->walkin->walk_in_to_time)->format('H:i A')):''),
            'contact_name'=>$job->contact_person_details->name??'',
            'contact_email'=>$job->contact_person_details->email??'',
            'contact_phone'=>$job->contact_person_details->phone_1??'',
            'contact_alternative'=>$job->contact_person_details->phone_2??'',
            'skillmatches' => $user->profileMatch($job->id),
            'is_applied'=>$user->isAppliedOnJob($job->id),
            'is_favourite'=>$user->isFavouriteJob($job->slug),
            'shortlist'=>$shortlist,
            'applied_at'=>(!empty($applied_at)?Carbon::parse($applied_at)->getTimestampMs():0),
            'website_url'=>$job->company->website_url??'',
            'linkedin_url'=>$job->company->linkedin_url??'',
            'twitter_url'=>$job->company->twitter_url??'',
            'fb_url'=>$job->company->fb_url??'',
            'insta_url'=>$job->company->insta_url??'',
        );

        $jobs = $this->fetchJobs($job->title, '', [], 10);
        $jobs['joblist']->each(function ($rjob, $key) use($user) {
            $jobc = Job::find($rjob->job_id);
            $rjob['company_image'] = $jobc->company->company_image??'';
            $rjob['location'] = $rjob->work_locations;
            $rjob['job_type'] = $jobc->getTypesStr();
            $rjob['skills'] = $jobc->getSkillsStr();
            $rjob['posted_at'] = Carbon::parse($jobc->posted_date)->getTimestampMs();
            $rjob['is_applied'] = $user->isAppliedOnJob($jobc->id);
            $rjob['is_favourite'] = $user->isFavouriteJob($jobc->slug);
        });   
        $joblist = $jobs['joblist']->items();     

        $breakpoint = JobScreeningQuiz::whereJobId($job->id)->whereBreakpoint('yes')->first();
        $screening = JobScreeningQuiz::whereJobId($job->id)
                                     ->select('quiz_code','answer_type','candidate_options','candidate_question as question','breakpoint')
                                     ->get()
                                     ->each(function ($screeningquiz, $key) {
                                        $screeningquiz['options'] = $screeningquiz->candidate_options?json_decode($screeningquiz->candidate_options):[];
                                     });
        $response = array(
                'job' => $jobd, 
                'relevant_job' => $joblist, 
                'company_slug' => $job->company->slug??'', 
                'breakpoint' => $breakpoint?'yes':'no',
                'have_screening' => JobScreeningQuiz::whereJobId($job->id)->count(),
                'screening_quiz' => $screening
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
        $user_id = Auth::user()->id??710;
        $user = User::find($user_id);
        $companies= Company::where('slug', $slug)->pluck('id')->first();
        $company = Company::find($companies);
        $company->country_name = $company->getCountry('country')??'';
        $company_jobs = Job::where('company_id', $companies)
                         ->whereIsActive(1)
                        //  ->whereDate('expiry_date', '>', Carbon::now())
                         ->get()->toArray();
        $gallery=Companygalary::whereCompanyId($companies)->get();
        $company->founded_on = $company->founded_on??0;
        $company->insta_url = $company->insta_url??'';
        $company->fb_url = $company->fb_url??'';
        $company->linkedin_url = $company->linkedin_url??'';
        $company->twitter_url = $company->twitter_url??'';
        $company->CEO_name = $company->CEO_name??'';
        $company->website = $company->website??'';
        $company->company_image = $company->company_image??"";
        $companyjobs = array_map(function ($companyjob) use($user) {
            $job = Job::find($companyjob['id']);
            $val = array(
                'id'=>$companyjob['id'],
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
                'is_applied'=>$user->isAppliedOnJob($job->id),
            );
            return $val;
        }, $company_jobs); 
        
        $response = array(
            'company' => $company, 
            'company_jobs' => $companyjobs,
            'gallery' => $gallery
        );
        return $this->sendResponse($response);
    }
    
    /**
     * return Success json response.
     *
     * @return \Illuminate\Http\Response
     */
    public function advancedFilter($jobalert='')
    {
        if(empty($jobalert)){

            $queries = JobSearch::whereIsActive(1);

            $filters = $this->getFilters($queries);
        }else{
            $filters = $this->getFilters();
        }
        return $this->sendResponse($filters);
    }
}
