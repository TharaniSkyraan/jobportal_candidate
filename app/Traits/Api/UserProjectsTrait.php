<?php

namespace App\Traits\Api;

use Auth;
use Carbon\Carbon;
use App\Model\User;
use App\Model\Country;
use App\Model\UserProject;
use App\Model\UserExperience;
use Illuminate\Http\Request;
use App\Http\Requests\Api\User\UserProjectRequest;
use Illuminate\Support\Str;
use App\Helpers\DataArrayHelper;

trait UserProjectsTrait

{

    public function projects(Request $request)
    { 

        $projects = UserProject::whereUserId(Auth::user()->id)->get()->toArray();
        $ip_data = $ip_data??array();
       
        $data = array_map(function ($project) use($ip_data) {
            
            $from = $project['date_start']?Carbon::parse($project['date_start'])->Format('M Y'):'';
            $to = ($project['is_on_going']!=1? ($project['date_end']?Carbon::parse($project['date_end'])->Format('M Y'):'') : 'Still Pursuing');
            $expe = UserExperience::find($project['user_experience_id']);
            $country = Country::find($project['country_id']);
            $val = array(
                'id'=>$project['id'],
                'project_name'=>$project['name']??'',
                'company' => $expe->company??$project['company_name'],
                'location'=>$project['location']??'',
                'project_location'=>$project['project_location']??'',
                'description'=>$project['description']??'',
                'used_tools'=>$project['used_tools']??'',
                'is_on_going'=>$project['is_on_going']??0,
                'work_as_team'=>$project['work_as_team']??'',
                'noof_team_member'=>$project['noof_team_member']??0,
                'role_on_project'=>$project['role_on_project']??'',
                'url'=>$project['url']??'',
                'country_id'=>$project['country_id'],
                'country'=>(!empty($project['country_id']))?$country->country:($ip_data['geoplugin_countryName']??""),
                'is_freelance'=>$project['is_freelance']??'',
                'year_of_project' => $from .'-'. $to,
                'from' => (!empty($project['date_start']))?Carbon::parse($project['date_start'])->getTimestampMs():0,
                'to' => (!empty($project['date_end']))?Carbon::parse($project['date_end'])->getTimestampMs():0,
            );
            return $val;
        }, $projects); 

        return $this->sendResponse($data);
        
    }
    
    public function projectsUpdate(UserProjectRequest $request)
    {

        $id = $request->project_id??NULL;
        $user_id = Auth::user()->id;
        if($id){
            $userProject = UserProject::find($id);
        }else{
            $userProject = new UserProject();
        }
        $userProject = $this->assignProjectValues($userProject, $request);
        $userProject->user_id = $user_id;
        $userProject->save();

        $message = "Updated successfully.";
        
        User::where('id',$user_id)->update(['updated_at'=>Carbon::now()]);
    
        return $this->sendResponse(['project_id'=>$userProject->id], $message); 

    }

    private function assignProjectValues($userProject, $request)
    {
        $userProject->name = $request->input('name');
        $userProject->user_experience_id = $request->input('user_experience_id')??NULL;
        $userProject->company_name = $request->input('company_name')??'';
        $userProject->url = $request->input('url');
        if(!empty($request->date_start)){
            $userProject->date_start =Carbon::parse($request->date_start)->format('Y-m-d');
        }else{
            $userProject->date_start = NULL;
        }
        if(!empty($request->date_end)){
            $userProject->date_end = Carbon::parse($request->date_end)->format('Y-m-d');
        }else{
            $userProject->date_end = NULL;
        }
        
        $userProject->is_on_going = $request->input('is_on_going')??NULL;
        $userProject->noof_team_member = $request->input('noof_team_member');
        $userProject->work_as_team = $request->input('work_as_team');
        $userProject->project_location = $request->input('project_location');
        $userProject->country_id = $request->input('country_id');
        $userProject->location = $request->input('location');
        $userProject->role_on_project = $request->input('role_on_project');
        $userProject->description = $request->input('description');        
        $userProject->used_tools = $request->input('used_tools');
        $userProject->is_freelance = $request->input('is_freelance')??Null;

        return $userProject;

    }

    public function deleteUserProject(Request $request)
    {
        $id = $request->input('id');
        try {
                UserProject::find($id)->delete();
                return $this->sendResponse('', 'Success');       
            } catch (ModelNotFoundException $e) {
                return $this->sendResponse('', 'Something Went Wrong.'); 
            }
    }

    public function undoUserProject(Request $request)
    {
        $id = $request->input('id');
        try {
                UserProject::withTrashed()->find($id)->restore();
                return $this->sendResponse('', 'Success');       
            } catch (ModelNotFoundException $e) {
                return $this->sendResponse('', 'Something Went Wrong.'); 
            }

    }

    private function removeUserProject($id)
    {

        try {
            $userProject = UserProject::findOrFail($id);

            $userProject->delete();

            return 'ok';

        } catch (ModelNotFoundException $e) {

            return 'notok';

        }

    }



}

