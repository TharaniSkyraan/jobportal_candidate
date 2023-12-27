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
use App\Model\JobViewedCandidate;
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
                        ->whereIn('application_status',['shortlist'])
                        ->whereIsRead(1)
                        // ->whereIn('application_status',['view','shortlist','consider'])
                        ->take(4)
                        ->orderBy('updated_at','desc')
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

        $filter = array();
        $filter['sortBy'] = 'date';
        $jobs = $this->fetchJobs($user->career_title,'', $filter, 5);
        
        $jobs['joblist']->each(function ($job, $key) use($user) {
            $jobc = Job::find($job->job_id);
            $job['company_image'] = $jobc->company->company_image??'';
            $job['job_type'] = $jobc->getTypesStr();
            $job['skills'] = $jobc->getSkillsStr();
            $job['posted_at'] = Carbon::parse($jobc->posted_date)->getTimestampMs();
            $job['is_applied'] = $user->isAppliedOnJob($job->job_id);
            $job['is_favourite'] = $user->isFavouriteJob($jobc->slug);
            $job['is_deleted'] = (!empty($jobc->deleted_at))?0:1; 
        });   
        $joblist = $jobs['joblist']->items();     

        $response = array(
                        'jobs' => $joblist, 
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
        $user_id = Auth::user()->id??710;        
        $user = User::find($user_id);

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

            $sector = Industry::where('city', 'REGEXP', $tcity->city_id)
                            ->leftJoin('job_searchs', 'job_searchs.industry', '=', 'industries.id')
                            ->select('industries.id as id', \DB::raw('COUNT(job_searchs.job_id) as jobsearch_count'),'industries.industry as industry')
                            ->orderBy('jobsearch_count','DESC')
                            ->havingRaw("jobsearch_count != 0")
                            ->groupBy('id')
                            ->groupBy('industry')
                            ->limit(3)
                            ->get();
            $tcity['sectors'] = $sector;
        });                                
        
        $top_cities->makeHidden(['total_count']);

        $sectors = Industry::withCount('jobsearch')
                            ->orderBy('jobsearch_count','DESC')
                            ->havingRaw("jobsearch_count != 0")
                            ->limit(15)
                            ->get();
        $sectors->makeHidden(['lang','industry_id','is_active','sort_order','is_default','created_at','updated_at']);

        $filter = array('sortBy'=> 'date');
        $jobs = $this->fetchJobs($user->career_title,'',$filter, 5);

        $jobs['joblist']->each(function ($job, $key) use($user) {
            $jobc = Job::find($job->job_id);
            $job['company_image'] = $jobc->company->company_image??'';
            $job['job_type'] = $jobc->getTypesStr();
            $job['skills'] = $jobc->getSkillsStr();
            $job['posted_at'] = Carbon::parse($jobc->posted_date)->getTimestampMs();
            $job['is_applied'] = $user->isAppliedOnJob($job->job_id);
            $job['is_favourite'] = $user->isFavouriteJob($jobc->slug);
            $job['is_deleted'] = (!empty($jobc->deleted_at))?0:1; 
        });   
        $joblist = $jobs['joblist']->items(); 

        $appliedjobs = JobApply::where('user_id',$user_id)
                        ->whereIn('application_status',['shortlist'])
                        ->whereIsRead(1)
                        // ->whereIn('application_status',['view','shortlist','consider'])
                        ->take(4)
                        ->orderBy('updated_at','desc')
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

        $response = array(
            'jobs' => $joblist,
            'top_cities' => $top_cities,
            'sectors' => $sectors, 
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
        $user = "";
        if(Auth::check()){
            UserActivity::updateOrCreate(['user_id' => Auth::user()->id],['last_active_at'=>Carbon::now()]);
            $user_id = Auth::user()->id??710;
            $user = User::find($user_id); 
        }

        $filters = $jobs = $filter = $citylFGid  = $salaryFGid = $jobtypeFGid = $jobshiftFGid = $edulevelFGid = $wfhtypeFid = $industrytypeGid = $functionalareaGid = $posteddateFid = array();

        $sortBy = 'date';
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
                $job['is_applied'] = (!empty($user))?$user->isAppliedOnJob($job->job_id):false;
                $job['is_favourite'] = (!empty($user))?$user->isFavouriteJob($jobc->slug):false;
                $job['is_deleted'] = (!empty($jobc->deleted_at))?0:1; 
            });   

            $joblist = $jobs['joblist']->items();  
            $joblist = $joblist;
            $filters = $jobs['filters'];
        
        }
        
        $response = array(
                        'joblist' => $joblist,    
                        'next_page' => (!empty($jobs['joblist']->nextPageUrl())?($jobs['joblist']->currentPage()+1):""),
                        'no_of_pages' => $jobs['joblist']->lastPage()??0
                    );
        if(!isset($request->is_fresher_api)){
            $response['designation'] = $designation;
            $response['location'] = $location;
            $response['sortBy'] = $sortBy;
            $response['filters'] = $filters;
        }

        return $this->sendResponse($response);
    }

    /**
     * return Success json response.
     *
     * @return \Illuminate\Http\Response
     */
    public function jobDetail($slug)
    {  
        $job = Job::whereSlug($slug)->with(['screeningquiz'])->first(); 
        if($job==NULL){
            return $this->sendError('No Job Available.'); 
        }

        $exclude_days = isset($job->walkin->exclude_days)?'(Excluding - '. $job->walkin->exclude_days.')':'';
        $job_skill_id = explode(',',$job->getSkillsStr());
        $user = $best_time_to_contact = '';
        $skill = array();
        if(Auth::check())
        {                
            
            JobViewedCandidate::updateOrCreate(['user_id' => Auth::user()->id],['job_id'=>$job->id,'job_slug'=>$slug]);
            $user_id = Auth::user()->id;
            $user = User::find($user_id);
            $jobapplied = JobApply::whereJobId($job->id)
                                  ->whereUserId($user_id)
                                  ->first();
            $skills = explode(',',$user->getUserSkillsStr('skill'));
            $skill = array_intersect($job_skill_id,$skills);
            $shortlist = (isset($jobapplied->application_status)?(!empty($jobapplied->application_status)?$jobapplied->application_status:''):'');
            $applied_at = (isset($jobapplied->created_at)?(!empty($jobapplied->created_at)?$jobapplied->created_at:''):'');
        
        }

        if(($job->contact_person_details->morning_section_from && $job->contact_person_details->morning_section_to)){
            $best_time_to_contact = Carbon::parse($job->contact_person_details->morning_section_from)->format('h:i A').' to '.Carbon::parse($job->contact_person_details->morning_section_to)->format('h:i A');
        }
        if(($job->contact_person_details->evening_section_from && $job->contact_person_details->evening_section_to)){
            $best_time_to_contact .= (!empty($best_time_to_contact)?' & ':'') . Carbon::parse($job->contact_person_details->evening_section_from)->format('h:i A').' to '.Carbon::parse($job->contact_person_details->evening_section_to)->format('h:i A');
        }

        $jobd = array(
            'id'=>$job->id,
            'slug'=>$job->slug,
            'title'=>$job->title,
            'description'=>$job->description,
            'location'=>$job->work_locations,
            'company_image'=>$job->company->company_image??'',
            'company_name'=>$job->company_name??$job->company->name,
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
            'walkin_date' => (isset($job->walkin)?'From :'.(Carbon::parse($job->walkin->walk_in_from_date)->format('d F, Y').' to '.Carbon::parse($job->walkin->walk_in_to_date)->format('d F, Y')).$exclude_days:''),
            'walkin_time' => (isset($job->walkin)?(Carbon::parse($job->walkin->walk_in_from_time)->format('H:i A').' to '.Carbon::parse($job->walkin->walk_in_to_time)->format('H:i A')):''),
            'contact_name'=>$job->contact_person_details->name??'',
            'contact_email'=>$job->contact_person_details->email??'',
            'contact_phone'=>$job->contact_person_details->phone_1??'',
            'contact_alternative'=>$job->contact_person_details->phone_2??'',
            'best_time_to_contact'=>$best_time_to_contact??'',
            'skillmatches' => (!empty($user))?$user->profileMatch($job->id):0,
            'is_applied'=>(!empty($user))?$user->isAppliedOnJob($job->id):false,
            'is_favourite'=>(!empty($user))?$user->isFavouriteJob($job->slug):false,
            'shortlist'=>$shortlist??'',
            'applied_at'=>(!empty($applied_at)?Carbon::parse($applied_at)->getTimestampMs():0),
            'website_url'=>$job->company->website_url??'',
            'linkedin_url'=>$job->company->linkedin_url??'',
            'twitter_url'=>$job->company->twitter_url??'',
            'fb_url'=>$job->company->fb_url??'',
            'insta_url'=>$job->company->insta_url??'',
            'is_admin' => $job->company->is_admin??0,
            'about_company' => $job->company->description??'',
            'redirect_url' => (!empty($job->reference_url))?$job->reference_url:'',
            'job_status' => (!empty($job->deleted_at) || $job->is_active==3)?'Job is expired or closed.':(($job->is_active==2)?'Job is In-active':''), 
            'website_link' => url('/detail').'/'.$job->slug
        );

        $jobs = $this->fetchJobs($job->title, '', [], 10);
        $jobs['joblist']->each(function ($rjob, $key) use($user) {
            $jobc = Job::find($rjob->job_id);
            $rjob['company_name'] = $jobc->company_name??$jobc->company->name;
            $rjob['company_image'] = $jobc->company->company_image??'';
            $rjob['location'] = $rjob->work_locations??'';
            $rjob['job_type'] = $jobc->getTypesStr();
            $rjob['skills'] = $jobc->getSkillsStr();
            $rjob['posted_at'] = Carbon::parse($jobc->posted_date)->getTimestampMs();
            $rjob['is_applied'] = (!empty($user))?$user->isAppliedOnJob($jobc->id):false;
            $rjob['is_favourite'] = (!empty($user))?$user->isFavouriteJob($jobc->slug):false;
            $rjob['is_deleted'] = (!empty($jobc->deleted_at))?0:1; 
        });   
        $joblist = $jobs['joblist']->items();  

        if(count($joblist)<3){
            usort($joblist, function ($a, $b) {
                return $a["job_id"] - $b["job_id"];
            });
        }

        $breakpoint = JobScreeningQuiz::whereJobId($job->id)->whereBreakpoint('yes')->first();
        $screening = JobScreeningQuiz::whereJobId($job->id)
                                     ->select('quiz_code','answer_type','candidate_options','candidate_question as question','breakpoint')
                                     ->get()
                                     ->each(function ($screeningquiz, $key) {
                                        $screeningquiz['options'] = $screeningquiz->candidate_options?json_decode($screeningquiz->candidate_options):[];
                                     });
        $job_id = $job->id;
        $response = array(
                'job' => $jobd, 
                'relevant_job' => array_filter($joblist, function ($job) use ($job_id) {return $job['job_id'] !== $job_id;}), 
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
    public function shortlistView(Request $request)
    {
        $user_id = Auth::user()->id??710;
        $job = Job::where('slug', $request->slug)->pluck('id')->first();
        $apply = JobApply::where('user_id',$user_id)->where('job_id',$job)->update(['is_read'=>'1']);
   
        return $this->sendResponse('', 'Success');
    }
    /**
     * return Success json response.
     *
     * @return \Illuminate\Http\Response
     */
    public function companyDetail($slug)
    {
        $user = '';
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $user = User::find($user_id);
        }
        $companies= Company::where('slug', $slug)->pluck('id')->first();
        $company = Company::find($companies);
        $company->country_name = $company->getCountry('country')??'';
        $company_jobs = Job::where('company_id', $companies)
                         ->whereIsActive(1)
                         ->orderBy('updated_at','desc')
                        //  ->whereDate('expiry_date', '>', Carbon::now())
                         ->get()->toArray();
        $gallery=Companygalary::whereCompanyId($companies)->get();
        $company->founded_on = $company->founded_on??0;
        $company->insta_url = $company->insta_url??'';
        $company->fb_url = $company->fb_url??'';
        $company->linkedin_url = $company->linkedin_url??'';
        $company->twitter_url = $company->twitter_url??'';
        $company->CEO_name = $company->CEO_name??'';
        $company->website_url = $company->website_url??'';
        $company->location = $company->location??'';
        $company->address = $company->address??'';
        $company->website = $company->website??'';
        $company->no_of_employees = $company->no_of_employees??'';
        $company->company_image = $company->company_image??"";
        $company->no_of_offices = $company->no_of_offices??'';
        $company->description = $company->description??'';
        $company->industry = DataArrayHelper::industryParticular($company->industry_id??0);

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
                'is_favourite'=>(!empty($user))?$user->isFavouriteJob($job->slug):false,
                'job_type'=>$job->getTypesStr(),
                'skills'=>$job->getSkillsStr(),
                'posted_at'=>Carbon::parse($job->posted_date)->getTimestampMs(),
                'is_applied'=>(!empty($user))?$user->isAppliedOnJob($job->id):false,
                'is_deleted' => (!empty($job->deleted_at))?0:1
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
