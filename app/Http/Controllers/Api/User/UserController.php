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
use App\Traits\Api\UserCvsTrait;
use App\Http\Requests\Api\User\UpdateCareerInfoRequest;
use App\Http\Requests\Api\User\UpdateProfileRequest;

class UserController extends BaseController
{
    
    use UserEducationTrait, UserExperienceTrait, UserProjectsTrait, UserLanguageTrait, UserSkillTrait, UserCvsTrait;

    public function profile()
    {
        $user = Auth::user();       
        $response = array(
            'user' => array(
                'image' => $user->image??'',
                'name' => $user->getName(),
                'email' => $user->email,
                'phone' => $user->phone??'',
                'alternative_phone' => $user->alternative_phone??'',
                'location' => $user->location??'',
                'country_id' => $user->country_id??'',
                'date_of_birth' => $user->date_of_birth??'',
                'gender' => $user->gender??'',
                'marital_status_id' => $user->marital_status_id??'',
            ),
            'genders' => DataArrayHelper::langGendersApiArray(),    
            'maritalStatuses' => DataArrayHelper::langMaritalStatusesApiArray()
        );
        return $this->sendResponse($response);
        
    }
    
    public function profileUpdate(UpdateProfileRequest $request)
    {

        $request['date_of_birth'] = Carbon::parse($request->date_of_birth)->format('Y-m-d');
        $user = User::findOrFail(Auth::user()->id)->update($request->all());

        $message = "Updated successfully.";

        return $this->sendResponse('', $message); 
    }
    
    public function career_info()
    {

        $user = Auth::user();     
        $exp = explode('.',$user->total_experience);
        $exp_in_year = $exp[0]??'';
        $exp_in_month = $exp[1]??'';  
        $response = array(
            'country_id' => $user->country_id??'',
            'prefered_location' => $user->prefered_location??'',
            'salary_currency' => $user->salary_currency??'',
            'expected_salary' => $user->expected_salary??'',
            'total_experience' => $user->total_experience??0,
            'career_title' => $user->career_title??'',
            'exp_in_year' => $exp_in_year??0,
            'exp_in_month' => $exp_in_month??0,
        );
        return $this->sendResponse($response);
        
    }

    public function about()
    {

        $user = Auth::user();     
        $response =  array('summary'=>$user->summary??'');
        return $this->sendResponse($response); 

    }
    
    public function career_infoUpdate(UpdateCareerInfoRequest $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->career_title = $request->career_title;
        $user->total_experience = $request->exp_in_year.'.'.$request->exp_in_month;
        $user->expected_salary = (int) str_replace(',',"",$request->input('expected_salary'));
        $user->salary_currency = $request->salary_currency;
        $user->country_id = $request->country_id;
        $user->prefered_location = $request->prefered_location;
        $user->save();
        
        $message = "Updated successfully.";

        return $this->sendResponse('', $message); 
    }

    public function aboutUpdate(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->summary = $request->summary;
        $user->save();
        
        $message = "Updated successfully.";

        return $this->sendResponse('', $message);  
    }

    
}