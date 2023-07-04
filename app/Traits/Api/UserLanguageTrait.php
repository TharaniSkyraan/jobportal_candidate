<?php

namespace App\Traits\Api;

use Auth;
use Carbon\Carbon;
use App\Model\User;
use App\Model\UserLanguage;
use App\Model\Language;
use App\Model\LanguageLevel;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\User\UserLanguageFormRequest;
use App\Helpers\DataArrayHelper;

trait UserLanguageTrait
{

    public function languages()
    { 

        $languages = UserLanguage::whereUserId(Auth::user()->id)->get()->toArray();
        $ip_data = $ip_data??array();
       
        $data = array_map(function ($language) use($ip_data) {
           $lang = Language::find($language['language_id']);
           $lang_level = LanguageLevel::where('language_level_id',$language['language_level_id'])->first();
            $val = array(
                'id'=>$language['id'],
                'language'=>$lang->language??'',
                'language_level' => $lang_level->language_level??'',
                'read'=>$language->read,
                'write'=>$language->write,
                'speak'=>$language->speak,
            );
            return $val;
        }, $languages); 

        
        return $this->sendResponse($data);
        
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
