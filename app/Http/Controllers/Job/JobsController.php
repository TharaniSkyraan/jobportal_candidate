<?php

namespace App\Http\Controllers\Job;
use Auth;
use DB;
use Cache;
use Session;
use Redirect;
use Carbon\Carbon;
use App\Model\City;
use App\Model\Title;
use App\Model\Company;
use App\Model\Blog;
use App\Model\UserActivity;
use App\Model\FavouriteJob;
use App\Model\JobApply;
use App\Model\Job;
use App\Model\JobSearch;
use App\Model\JobScreeningQuiz;
// use App\Model\MessageContact;
use App\Model\JobAnalytics;
use App\Model\Industry;
use App\Model\JobWorkLocation;
use App\Model\JobQuizCandidateAnswer;
use App\Model\JobViewedCandidate;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\Front\ApplyJobFormRequest;
use App\Http\Controllers\Controller;
use App\Traits\FetchJobsList;
use App\Traits\BlockedKeywords;
use App\Traits\JobTrait;
use App\Traits\ShareToLayout;
use App\Events\JobApplied;
use Illuminate\Support\Facades\Crypt;
use Cookie;


class JobsController extends Controller
{

    //use Skills;
    use FetchJobsList, BlockedKeywords, ShareToLayout, JobTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth', ['except' => ['search', 'viewJob', 'searchJob', 'searchJob_2','jobDetail']]);
        // $this->functionalAreas = DataArrayHelper::langFunctionalAreasArray();
        // $this->countries = DataArrayHelper::langCountriesArray();
    }
    
    public function searchIndex()
    {
        
        $session= Session::get('ip_config');

        $near_job = JobSearch::select('title','location', 'company_name', DB::raw('count(`title`) as total_count'))
                            ->where('location', 'like', "%{$session['city']}%")
                            ->groupBy('title','location', 'company_name')
                            ->havingRaw("total_count != 0")
                            ->orderBy('total_count','desc')
                            ->limit(3)
                            ->get();

        $recent_job = JobSearch::select('title', 'company_name', 'salary_string', 'experience_string', 'location', 'slug')
                                ->where('location', 'like', "%{$session['city']}%")
                                ->orderBy('posted_date','desc')
                                ->limit(3)
                                ->get();
                                
        $job_list = JobSearch::select('title', DB::raw('count(`title`) as total_count'))
                            ->groupBy('title')
                            ->whereNotNull('title')
                            ->havingRaw("total_count != 0")
                            ->orderBy('total_count','DESC')
                            ->limit(4)
                            ->get();

        $top_cities = JobWorkLocation::whereHas('job',function($q){
                                        $q->where('work_from_home','!=','permanent');
                                    })
                                    ->select('city', DB::raw('count(`job_id`) as total_count'))
                                    ->groupBy('city')
                                    ->havingRaw("total_count != 0")
                                    ->orderBy('total_count','DESC')
                                    ->limit(4)
                                    ->get();

        $top_sector = Industry::withCount('jobsearch')
                                ->orderBy('jobsearch_count','DESC')
                                ->havingRaw("jobsearch_count != 0")
                                ->limit(3)
                                ->get();

        $titles = Title::where('hit_count','!=',0)->orderBy('hit_count','desc')->take(5)->get();
        $this->shareSeoToLayout('candidate_home');
        $blog = Blog::orderBy('created_at','desc')->take(5)->get();
        return view('candidate-home', compact('titles', 'near_job', 'recent_job', 'job_list', 'top_cities', 'top_sector', 'blog'));

    }
    
    public function search(Request $request, $data)
    {
        
        $meta=[];
        if(strpos($data, 'jobs') !== false){    

            $dl = explode('jobs',str_replace("-in-", "-", $data));
            $d = implode(' ',array_filter(explode('-',$dl[0])));
            $l = implode(' ',array_filter(explode('-',$dl[1])));
            if(!empty($d))
            {
                $checkKeywords = $this->checkKeywords($request, $d, $l);
                if($checkKeywords['sl'] != $data){
                    return Redirect::to('/'.$checkKeywords['sl']);
                }
                $d = $checkKeywords['d'];
            }

            if(!empty($d) || !empty($l))
            {
                // $meta['title'] = $tt .' Jobs and Vacancies - '.date("n F Y").' | Mugaam.com';
                // $meta['description'] = $tt .' Jobs and Vacancies - '.date("n F Y").' on Mugaam.com';
            }
            
        }else{
            abort(404);
        }
        $this->shareSeoToLayout('job_search',$d,$l);
        $slug = $data;
        return view('jobs.search', compact('d','l','slug'));
    }
    
    public function searchJob(Request $request)
    {

        if(Auth::check()){
            UserActivity::updateOrCreate(['user_id' => Auth::user()->id],['last_active_at'=>Carbon::now()]);
        }
        $filters = $jobs = $filter = $citylFGid  = $salaryFGid = $jobtypeFGid = $jobshiftFGid = $edulevelFGid = $wfhtypeFid = $industrytypeGid = $functionalareaGid = $posteddateFid = array();

        $sortBy = $request->sortBy??'relevance';
        $experienceFid = $request->experinceFv??'';
        $designation = $request->d??'';
        $location = $request->l??'';
        $slug = $request->sl??'';
        $words = DataArrayHelper::blockedKeywords();

        $dbk = $this->checkTitleBlockedKeywords($designation, $words);
        $lbk = $this->checkLocationBlockedKeywords($request->location, $words);

        if($dbk == 'yes' && $lbk == 'yes'){
            $joblist = JobSearch::where('id',0)->paginate(15);
            $filters = array();
        }else{
            $query = $_SERVER['QUERY_STRING'];
            $vars = array();
            foreach (explode('&', $query) as $pair) {
                list($key, $value) = explode('=', $pair);
                if('citylFGid' == $key){
                    $citylFGid[] = $value;
                }
                if('salaryFGid' == $key){
                    $salaryFGid[] = $value;
                }
                if('jobtypeFGid' == $key){
                    $jobtypeFGid[] = $value;
                }
                if('jobshiftFGid' == $key){
                    $jobshiftFGid[] = $value;
                }
                if('edulevelFGid' == $key){
                    $edulevelFGid[] = $value;
                }
                if('wfhtypeFid' == $key){
                    $wfhtypeFid[] = $value;
                }
                if('industrytypeGid' == $key){
                    $industrytypeGid[] = $value;
                }
                if('functionalareaGid' == $key){
                    $functionalareaGid[] = $value;
                }
                if('posteddateFid' == $key){
                    $posteddateFid[] = $value;
                }
                $vars[] = array(urldecode($key), urldecode($value));
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

            $joblist = $jobs['joblist'];    
            
            $jobs['joblist']->each(function ($rjob, $key) {
                $jobc = Job::find($rjob->job_id);
                $rjob['is_admin'] = $jobc->company->is_admin??'';
                $rjob['logo'] = $jobc->company->company_image??'';
            });    
            $filters = $jobs['filters'];

            // if($joblist->total()!= 0){
            // }
            self::checkCache($designation, $location);

        }
        
        if(Auth::check()){
            $datas = $joblist->toArray();
            $jobids = array_column($datas['data'], 'job_id');
            $appliedjodids = JobApply::where('user_id',Auth::user()->id)->whereIn('job_id',$jobids)->pluck('job_id')->toArray();
            $savedjodids = FavouriteJob::where('user_id',Auth::user()->id)->whereIn('job_id',$jobids)->pluck('job_id')->toArray();
        }

        return response()->json(array('success' => true, 
                                    'd' => $designation, 
                                    'l' => $location,
                                    'slug' => $slug,
                                    'joblist' => $joblist,    
                                    'appliedJobids' => $appliedjodids??array(),                           
                                    'savedJobids' => $savedjodids??array(),                           
                                    'filters' => $filters,
                                    'sortBy' => $sortBy
                                ));    
    }
    
    public function jobDetail($slug)
    {  
        
        $job = Job::whereSlug($slug)->first(); 
        if($job==NULL){
            abort(404);
        }
        if(Auth::check()){
            JobViewedCandidate::updateOrCreate(['user_id' => Auth::user()->id],['job_id'=>$job->id,'job_slug'=>$slug]);
        }
        $breakpoint = JobScreeningQuiz::whereJobId($job->id)->whereBreakpoint('yes')->first();
      
        $meta =[];
        if(!empty($job))
        {
            $tt = $job->title ?? '';
            $cpn = $job->company_name ?? $job->company->name;
            if(!empty($cpn)){
                $cpn = ucwords($cpn);
            }else{
                $cpn = '';
            }
            if(!empty($tt)){
                $tt = ucwords($tt);
            }else{
                $tt = '';
            }
            $wl = $job->work_locations ?? '';
            $wl = !empty($wl) ? rtrim( $job->work_locations , ", ") : '';
            $this->shareSeoToLayout('job_detail',$tt,$wl,$cpn);  

        }

        
        return view('jobs.job_detail', compact('job','meta','breakpoint'));
    }
    
    public function ApplyJob(Request $request, $job_slug)
    {
     
        // print  $server_output;exit;
        $reload_page = $screening_enable = false;
        
        if(Auth::check()){


            if(Auth::user()->getProfilePercentage()<40){
                $response = array("success" => false, "message" => "", "return_to" => Auth::user()->getContinueProfileUpdate(),"candidate"=>Auth::user()->getName(), "percentage" => Auth::user()->getProfilePercentage());
            }else
            if(Auth::user()->is_active ==1){
                
                $is_login = $request->is_login ?? 0;
                $is_screening = ($request->is_screening=='yes')?'yes':'no';
                $is_enabled = ($request->is_enabled=='enabled')?1:0;
                if(! $is_login){
                    $reload_page = true;
                }
                if(! $is_enabled && $is_screening=='yes'){
                    $screening_enable = true;
                    $response = array("success" => false, "message" => "", "return_to" => "screening");
                }else{
                    $response = array("success" => true, "message" => "You have already applied for this job", "return_to" => "already_applied");
                }
                $user = Auth::user();
                $user_id = $user->id;
                $job = Job::where('slug', 'like', $job_slug)->first();
                if(Auth::user()->isAppliedOnJob($job->id)==false && $screening_enable==false)
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
            
                    if(count($job->screeningquiz)!=0 && !isset($request->skip_screening)){
                        foreach($job->screeningquiz as $quiz){
                            $answerkey = 'answer_'.$quiz->quiz_code;
                            $data = new JobQuizCandidateAnswer();
                            $data->apply_id = $jobApply->id;
                            $data->job_screening_quiz_id = $quiz->id;
                            $data->answer = is_array($request[$answerkey]) ? implode(',', $request[$answerkey]) : $request[$answerkey];
                            $data->save();
                        }
                    }

                    // $message = new MessageContact();
                    // $message->user_id =$user_id;
                    // $message->job_id=$job->id;
                    // $message->sub_user_id=$job->created_by;
                    // $message->save();

                    // $messagecontact = MessageContact::findorFail($message->id);
                    // $messagecontact->message_id = $this->generateMessageContactId($message->id);
                    // $messagecontact->save();
                    
                    /*         * ******************************* */
                    // if ((bool) config('jobseeker.is_jobseeker_package_active')) {
                    //     $user->availed_jobs_quota = $user->availed_jobs_quota + 1;
                    //     $user->update();
                    // }
                    /*         * ******************************* */
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
                    $response = array("success" => true, "message" => "You have successfully applied for this job", "return_to" => "");
                }
                     
            }else{            
                $response = array("success" => false, "message" => "In active user.", "return_to" => "redirect_user");
            }

        }else{

            if(Auth::check()){
                $response = array("success" => false,
                            "message" => "Unauthorized user.", 
                            "return_to" => "company/postedjobslist"
                            );
            }

            $response = array("success" => false, 
                          "message" => "Unauthorized user.", 
                          "return_to" => "login"
                          );
        }

        $response['reload_page']=$reload_page;
        $response['screening_enable']=$screening_enable;
        
        return response()->json($response, SUCCESS);
    }

    function checkCache($search_index, $search_location){
        
        $array = array();
        
        if (Cookie::has('searchJobs')) {
            $input_array[] = ([
                'designation' => $search_index,
                'location' => $search_location,
            ]);
            $array = json_decode(Cookie::get('searchJobs'));

            $diff = array_diff(array_map('json_encode', $input_array), array_map('json_encode', $array));
            if(count($diff)!=0){
                $array[] = ([
                    'designation' => $search_index,
                    'location' => $search_location,
                ]);
            }

        }else{
            
            $array[] = ([
                'designation' => $search_index,
                'location' => $search_location,
            ]);
        }

        $array = json_encode($array);
        Cookie::queue('searchJobs', $array, 120);
    }


    public function companydetail($slug)
    {
        $companies= Company::where('slug', $slug)->pluck('id')->first();
        $company =Company::find($companies);
        $breadcrumbs= Job::where('company_id', $companies)->select('title', 'slug')->first();
        $company_jobs=$company->getOpenJobs();

        return view('jobs.company_view', compact('company','company_jobs', 'breadcrumbs'));
    }


}



