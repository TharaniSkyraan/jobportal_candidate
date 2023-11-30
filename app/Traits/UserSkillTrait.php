<?php

namespace App\Traits;

use Auth;
use DB;
use Input;
use Carbon\Carbon;
use Redirect;
use App\Model\User;
use App\Model\AccountType;
use App\Model\UserSkill;
use App\Model\Skill;
use App\Model\Experience;
use App\Model\Country;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\User\UserSkillFormRequest;
use App\Helpers\DataArrayHelper;

trait UserSkillTrait
{

    public function showUserSkills(Request $request, $user_id=null)
    {
        if(Auth::user()->userSkills->count()==0){
            $user_skills = json_decode(Auth::user()->skill);

            $words = DataArrayHelper::blockedKeywords();
            $skills = [];
            foreach($user_skills as $skill)
            {
                if(!isset($skill->id) && !in_array($skill->value, $words))
                {                
                    if(Skill::where('skill',$skill->value)->doesntExist())
                    {
                        $newskill = new Skill();                
                        $newskill->skill = $skill->value;
                        $newskill->is_active = 0;
                        $newskill->lang = 'en';
                        $newskill->is_default = 1;
                        $newskill->save();
                        $newskill->skill_id = $newskill->id;
                        $newskill->update();
                    }else{
                        $newskill = Skill::where('skill',$skill->value)->first();
                    }
                }

                if(isset($skill->id) || isset($newskill->id))
                {    
                    $skill_id = $skill->id??$newskill->id;       
                    if(UserSkill::where('skill_id',$skill_id)->doesntExist())
                    {                
                        $updateSkill = new UserSkill();
                        $updateSkill->user_id = $user->id;
                        $updateSkill->skills  = $skill->value;
                        $updateSkill->skill_id  = $skill_id;
                        $updateSkill->save();
                    }
                    $skills[] = array(
                        'id'=>$skill_id,
                        'value'=>$skill->value,
                    );
                }
            }
            $user = User::findOrFail(Auth::user()->id);
            $user->skill = json_encode($skills);
            $user->save();
    

        }

        $html = view('user.skill.skillslist')->render();
        
        echo $html;  
    }

    public function getFrontUserSkillForm(Request $request, $user_id=null)
    {

        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $skills = DataArrayHelper::langSkillsArray();
        $experiences = DataArrayHelper::langExperiencesArray();
        $levels = DataArrayHelper::langLanguageLevelsArray();

        $user = User::find($user_id);
        $returnHTML = view('user.skill.add')
                ->with('user', $user)
                ->with('skills', $skills)
                ->with('suggested_skill_id', $request->suggested_skill_id)
                ->with('experiences', $experiences)
                ->with('levels', $levels)
                ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function storeFrontUserSkill(UserSkillFormRequest $request, $user_id=null)
    {

        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $skill = Skill::find($request->input('skill_id'));
        $userSkill = new UserSkill();
        $userSkill->user_id = $user_id;
        $userSkill->skills = $skill->skill;
        $userSkill->skill_id = $request->input('skill_id');
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
        
       // $returnHTML = view('user.forms.skill.skill_thanks')->render();
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML??''), 200);
    }
    
    public function getFrontUserSkillEditForm(Request $request, $user_id=null)
    {
        
        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $skill_id = $request->input('skill_id');
        $userSkill = UserSkill::find($skill_id);
        
        $skills = DataArrayHelper::langSkillsArray();
        $experiences = DataArrayHelper::langExperiencesArray();
        $levels = DataArrayHelper::langLanguageLevelsArray();
        $user = User::find($user_id);
        
        // $returnHTML = view('user.forms.skill.skill_edit_modal')
        $returnHTML = view('user.skill.edit')
                ->with('user', $user)
                ->with('userSkill', $userSkill)
                ->with('skills', $skills)
                ->with('levels', $levels)
                ->with('experiences', $experiences)
                ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }


    public function updateFrontUserSkill(UserSkillFormRequest $request, $skill_id, $user_id=null)
    {
        
        $user_id = empty($user_id)?Auth::user()->id:$user_id;
       
        $userSkill = UserSkill::find($skill_id);
        $userSkill->user_id = $user_id;
        $userSkill->skill_id = $request->input('skill_id');
        $userSkill->level_id = $request->input('level_id');    
        if(!empty($request->start_date)){
            $userSkill->start_date = Carbon::parse($request->input('start_date'))->format('Y-m');
        }else{            
            $userSkill->start_date = NULL;
        }   
        if(!empty($request->end_date)){
            $userSkill->end_date = Carbon::parse($request->input('end_date'))->format('Y-m');
        }else{
            $userSkill->end_date = NULL;
        }
        $userSkill->is_currently_working = $request->input('is_currently_working')??NULL;
        $userSkill->update();
        /*         * ************************************ */

        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML??""), 200);
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
