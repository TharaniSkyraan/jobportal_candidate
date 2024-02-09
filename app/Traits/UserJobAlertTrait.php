<?php

namespace App\Traits;

use Auth;
use DB;
use Input;
use Carbon\Carbon;
use Redirect;
use App\Model\User;
use App\Model\JobAlert;
use App\Model\Country;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Helpers\DataArrayHelper;
use App\Traits\FetchJobsList;

trait UserJobAlertTrait
{
    use FetchJobsList;

    public function JobAlertDetail(Request $request)
    {
        $user = Auth::user();
        return view('user.job_alert.job_alert');
    }
   
    public function showJobAlertList(Request $request)
    {
        
        $countries = DataArrayHelper::CountriesArray();
        $user = Auth::user();
        $html = view('user.job_alert.job_alert_list', compact('countries','user'))->render();
        
        echo $html;
    }

    public function getFrontJobAlertForm(Request $request, $user_id=null)
    {
        
        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $countries = DataArrayHelper::CountriesArray();
        $filters = $this->getFilters();
        $user = User::find($user_id);
        $returnHTML = view('user.job_alert.add')
                ->with('user', $user)
                ->with('countries', $countries)
                ->with('filters', $filters)
                ->render();

        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function storeFrontJobAlert(Request $request, $user_id=null)
    {

        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $jobAlert = new JobAlert();
        
        $jobalerts = JobAlert::whereUserId(Auth::user()->id)->count();
        if($jobalerts>4){
            $job_alert = JobAlert::whereUserId(Auth::user()->id)->oldest()->first();
            $job_alert->forceDelete();
        }
        $jobAlert = $this->assignJobAlertValues($jobAlert, $request, $user_id);
        $jobAlert->save();

        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML??''), 200);
    }

    private function assignJobAlertValues($jobAlert, $request, $user_id=null)
    {
        
        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $jobAlert->user_id = $user_id;
        $jobAlert->title              = $request->title;
        $jobAlert->location           = $request->location;
        $jobAlert->salaryFGid         = isset($request->salaryFGid)?implode(',',$request->salaryFGid):'';
        $jobAlert->jobtypeFGid        = isset($request->jobtypeFGid)?implode(',',$request->jobtypeFGid):'';
        $jobAlert->jobshiftFGid       = isset($request->jobshiftFGid)?implode(',',$request->jobshiftFGid):'';
        $jobAlert->edulevelFGid       = isset($request->edulevelFGid)?implode(',',$request->edulevelFGid):'';
        $jobAlert->wfhtypeFid         = isset($request->wfhtypeFid)?implode(',',$request->wfhtypeFid):'';
        $jobAlert->posteddateFid      = isset($request->posteddateFid)?implode(',',$request->posteddateFid):'';
        $jobAlert->experienceFid      = ($request->experienceFid!='any')?$request->experienceFid:0;
        $jobAlert->immediate_join     = $request->immediate_join??'no';
        return $jobAlert;
    }

    public function getFrontJobAlertEditForm(Request $request, $user_id=null)
    {
        
        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $job_alert_id = $request->input('job_alert_id');
        $countries = DataArrayHelper::CountriesArray();
        $filters = $this->getFilters();

        $jobAlert = JobAlert::find($job_alert_id);
        $user = User::find($user_id);

        $returnHTML = view('user.job_alert.edit')
                ->with('user', $user)
                ->with('jobAlert', $jobAlert)
                ->with('countries', $countries)
                ->with('filters', $filters)
                ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function updateFrontJobAlert(Request $request, $job_alert_id, $user_id)
    {

        $jobAlert = JobAlert::find($job_alert_id);
        $jobAlert = $this->assignJobAlertValues($jobAlert, $request, $user_id);
        $jobAlert->update();

        $returnHTML = '';
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
    }

    public function deleteJobAlert(Request $request)
    {
        $id = $request->input('id');
        try {
            $jobAlert = JobAlert::findOrFail($id);
            $jobAlert->delete();
           
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function undoJobAlert(Request $request)
    {

        $id = $request->input('id');
        try {
            // $jobAlert = JobAlert::findOrFail($id);
            // $jobAlert->delete();
            JobAlert::withTrashed()->find($id)->restore();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

}
