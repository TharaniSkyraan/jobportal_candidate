<?php

namespace App\Http\Controllers\Auth;
 
use Auth;
use Session;
use App\Model\User;
use App\Model\UserEducation;
use App\Model\UserExperience;
use App\Model\UserCv;
use App\Model\UserSkill;
use App\Model\JobSkill;
use App\Model\Skill;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;
use App\Http\Requests\Front\UserFrontRegisterFormRequest;
use App\Helpers\DataArrayHelper;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use Illuminate\Auth\Events\Registered;
use App\Events\UserRegistered;

class RegisterController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

    use RegistersUsers;
    use VerifiesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('checkauth')->except('getVerification', 'getVerificationError');

    }

    /**
     *  View Blade file of Candidate Basic Information Form
     
     * 
     
     *  @param Get user id from session 
     
     * 
     
     *  @return Education Information Form
     
     * 
     
     */

     public function Education()
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

        
        return view('user.signup.education', compact('education','educationLevels','educationTypes'));
    }
 
    /**
     *  View Blade file of Candidate Basic Information Form
     
     * 
     
     *  @param Get user id from session 
     
     * 
     
     *  @return Education Information Form
     
     * 
     
     */

     public function EducationSave(Request $request)
     {
        // dd($request->all());
        $user = User::findOrFail(Auth::user()->id);

        $education  = (count($user->userEducation)>0)?$user->userEducation[0]:null;
        if(!empty($education)){
            $userEducation = UserEducation::find($education->id);
        }else{
            $userEducation = new UserEducation();
        }
        $userEducation->user_id = $user->id;
        $userEducation->education_level_id = $request->education_level_id;
        $userEducation->education_type_id = $request->education_type_id;
        $userEducation->save();

        if($user->next_process_level == 'education'){                
            $user->next_process_level = 'experience';
            $user->save();
        }

        return redirect('/experience');

     }

     /**
      *  View Blade file of Candidate Basic Information Form
      
      * 
      
      *  @param Get user id from session 
      
      * 
      
      *  @return Experience Information Form
      
      * 
      
      */
 
     public function Experience()
     {
        $user = User::findOrFail(Auth::user()->id);
         
        return view('user.signup.experience')->with('user', $user);
     
     }

     /**
      *  View Blade file of Candidate Basic Information Form
      
      * 
      
      *  @param Get user id from session 
      
      * 
      
      *  @return Experience Information Form
      
      * 
      
      */
 
     public function ExperienceSave(Request $request)
     {
        $user = User::findOrFail(Auth::user()->id);
        $user->employment_status = $request->employment_status;
        if($user->next_process_level == 'experience'){                
            $user->next_process_level = 'career_info';
        }
        $user->save();
         
        return redirect('/career_info');
     
     }
 
     /**
      *  View Blade file of Candidate Basic Information Form
      
      * 
      
      *  @param Get user id from session 
      
      * 
      
      *  @return Experience Information Form
      
      * 
      
      */
 
     public function CareerInfo()
     {
        $user = User::findOrFail(Auth::user()->id);
         
        $countries = DataArrayHelper::CountriesArray();
        return view('user.signup.career_info', compact('countries','user'));
     
     }
     /**
      *  View Blade file of Candidate Basic Information Form
      
      * 
      
      *  @param Get user id from session 
      
      * 
      
      *  @return Experience Information Form
      
      * 
      
      */
 
     public function CareerInfoSave(Request $request)
     {
        $user = User::findOrFail(Auth::user()->id);
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
        
        return redirect('/skills');
     
     }
     
 
     /**
      *  View Blade file of Candidate Basic Information Form
      
      * 
      
      *  @param Get user id from session 
      
      * 
      
      *  @return Skills Information Form
      
      * 
      
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

        

        if(count($suggestedskill)!=0){   
            $skills = Skill::whereIn('id',$suggestedskill)->pluck('skill','id')->toArray(); 
        }
        
        return view('user.signup.skills')->with(['user'=> $user,'skills'=>$skills??array()]);
    
     }
  
     /**
      *  View Blade file of Candidate Basic Information Form
      
      * 
      
      *  @param Get user id from session 
      
      * 
      
      *  @return Skills Information Form
      
      * 
      
      */
 
      public function SkillSave(Request $request)
      {
        $user = User::findOrFail(Auth::user()->id);
        $user->skill = $request->skills;
        if($user->next_process_level == 'skills'){                
            $user->next_process_level = 'resume_upload';
        }
        $user->save();

        $skills = json_decode($request->skills);
        $skill_id = array_column($skills, 'id');
        $user_skill_id = UserSkill::whereUserId($user->id)->pluck('skill_id')->toArray();
        
        $remove_id = UserSkill::whereUserId($user->id)->whereIn('skill_id',array_diff($user_skill_id,$skill_id))->delete(); 
        $skills  = array_diff($skill_id,$user_skill_id);
        foreach($skills as $skill)
        {
            $updateSkill = new UserSkill();
            $updateSkill->user_id = $user->id;
            $updateSkill->skill_id  = $skill;
            $updateSkill->save();
        }

        return redirect('/resume_upload');

      }

    /**
     *  Upload file of Candidate Resume
     
     * 
     
     *  @param Post user id from session 
     
     * 
     
     *  @return Resume File to s3
     
     * 
     
     */

     public function ResumeUpload()
     {
        $user = User::findOrFail(Auth::user()->id);
            
        return view('user.signup.resume_upload')->with('user', $user);
     }

    /**
     *  Upload file of Candidate Resume
     
     * 
     
     *  @param Post user id from session 
     
     * 
     
     *  @return Resume File to s3
     
     * 
     
     */

    public function ResumeUpdate(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        
        if ($request->hasFile('file')) {

            $request->validate([
                'file' => 'required|file|mimes:pdf,docx,doc,txt,rtf|max:2048',
            ]);        
         
            $path = Storage::disk('s3')->put('candidate/'.$user->token.'/file', $request->file);
            $url = Storage::disk('s3')->url($path);
            $UserCv = new UserCv();
            $UserCv->path = $path;
            $UserCv->cv_file = $url;
            $UserCv->user_id = $user->id;
            $UserCv->is_default = 1;
            $UserCv->save();

        }
        $user = User::findOrFail(Auth::user()->id);
        if($user->next_process_level == 'resume_upload'){                
            $user->is_active = 1;
            $user->next_process_level = 'completed';
        }
        $user->save();
        
        return redirect('/home');
                
    }

   
    public function CompleteSignup(){
        
        $user = User::findOrFail(Auth::user()->id); 
        $user->next_process_level = 'completed';
        $user->is_active = 1;
        $user->save();

        // User signup
        // event(new Registered($user));
        // event(new UserRegistered($user));   
        Auth::login($user, true);

        Session::forget('id');
        return redirect('/');
    }

    
}