<?php

namespace App\Traits;

use Session;
use Auth;
use DB;
use Input;
use Carbon\Carbon;
use Redirect;
use App\Model\User;
use App\Model\UserEducation;
use App\Model\UserEducationMajorSubject;
use App\Model\EducationLevel;
use App\Model\EducationType;
use App\Model\ResultType;
use App\Model\MajorSubject;
use App\Model\AccountType;
use App\Model\Country;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\User\UserEducationFormRequest;
use App\Helpers\DataArrayHelper;

trait UserEducationTrait
{

    public function showFrontUserEducation(Request $request, $user_id=null)
    {
        
        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $user = User::find($user_id);
        $html ='';
        if (isset($user) && count($user->userEducation)):

            foreach ($user->userEducation as $education):
                //  deleted-detail -> class name
                $html .= '<div class="education_div shadow p-4 rounded bg-white mb-4 education_edited_div_'.$education->id.'"><div class="container">
                <div class="row">
                <div class="col-md-9 col-sm-8 col-xs-8 col-12">
                <h5 class="text-green-color fw-bolder">' . $education->getEducationLevel('education_level') . ($education->getEducationType('education_type')!=''? ' - ' : ' ') . $education->getEducationType('education_type') . '</h5>
                </div>
                
                <div class="col-md-3 col-sm-4 col-xs-4 col-12 d-flex justify-content-between mb-3">
                <div class="edit_education_'.$education->id.'"><a href="javascript:void(0);"><i class="fa-solid fa-pen-to-square text-green-color openForm"  data-form="edit" data-id="'.$education->id.'" data-type-id="'.($education->education_type_id??0).'"></i></a></div>';
                if(count($user->userEducation)>1){
                    $html .='<div class="delete_education_'.$education->id.' delete_education"><a href="javascript:void(0);"><i class="fa-solid fa-trash-can text-danger" onclick="delete_user_education(' . $education->id . ');"></i></a></div>
                    <div class="undo_education_'.$education->id.'" onclick="undo_user_education(' . $education->id . ');" style="display:none;"><a href="javascript:void(0);"><i class="fa-solid fa-arrow-rotate-left text-green-color border-0 rounded p-2" style="background-color:#6CD038;" ></i></a></div>';
                }                
                $html .='</div>
                </div>
                
                <div style="margin: 5px 0;">' . ucwords($education->institution) . '</div>
                <div style="margin: 5px 0;">' . ucwords($education->location) . '</div>
                <div style="margin: 5px 0;">' . Carbon::parse($education->from_year)->Format('M Y') . ' - '. ($education->pursuing!='yes'? Carbon::parse($education->to_year)->Format('M Y') : 'Still Pursuing') . '</div>
                <div style="margin: 5px 0;">' . ($education->percentage!=''? $education->getResultType('result_type') . ': ' . $education->percentage : ' ' ) . '</div>
                </div></div>';

            endforeach;

        endif;

        echo $html;

    }


    public function getFrontUserEducationForm(Request $request, $user_id=null)
    {
        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $educationLevels = DataArrayHelper::langEducationlevelsArray();
        $resultTypes = DataArrayHelper::langResultTypesArray();
        $majorSubjects = DataArrayHelper::langMajorSubjectsArray();
        $countries = DataArrayHelper::CountriesArray();
        $userEducationMajorSubjectIds = array();

        $user = User::find($user_id);
        $returnHTML = view('user.education.add')
                ->with('user', $user)
                ->with('educationLevels', $educationLevels)
                ->with('resultTypes', $resultTypes)
                ->with('majorSubjects', $majorSubjects)
                ->with('userEducationMajorSubjectIds', $userEducationMajorSubjectIds)
                ->with('countries', $countries)
                ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }


    public function storeFrontUserEducation(UserEducationFormRequest $request, $user_id=null)
    {
        
        $user_id = empty($user_id)?Auth::user()->id:$user_id;

        $userEducation = new UserEducation();
        $userEducation = $this->assignEducationValues($userEducation, $request, $user_id);
        $userEducation->save();
        
        // Update Signup Processing Level
        $masterTable = AccountType::findorFail($userEducation->user->account_type_id);
        if($masterTable->next_process_level == 'user_education'){
            $masterTable->next_process_level = 'user_experience';
            $masterTable->save();
        }
        /*         * ************************************ */
        $this->storeuserEducationMajorSubjects($request, $userEducation->id);
        /*         * ************************************ */
     
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML??''), 200);
    }

    private function assignEducationValues($userEducation, $request, $user_id=null)
    {
        
        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        if($request->input('result_type_id') ==3){
            $percentage = $request->input('percentage');
        }
        if($request->input('result_type_id') ==2){
            $percentage = $request->input('grade');
        }
        if($request->input('result_type_id') ==1){
            $percentage = $request->input('gpa');
        }
        $userEducation->user_id = $user_id;
        $userEducation->education_level_id = $request->input('education_level_id');
        $userEducation->education_type_id = $request->input('education_type_id');
        $userEducation->country_id = $request->input('country_id_dd');
        $userEducation->from_year = $request->input('from_year');
        $userEducation->to_year = $request->input('to_year');
        $userEducation->institution = $request->input('institution');
        $userEducation->location = $request->input('location');
        $userEducation->percentage = $percentage??null;
        $userEducation->result_type_id = $request->input('result_type_id');
        $userEducation->pursuing = $request->input('pursuing')??Null;
        // $userEducation->education_title = $request->input('education_title');
        // $userEducation->state_id = $request->input('state_id_dd');
        // $userEducation->city_id = $request->input('city_id_dd');
        // $userEducation->course_type = $request->input('course_type');
        // $userEducation->university_board = $request->input('university_board');
        return $userEducation;
    }

    public function getFrontUserEducationEditForm(Request $request, $user_id=null)
    {

        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $education_id = $request->input('education_id');

        $educationLevels = DataArrayHelper::langEducationlevelsArray();
        $resultTypes = DataArrayHelper::langResultTypesArray();
        $countries = DataArrayHelper::CountriesArray();

        $userEducation = UserEducation::find($education_id);
        $user = User::find($user_id);

        $returnHTML = view('user.education.edit')
                        ->with('user', $user)
                        ->with('userEducation', $userEducation)
                        ->with('educationLevels', $educationLevels)
                        ->with('resultTypes', $resultTypes)
                        ->with('countries', $countries)
                        ->render();

        return response()->json(array('success' => true, 'html' => $returnHTML));

    }

    public function updateFrontUserEducation(UserEducationFormRequest $request, $education_id, $user_id=null)
    {

        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $userEducation = UserEducation::find($education_id);
        $userEducation = $this->assignEducationValues($userEducation, $request, $user_id);
        $userEducation->update();
        /*         * ************************************ */
        $this->storeuserEducationMajorSubjects($request, $userEducation->id);
        /*         * ************************************ */

        $returnHTML = '';
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
    }

    private function storeuserEducationMajorSubjects($request, $user_education_id)
    {
        if ($request->has('major_subjects')) {
            UserEducationMajorSubject::where('user_education_id', '=', $user_education_id)->delete();
            $major_subjects = $request->input('major_subjects');
            foreach ($major_subjects as $major_subject_id) {
                $userEducationMajorSubject = new UserEducationMajorSubject();
                $userEducationMajorSubject->user_education_id = $user_education_id;
                $userEducationMajorSubject->major_subject_id = $major_subject_id;
                $userEducationMajorSubject->save();
            }
        }
    }

    public function deleteAllUserEducation($user_id=null)
    {
        
        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $userEducations = UserEducation::where('user_id', '=', $user_id)->get();
        foreach ($userEducations as $userEducation) {
            echo $this->removeUserEducation($userEducation->id);
        }
    }

    public function deleteUserEducation(Request $request)
    {
        $id = $request->input('id');
        return $this->removeUserEducation($id);
    }

    private function removeUserEducation($id)
    {
        try {
            $userEducation = UserEducation::findOrFail($id);
            UserEducationMajorSubject::where('user_education_id', '=', $id)->delete();
            $userEducation->delete();            
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }
    

    public function undoUserEducation(Request $request)
    {
        $id = $request->input('id');
    
        try {
            UserEducation::withTrashed()->find($id)->restore();
            UserEducationMajorSubject::withTrashed()->where('user_education_id', '=', $id)->restore();
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

}
