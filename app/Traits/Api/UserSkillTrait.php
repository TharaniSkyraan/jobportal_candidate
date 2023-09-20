<?php

namespace App\Traits\Api;

use Auth;
use Carbon\Carbon;
use App\Model\User;
use App\Model\UserSkill;
use App\Model\LanguageLevel;
use App\Model\Skill;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\Api\User\UserSkillRequest;
use App\Helpers\DataArrayHelper;

trait UserSkillTrait
{

    public function skills()
    { 

        $skills = UserSkill::whereUserId(Auth::user()->id)->get()->toArray();
        $ip_data = $ip_data??array();
       
        $data = array_map(function ($user_skill) use($ip_data) {
            $skill = Skill::where('skill_id',$user_skill['skill_id'])->first();
            $lang_level = LanguageLevel::where('language_level_id',$user_skill['level_id'])->first();
            $from = $user_skill['start_date']?Carbon::parse($user_skill['start_date'])->Format('M Y'):'';
            $to = ($user_skill['is_currently_working']!='yes'? ($user_skill['end_date']?Carbon::parse($user_skill['end_date'])->Format('M Y'):'') : 'Still Working');
            $val = array(
                'id'=>$user_skill['id'],
                'skill'=>$skill->skill??'',
                'skill_id'=>$user_skill['skill_id']??0,
                'skill_level' => $lang_level->language_level??'',
                'level_id' => $user_skill['level_id']??0,
                'date' => $from .'-'. $to,
                'from' => (!empty($user_skill['start_date']))?Carbon::parse($user_skill['start_date'])->getTimestampMs():"",
                'to' => (!empty($user_skill['end_date']))?Carbon::parse($user_skill['end_date'])->getTimestampMs():"",
            );
            return $val;
        }, $skills); 
        
        return $this->sendResponse($data);
        
    }

    public function skillsUpdate(UserSkillRequest $request)
    {

        $user_id = Auth::user()->id;
        $id = $request->id??NULL;
        if($id){
            $userSkill = UserSkill::find($id);
        }else{
            $userSkill = new UserSkill();
        }
        if(empty($request->skill_id)){            
            $skill = new Skill();                
            $skill->skill = $request->skill;
            $skill->is_active = 0;
            $skill->lang = 'en';
            $skill->is_default = 1;
            $skill->save();
            $skill->skill_id = $skill->id;
            $skill_id = $skill->id;
            $skill_name = $request->skill;
            $skill->update();
        }else{
            $skill = Skill::find($request->input('skill_id'));
            $skill_name = $skill->skill;
            $skill_id = $request->skill_id;
        }
        $userSkill->user_id = $user_id;
        $userSkill->skills = $skill_name;
        $userSkill->skill_id = $skill_id;
        $userSkill->level_id = $request->input('level_id');
        if(!empty($request->start_date)){
            $userSkill->start_date = Carbon::parse($request->input('start_date'))->format('Y-m-d');
        }else{            
            $userSkill->start_date = NULL;
        }   
        if(!empty($request->end_date)){
            $userSkill->end_date = Carbon::parse($request->input('end_date'))->format('Y-m-d');
        }else{
            $userSkill->end_date = NULL;
        }
        $userSkill->is_currently_working = $request->input('is_currently_working')??NULL;
        $userSkill->save();
    
        $message = "Updated successfully.";

        return $this->sendResponse(['id'=>$userSkill->id], $message); 
   
    }

    public function deleteUserSkill(Request $request)
    {
        $id = $request->input('id');
        try {
            $userSkill = UserSkill::findOrFail($id);
            $userSkill->delete();
            return $this->sendResponse('', 'Success');       
        } catch (ModelNotFoundException $e) {
            return $this->sendResponse('', 'Something Went Wrong.'); 
        }
    }

    public function undoUserSkill(Request $request)
    {
        $id = $request->input('id');
        try {
            UserSkill::withTrashed()->find($id)->restore();
            return $this->sendResponse('', 'Success');       
        } catch (ModelNotFoundException $e) {
            return $this->sendResponse('', 'Something Went Wrong.'); 
        }
    }

}
