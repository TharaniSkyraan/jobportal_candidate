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
use App\Http\Requests\User\UserSkillFormRequest;
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
                'skill_level' => $lang_level->language_level??'',
                'date' => $from .'-'. $to,
            );
            return $val;
        }, $skills); 
        
        return $this->sendResponse($data);
        
    }

    public function deleteUserSkill(Request $request)
    {
        $id = $request->input('id');
        try {
            $userSkill = UserSkill::findOrFail($id);
            $userSkill->delete();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function undoUserSkill(Request $request)
    {
        $id = $request->input('id');
        try {
            UserSkill::withTrashed()->find($id)->restore();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

}
