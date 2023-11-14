<?php

namespace App\Http\Controllers\User;

use Auth;
use DB;
use Input;
use Redirect;
use App\Model\Job;
use App\Model\JobApply;
use App\Model\JobScreeningQuiz;
use App\Model\FavouriteJob;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class JobsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Job $job, JobApply $jobapply, FavouriteJob $savedjobs)
    {
        $this->middleware('auth');
        $this->job = $job;
        $this->jobapply = $jobapply;
        $this->savedjobs = $savedjobs;
    }

    public function appliedjobs()
    {        
        return view('user.dashboard.applied_jobs');
    }
    
    public function appliedJobsList(Request $request){      
        $user_id = Auth::user()->id;
        $sortBy = $request->sortBy;
        $jobs = $this->jobapply->where('user_id',$user_id)
                               ->where(function($q) use($sortBy){
                                    if($sortBy =='view'){                
                                        $q->whereIn('application_status',['view','consider']);
                                    }elseif($sortBy !='all'){           
                                        $q->whereApplicationStatus($sortBy);
                                    }
                               })->whereHas('job', function($q1){
                                    $q1->whereNotNull('slug');
                               })->orderBy('created_at','desc')
                                 ->paginate(10);

        $returnHTML = view('user.jobs.applied-joblist', compact('jobs'))->render();    
        
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
        
    public function savedJobs()
    {        
        return view('user.dashboard.saved_jobs');
    }
    
    public function savedJobsList(Request $request){      
        $user_id = Auth::user()->id;
        $sortBy = $request->sortBy;
        $jobs = $this->savedjobs->where('user_id',$user_id)->orderBy('created_at','desc')->paginate(10);
                            //    ->where(function($q) use($sortBy){
                            //         if($sortBy =='view'){                
                            //             $q->whereIn('application_status',['view','consider']);
                            //         }elseif($sortBy !='all'){           
                            //             $q->whereApplicationStatus($sortBy);
                            //         }
                            //    })


        $returnHTML = view('user.jobs.saved-joblist', compact('jobs'))->render();    
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
    
}
