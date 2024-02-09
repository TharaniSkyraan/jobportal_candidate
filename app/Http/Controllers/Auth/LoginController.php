<?php



namespace App\Http\Controllers\Auth;

use App\Model\User;

use Hash;

use Auth;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

use Session;

use Laravel\Socialite\Facades\Socialite;

use SocialiteProviders\Manager\SocialiteWasCalled;

use Cookie;

use Illuminate\Support\Str;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

use Jrean\UserVerification\Traits\VerifiesUsers;

use Jrean\UserVerification\Facades\UserVerification;

use App\Http\Requests\Front\SIgnup_SigninPasswordRequest;

use App\Traits\ShareToLayout;

class LoginController extends Controller
{

    /*

      |--------------------------------------------------------------------------

      | Login Controller

      |--------------------------------------------------------------------------

      |

      | This controller handles authenticating users for the application and

      | redirecting them to your home screen. The controller uses a trait

      | to conveniently provide its functionality to your applications.

      |

     */



    use AuthenticatesUsers, ShareToLayout;



    /**

     * Where to redirect users after login.

     *

     * @var string

     */
    protected $redirectToUser = '/home';

    protected $redirectTo = '/postedjobslist';



    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()
    {
        $this->middleware('guest')->except(['logout','UserSwitchRedirect']);
        
    }

    public function logout(Request $request) {
        Auth::logout();
        return back();
    }
    
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        $this->shareSeoToLayout('candidate_login');  
        return view('auth.login');
    }

    /** 
     * 
     * Social Login Or Signup (Candidate / Employer) 
    
     * Redirect the user to the OAuth Provider.

     * @return Response

     */

     public function redirectToProvider($provider)
     {
         return Socialite::driver($provider)->stateless()->redirect();
     }
 
     /**
 
      * Obtain the user information from provider.  Check if the user already exists in our
 
      * database by looking up their provider_id in the database.
 
      * If the user exists, log them in. Otherwise, create a new user then log them in. After that 
 
      * redirect them to the authenticated users homepage.
 
      *
 
      * @return Response
 
      */
 
     public function handleProviderCallback(Request $request,$provider)
     {
        if($request->has('error')){
            if($provider=='facebook'){
                return redirect('login')->with("error", $request->error_description);   
            }elseif($provider=='apple'){
                return redirect('login')->with("error", $request->error);   
            }
        }
         
        $user = Socialite::driver($provider)->stateless()->user();
        
        if($user->getEmail() != '' && !isset($user->user['is_private_email'])) 
        {
            $data['provider'] = $provider;
            $data['provider_id'] = $user->getId(); 
            if($provider=='apple'){
                $data['apple_provider_id'] = $user->getId(); 
            }

            $str = $user->getName() . $user->getId() . $user->getEmail();
            $email = $user->getEmail();
            $providerId = $user->getId();
            $names = !empty($email)?explode('@',$email):'';

            if(User::where('email',$email)->doesntExist()){

                $data['first_name'] = $user->getName()??(!empty($names)?$names[0]:''); 
                $data['email'] = $user->getEmail();
                $data['password'] = bcrypt($str); 
                $data['next_process_level'] =  'education';
                $data['is_active'] = 0; 
                $data['verified'] = 1; 
                $data['token']=$this->generateRandomString(8);
            
                $user = User::create($data);

                $user = User::findorFail($user->id);

                $update = User::findorFail($user->id);
                $update->candidate_id = $this->generateCandidate($user->id);
                $update->save();
               
                $page = $this->SwitchRedirect('education');
            }else{

                $user = User::where('email',$email)->first();
                $user_id = $user->id;
                
                if($user->next_process_level=='verify_otp'){
                    
                    $data['next_process_level'] =  'education';
                    $data['is_active'] = 0; 
                    $data['verified'] = 1; 
                    User::where('email',$email)->update($data);
                }else{
                    User::where('email',$email)->update($data);
                }
                $user = User::findorFail($user->id);
                $page = $this->SwitchRedirect($user->next_process_level);
            }
            Auth::login($user, true);
            session(['id' => $user->id]);
            return redirect($page);
        }elseif(isset($user->user['is_private_email'])){
            
            if(User::where('apple_provider_id',$user->getId())->exists())
            {
                $user = User::where('apple_provider_id',$user->getId())->first();
                $page = $this->SwitchRedirect($user->next_process_level);
                Auth::login($user, true); session(['id' => $user->id]);
                return redirect($page);
            }
            return redirect('login')->with("error", 'Something went wrong!');   
        }

        return redirect('/login');

    }

     //============================End / Social Signin or Signup========================//
 
     
     /**
 
      * Check Exisiting UserAccount And Login/Signup.
 
      * @return Response
 
      */
 
     public function accountVerification(Request $request)
     {
        DB::beginTransaction();
 
        try {

            if(empty($request->user_type)){
                
                if(User::where('email',$request->email)->doesntExist()){
                    return Response()->json(['user_type' => 'new'], 200); 
                }else{
                    return Response()->json(['user_type' => 'existing'], 200); 
                }
            }else
            if($request->user_type=='new')
            {
                $user = User::create([
                            'first_name' => $request->name, 
                            'email' => $request->email, 
                            'is_active' => 0, 
                            'verified' => 0,
                            'password' => Hash::make($request->password),
                            'next_process_level' => 'verify_otp',
                            'token'=>$this->generateRandomString(8),
                        ]);  
                $user = User::findorFail($user->id);

                $update = User::findorFail($user->id);
                $update->candidate_id = $this->generateCandidate($user->id);
                $update->save();
               
                $page = $this->SwitchRedirect('verify_otp');

            }else
            {

                $user = User::whereEmail($request->email)->first();

                if(isset($request->password)){
                    if(! Hash::check( $request->password , $user->password))
                    {
                        return Response()->json(['errors' => array('password' => 'Invalid Password')], 422);
                    }
                }   
                if($user->verified==1){
                    Auth::login($user, true); 
                }
                
                $page = $this->SwitchRedirect($user->next_process_level);
            }
            DB::commit();
            session(['id' => $user->id]);

            return Response()->json(['success' => true, 'page'=>$page], 200);

        }catch (\Exception $e) {
            // DB::roleback();
            return Response()->json(['errors' => array('email' => 'Invalid Email. Please try again')], 422);
        }
 
 
     }
       /**
 
      * Signup / Signin Password
       
      * @param $request password, phone number (optional)
      
      * @return redirect to next page according signup level by using *\SwitchRedirect
      
      */
 
    public function verifyOtp(Request $request)
    {
        
        $user = User::findOrFail(Session::get('id'));
        $otp = '';
        if(empty($user->verify_otp)){
            $otp = $this->generateRandomCode(6);
            $user->verify_otp = $otp;
            $user->session_otp = Carbon::now();
            $user->save();
            $user = User::findOrFail(Session::get('id'));
            Auth::login($user, true); 
            UserVerification::generate($user);
            UserVerification::send($user, 'User Verification', config('mail.recieve_to.address'), config('mail.recieve_to.name'));
            Auth::logout();
        }
            
        return view('auth.verify_otp',compact('user','otp'));      

    }

       /**
 
      * Signup / Signin Password
       
      * @param $request password, phone number (optional)
      
      * @return redirect to next page according signup level by using *\SwitchRedirect
      
      */
 
    public function VerifySignup(Request $request)
    {

        $user = User::find(Session::get('id'));
        $startdate = Carbon::parse($user->session_otp);
        $enddate = Carbon::now();

        if(($startdate->diffInMinutes($enddate)) > 5)  // 5 refers to 5 minutes
        {
            return Response()->json(['success' => true, 'error'=>'OTP expired. Please try again'], 422);  
        }else
        if(($request->otp != $user->verify_otp))  // 5 refers to 5 minutes
        {
            return Response()->json(['success' => true, 'error'=>'Invalid OTP.'], 422);
        }
        $user->verify_otp = null;
        $user->verified = 1;
        $user->next_process_level = 'education';
        $user->save();
        
        $page = $this->SwitchRedirect('education');
        Auth::login($user, true);
        return Response()->json(['success' => true, 'page'=>'/education'], 200);
    }
    /**
      * @param $email data
      
      * check and resend verification mail 
      
      * @return success
      */
     public function resentMail(Request $request)
     {
         
        $user = User::whereEmail($request->email)->first();
        $user->verify_otp = $this->generateRandomCode(6);
        $user->session_otp = Carbon::now();
        $user->save();

        $user =  User::whereEmail($request->email)->first();

        Auth::login($user, true); 
        UserVerification::generate($user);
        UserVerification::send($user, 'Account Verification', config('mail.recieve_to.address'), config('mail.recieve_to.name'));
        Auth::logout();
        
        return true;
     }
     
     public function UserSwitchRedirect($from='')
     {
        if(Auth::check() && !empty(Auth::user()->reset_via)){
            $user = User::find(Auth::user()->id);
            $via = $user->reset_via??'';
            $user->reset_via = Null;
            $user->save();
            Auth::logout();
            return redirect('/password/reset/success?email=')->with("message", 'Password Updated Successfully.'); 
        }
        if($from=='reset_password' && Auth::user()->next_process_level=='verify_otp')
        {              
            $user = User::find(Auth::user()->id);     
            $user->verify_otp = null;
            $user->verified = 1;
            $user->next_process_level = 'education';
            $user->save();
            return redirect('/education');
        }
         switch(Auth::user()->next_process_level) {
 
            case 'verify_otp':
                $page = "/verify_otp";
                break;
            case 'education':
                $page = '/education';
                break;
            case 'career_info':
                $page = '/career_info';
                break;
            case 'skills':
                $page = '/skills';
                break;
            case 'experience':
                $page = '/experience';
                break;
            case 'resume_upload':
                $page = '/resume_upload';
                break;
            case 'completed':
                $page = '/';
                break;
 
        }
        return redirect($page??'');         
     }
  
     /**
      
      *  Switch to Which Form Direction 
      
      * @param $next_process_level datas
      
      * @return redirect accounting signup status
      
     */
 
     public function SwitchRedirect($next_process_level)
     {
        $page = '';

        switch($next_process_level) {

            case 'verify_otp':
                $page = "/verify_otp";
                break;
            case 'education':
                $page = '/education';
                break;
            case 'career_info':
                $page = '/career_info';
                break;
            case 'skills':
                $page = '/skills';
                break;
            case 'experience':
                $page = '/experience';
                break;
            case 'resume_upload':
                $page = '/resume_upload';
                break;
            case 'completed':
                $page = '/';
                break;

        }

        return $page;
         
    }
 
}

