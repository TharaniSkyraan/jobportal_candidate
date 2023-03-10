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
use App\Model\JobApply;
use App\Model\Job;
use App\Model\JobSearch;
use App\Model\JobScreeningQuiz;
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
use App\Traits\ShareToLayout;
use App\Events\JobApplied;
use Illuminate\Support\Facades\Crypt;
use Cookie;

class JobsController extends Controller
{

    //use Skills;
    use FetchJobsList, BlockedKeywords, ShareToLayout;

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
                            ->orderBy('total_count','desc')
                            ->limit(3)
                            ->get();

        $recent_job = JobSearch::select('title', 'company_name', 'salary_string', 'experience_string', 'location', 'slug')
                                ->where('location', 'like', "%{$session['city']}%")
                                ->orderBy('created_at','asc')
                                ->limit(3)
                                ->get();
                                
        $job_list = Job::whereIsActive(0)
                        ->select('title', DB::raw('count(`title`) as total_count'))
                        ->groupBy('title')
                        ->orderBy('total_count','DESC')
                        ->limit(4)
                        ->get();

        $top_cities = JobWorkLocation::select('city', DB::raw('count(`job_id`) as total_count'))
                                    ->groupBy('city')
                                    ->orderBy('total_count','DESC')
                                    ->limit(4)
                                    ->get();

        $top_sector = Industry::withCount('jobsearch')
                                ->orderBy('jobsearch_count','DESC')
                                ->limit(3)
                                ->get();

        $titles = Title::where('hit_count','!=',0)->orderBy('hit_count','desc')->take(5)->get();
        $this->shareSeoToLayout('candidate_home');
        return view('candidate-home', compact('titles', 'near_job', 'recent_job', 'job_list', 'top_cities', 'top_sector'));

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

        return view('jobs.search', compact('d','l'));
    }
    
    public function searchJob(Request $request)
    {

        $filters = $jobs = $filter = $citylFGid  = $salaryFGid = $jobtypeFGid = $jobshiftFGid = $edulevelFGid = $wfhtypeFid = $industrytypeGid = $functionalareaGid = array();

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
            $filter['sortBy']  = $sortBy;
            
            $jobs = $this->fetchJobs($designation, $location, $filter, 15);

            $joblist = $jobs['joblist'];           
            $filters = $jobs['filters'];

            // if($joblist->total()!= 0){
            // }
            self::checkCache($designation, $location);

        }
        
        if(Auth::check()){
            $datas = $joblist->toArray();
            $jobids = array_column($datas['data'], 'job_id');
            $appliedjodids = JobApply::where('user_id',Auth::user()->id)->whereIn('job_id',$jobids)->pluck('job_id')->toArray();
        }

        return response()->json(array('success' => true, 
                                    'd' => $designation, 
                                    'l' => $location,
                                    'slug' => $slug,
                                    'joblist' => $joblist,    
                                    'appliedJobids' => $appliedjodids??array(),                           
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
        $breakpoint = JobScreeningQuiz::whereJobId($job->id)->whereBreakpoint('yes')->first();
        $meta =[];
        if(!empty($job))
        {
            $tt = $job->title ?? '';
            $cpn = $job->company->name ?? '';
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
        $reload_page = false;
        
        if(Auth::check()){

            if(Auth::user()->is_active ==1){
                
                $is_login = $request->is_login ?? 0;
                if(! $is_login){
                    $reload_page = true;
                }

                $user = Auth::user();
                $user_id = $user->id;
                $job = Job::where('slug', 'like', $job_slug)->first();
                $response = array("success" => true, "message" => "You have already applied for this job", "return_to" => "already_applied");
                if(Auth::user()->isAppliedOnJob($job->id)==false)
                {
                    $jobApply = new JobApply();
                    $jobApply->user_id = $user_id;
                    $jobApply->job_id = $job->id;
                    $jobApply->percentage = $user->profileMatch($job->id);
                    $jobApply->save();
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
                    
                    /*         * ******************************* */
                    // if ((bool) config('jobseeker.is_jobseeker_package_active')) {
                    //     $user->availed_jobs_quota = $user->availed_jobs_quota + 1;
                    //     $user->update();
                    // }
                    /*         * ******************************* */
                    $this->Notification($jobApply->id);
                    event(new JobApplied($job, $jobApply));
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


    public function companydetail($slug){
        $companies= Company::where('slug', $slug)->pluck('id')->first();
        $company =Company::find($companies);
        $breadcrumbs= Job::where('company_id', $companies)->select('title', 'slug')->first();
        $company_jobs=$company->getOpenJobs();

        return view('jobs.company_view', compact('company','company_jobs', 'breadcrumbs'));
    }

    public function Notification($id)
    {
        $job = JobApply::find($id);
        $phone = str_replace("+","",$job->user->phone);

        if(!empty($phone)){

            $name = $job->user->getName();
            $title = $job->job->title;
            $data = [
                "to"=>$phone,
                "messaging_product"=>"whatsapp",
                "type"=>"template",
                "template"=>[
                    "name"=>"job_applied_notification",
                    "language"=>[
                        "code"=>"en_US"
                    ],
                    "components"=>[
                        [
                            "type"=>"body",
                            "parameters"=>[
                                [
                                    "type"=>"text",
                                    "text"=>"*$name*"
                                ],
                                [
                                    "type"=>"text",
                                    "text"=>"*$title*"
                                ]
                            ]
                        ]
                    ]            
                ]
            ];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://graph.facebook.com/v15.0/108875332057674/messages");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));  //Post Fields
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
            $headers = [
                'Authorization: Bearer EAALy6BVbtlMBACz2abQ9FzLXf9fPVSxwUxOL5Md7cdYzsJ3v0QkZCTCx5DBqRB5P1kGIONvYF2rHCPZAPKE4sksJDdCN0178S9G8ZAKRK2YVO0hO4X4KYiKDLzLal1kRfak0uBoC7rp5Ek1wEmLs9DSU7WuowAFxxWRfbAF95JSrMXEttMWPCJwX9KX56g9qkMlSeabQQZDZD', 
                'Content-Type: application/json' 
            ];
        
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
            $server_output = curl_exec ($ch);
        
            curl_close ($ch); 
        }

    }


}



