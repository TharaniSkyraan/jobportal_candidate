<?php

namespace App\Traits;

use Auth;
use DB;
use Input;
use Carbon\Carbon;
use Redirect;
use App\Model\User;
use App\Model\UserExperience;
use App\Model\Country;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\User\UserExperienceFormRequest;
use App\Helpers\DataArrayHelper;

trait UserExperienceTrait
{
    public function ExpDetail(Request $request)
    {
        $user = Auth::user();
        if($user->employment_status=='fresher'){
            return view('user.experience.fresher');
        }else{
            return view('user.experience.experience');
        }
 
    }
    public function employementStatusUpdate(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $user->employment_status = $request->employment_status;
        $user->save();
        return redirect('/experience-details');
    }

    public function showUserExperienceList(Request $request)
    {
        
        $countries = DataArrayHelper::CountriesArray();
        $user = Auth::user();
        $html = view('user.experience.experiencelist', compact('countries','user'))->render();
        
        echo $html;
    }

    // public function showFrontUserExperience(Request $request, $user_id=null)
    // {
        
    //     $user_id = empty($user_id)?Auth::user()->id:$user_id;
    //     $user = User::find($user_id);
    //     $html = '';
    //     if (isset($user) && count($user->userExperience)):
    //         foreach ($user->userExperience as $experience):
               

    //             $html .= '<div class="experience_div shadow p-4 rounded bg-white mb-4 experience_edited_div_'.$experience->id.'"><div class="container">
    //                     <div class="row">
    //                         <div class="col-md-9 col-sm-8 col-xs-8 col-8">
    //                             <h5 class="text-green-color fw-bolder">' . $experience->title . '</h5>
    //                         </div>

    //                         <div class="col-md-3 col-sm-4 col-xs-4 col-4 d-flex justify-content-between mb-3">
    //                             <div class="edit_experience_'.$experience->id.'"><a  href="javascript:void(0);"><i class="fa-solid fa-pen-to-square text-green-color openForm" data-form="edit" data-id="'.$experience->id.'"></i></a></div>';
    //                             if(count($user->userExperience)>1){
    //                                 $html .='<div class="delete_experience delete_experience_'.$experience->id.'"><a href="javascript:void(0);" onclick="delete_user_experience(' . $experience->id . ');"><i class="fa-solid fa-trash-can text-danger"></i></a></div>
    //                                 <div class="undo_experience_'.$experience->id.'" onclick="undo_user_experience(' . $experience->id . ');" style="display:none;"><a href="javascript:void(0);"><i class="fa-solid fa-arrow-rotate-left text-green-color border-0 rounded p-2" style="background-color:#6CD038;" ></i></a></div>';
    //                             }
    //                             $html .='</div>
    //                     </div>

    //                     <div style="margin: 5px 0;">' . $experience->company . '</div>
    //                     <div style="margin: 5px 0;">' . $experience->location . '</div>
                        
    //                     <div style="margin: 5px 0;">'. Carbon::parse($experience->date_start)->Format('M Y') . ' - '. ($experience->is_currently_working!=1? Carbon::parse($experience->date_end)->Format('M Y') : 'Currently working') .'</div>
                        
    //                     <div class="more-details-show-hide collapse mt-3" id="collapseExample'.$experience->id.'">
    //                         <div class="mb-3">
    //                             <label class="fw-bolder mb-2">Job Description</label><br>
    //                             <text> '. (($experience->description!='')?$experience->description:'No Job Description') .' </text>
    //                         </div>';
    //                         if($experience->used_tools!=null){
    //                             $html .='<div class="mb-3">
    //                                 <label class="fw-bolder mb-2">Tools / Software used</label><br>';
    //                                 foreach(explode(',',$experience->used_tools) as $usedtools){$html .='<div class="d-flex"><button class="btn tag">' . $usedtools . '</button></div>';}
    //                             $html .='</div>';
    //                         }

    //                     $html .='</div>

    //                         <div class="text-center mt-2 more-details more-details'.$experience->id.'"  onclick="collapsedExp('.$experience->id.')">
    //                             <a class="text-green-color" id="more-details-button-exp" data-bs-toggle="collapse" href="#collapseExample'.$experience->id.'" role="button" aria-expanded="false" aria-controls="collapseExample">More details 
    //                             <i class="fa-solid fa-chevron-down collapse-down-arrow"></i> 
    //                             <i class="fa-solid fa-chevron-up collapse-up-arrow" style="display:none;"></i></a>
    //                         </div>
    //                     </div>
    //                 </div>';
    //             endforeach;
    //         endif;
    
    //         echo $html;
            
    // }

    public function getFrontUserExperienceForm(Request $request, $user_id=null)
    {
        
        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $countries = DataArrayHelper::CountriesArray();
        
        $user = User::find($user_id);
        $returnHTML = view('user.experience.add')
                ->with('user', $user)
                ->with('countries', $countries)
                ->render();

        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function storeFrontUserExperience(UserExperienceFormRequest $request, $user_id=null)
    {

        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $userExperience = new UserExperience();
        $userExperience = $this->assignExperienceValues($userExperience, $request, $user_id);
        $userExperience->save();

        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML??''), 200);
    }

    private function assignExperienceValues($userExperience, $request, $user_id=null)
    {
        
        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $userExperience->user_id = $user_id;
        $userExperience->title = $request->input('title');
        $userExperience->company = $request->input('company');
        $userExperience->country_id = $request->input('country_id_dd');
        $userExperience->location = $request->input('location');
        // $userExperience->state_id = $request->input('state_id_dd');
        // $userExperience->city_id = $request->input('city_id_dd');
        $userExperience->date_start = $request->input('date_start');
        $userExperience->date_end = $request->input('date_end');
        $userExperience->is_currently_working = $request->input('is_currently_working')??'0';
        $userExperience->description = $request->input('description');
        $userExperience->used_tools = $request->input('used_tools');
        return $userExperience;
    }

    public function getFrontUserExperienceEditForm(Request $request, $user_id=null)
    {
        
        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $user_experience_id = $request->input('profile_experience_id');
        $countries = DataArrayHelper::CountriesArray();

        $userExperience = UserExperience::find($user_experience_id);
        $user = User::find($user_id);

        $returnHTML = view('user.experience.edit')
                ->with('user', $user)
                ->with('userExperience', $userExperience)
                ->with('countries', $countries)
                ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function updateFrontUserExperience(UserExperienceFormRequest $request, $user_experience_id, $user_id)
    {

        $userExperience = UserExperience::find($user_experience_id);
        $userExperience = $this->assignExperienceValues($userExperience, $request, $user_id);
        $userExperience->update();

        $returnHTML = '';
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
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
            // $userExperience = UserExperience::findOrFail($id);
            // $userExperience->delete();
            UserExperience::withTrashed()->find($id)->restore();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

}
