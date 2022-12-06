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
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/redirect_user';
    protected $redirectAfterVerification = '/email_verified';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        // if(isset($request->email)){
        //     session(['email' => $request->email]);
        // }
      
        $this->middleware(function ($request, $next) {
            
            if(Session::get('account_type') == 'candidate')
            {
                return $next($request);
            }else{
                abort(404);
            }
        })->except('getVerification', 'getVerificationError');

    }

    /**
     *  View Blade file of Candidate Basic Information Form
     
     * 
     
     *  @param Get user id from session 
     
     * 
     
     *  @return Basic Information Form
     
     * 
     
     */
    public function basicInfo()
    {
        // dd(Auth::user()->is_active);
        $genders = DataArrayHelper::langGendersArray();
        $maritalStatuses = DataArrayHelper::langMaritalStatusesArray();
        $countries = DataArrayHelper::CountriesArray();
        $noticePeriod = DataArrayHelper::langNoticePeriodsArray();
        $user = User::findOrFail(Session::get('id'));
        return view('user.basic_info')
                        ->with('genders', $genders)
                        ->with('maritalStatuses', $maritalStatuses)
                        ->with('countries', $countries)
                        ->with('noticePeriod', $noticePeriod)
                        ->with('user', $user??'');
    
    }

    /**
     *  Save User Basic Information in Signup
     
     * 
     
     *  @param $request
     
     * 
     
     *  @return redirect next education level
     
     * 
     
     */

    public function basicInfoSave(UserFrontRegisterFormRequest $request)
    {
        $request['date_of_birth'] = Carbon::parse($request->date_of_birth)->format('Y-m-d');
        $user = User::findOrFail(Session::get('id'));
        $account_type_id = $user->account_type_id;
        $user->update($request->all());

        // Update Signup Processing Level
        $masterTable = AccountType::findorFail($account_type_id);
        if($masterTable->next_process_level == 'user_basic_info'){
            $masterTable->next_process_level = 'user_education';
            $masterTable->save();
        }
        
        return redirect('/education');

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
            // $is_deleted = $this->deleteUserfile($user->id);

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
        return view('user.education')->with('user', $user);
    
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
        
        return view('user.experience')->with('user', $user);
    
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
          
        return view('user.skills')->with(['user'=> $user,'skills'=>$skills??array()]);
    
    }
    
    /**
     *  View Blade file of Candidate Basic Information Form
     
     * 
     
     *  @param Get user id from session 
     
     * 
     
     *  @return Languages Information Form
     
     * 
     
     */

    public function Languages()
    {
        $user = User::findOrFail(Session::get('id'));  

        return view('user.languages')->with(['user'=> $user]);
    }


    public function CompleteSignup(){
        
        $user = User::findOrFail(Session::get('id')); 
        // User signup
        // event(new Registered($user));
        // event(new UserRegistered($user));   
        User::where('id',$user->id)->update(['is_active'=>1]);
        $masterTable = AccountType::findorFail($user->account_type_id);
        $masterTable->next_process_level = 'user_dashboard';
        $masterTable->is_active = 1;
        $masterTable->save();
        Auth::login($user, true);

        Session::forget('id');
        Session::forget('account_type');
        return redirect('/');
    }

    
}