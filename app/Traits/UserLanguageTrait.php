<?php

namespace App\Traits;

use Auth;
use DB;
use Input;
use Carbon\Carbon;
use Redirect;
use App\Model\AccountType;
use App\Model\User;
use App\Model\UserLanguage;
use App\Model\Language;
use App\Model\LanguageLevel;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\User\UserLanguageFormRequest;
use App\Helpers\DataArrayHelper;

trait UserLanguageTrait
{

    public function showUserLanguages(Request $request, $user_id=null)
    {

        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $user = User::find($user_id);
        $html = '';
        if (isset($user) && count($user->userLanguages)):
        $html .= ' <table class="table">            
                <thead> <tr class="thtg"> <th>Language</th> <th>Fluency Level</th> <th>Read</th>
                <th>Speak</th> <th>Write</th> <th>Action</th></tr>  </thead> <tbody>';      
           
                foreach ($user->userLanguages as $language):  
                    $read = $language->read == "yes"? '<i class="fa-solid fa-check" style="color:green; padding-right:3px;"></i>' : '-';               
                    $write = $language->write == "yes"? '<i class="fa-solid fa-check" style="color:green; padding-right:3px;"></i>' : '-';               
                    $speak = $language->speak == "yes"? '<i class="fa-solid fa-check" style="color:green; padding-right:3px;"></i>' : '-';
                    $html .=  '<tr class="rslt language_div language_edited_div_'.$language->id.'" >
                    <td class="fw-bolder">' . $language->getLanguage('lang') . '</td>
                    <td>' . $language->getLanguageLevel('language_level') . '</td>
                    <td>' . $read . '</td>
                    <td>' . $speak . '</td>
                    <td>' . $write . '</td>
                    <td><a href="javascript:;" class="edit_language_'.$language->id.'"><i class="fa fa-pencil pe-3 openForm" data-form="edit" data-id="'.$language->id.'"></i></a>';
                    if(count($user->userLanguages)>1){
                        $html .='<a href="javascript:;" onclick="delete_user_language(' . $language->id . ');" class="delete_language delete_language_'.$language->id.'"><i class="fa-solid fa-trash-can text-danger pe-3"></i></a>
                        <a href="javascript:void(0);" onclick="undo_user_language(' . $language->id . ');" style="display:none;" class="undo_language_'.$language->id.'" ><i class="fa-solid fa-arrow-rotate-left text-green-color border-0 rounded p-2" style="background-color:#6CD038;" ></i></a>';
                    }
                    $html .='</td></tr>';
            endforeach;
            $html .'</tbody> </table>';
        endif;

        echo $html;
    }

    public function getFrontUserLanguageForm(Request $request, $user_id=null)
    {

        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $languages = DataArrayHelper::languagesArray();
        $languageLevels = DataArrayHelper::langLanguageLevelsArray();

        $user = User::find($user_id);
        $returnHTML = view('user.language.add')
                ->with('user', $user)
                ->with('languages', $languages)
                ->with('languageLevels', $languageLevels)
                ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function storeFrontUserLanguage(UserLanguageFormRequest $request, $user_id=null)
    {

        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $userLanguage = new UserLanguage();
        $userLanguage = $this->assignLanguageValues($userLanguage, $request, $user_id);
        $userLanguage->save();

        return response()->json(array('success' => true, 'message' =>'Language create successfully', 'status' => 200, 'html' => $returnHTML??""), 200);
    }

    public function getFrontUserLanguageEditForm(Request $request, $user_id=null)
    {
        
        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $user_language_id = $request->input('user_language_id');

        $languages = DataArrayHelper::languagesArray();
        $languageLevels = DataArrayHelper::langLanguageLevelsArray();

        $userLanguage = UserLanguage::find($user_language_id);
        $user = User::find($user_id);

        $returnHTML = view('user.language.edit')
                ->with('user', $user)
                ->with('userLanguage', $userLanguage)
                ->with('languages', $languages)
                ->with('languageLevels', $languageLevels)
                ->render();
        return response()->json(array('success' => true, 'message' =>'Language Update successfully', 'html' => $returnHTML));
    }
    
    public function updateFrontUserLanguage(UserLanguageFormRequest $request, $user_language_id, $user_id=null)
    {

        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $userLanguage = UserLanguage::find($user_language_id);
        $userLanguage = $this->assignLanguageValues($userLanguage, $request, $user_id);
        $userLanguage->update();
        /*         * ************************************ */

        // $returnHTML = view('user.forms.language.language_edit_thanks')->render();
        return response()->json(array('success' => true,'message' =>'Language Update successfully', 'status' => 200, 'html' => ''), 200);
    }

    public function assignLanguageValues($userLanguage, $request, $user_id=null)
    {
        
        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $userLanguage->user_id = $user_id;
        $userLanguage->language_id = $request->input('language_id');
        $userLanguage->language_level_id = $request->input('language_level_id');
        $userLanguage->read = $request->input('read')??'no';
        $userLanguage->write = $request->input('write')??'no';
        $userLanguage->speak = $request->input('speak')??'no';
        return $userLanguage;
    }

    public function deleteUserLanguage(Request $request)
    {
        $id = $request->input('id');
        try {
            $userLanguage = UserLanguage::findOrFail($id);
            $userLanguage->delete();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function undoUserLanguage(Request $request)
    {
        $id = $request->input('id');
        try {
            UserLanguage::withTrashed()->find($id)->restore();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

}
