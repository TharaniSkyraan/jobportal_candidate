<?php

namespace App\Http\Controllers\Api\User;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Model\Job;
use App\Model\User;
use App\Helpers\DataArrayHelper;
use App\Traits\Api\UserEducationTrait;
use App\Traits\Api\UserExperienceTrait;
use App\Traits\Api\UserProjectsTrait;
use App\Traits\Api\UserLanguageTrait;
use App\Traits\Api\UserSkillTrait;

class UserController extends BaseController
{
    
    use UserEducationTrait, UserExperienceTrait, UserProjectsTrait, UserLanguageTrait, UserSkillTrait;

    public function profile()
    {
        $user = Auth::user();       
        $response = array(
            'user' => array(
                'image' => $user->image??'',
                'name' => $user->getName(),
                'email' => $user->email,
                'phone' => $user->phone??'',
                'alt_phone' => $user->alt_phone??'',
                'location' => $user->location??'',
                'date_of_birth' => $user->date_of_birth??'',
                'gender' => $user->gender??'',
                'marital_status_id' => $user->marital_status_id??'',
            ),
            'genders' => DataArrayHelper::langGendersApiArray(),    
            'maritalStatuses' => DataArrayHelper::langMaritalStatusesApiArray()
        );
        return $this->sendResponse($response);
        
    }
    
    public function career_info()
    {
        $user = Auth::user();       
        $response = array(
            'user' => array(
                'image' => $user->image??'',
                'name' => $user->getName(),
                'email' => $user->email,
                'phone' => $user->phone??'',
                'alt_phone' => $user->alt_phone??'',
                'location' => $user->location??'',
                'date_of_birth' => $user->date_of_birth??'',
                'gender' => $user->gender??'',
                'marital_status_id' => $user->marital_status_id??'',
            ),
            'genders' => DataArrayHelper::langGendersApiArray(),    
            'maritalStatuses' => DataArrayHelper::langMaritalStatusesApiArray()
        );
        return $this->sendResponse($response);
        
    }
}