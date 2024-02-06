<?php

namespace App\Traits;

use Auth;
use Carbon\Carbon;
use App\Model\User;
use App\Model\JobRecentSearch;
use App\Model\JobAlert;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\Api\Job\JobSearchRequest;
use App\Helpers\DataArrayHelper;

trait UserJobRecentSearchTrait
{

    /**
     * return Success json response.
     *
     * @return \Illuminate\Http\Response
     */
    public function recentsearchStore(JobSearchRequest $request)
    {
        
        $user_id = Auth::user()->id??0;

        $designation = $request->designation;
        $location = $request->location;
        $experienceFid = $request->experinceFv??0;

        $search = JobRecentSearch::where(function($q) use($designation){
                                    $designations = $designation??'';
                                    $q->where('title',$designation)->orwhere('title',$designations);
                                })->where(function($q) use($location){
                                    $locations = $location??'';
                                    $q->where('location',$location)->orwhere('location',$locations);
                                })->where('user_id',$user_id)
                                ->orderBy('updated_at','desc')->first();
        $jobAlert = JobAlert::where(function($q) use($designation){
                                $designations = $designation??'';
                                $q->where('title',$designation)->orwhere('title',$designations);
                            })->where(function($q) use($location){
                                $locations = $location??'';
                                $q->where('location',$location)->orwhere('location',$locations);
                            })->where('user_id',$user_id)
                            ->orderBy('updated_at','desc')->first();

        $jobSearch = new JobRecentSearch();
        if(isset($search)){
            $jobSearch = JobRecentSearch::find($search->id);
        }else{
            
            $jobSearchs = JobRecentSearch::whereUserId(Auth::user()->id)->count();
            if($jobSearchs>4){
                $jobsearches = JobRecentSearch::oldest()->first();
                $jobsearches->forceDelete();
            }
        }
        $jobSearch->user_id            = $user_id;
        $jobSearch->title              = $designation;
        $jobSearch->location           = $location;
        $jobSearch->citylFGid          = $request->citylFGid;
        $jobSearch->salaryFGid         = $request->salaryFGid;
        $jobSearch->jobtypeFGid        = $request->jobtypeFGid;
        $jobSearch->jobshiftFGid       = $request->jobshiftFGid;
        $jobSearch->edulevelFGid       = $request->edulevelFGid;
        $jobSearch->wfhtypeFid         = $request->wfhtypeFid;
        $jobSearch->industrytypeGid    = $request->industrytypeGid;
        $jobSearch->functionalareaGid  = $request->functionalareaGid;
        $jobSearch->posteddateFid      = $request->posteddateFid;
        $jobSearch->experienceFid      = $request->experinceFv??0;
        $jobSearch->save();

        $jobAlert_status = 'new';
        if(isset($jobAlert)){
            
            $jobAlert_status = 'exist';
            $citylFGid         = $request->citylFGid?explode(',',$request->citylFGid):[];
            $salaryFGid        = $request->salaryFGid?explode(',',$request->salaryFGid):[];
            $jobtypeFGid       = $request->jobtypeFGid?explode(',',$request->jobtypeFGid):[];
            $jobshiftFGid      = $request->jobshiftFGid?explode(',',$request->jobshiftFGid):[];
            $edulevelFGid      = $request->edulevelFGid?explode(',',$request->edulevelFGid):[];
            $wfhtypeFid        = $request->wfhtypeFid?explode(',',$request->wfhtypeFid):[];
            $industrytypeGid   = $request->industrytypeGid?explode(',',$request->industrytypeGid):[];
            $functionalareaGid = $request->functionalareaGid?explode(',',$request->functionalareaGid):[];
            $posteddateFid     = $request->posteddateFid?explode(',',$request->posteddateFid):[];
            $immediate_join    = $request->immediate_join??'no';

            $j_citylFGid         = $jobAlert->citylFGid?explode(',',$jobAlert->citylFGid):[];
            $j_salaryFGid        = $jobAlert->salaryFGid?explode(',',$jobAlert->salaryFGid):[];
            $j_jobtypeFGid       = $jobAlert->jobtypeFGid?explode(',',$jobAlert->jobtypeFGid):[];
            $j_jobshiftFGid      = $jobAlert->jobshiftFGid?explode(',',$jobAlert->jobshiftFGid):[];
            $j_edulevelFGid      = $jobAlert->edulevelFGid?explode(',',$jobAlert->edulevelFGid):[];
            $j_wfhtypeFid        = $jobAlert->wfhtypeFid?explode(',',$jobAlert->wfhtypeFid):[];
            $j_industrytypeGid   = $jobAlert->industrytypeGid?explode(',',$jobAlert->industrytypeGid):[];
            $j_functionalareaGid = $jobAlert->functionalareaGid?explode(',',$jobAlert->functionalareaGid):[];
            $j_posteddateFid     = $jobAlert->posteddateFid?explode(',',$jobAlert->posteddateFid):[];
            $j_immediate_join    = $jobAlert->immediate_join;
            $j_experienceFid     = $jobAlert->experienceFid;

            if($j_experienceFid != $experienceFid){
                $jobAlert_status = 'modified';
            }
            
            if($j_immediate_join != $immediate_join){
                $jobAlert_status = 'modified';
            }

            $salary = array_merge(array_diff($salaryFGid, $j_salaryFGid), array_diff($j_salaryFGid, $salaryFGid));
            $city = array_merge(array_diff($citylFGid, $j_citylFGid), array_diff($j_citylFGid, $citylFGid));
            $jobtype = array_merge(array_diff($jobtypeFGid, $j_jobtypeFGid), array_diff($j_jobtypeFGid, $jobtypeFGid));
            $jobshift = array_merge(array_diff($jobshiftFGid, $j_jobshiftFGid), array_diff($j_jobshiftFGid, $jobshiftFGid));
            $edulevel = array_merge(array_diff($edulevelFGid, $j_edulevelFGid), array_diff($j_edulevelFGid, $edulevelFGid));
            $wfhtype = array_merge(array_diff($wfhtypeFid, $j_wfhtypeFid), array_diff($j_wfhtypeFid, $wfhtypeFid));
            $industrytype = array_merge(array_diff($industrytypeGid, $j_industrytypeGid), array_diff($j_industrytypeGid, $industrytypeGid));
            $functionalarea = array_merge(array_diff($functionalareaGid, $j_functionalareaGid), array_diff($j_functionalareaGid, $functionalareaGid));
            $posteddate = array_merge(array_diff($posteddateFid, $j_posteddateFid), array_diff($j_posteddateFid, $posteddateFid));

            if(!empty(implode(',',$salary))) $jobAlert_status = 'modified';
            if(!empty(implode(',',$city))) $jobAlert_status = 'modified';
            if(!empty(implode(',',$jobtype))) $jobAlert_status = 'modified';
            if(!empty(implode(',',$jobshift))) $jobAlert_status = 'modified';
            if(!empty(implode(',',$wfhtype))) $jobAlert_status = 'modified';
            if(!empty(implode(',',$industrytype))) $jobAlert_status = 'modified';
            if(!empty(implode(',',$functionalarea))) $jobAlert_status = 'modified';
            if(!empty(implode(',',$posteddate))) $jobAlert_status = 'modified';
        }
        
        $response = array(
            'jobalert_status' => $jobAlert_status
        );

        return $this->sendResponse([$response]);
    }

    public function getRecentsearch(Request $request)
    {
        $user_id = Auth::user()->id??1;
        $id = $request->recent_search_id??'';
        $user = User::find($user_id);
        $list = JobRecentSearch::select('id','title','location','created_at')
                        ->whereUserId($user_id)
                        ->where(function($q) use($id){
                            if(!empty($id)){
                                $q->where('id',$id);
                            }
                        })->orderBy('created_at','asc')->take(5)->get();
        
        $list->each(function ($job, $key) use($user) {
            $designation = $job->title;
            $location = $job->location;
            $alert = JobRecentSearch::find($job->id);
            $job['title'] = !empty($job->title)?$job->title:'';
            $job['location'] = !empty($job->location)?$job->location:'';
            $job['saved_at'] = Carbon::parse($job->updated_at)->getTimestampMs();
            $job['industrytype'] = implode(", ",$alert->getIndustryType());
            $job['functionalarea'] = implode(", ",$alert->getFunctionalArea());
            $job['edulevel'] = implode(", ",$alert->getEducationLevel());
            $job['jobtype'] = implode(", ",$alert->getJobType());
            $job['jobshift'] = implode(", ",$alert->getShift());
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
            
            $jobAlert = JobAlert::where(function($q) use($designation){
                                    $designations = $designation??'';
                                    $q->where('title',$designation)->orwhere('title',$designations);
                                })->where(function($q) use($location){
                                    $locations = $location??'';
                                    $q->where('location',$location)->orwhere('location',$locations);
                                })->where('user_id',$user->id)
                                ->orderBy('updated_at','desc')->first();
            $job['jobalert_id'] = $jobAlert->id??0;

        });

        return $this->sendResponse([$list]);  
    }

}
