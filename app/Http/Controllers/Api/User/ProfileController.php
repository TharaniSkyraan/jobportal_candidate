<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Model\User;
use App\Model\UserSkill;
use App\Model\JobSkill;
use App\Model\Skill;
use App\Model\UserEducation;
use App\Model\UserCv;
use App\Helpers\DataArrayHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Api\CareerInfoRequest;
use App\Http\Requests\Api\ResumeUploadRequest;
use Carbon\Carbon;
use Validator;
use DB;
   
class ProfileController extends BaseController
{   
    /**
     *  View Blade file of Candidate Basic Information Form

     *  @param Get user id from session 

     *  @return Education Information Form

     */
    public function educations()
    {
        $user = User::findOrFail(Auth::user()->id);
        $educationLevels = DataArrayHelper::langEducationlevelsArray();
        $educationTypes = '';
        $education  = (count($user->userEducation)>0)?$user->userEducation[0]:null;
        
        if(!empty($education)){
            $education_level_id = $education->education_level_id;
            $education_type_id = $education->education_type_id;
            if(!empty($education_type_id)){
                $educationTypes = DataArrayHelper::langEducationTypesArray($education_level_id);
            }
        }

        $response['education'] = array(
            'education_level_id' => $education_level_id??"",
            'education_type_id' => $education_type_id??""
        ); 
        $response['educationLevels'] = $educationLevels;
        return $this->sendResponse($response);
    }
    /**
     *  View Blade file of Candidate Basic Information Form

     *  @param Get user id from session 

     *  @return Education Information Form
     */

    public function educationsUpdate(EducationRequest $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $education  = (count($user->userEducation)>0)?$user->userEducation[0]:null;
        if(!empty($education)){
            $userEducation = UserEducation::find($education->id);
        }else{
            $userEducation = new UserEducation();
        }
        $userEducation->user_id = $user->id;
        $userEducation->education_level_id = $request->education_level_id;
        $userEducation->education_type = $request->education_type;
        $userEducation->pursuing = Null;
        $userEducation->save();

        return $this->sendResponse();

    }

    /**
     * Expeience api
     *
     * @return \Illuminate\Http\Response
     */
    public function experiences()
    {
        $user =  User::find(Auth::user()->id);
        return $this->sendResponse($user->employment_status);
    }

    /**
     *  View Blade file of Candidate Basic Information Form
        
     *  @param Get user id from session 
      
     *  @return Experience Information Form
      
     */

    public function experiencesUpdate(ExperienceRequest $request)
    {
       $user = User::findOrFail(Auth::user()->id);
        
       return $this->sendResponse();
    }

    /**
     * Project api
     *
     * @return \Illuminate\Http\Response
     */
    public function projects()
    {
        $user =  User::find(Auth::user()->id);
        return $this->sendResponse($user->employment_status);
    }

    /**
     *  View Blade file of Candidate Basic Information Form
        
     *  @param Get user id from session 
      
     *  @return Project Information Form
      
     */

    public function projectsUpdate(ExperienceRequest $request)
    {
       $user = User::findOrFail(Auth::user()->id);
        
       return $this->sendResponse();
    }
    
    /**
    *  View Blade file of Candidate Basic Information Form

    *  @param Get user id from session 
    
    *  @return Experience Information Form
    */
 
    public function career_info()
    {
        $user = User::findOrFail(Auth::user()->id);

        $response =array(
            'career_title' => $user->career_title,
            'total_experience' => $user->total_experience,
            'salary_currency' => $user->salary_currency,
            'expected_salary' => $user->expected_salary,
            'country_id' => $user->country_id,
            'location' => $user->location,
            'phone' => $user->phone,
        );
        
       return $this->sendResponse($response);
    }
    /**
     *  View Blade file of Candidate Basic Information Form

     *  @param Get user id from session 

     *  @return CareerInfo Information Form updae
     */

    public function career_infoUpdate(CareerInfoRequest $request)
    {  
       $user = User::findOrFail(Auth::user()->id);
       $user->phone = $request->phone;
       $user->career_title = $request->career_title;
       $user->total_experience = $request->exp_in_year.'.'.$request->exp_in_month;
       $user->expected_salary = (int) str_replace(',',"",$request->input('expected_salary'));
       $user->salary_currency = $request->salary_currency;
       $user->country_id = $request->country_id;
       $user->location = $request->location;
       $user->save();
       
       return $this->sendResponse();
    
    }
 
    /**
     *  View Blade file of Candidate Basic Information Form

     *  @param Get user id from session 

     *  @return Skills Information Form
     */
    public function skills()
    {
       
       $user = User::findOrFail(Auth::user()->id);  
       $title =  $user->career_title??'';
       $user_skill_id = UserSkill::whereUserId($user->id)->pluck('skill_id')->toArray();

       $suggestedskill = JobSkill::whereHas('job', function($q) use($title){
                           $q->where('title', 'like', '%' . $title . '%');
                       })
                       ->whereNotIn('skill_id',$user_skill_id)
                       ->select('job_skills.skill_id', \DB::raw('COUNT(job_skills.skill_id) as count'))
                       ->groupBy('skill_id')
                       ->orderBy('count','desc')
                       ->limit(10)
                       ->pluck('skill_id');

       $reponse['skills'] = $user->skill;

       if(count($suggestedskill)!=0){   
           $skills = Skill::whereIn('id',$suggestedskill)->pluck('skill','id')->toArray(); 
       }
       $reponse['suggested_skill'] = $skills??[];
       
       return $this->sendResponse($reponse);
    }
  
    /**
     *  View Blade file of Candidate Basic Information Form
      
     *  @param Get user id from session 
     
     *  @return Skills Information Form     
     */
     public function skillsUpdate(SkillRequest $request)
     {

       $user = User::findOrFail(Auth::user()->id);
       $skills = [];
       $words = DataArrayHelper::blockedKeywords();

       foreach(json_decode($request->skills) as $skill)
       {
           if(!isset($skill->id) && !in_array($skill->value, $words))
           {                
               if(Skill::where('skill',$skill->value)->doesntExist())
               {
                   $newskill = new Skill();                
                   $newskill->skill = $skill->value;
                   $newskill->is_active = 0;
                   $newskill->lang = 'en';
                   $newskill->is_default = 1;
                   $newskill->save();
                   $newskill->skill_id = $newskill->id;
                   $newskill->update();
               }else{
                   $newskill = Skill::where('skill',$skill->value)->first();
               }
           }

           if(isset($skill->id) || isset($newskill->id))
           {    
               $skill_id = $skill->id??$newskill->id;       
               if(UserSkill::where('skill_id',$skill_id)->doesntExist())
               {                
                   $updateSkill = new UserSkill();
                   $updateSkill->user_id = $user->id;
                   $updateSkill->skills  = $skill->value;
                   $updateSkill->skill_id  = $skill_id;
                   $updateSkill->save();
               }
               $skills[] = array(
                   'id'=>$skill_id,
                   'value'=>$skill->value,
               );
           }
       }
       $user->skill = json_encode($skills);
       $user->save();

       return $this->sendResponse();

     }
 
    /**
    *  View Blade file of Candidate Basic Information Form

    *  @param Get user id from session 

    *  @return Languages Information Form
    */
     public function languages()
     {
        
        $user = User::findOrFail(Auth::user()->id);  
        $title =  $user->career_title??'';
        $user_skill_id = UserSkill::whereUserId($user->id)->pluck('skill_id')->toArray();
 
        $suggestedskill = JobSkill::whereHas('job', function($q) use($title){
                            $q->where('title', 'like', '%' . $title . '%');
                        })
                        ->whereNotIn('skill_id',$user_skill_id)
                        ->select('job_skills.skill_id', \DB::raw('COUNT(job_skills.skill_id) as count'))
                        ->groupBy('skill_id')
                        ->orderBy('count','desc')
                        ->limit(10)
                        ->pluck('skill_id');
 
        $reponse['skills'] = $user->skill;
 
        if(count($suggestedskill)!=0){   
            $skills = Skill::whereIn('id',$suggestedskill)->pluck('skill','id')->toArray(); 
        }
        $reponse['suggested_skill'] = $skills??[];
        
        return $this->sendResponse($reponse);
     }
   
    /**
    *  View Blade file of Candidate Basic Information Form
    
    *  @param Get user id from session 
    
    *  @return Languages Information Form     
    */
    public function languagesUpdate(SkillRequest $request)
    {

    $user = User::findOrFail(Auth::user()->id);
    $skills = [];
    $words = DataArrayHelper::blockedKeywords();

    foreach(json_decode($request->skills) as $skill)
    {
        if(!isset($skill->id) && !in_array($skill->value, $words))
        {                
            if(Skill::where('skill',$skill->value)->doesntExist())
            {
                $newskill = new Skill();                
                $newskill->skill = $skill->value;
                $newskill->is_active = 0;
                $newskill->lang = 'en';
                $newskill->is_default = 1;
                $newskill->save();
                $newskill->skill_id = $newskill->id;
                $newskill->update();
            }else{
                $newskill = Skill::where('skill',$skill->value)->first();
            }
        }

        if(isset($skill->id) || isset($newskill->id))
        {    
            $skill_id = $skill->id??$newskill->id;       
            if(UserSkill::where('skill_id',$skill_id)->doesntExist())
            {                
                $updateSkill = new UserSkill();
                $updateSkill->user_id = $user->id;
                $updateSkill->skills  = $skill->value;
                $updateSkill->skill_id  = $skill_id;
                $updateSkill->save();
            }
            $skills[] = array(
                'id'=>$skill_id,
                'value'=>$skill->value,
            );
        }
    }
    $user->skill = json_encode($skills);
    $user->save();

    return $this->sendResponse();

    }

    /**
    *  Upload file of Candidate Resume

    *  @param Post user id from session 

    *  @return Resume File to s3
    */
    public function uploadResume(ResumeUploadRequest $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $path = Storage::disk('s3')->put('candidate/'.$user->token.'/file', $request->file);
        $url = Storage::disk('s3')->url($path);

        $UserCv = new UserCv();
        $UserCv->path = $path;
        $UserCv->cv_file = $url;
        $UserCv->user_id = $user->id;
        $UserCv->is_default = 1;
        $UserCv->save();
        
        $user = User::findOrFail(Auth::user()->id);  
        $user->device_token = $request->device_token;
        $user->device_type = $request->device_type;           
        $user->next_process_level = 'completed';
        $user->is_active = 1;
        $user->save();
    
        // User signup
        event(new UserRegistered($user)); 

        return $this->sendResponse('', 'Signup Completed');
                
    }

    /**
     * GetProfile api
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $data =  User::find(Auth::user()->id);            
        return $this->sendResponse($data);
    }
    
}