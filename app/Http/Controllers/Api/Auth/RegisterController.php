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
use App\Model\UserCv;
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
            }
        }        

        if(isset($user))
        {
            $response['token'] = $user->createToken($request->email)->accessToken; 
            $response['next_process_level'] = $user->next_process_level;
            
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
        if(User::where('email',$request->email)->doesntExist())
        {
            $otp = $this->generateRandomCode(6);
            $data = $request->all();
            $data['verify_otp'] = $otp;
            $data['session_otp'] = Carbon::now();
            $data['password'] = Hash::make($request->password);
            $data['next_process_level'] = 'verify_otp';
            $user = User::create($data);
            dd($data);
            
            Auth::login($user, true); 
            UserVerification::generate($user);
            UserVerification::send($user, 'User Verification', config('mail.recieve_to.address'), config('mail.recieve_to.name'));
            Auth::logout();

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
  dd($request->all());
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
        $user->save();
        
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
        
        $user = User::find($request->id);
        $user->verify_otp = $this->generateRandomCode(6);
        $user->session_otp = Carbon::now();
        $user->save();

        $user =  User::find($request->id);

        Auth::login($user, true); 
        UserVerification::generate($user);
        UserVerification::send($user, 'Account Verification', config('mail.recieve_to.address'), config('mail.recieve_to.name'));
        Auth::logout();
        
        return $this->sendResponse(['id'=>$user->id], 'Verification OTP Send Successful.');

    }
    
    /**
     *  View Blade file of Candidate Basic Information Form

     *  @param Get user id from session 

     *  @return Education Information Form

     */
    public function education()
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

    public function educationSave(EducationRequest $request)
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

        if($user->next_process_level == 'education'){                
            $user->next_process_level = 'experience';
            $user->save();
        }

        return $this->sendResponse();

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
       if($user->next_process_level == 'experience'){                
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
     
     * 
     
     *  @param Get user id from session 
     
     * 
     
     *  @return Experience Information Form
     
     * 
     
     */

    public function careerInfoSave(CareerInfoRequest $request)
    {  
       $user = User::findOrFail(Auth::user()->id);
       $user->phone = $request->phone;
       $user->career_title = $request->career_title;
       $user->total_experience = $request->exp_in_year.'.'.$request->exp_in_month;
       $user->expected_salary = (int) str_replace(',',"",$request->input('expected_salary'));
       $user->salary_currency = $request->salary_currency;
       $user->country_id = $request->country_id;
       $user->location = $request->location;
       if($user->next_process_level == 'career_info'){                
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

       $reponse['skills'] = $user->skill;

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
       if($user->next_process_level == 'skills'){                
           $user->next_process_level = 'resume_upload';
       }

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