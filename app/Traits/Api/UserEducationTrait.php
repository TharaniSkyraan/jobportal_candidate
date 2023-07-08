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
use App\Http\Requests\Api\User\UserEducationRequest;

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
                'education_level_id' => $education['education_level_id']??0,
                'education' => $education['education_type']??($education_type->education_type??""),
                'institution'=>$education['institution']??"",
                'country'=>(!empty($education['country_id']))?$country->country:($ip_data['geoplugin_countryName']??""),
                'country_id'=>$education['country_id']??0,
                'location'=>$education['location']??"",
                'percentage_val'=> (!empty($education['percentage'])?($result_type->result_type??"").'-'.$education['percentage']:'-'),
                'percentage' => $education['percentage']??"",
                'result_type_id' => $education['result_type_id']??0,
                'year_of_education' =>  $from .'-'. $to,
                'from' => (!empty($education['from_year']))?Carbon::parse($education['from_year'])->getTimestampMs():"",
                'to' => (!empty($education['to_year']))?Carbon::parse($education['to_year'])->getTimestampMs():"",
            );
            return $val;
        }, $educations); 
        
        return $this->sendResponse($data);
        
    }

    public function educationsUpdate(UserEducationRequest $request)
    {
        $id = $request->education_id??NULL;
        if($id){
            $userEducation = UserEducation::find($id);
        }else{
            $userEducation = new UserEducation();
        }
        $userEducation = $this->assignEducationValues($userEducation, $request);
        $userEducation->save();
        
        /*         * ************************************ */
        $this->storeuserEducationMajorSubjects($request, $userEducation->id);
        /*         * ************************************ */
     
     
        $message = "Updated successfully.";

        return $this->sendResponse(['education_id'=>$userEducation->id], $message); 
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

    private function assignEducationValues($userEducation, $request)
    {
        $userEducation->user_id = Auth::user()->id;
        $userEducation->education_level_id = $request->input('education_level_id');
        $userEducation->education_type_id = NULL;
        $userEducation->education_type = $request->input('education');
        $userEducation->country_id = $request->input('country_id');
        $userEducation->from_year = $request->input('from_year');
        $userEducation->to_year = $request->input('to_year');
        $userEducation->institution = $request->input('institution');
        $userEducation->location = $request->input('location');
        $userEducation->percentage = $request->percentage??null;
        $userEducation->result_type_id = $request->input('result_type_id');
        $userEducation->pursuing = $request->input('pursuing')??Null;
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
