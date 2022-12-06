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
        
        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $user = User::find($user_id);
        $html = ''; 
        
        if (isset($user) && count($user->userSkills)):
            $html .= '<div class=" shadow p-4 rounded bg-white mb-4">                            
                        <div class="table-responsive">
                            <table class="table table-hover">                                    
                            <thead>
                                <tr>
                                    <th>Skill name</th>                                        
                                    <th>Skill level</th>                                        
                                    <th>Skill practice</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>';
            foreach ($user->userSkills as $skill){
                
                $date =  (!empty($skill->start_date)?Carbon::parse($skill->start_date)->Format('M Y'):'').(!empty($skill->end_date)?Carbon::parse($skill->end_date)->Format('M Y'):'');

                if(!empty($skill->start_date) && !empty($skill->end_date)){ 
                    $date = Carbon::parse($skill->start_date)->Format('M Y').' - '.Carbon::parse($skill->end_date)->Format('M Y');
                } 
                $skill_practice = !empty($date) ? $date.($skill->is_currently_working=='yes'?'( Currently Working )':''):'-';
                $html .= '<tr class="skill_div skill_edited_div_'.$skill->id.'" >
                            <td>' . $skill->getSkill('skill') . '</td>
                            <td>' . $skill->getLevel('language_level') . '</td>
                            <td>' . $skill_practice.'</td>
                            <td><a class="edit_skill_'.$skill->id.'" href="javascript:;" ><i class="fa-solid fa-pen-to-square text-green-color pe-3 openForm" data-form="edit" data-id="'.$skill->id.'"></i></a>';
                            if(count($user->userSkills)>1){
                                $html .='<a href="javascript:;" onclick="delete_user_skill(' . $skill->id . ');" class="delete_skill delete_skill_'.$skill->id.'" ><i class="fa-solid fa-trash-can text-danger pe-3"></i></a>
                                <a href="javascript:void(0);" onclick="undo_user_skill(' . $skill->id . ');" style="display:none;" class="undo_skill_'.$skill->id.'" ><i class="fa-solid fa-arrow-rotate-left text-green-color border-0 rounded p-2" style="background-color:#6CD038;" ></i></a>';
                            }
                                $html .='</td>
                        </tr>';
            }
            $html . '</tbody> </table></div> </div>';
        endif;          

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
        
        // Update Signup Processing Level
        $masterTable = AccountType::findorFail($userSkill->user->account_type_id);
        if($masterTable->next_process_level == 'user_skills'){
            $masterTable->next_process_level = 'user_languages';
            $masterTable->save();
        }
        /*         * ************************************ */
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
