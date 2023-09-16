<?php

namespace App\Traits\Api;

use Auth;
use Carbon\Carbon;
use App\Model\User;
use App\Model\UserExperience;
use App\Model\Country;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\Api\User\UserExperienceRequest;
use App\Helpers\DataArrayHelper;

trait UserExperienceTrait
{
    
    public function experiences(Request $request)
    { 

        $experiences = UserExperience::whereUserId(Auth::user()->id)->get()->toArray();
        $ip_data = $ip_data??array();
       
        $data = array_map(function ($experience) use($ip_data) {
            $from = $experience['date_start']?Carbon::parse($experience['date_start'])->Format('M Y'):'';
            $to = ($experience['is_currently_working']!=1? ($experience['date_end']?Carbon::parse($experience['date_end'])->Format('M Y'):'') : 'Still Working');
            $country = Country::find($experience['country_id']);
            $val = array(
                    'id' => $experience['id'],
                    'title' => $experience['title'],
                    'company' => $experience['company'],
                    'location' => $experience['location'],
                    'description' => $experience['description'],
                    'used_tools' => $experience['used_tools'],
                    'country_id' => $experience['country_id'],
                    'country'=>(!empty($experience['country_id']))?$country->country:($ip_data['geoplugin_countryName']??""),
                    'is_currently_working' => $experience['is_currently_working'],
                    'year_of_experience' => $from .'-'. $to,
                    'from' => (!empty($experience['date_start']))?Carbon::parse($experience['date_start'])->getTimestampMs():"",
                    'to' => (!empty($experience['date_end']))?Carbon::parse($experience['date_end'])->getTimestampMs():"",
                );
            return $val;
        }, $experiences); 
        
        return $this->sendResponse($data);
        
    }

    public function experiencesUpdate(UserExperienceRequest $request)
    {

        $id = $request->experience_id??NULL;
        if($id){
            $userExperience = UserExperience::find($id);
        }else{
            $userExperience = new UserExperience();
        }
        $userExperience = $this->assignExperienceValues($userExperience, $request);
        $userExperience->save();
          
        $message = "Updated successfully.";

        return $this->sendResponse(['experience_id'=>$userExperience->id], $message); 
  
    }

    private function assignExperienceValues($userExperience, $request)
    {
        
        $user_id = Auth::user()->id;
        $userExperience->user_id = $user_id;
        $userExperience->title = $request->input('title');
        $userExperience->company = $request->input('company');
        $userExperience->country_id = $request->input('country_id');
        $userExperience->location = $request->input('location');
        if(!empty($request->date_start)){
            $userExperience->date_start =Carbon::parse($request->date_start)->format('Y-m-d');
        }else{
            $userExperience->date_start = NULL;
        }
        if(!empty($request->date_end)){
            $userExperience->date_end = Carbon::parse($request->date_end)->format('Y-m-d');
        }else{
            $userExperience->date_end = NULL;
        }
        $userExperience->is_currently_working = $request->input('is_currently_working')??NULL;
        $userExperience->description = $request->input('description');
        $userExperience->used_tools = $request->input('used_tools');
        return $userExperience;
    }

    public function deleteUserExperience(Request $request)
    {
        $id = $request->input('id');
        try {
            $userExperience = UserExperience::findOrFail($id);
            $userExperience->delete();
            return $this->sendResponse('', 'Success');       
        } catch (ModelNotFoundException $e) {
            return $this->sendResponse('', 'Something Went Wrong.'); 
        }
    }

    public function undoUserExperience(Request $request)
    {

        $id = $request->input('id');
        try {
            UserExperience::withTrashed()->find($id)->restore();
            return $this->sendResponse('', 'Success');       
        } catch (ModelNotFoundException $e) {
            return $this->sendResponse('', 'Something Went Wrong.'); 
        }
    }

}
