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
        $userSkill = new UserSkill();
        $userSkill->user_id = $user_id;
        $userSkill->skill_id = $request->input('skill_id');
        $userSkill->level_id = $request->input('level_id');
        $userSkill->start_date = $request->input('start_date');
        $userSkill->end_date = $request->input('end_date');
        $userSkill->is_currently_working = $request->input('is_currently_working')??'no';
        $userSkill->save();
        
       // $returnHTML = view('user.forms.skill.skill_thanks')->render();
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML??''), 200);
    }
    
    public function getFrontUserSkillEditForm(Request $request, $user_id=null)
    {
        
        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $skill_id = $request->input('skill_id');

        $skills = DataArrayHelper::langSkillsArray();
        $experiences = DataArrayHelper::langExperiencesArray();
        $levels = DataArrayHelper::langLanguageLevelsArray();

        $userSkill = UserSkill::find($skill_id);
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
        $userSkill->start_date = $request->input('start_date');
        $userSkill->end_date = $request->input('end_date');
        $userSkill->is_currently_working = $request->input('is_currently_working')??'no';
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
