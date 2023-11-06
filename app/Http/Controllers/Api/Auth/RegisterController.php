<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Model\User;
use App\Model\UserSkill;
use App\Model\JobSkill;
use App\Model\Skill;
use App\Model\UserEducation;
use App\Model\UserActivity;
use App\Model\UserCv;
use App\Model\ResultType;
use App\Model\Country;
use App\Model\EducationType;
use App\Model\EducationLevel;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\ResentRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\VerifyOtpRequest;
use App\Http\Requests\Api\ForgetPasswordRequest;
use App\Http\Requests\Api\EducationRequest;
use App\Http\Requests\Api\ExperienceRequest;
use App\Http\Requests\Api\SkillRequest;
use App\Http\Requests\Api\CareerInfoRequest;
use App\Http\Requests\Api\ResumeUploadRequest;
use App\Helpers\DataArrayHelper;
use App\Mail\UserResetPasswordMailable;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Events\UserRegistered;
use Carbon\Carbon;
use Validator;
use DB;
use Hash;
use Mail;
   
class RegisterController extends BaseController
{
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        if(empty($request->provider))
        {
            // normal Login
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
                $user = Auth::user(); 
            } 
        }else{
            // social login
            $user = User::whereEmail($request->email)->first();
            if(isset($user)){
                Auth::login($user, true);
                $user = Auth::user();
            }else
            {
                
                $otp = $this->generateRandomCode(6);
                $data = $request->all();
                $data['token'] = $this->generateRandomString(8);
                User::updateOrCreate(['email' => $request->email],$data);
                
                $updateUser = User::where('email',$request->email)->first();
                Auth::login($updateUser, true);
                $user = Auth::user();
                $updateUser->verify_otp = null;
                $updateUser->verified = 1;
                $updateUser->next_process_level = 'education';
                $updateUser->candidate_id = $this->generateCandidate($updateUser->id);
                $updateUser->save();
            }

        }        

        if(isset($user))
        {
            $response['token'] = $user->createToken($request->email)->accessToken; 
            $response['next_process_level'] = $user->next_process_level;
            $response['id'] = $user->id;
            
            $update = User::find($user->id);
            $update->device_token = $request->device_token;
            $update->device_type = $request->device_type;
            if($user->next_process_level == 'verify_otp'){
                $update->verify_otp = $this->generateRandomCode(6);
                $update->session_otp = Carbon::now();
                UserVerification::generate($user);
                UserVerification::send($user, 'User Verification', config('mail.recieve_to.address'), config('mail.recieve_to.name'));
                // Auth::logout();
            }
            $update->save();
            return $this->sendResponse($response, 'User login successfully.');
        }        
        
        return $this->sendError('Unauthorised.', ['error'=>'Invalid Credential']);
    }
    
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        if(User::where('email',$request->email)->doesntExist() || User::where('email',$request->email)->whereVerified(0)->exists())
        {
            $otp = $this->generateRandomCode(6);
            $data = $request->all();
            $data['verify_otp'] = $otp;
            $data['session_otp'] = Carbon::now();
            $data['password'] = Hash::make($request->password);
            $data['next_process_level'] = 'verify_otp';
            $data['token'] = $this->generateRandomString(8);
            User::updateOrCreate(['email' => $request->email],$data);

            $user = User::where('email',$request->email)->first();
            
            Auth::login($user, true); 
            UserVerification::generate($user);
            UserVerification::send($user, 'User Verification', config('mail.recieve_to.address'), config('mail.recieve_to.name'));
            Auth::logout();
            UserActivity::updateOrCreate(['user_id' => $user->id],['last_active_at'=>Carbon::now()]);

            return $this->sendResponse(['id'=>$user->id,'otp'=>$otp], 'Verification OTP Send Successful.');
        }

        return $this->sendResponse('', 'Existing'); 
    
    }
    /**
 
      * Signup / Signin Password
       
      * @param $request password, phone number (optional)
      
      * @return redirect to next page according signup level by using *\SwitchRedirect
      
      */ 
    public function verifyOTP(VerifyOtpRequest $request)
    {
        $user = User::find($request->id);
        $startdate = Carbon::parse($user->session_otp);
        $enddate = Carbon::now();

        if(($startdate->diffInMinutes($enddate)) > 5)  // 5 refers to 5 minutes
        {
            return $this->sendError('OTP expired. Please try again.', array(), 422); 
        }else
        if(($request->otp != $user->verify_otp))  // 5 refers to 5 minutes
        {
            return $this->sendError('Invalid OTP.', array(), 422); 
        }
        $user->verify_otp = null;
        $user->verified = 1;
        $user->next_process_level = 'education';
        $user->candidate_id = $this->generateCandidate($user->id);
        $user->save();
        
        $user = User::find($request->id);
        
        Auth::login($user, true);
        $response['token'] =  $user->createToken($user->email)->accessToken; 
        $response['next_process_level'] = $user->next_process_level;

        return $this->sendResponse($response, 'OTP Verified Successful.');

    }

    /**
      * @param $email data
      
      * check and resend verification mail 
      
      * @return success
      */
    public function resentOtp(ResentRequest $request)
    {
        $otp = $this->generateRandomCode(6);
        $user = User::find($request->id);
        $user->verify_otp = $otp;
        $user->session_otp = Carbon::now();
        $user->save();

        $user =  User::find($request->id);

        Auth::login($user, true); 
        UserVerification::generate($user);
        UserVerification::send($user, 'Account Verification', config('mail.recieve_to.address'), config('mail.recieve_to.name'));
        Auth::logout();
        
        return $this->sendResponse(['id'=>$request->id,'otp'=>$otp], 'Verification OTP Send Successful.');

    }
    
    /**
     *  View Blade file of Candidate Basic Information Form

     *  @param Get user id from session 

     *  @return Education Information Form

     */
    public function education()
    {
        $user = User::findOrFail(Auth::user()->id);
        $education  = (count($user->userEducation)>0)?$user->userEducation[0]:null;
        
        if(!empty($education)){
            $result_type = ResultType::find($education->result_type_id);
            $country = Country::find($education->country_id);
            $education_level = EducationLevel::find($education->education_level_id);
            $education_type = EducationType::find($education->education_type_id);
        }

        $data[] = array(
            'id'=>$education->id??0,
            'education_type_id'=>$education->education_type_id??0,
            'education_level'=>$education_level->education_level??"",
            'education_level_id' => $education->education_level_id??0,
            'education' => $education->education_type??($education_type->education_type??""),
            'institution'=>$education->institution??"",
            'country'=>(!empty($education->country_id))?$country->country:($ip_data['geoplugin_countryName']??""),
            'country_id'=>$education->country_id??0,
            'location'=>$education->location??"",
            'pursuing'=>$education->pursuing??"",
            'percentage' => $education->percentage??"",
            'percentage_val'=> "",
            'result_type_id' => $education->result_type_id??0,
            'year_of_education' =>  '',
            'from' => (!empty($education->from_year))?Carbon::parse($education->from_year)->getTimestampMs():0,
            'to' => (!empty($education->to_year))?Carbon::parse($education->to_year)->getTimestampMs():0,
        ); 
        return $this->sendResponse($data);
    }
    /**
     *  View Blade file of Candidate Basic Information Form

     *  @param Get user id from session 

     *  @return Education Information Form
     */

    public function educationSave(EducationRequest $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $education  = (count($user->userEducation)>0)?$user->userEducation[0]:null;
        if(!empty($education)){
            $userEducation = UserEducation::find($education->id);
        }else{
            $userEducation = new UserEducation();
        }
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
        $userEducation->save();

        if($user->next_process_level == 'education'||$user->next_process_level == 'experience'){                
            $user->next_process_level = 'career_info';
            $user->save();
        }

        return $this->sendResponse(['education_id'=>0]);

    }

    /**
     * Expeience api
     *
     * @return \Illuminate\Http\Response
     */
    public function experience()
    {
        $user =  User::find(Auth::user()->id);
        return $this->sendResponse($user->employment_status);
    }

    /**
     *  View Blade file of Candidate Basic Information Form
        
     *  @param Get user id from session 
      
     *  @return Experience Information Form
      
     */

    public function experienceSave(ExperienceRequest $request)
    {
       $user = User::findOrFail(Auth::user()->id);
       $user->employment_status = $request->employment_status;
       if($user->next_process_level == 'education'||$user->next_process_level == 'experience'){                
           $user->next_process_level = 'career_info';
       }
       $user->save();
        
       return $this->sendResponse();
    }
    
    /**
    *  View Blade file of Candidate Basic Information Form

    *  @param Get user id from session 
    
    *  @return Experience Information Form
    */
 
    public function careerInfo()
    {
        $user = User::findOrFail(Auth::user()->id);
        $exp = explode('.',$user->total_experience);
        $exp_in_year = $exp[0]??'';
        $exp_in_month = $exp[1]??'';  

        $response =array(
            'career_title' => $user->career_title,
            'total_experience' => $user->total_experience,
            'salary_currency' => $user->salary_currency,
            'expected_salary' => $user->expected_salary,
            'country_id' => $user->country_id,
            'prefered_location' => $user->prefered_location,
            'employment_status' => $user->employment_status??'fresher',
            'country' => $user->country->country??'',
            'exp_in_year' => $exp_in_year??0,
            'exp_in_month' => $exp_in_month??0,
        );
        
       return $this->sendResponse($response);
    }
    /**
     *  View Blade file of Candidate Basic Information Form
     
     * 
     
     *  @param Get user id from session 
     
     * 
     
     *  @return Experience Information Form
     
     * 
     
     */

    public function careerInfoSave(CareerInfoRequest $request)
    {  
       $user = User::findOrFail(Auth::user()->id);
       $user->employment_status = $request->employment_status;
       $user->career_title = $request->career_title;
       $user->total_experience = $request->exp_in_year.'.'.$request->exp_in_month;
       $user->expected_salary = (int) str_replace(',',"",$request->input('expected_salary'));
       $user->salary_currency = $request->salary_currency;
       $user->country_id = $request->country_id;
       $user->prefered_location = $request->prefered_location;
       if($user->next_process_level == 'career_info'||$user->next_process_level == 'experience'){                
           $user->next_process_level = 'skills';
       }
       $user->save();
       
       return $this->sendResponse();
    
    }
 
    /**
     *  View Blade file of Candidate Basic Information Form

     *  @param Get user id from session 

     *  @return Skills Information Form
     */

    public function Skills()
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

       $reponse['skills'] = !empty($user->skill)?json_decode($user->skill):[];

       if(count($suggestedskill)!=0){   
           $skills = Skill::whereIn('id',$suggestedskill)->pluck('skill','id')->toArray(); 
       }
       $reponse['suggested_skill'] = $skills??[];
       
       return $this->sendResponse($reponse);
    }
  
    /**
     *  View Blade file of Candidate Basic Information Form
     
     * 
     
     *  @param Get user id from session 
     
     * 
     
     *  @return Skills Information Form
     
     * 
     
     */

     public function SkillSave(SkillRequest $request)
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

       if($user->next_process_level == 'skills'){                
           $user->next_process_level = 'resume_upload';
       }

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

        $UserCv = new UserCv();
        $UserCv->path = $request->path??"";
        $UserCv->cv_file = $request->url??"";
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
    public function profileData()
    {
        $data =  User::find(Auth::user()->id);            
        return $this->sendResponse($data, 'User register successfully.');
    }
    
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $credentials = ['email' => $request->email];
        Password::sendResetLink($credentials);
        $user = User::whereEmail($request->email)->first();
        $user->reset_via = 'app';
        $user->save();                            

        return $this->sendResponse('', 'Password Reset Mail Sent Successfully!');
    } 
    /**
     * Logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        return $this->sendResponse('', 'You have been successfully logged out!');
    }

}