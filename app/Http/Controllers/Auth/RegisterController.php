<?php

namespace App\Http\Controllers\Auth;
 
use Auth;
use Session;
use App\Model\User;
use App\Model\UserExperience;
use App\Model\UserCv;
use App\Model\Skill;
use App\Model\AccountType;
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
        $this->middleware('auth')->except('getVerification', 'getVerificationError');
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
        $user = User::findOrFail(Session::get('id'));
        return view('user.signup.education')->with('user', $user);
     
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
        $user = User::findOrFail(Session::get('id'));
         
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
 
     public function CareerInfo()
     {
        $user = User::findOrFail(Session::get('id'));
         
        return view('user.signup.career_info')->with('user', $user);
     
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
         $user = User::findOrFail(Session::get('id'));  
 
         if(count($user->userSkills)==0){   
             $skill_id = DataArrayHelper::usedTools(Session::get('id'));
             $skills = Skill::whereIn('id',$skill_id)->pluck('skill','id')->toArray(); 
         }
           
         return view('user.signup.skills')->with(['user'=> $user,'skills'=>$skills??array()]);
     
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
        $user = User::findOrFail(Session::get('id'));
        
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
        

        return response()->json(array('success' => true));
                
    }

   
    public function CompleteSignup(){
        
        $user = User::findOrFail(Session::get('id')); 
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