<?php

namespace App\Traits\Api;

use Auth;
use Carbon\Carbon;
use App\Model\User;
use App\Model\UserExperience;
use App\Model\Country;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\User\UserExperienceFormRequest;
use App\Helpers\DataArrayHelper;

trait UserExperienceTrait
{
    
    public function experiences(Request $request)
    { 

        $experiences = UserExperience::whereUserId(Auth::user()->id)->get()->toArray();
        $ip_data = $ip_data??array();
       
        $data = array_map(function ($experience) use($ip_data) {
            $from = $experience['date_start']?Carbon::parse($experience['date_start'])->Format('M Y'):'';
            $to = ($experience['is_currently_working']!=1? ($experience['date_end']?Carbon::parse($experience['date_end'])->Format('M Y'):'') : 'Still Pursuing');
            $val = array(
                'id'=>$experience['id'],
                'title'=>$experience['title'],
                'company' => $experience['company'],
                'location'=>$experience['location'],
                'description'=>$experience['description'],
                'used_tools'=>$experience['used_tools'],
                'year_of_experience' => $from .'-'. $to,
            );
            return $val;
        }, $experiences); 

        
        return $this->sendResponse($data);
        
    }

    public function storeFrontUserExperience(UserExperienceFormRequest $request, $user_id=null)
    {

        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $userExperience = new UserExperience();
        $userExperience = $this->assignExperienceValues($userExperience, $request, $user_id);
        $userExperience->save();

        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML??''), 200);
    }

    public function deleteUserExperience(Request $request)
    {
        $id = $request->input('id');
        try {
            $userExperience = UserExperience::findOrFail($id);
            $userExperience->delete();
           
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function undoUserExperience(Request $request)
    {

        $id = $request->input('id');
        try {
            UserExperience::withTrashed()->find($id)->restore();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

}
