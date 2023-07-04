<?php

namespace App\Traits\Api;

use Auth;
use DB;
use Redirect;
use Carbon\Carbon;
use App\Model\User;
use App\Model\UserEducation;
use App\Model\EducationLevel;
use App\Model\EducationType;
use App\Model\ResultType;
use App\Model\Country;
use App\Model\UserEducationMajorSubject;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\Api\User\UserEducationFormRequest;
use App\Helpers\DataArrayHelper;

trait UserEducationTrait
{

    public function educations()
    { 

        $educations = UserEducation::whereUserId(Auth::user()->id)->get()->toArray();
        $ip_data = $ip_data??array();
       
        $data = array_map(function ($education) use($ip_data) {
            $education_level = EducationLevel::find($education['education_level_id']);
            $education_type = EducationType::find($education['education_type_id']);
            $country = Country::find($education['country_id']);
            $result_type = ResultType::find($education['result_type_id']);
            $from = $education['from_year']?Carbon::parse($education['from_year'])->Format('M Y'):'';
            $to = ($education['pursuing']!='yes'? ($education['to_year']?Carbon::parse($education['to_year'])->Format('M Y'):'') : 'Still Pursuing');
            $val = array(
                'id'=>$education['id'],
                'education_level'=>$education_level->education_level??"",
                'education' => $education['education_type']??($education_type->education_type??''),
                'institution'=>$education['institution'],
                'country'=>(!empty($education['country_id']))?$country->country:($ip_data['geoplugin_countryName']??''),
                'location'=>$education['location'],
                'percentage'=>(!empty($education['percentage'])?($result_type->result_type??'').'-'.$education['percentage']:'-'),
                'year_of_education' =>  $from .'-'. $to,
            );
            return $val;
        }, $educations); 

        
        return $this->sendResponse($data);
        
    }

    public function storeFrontUserEducation(UserEducationFormRequest $request, $user_id=null)
    {
        
        $user_id = empty($user_id)?Auth::user()->id:$user_id;

        $userEducation = new UserEducation();
        $userEducation = $this->assignEducationValues($userEducation, $request, $user_id);
        $userEducation->save();
        
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
        $userEducation->education_type = $request->input('education_type');
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
