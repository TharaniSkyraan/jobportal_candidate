<?php



namespace App\Http\Controllers\Auth;

use App\Model\User;

use App\Model\Company;

use App\Model\AccountType;

use Hash;

use Auth;

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

     * @var string

     */

    protected $redirectToUser = '/home';

    protected $redirectToCompany = '/company/postedjobslist';

    /**

     * Create a new controller instance.

     * @return void

     */

    public function __construct()
    {

        $this->middleware('guest')->except(['logout','UserSwitchRedirect']);
        $this->middleware('company.guest')->except(['logout','UserSwitchRedirect']);
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
     
        $findDetail = $this->findOrCreateUser($user, $provider);

        // Email Verified
        if($findDetail['masterTable']->verified==1){            
            if($findDetail['masterTable']->account_type=='candidate'){
                // Login as Candidate
                Auth::login($findDetail['masterTable']->user, true);
            }else{
                // Login as Employer
                Auth::guard('company')->login($findDetail['masterTable']->company, true);
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
            return redirect($this->redirectToCompany);
        }

    }

    /**

     * If a user has registered before using social auth, return the user

     * else, create a new user object.

     * @param  $user Socialite user object

     * @param $provider Social auth provider

     * @return  User

     */

    public function findOrCreateUser($user, $provider)
    {

        $findDetail = array();
        if ($user->getEmail() != '') {

            $masterTable = AccountType::where('email', 'like', $user->getEmail())->first();
            
            $str = $user->getName() . $user->getId() . $user->getEmail();

            if ($masterTable) {

                $findDetail['masterTable'] = $masterTable;
                $findDetail['is_exist'] = 'yes';

                $masterTable->provider = $provider;
                $masterTable->provider_id = $user->getId();
                $masterTable->update(); 
                // Candidate 
                if($masterTable->account_type =='candidate'){            
                    User::where('email',$user->getEmail())->update(['verified' => 1, 'account_type_id' => $masterTable->id]);
                }   

                // Employer
                if($masterTable->account_type =='employer'){ 
                    $company = Company::where('email',$user->getEmail())->update(['verified' => 1, 'account_type_id'=>$masterTable->id]);
                }   

            }else{
                $account_type = Cookie::get('accounttype')??'candidate';
                $masterTable = AccountType::create([
                                'name' => $user->getName()??"",
                                'email' => $user->getEmail(),
                                'account_type' => $account_type,
                                'next_process_level' =>  $account_type=='candidate'?'signup_password':'company_basic_info',
                                'provider' => $provider,
                                'provider_id' => $user->getId(),
                                'password' => bcrypt($str),
                            ]);
                // Candidate 
                if($masterTable->account_type =='candidate'){            
                    User::create([
                        'first_name' => $user->getName()??'', 
                        'middle_name' => '', 
                        'last_name' => '', 
                        'name' => $user->getName()??'', 
                        'email' => $user->getEmail(), 
                        'password' => bcrypt($str), 
                        'is_active' => 0, 
                        'verified' => 1, 
                        'token'=>$this->generateRandomString(8),
                        'account_type_id' => $masterTable->id]);
                }   

                // Employer
                if($masterTable->account_type =='employer'){ 
                    $company = Company::create([
                        'name' => $user->getName()??'', 
                        'email' => $user->getEmail(), 
                        'password' => bcrypt($str), 
                        'is_active' => 0, 
                        'verified' => 1, 
                        'token'=>$this->generateRandomString(8),
                        'account_type_id'=>$masterTable->id]);
                    Company::where('id',$company->id)->update(['slug' => Str::slug($company->name, '-') . '-' . $company->id]);  
                }   
            
                $findDetail['masterTable'] = $masterTable;
                $findDetail['is_exist'] = 'no';
            }
            

        }
        
        return $findDetail;

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
            $is_login = 'no';
            $is_exist = 'no';
            $page = 'auth.password';
            $email = $request->email??Session::get('email');
            if ($email != '') {

                $masterTable = AccountType::where('email', 'like', $email)->first();

                if(!isset($masterTable)){

                    /** Create User/Employer */

                    $masterTable = $this->CreateUser($email);
                    
                    if($masterTable==false){
                        DB::rollback();
                        return back()->with("errors","Invalid Email, Please Try Again");
                    }
                }else{

                    $is_exist = 'yes';

                    /** Check Email Verified */ 

                    $check_verified = $this->CheckAccountIsVerified($masterTable);
                    
                    if($check_verified=='yes'){

                        if($masterTable->is_active==1){
                            $is_login = 'yes';
                        }

                    }

                }
                DB::commit();
                Session::forget('email');
                return view('auth.password')->with(['data'=>$masterTable,'is_exist'=>$is_exist,'is_login'=>$is_login]);

            }
        }catch (\Exception $e) {
            DB::roleback();
            return back()->with("errors","Invalid Email. Please try again.");
        }


    }
    
    /**
     
     * Check Email Verified Or not
     
     * @param $masterTable data
     
     * check and send verification mail 
     
     * @return success
     */

    public function CheckAccountIsVerified($masterTable)
    {
        
        $is_already_verified = 'yes';
        
        // Candidate
        if($masterTable->account_type=='candidate' && $masterTable->user->verified==0){
            $is_already_verified = 'no';  
        }
        
        // Employer
        if($masterTable->account_type=='employer' && $masterTable->company->verified==0){
            $is_already_verified = 'no';   
        }           

        AccountType::find($masterTable->id)->update([
            'provider' => null, 
            'provider_id' => null
        ]);

        return $is_already_verified;
    }

    /**

     * If a user has registered before  

     * else, create a new user object.

     * @param  $email user/employer object

     * @return  $fulldetail of candidate/employer

     */

    public function CreateUser($email)
    {

       try{
            // $name = explode("@",$email);
            $name = '';
            $masterTable = AccountType::create([
                'account_type' => Cookie::get('accounttype'),
                'name' => '',
                'email' => $email,
                'next_process_level' => 'signup_password',
            ]);

            // Candidate 
            if($masterTable->account_type =='candidate'){
                $user = User::create(['name' => '', 'email' => $email, 'is_active' => 0, 'verified' => 0, 'account_type_id' => $masterTable->id]);  
                Auth::guard()->login($user, true);
                UserVerification::generate($user);
                UserVerification::send($user, 'Account Verification', config('mail.recieve_to.address'), config('mail.recieve_to.name'));
                Auth::guard()->logout();
            }   
            // // Employer
            // if($masterTable->account_type =='employer'){

            //     $company = Company::create(['name' => $name[0]??'', 'email' => $email, 'is_active' => 0, 'verified' => 0, 'account_type_id' => $masterTable->id]);  
            //     $company = Company::findorFail($company->id);
            //     $company->slug = Str::slug($company->name, '-') . '-' . $company->id;
            //     $company->save();  

            //     Auth::guard('company')->login($company, true); 
            //     UserVerification::generate($company);
            //     UserVerification::send($company, 'Company Verification', config('mail.recieve_to.address'), config('mail.recieve_to.name'));
            //     Auth::guard('company')->logout();
            // }   

            return $masterTable;
        } catch(\Exception $e){
           return false;
        }
      
    }

    /**

     * Signup / Signin Password
      
     * @param $request password, phone number (optional)
     
     * @return redirect to next page according signup level by using *\SwitchRedirect
     
     */

    public function signupAccount(SIgnup_SigninPasswordRequest $request){
     
        DB::beginTransaction();

        try {
            $emailIsVerfied = $this->emailIsVerfied($request->email);
            $url = '';
            if($emailIsVerfied =='no'){
                return Response()->json(['emailIsVerfied' => 'no'], 200); 
            }elseif($emailIsVerfied =='yes'){

                $masterTable = AccountType::whereEmail($request->email)->first();
        
            
                /** Login Section */
        
                if($masterTable->verified == 1){
                    
                    // Login as Candidate
        
                    if($masterTable->account_type=='candidate'){
        
                        $user = User::whereEmail($request->email)->first();
                        
                        if(isset($request->password)){
                            if(! Hash::check( $request->password , $user->password)){
                                return Response()->json(['errors' => array('password' => 'Invalid Password')], 422);
                            }
                        }
                        if($request->is_login == 'yes')
                        {        
                            $url = $this->redirectToUser;
                        }
        
                    }
        
                    // Login as Employer            
                    if($masterTable->account_type=='employer'){
                            
                        $company = Company::whereEmail($request->email)->first();
                                
                        if(isset($request->password)){
                            if(! Hash::check( $request->password , $company->password)){
                                return Response()->json(['errors' => array('password' => 'Invalid Password')], 422);
                            }
                        }
                        if($request->is_login == 'yes')
                        {  
                            $url = $this->redirectToCompany;
                        }
                    }
                }
        
                /** Signup Section */
        
                if($masterTable->verified==0){
        
                    $masterTable = AccountType::findorFail($masterTable->id);
                    $masterTable->phone = $request->full_number;
                    $masterTable->next_process_level = ($request->account_type == 'candidate' ? 'user_basic_info' : 'company_basic_info');
                    $masterTable->verified = 1;
                    $masterTable->save();
                    
                    if($masterTable->account_type !=$request->account_type){
                        
                        $masterTable = AccountType::findorFail($masterTable->id);
                        $masterTable->account_type = $request->account_type;
                        $masterTable->save();
                            
                        if($request->account_type=='candidate'){
            
                            $user_check = User::whereEmail($email)->first();
                            $data = array(
                                'first_name' => $masterTable->name, 
                                'middle_name' => '', 
                                'last_name' => '', 
                                'name' => $masterTable->name, 
                                'email' => $masterTable->email, 
                                'phone' => $request->full_number, 
                                'password' => ($request->password)?bcrypt($request->input('password')):null, 
                                'is_active' => 0, 
                                'verified' => 1, 
                                'account_type_id' => $masterTable->id,
                                'token'=>$this->generateRandomString(8)
                            );
                            if(isset($user_check)){
                                $user = User::where('id',$user_check->id)->update($data);  
                            }else{
                                $user = User::create($data);  
                            }
                            
                        }else{
            
                            $company_check = Company::whereEmail($masterTable->email)->first();
                            $data = array(
                                'name' => $masterTable->name,
                                'email' => $masterTable->email, 
                                'is_active' => 0, 
                                'verified' => 1, 
                                'phone' => $request->full_number, 
                                'password' => ($request->password)?bcrypt($request->input('password')):null, 
                                'account_type_id' => $masterTable->id,
                                'token'=>$this->generateRandomString(8)
                            );
                            if(isset($company_check)){
                                $company = Company::where('id',$company_check->id)->update($data); 
                            }else{
                                $company = Company::create($data);
                                $company = Company::findorFail($company->id);
                                $company->slug = Str::slug($company->name, '-') . '-' . $company->id;
                                $company->save();  
                            }  
            
                        }
            
                    }else{
        
                        if($masterTable->account_type=='candidate'){
        
                            $user = User::findorFail($masterTable->user->id);
                            $user->phone = $request->full_number;
                            $user->token = $this->generateRandomString(8);
                            $user->password = ($request->password)?bcrypt($request->input('password')):null;
                            $user->save();
                
                        }else{
                
                            $company = Company::findorFail($masterTable->company->id);
                            $company->phone = $request->full_number;
                            $company->token = $this->generateRandomString(8);
                            $company->password = ($request->password)?bcrypt($request->input('password')):null;
                            $company->save();
                
                        }
        
                    }
        
                }
                DB::commit();
                
                $masterTable = AccountType::findorFail($masterTable->id);
                ($masterTable->account_type=='candidate')? Auth::login($masterTable->user, true) : Auth::guard('company')->login($masterTable->company, true);
        
                return Response()->json(['url' => ($url != '' ? $url : $this->SwitchRedirect($masterTable))], 200);
                
            }
            
        }catch (\Exception $e) {
            DB::roleback();
            return back();
        }


    }

    /**

     * Ajax
     
     * Check Email is Verified Before Create User candidate / employer

     * @param  $email 

     * @return  status of yes / no

     */
    public function emailIsVerfied($email)
    {

        $masterTable = AccountType::whereEmail($email)->first();
        $is_verified = 'no';

        if(isset($masterTable)){
            if($masterTable->account_type=='candidate'){

                if($masterTable->user->verified == 1){
                    $is_verified = 'yes';
                }
            }else{
    
                if($masterTable->company->verified == 1){
                    $is_verified = 'yes';
                }
            }
        }

        return $is_verified;
    }


    public function resentMail(Request $request)
    {
        
        $masterTable = AccountType::whereEmail($request->email)->first();

        // Candidate 
        if($masterTable->account_type =='candidate'){

            $user = $masterTable->user;
            Auth::guard()->login($user, true); 
            UserVerification::generate($user);
            UserVerification::send($user, 'Account Verification', config('mail.recieve_to.address'), config('mail.recieve_to.name'));
            Auth::guard()->logout();
            
        }   

        // // Employer
        // if($masterTable->account_type =='employer'){

        //     $company = $masterTable->company;p
        //     Auth::guard('company')->login($company, true); 
        //     UserVerification::generate($company);
        //     UserVerification::send($company, 'Company Verification', config('mail.recieve_to.address'), config('mail.recieve_to.name'));
        //     Auth::guard('company')->logout();
       
        // }  

        return true;
    }
    /**
     
     *  Switch to Which Form Direction 
     
     * @param $masterTable datas
     
     * @return redirect accounting signup status
     
    */

    public function SwitchRedirect($data){
        
        $id = $data->account_type == 'candidate' ? $data->user->id : $data->company->id;
    
        session(['id' => $id, 'account_type' => $data->account_type]);
        
        $page = '';

        switch($data->next_process_level) {

            case 'signup_password':
                $page = "auth.password";
                break;
            case 'user_basic_info':                
                $page = '/basic_info';
                break;
            case 'user_education':
                $page = '/education';
                break;
            case 'user_experience':
                $page = '/experience';
                break;
            case 'user_skills':
                $page = '/skills';
                break;
            case 'user_languages':
                $page = '/languages';
                break;
            case 'company_basic_info':
                $page = '/company/basic_info';
                break;
            case 'job_info':
                $page = '/company/job_info';
                break;
            case 'job_requirements':
                $page = '/company/job_requirements';
                break;
            case 'benefits':
                $page = '/company/benefits';
                break;
            case 'contact_person_details':
                $page = '/company/contact_person_details';
                break;
            case 'job_preview':
                $page = '/company/job_preview';
                break;
            case 'company_dashboard':
                $page = '/company/postedjobslist';
                break;

        }

        return $page;
        
    }

    public function UserSwitchRedirect()
    {

        $data = (Auth::user()??Auth::guard('company')->user());
        
        session(['id' => $data->id, 'account_type' => $data->AccountType->account_type]);
       
        $page = '/';

        if($data->AccountType->next_process_level == 'signup_password'){
            return view("auth.password")->with(['data'=>$data->AccountType,'is_exist'=>'no','is_login'=>'no']);
        }

        switch($data->AccountType->next_process_level) {

            case 'user_basic_info':                
                $page = '/basic_info';
                break;
            case 'user_education':
                $page = '/education';
                break;
            case 'user_experience':
                $page = '/experience';
                break;
            case 'user_skills':
                $page = '/skills';
                break;
            case 'user_languages':
                $page = '/languages';
                break;
            case 'company_basic_info':
                $page = '/company/basic_info';
                break;
            case 'job_info':
                $page = '/company/job_info';
                break;
            case 'job_requirements':
                $page = '/company/job_requirements';
                break;
            case 'benefits':
                $page = '/company/benefits';
                break;
            case 'contact_person_details':
                $page = '/company/contact_person_details';
                break;
            case 'screening':
                $page = '/company/screening';
                break;
            case 'job_preview':
                $page = '/company/job_preview';
                break;
            case 'company_dashboard':
                $page = '/company/postedjobslist';
                break;

        }

        return redirect($page);
        
    }
 
}

