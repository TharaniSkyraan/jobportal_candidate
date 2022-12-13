<?php



namespace App\Http\Controllers\Auth;

use App\Model\User;

use App\Model\AccountType;

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



    use AuthenticatesUsers;



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

         
         $findDetail = array();
         if ($user->getEmail() != '') {
 
             $user = User::where('email', $user->getEmail())->first();
             
             $str = $user->getName() . $user->getId() . $user->getEmail();
 
             if ($user) {
 
                // Employer
                User::where('email',$user->getEmail())->update(['verified' => 1, 'account_type_id'=>$masterTable->id]);
                   
 
             }else{
       
 
                 // Employer
                 $user = User::create([
                    'name' => $user->getName()??'', 
                    'email' => $user->getEmail(),
                    'next_process_level' =>  $account_type=='candidate'?'signup_password':'company_basic_info',
                    'provider' => $provider,
                    'provider_id' => $user->getId(), 
                    'password' => bcrypt($str), 
                    'is_active' => 0, 
                    'verified' => 1, 
                    'token'=>$this->generateRandomString(8)
                ]);
                User::where('id',$user->id)->update(['slug' => Str::slug($user->name, '-') . '-' . $user->id]);  
           
             }
             
 
         }
         
         return $findDetail;
 
         $findDetail = $this->findOrCreateUser($user, $provider);
 
         // Email Verified
         if($findDetail['masterTable']->verified==1){   

             if($findDetail['masterTable']->account_type=='candidate'){
                 // Login as Candidate
                 Auth::login($findDetail['masterTable']->user, true);
             }else{
                 // Login as Employer
                 Auth::login($findDetail['masterTable']->company, true);
             } 
         }
 
         if($findDetail['masterTable']->is_active==0){
 
             $page = $this->SwitchRedirect($findDetail['masterTable']);
               
             if($findDetail['masterTable']->next_process_level == 'signup_password'){
                 session(['email' => $user->getEmail()]);
                 $page = "accountverification";
                 // return view($page)->with(['data'=>$findDetail['masterTable'],'is_exist'=>$findDetail['is_exist'],'is_login'=>'no']);
             }
             return redirect($page);
 
         }else{
             
             if($findDetail['masterTable']->account_type=='candidate'){
                 return redirect($this->redirectToUser);
             }          
             return redirect($this->redirectTo);
         }
 
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
                            'name' => $request->name, 
                            'email' => $request->email, 
                            'is_active' => 0, 
                            'verified' => 0,
                            'password' => Hash::make($request->password),
                            'next_process_level' => 'verify_otp',
                            'token'=>$this->generateRandomString(8),
                        ]);  
                $user = User::findorFail($user->id);
               
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
        $user->verify_otp = $this->generateRandomCode(6);
        $user->session_otp = Carbon::now();
        $user->save();
            
        // Auth::login($user, true); 
        // UserVerification::generate($user);
        // UserVerification::send($user, 'User Verification', config('mail.recieve_to.address'), config('mail.recieve_to.name'));
        // Auth::logout();
        // if(empty($user->verify_otp))
        // {                
        // }

        return view('auth.verify_otp',compact('user'));      

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

        if(($startdate->diffInSeconds($enddate)) > 35)  // 5 refers to 5 minutes
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

        // Auth::login($user, true); 
        // UserVerification::generate($user);
        // UserVerification::send($user, 'Account Verification', config('mail.recieve_to.address'), config('mail.recieve_to.name'));
        // Auth::logout();
        
        return true;
     }
     
     public function UserSwitchRedirect()
     {
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
            case 'benefits':
                $page = '/benefits';
                break;
            case 'resume_upload':
                $page = '/resume_upload';
                break;
            case 'completed':
                $page = '/home';
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
            case 'benefits':
                $page = '/benefits';
                break;
            case 'resume_upload':
                $page = '/resume_upload';
                break;
            case 'completed':
                $page = '/home';
                break;

        }

        return $page;
         
    }
 
}

