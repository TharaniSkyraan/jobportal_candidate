<?php

namespace App\Http\Controllers\User;

use Mail;
use Cookie;
use Auth;
use DB;
use Input;
use File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use ImgUploader;
use Carbon\Carbon;
use Redirect;
use Newsletter;
use App\Model\User;
use App\Model\Subscription;
use App\Model\ApplicantMessage;
use App\Model\Company;
use App\Model\FavouriteCompany;
use App\Model\Gender;
use App\Model\MaritalStatus;
use App\Model\Country;
use App\Model\State;
use App\Model\City;
use App\Model\ProfilePercentage;
use App\Model\Experience;
use App\Model\JobApply;
use App\Model\CareerLevel;
use App\Model\Industry;
use App\Model\Alert;
use App\Model\FunctionalArea;
use App\Model\SiteSetting;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Mail\ChangePasswordRequestMailable;
use App\Traits\CommonUserFunctions;
use App\Traits\UserSummaryTrait;
use App\Traits\UserCvsTrait;
use App\Traits\UserProjectsTrait;
use App\Traits\UserExperienceTrait;
use App\Traits\UserEducationTrait;
use App\Traits\UserSkillTrait;
use App\Traits\UserLanguageTrait;
use App\Traits\UserJobAlertTrait;
// use App\Http\Requests\Front\UserFrontFormRequest;
use App\Helpers\DataArrayHelper;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\User\ChangePasswordFormRequest;
use App\Http\Requests\User\VerifyPhoneNumberFormRequest;
use App\Http\Requests\User\ChangePhoneNumberFormRequest;
use App\Http\Requests\Front\UserFrontRegisterFormRequest;

use Twilio\Jwt\ClientToken;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class UserController extends Controller
{

    use CommonUserFunctions;
    use UserSummaryTrait;
    use UserCvsTrait;
    use UserProjectsTrait;
    use UserExperienceTrait;
    use UserEducationTrait;
    use UserSkillTrait;
    use UserLanguageTrait;
    use UserJobAlertTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['index', 'myProfile', 'updateMyProfile', 'viewPublicProfile', 'accountSettings']]);
        // $this->middleware('checkauth', ['only' => ['index']]);
    }

    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();        
        $genders = DataArrayHelper::langGendersArray();
        $maritalStatuses = DataArrayHelper::langMaritalStatusesArray();
        $noticePeriod = DataArrayHelper::langNoticePeriodsArray();
        $countries = DataArrayHelper::CountriesArray();

        return view('user.dashboard.about-me', compact('noticePeriod', 'user', 'genders', 'maritalStatuses', 'countries'));
        
    }
    
    public function viewPublicProfile($id)
    {

        $user = User::findOrFail($id);
        $UserCv = $user->getDefaultCv();

        return view('user.applicant_profile')
                        ->with('user', $user)
                        ->with('UserCv', $UserCv)
                        ->with('page_title', $user->getName())
                        ->with('form_title', 'Contact ' . $user->getName());
    }

    public function myProfile()
    {
        $user = Auth::user();
        
        $genders = DataArrayHelper::langGendersArray();
        $maritalStatuses = DataArrayHelper::langMaritalStatusesArray();
        $noticePeriod = DataArrayHelper::langNoticePeriodsArray();
        $countries = DataArrayHelper::CountriesArray();

       return view('user.dashboard.about-me', compact('noticePeriod', 'user', 'genders', 'maritalStatuses', 'countries'));
    }    

    public function accountSettings(){
        return view('user.dashboard.accounts_settings');
    }
    
    public function updateMyProfile(UserFrontRegisterFormRequest $request)
    { 
        // $request['current_salary']      = (int) str_replace(',',"",$request->input('current_salary'));
        // $request['expected_salary']      = (int) str_replace(',',"",$request->input('expected_salary'));
        $request['date_of_birth'] = Carbon::parse($request->date_of_birth)->format('Y-m-d');
        // $request['location'] = $request->user_location;
        // dd($request->all());
        $user = User::findOrFail(Auth::user()->id)->update($request->all());
    
        return \Redirect::route('home')->with('message',' Updated Succssfully!');
    }
    
    public function updateCareer(Request $request)
    { 
        $request['expected_salary']      = (int) str_replace(',',"",$request->input('expected_salary'));
        $request['location'] = $request->location;       
        $request['career_title'] = $request->career_title;
        $request['notice_period'] = $request->notice_period;
        $request['total_experience'] = ($request->exp_in_year??0).'.'.($request->exp_in_month??0);
        $request['salary_currency'] = $request->salary_currency;
        $request['country_id'] = $request->country_id;
        if($request['total_experience']==0.0){
            $request['employment_status'] = 'fresher';
        }

        $user = User::findOrFail(Auth::user()->id)->update($request->all());
    
        return \Redirect::back()->with('message',' Updated Succssfully!');
    }
    
    public function ProfileUpdate(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);        
        $image_array_1 = explode(";", $request->image);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        $imageName = time() . '.png';
        $fold_path = "candidate/$user->token/profile_image/$imageName";
        $path = Storage::disk('s3')->put($fold_path, $data);
        $path = Storage::disk('s3')->url($fold_path);
        $user->image = $path;
        $user->save();
        
        return response()->json(array('success' => true, 'status' => 200, 'img'=>$path), 200);
           
    }

    public function base64_to_jpeg($base64_string, $output_file) {
        // open the output file for writing
        $ifp = fopen( $output_file, 'wb' ); 
        $data = explode( ',', $base64_string );
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );
        fclose( $ifp ); 
    
        return $base64_string; 
    }

    public function SendRequest(ChangePhoneNumberFormRequest $request)
    {
        $verification_token = $this->generateRandomCode(6);
        $user = User::find(Auth::user()->id);
        $user->verification_token = $verification_token;
        $user->session_otp = Carbon::now();
        $user->save();
        $this->Notification($request->phone,$verification_token);
        // Mail::send(new ChangePasswordRequestMailable($user));
           
        // $settings = SiteSetting::findOrFail(1272);
        // $account_sid = $settings->twilio_account_sid;
        // $auth_token = $settings->twilio_auth_token;   
        // $twilio_number = $settings->twilio_number;
        // $client = new Client(['auth' => [$account_sid, $auth_token]]);
        // $result = $client->post('https://api.twilio.com/2010-04-01/Accounts/'.$account_sid.'/Messages.json',
        //         ['form_params' => [
        //         'Body' => 'CODE:'.$verification_token, //set message body
        //         'To' => '+917402171681',
        //         'From' => $twilio_number //we get this number from twilio
        //         ]]);

        return response()->json(array('success' => true, 'status' => 200, 'token' => $verification_token), 200);

    }

    public function VerifyOtp(VerifyPhoneNumberFormRequest $request)
    {
        $user = User::find(Auth::user()->id);
        $startdate = Carbon::parse($user->session_otp);
        $enddate = Carbon::now();

        if(($startdate->diffInMinutes($enddate)) > 5)  // 5 refers to 5 minutes
        {
            return response()->json(['errors' => ["otp" => "OTP was expired. Please try again."]], 422);
        }
        if(($request->otp != $user->verification_token))  // 5 refers to 5 minutes
        {
            return response()->json(['errors' => ["otp" => "Invalid OTP. Please try again."]], 422);
        }
        $user->phone = $request->phone;
        $user->verification_token = null;
        $user->is_mobile_verified = 'yes';
        $user->save();

        return response()->json(array('success' => true, 'status' => 200), 200);

    }

    public function ChangePassword(ChangePasswordFormRequest $request){
    
        if (!(Hash::check($request->post('old_password'), Auth::user()->password))) {
            // The passwords matches
            return response()->json(['errors' => ["old_password" => "Your old password does not matches with the current password"]], 422);
        }
        if ((Hash::check($request->post('password'), Auth::user()->old_password)) || (Hash::check($request->post('password'), Auth::user()->prev_old_password))) {
            // The passwords matches
            return response()->json(['errors' => ["password" => "Entered password matches with the last 3 passwords which you have used."]], 422);
        }
        // Change Password
        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($request->post('password'));
        $user->old_password = Auth::user()->password;
        $user->prev_old_password = Auth::user()->old_password;
        $user->save();

        return response()->json(array('success' => true, 'status' => 200), 200);
        
    }

    public function addToFavouriteCompany(Request $request, $company_slug)
    {
        $data['company_slug'] = $company_slug;
        $data['user_id'] = Auth::user()->id;
        $data_save = FavouriteCompany::create($data);
        flash(__('Company has been added in favorites list'))->success();
        return \Redirect::route('company.detail', $company_slug);
    }

    public function removeFromFavouriteCompany(Request $request, $company_slug)
    {
        $user_id = Auth::user()->id;
        FavouriteCompany::where('company_slug', 'like', $company_slug)->where('user_id', $user_id)->delete();

        flash(__('Company has been removed from favorites list'))->success();
        return \Redirect::route('company.detail', $company_slug);
    }

    public function myFollowings()
    {
        $user = User::findOrFail(Auth::user()->id);
        $companiesSlugArray = $user->getFollowingCompaniesSlugArray();
        $companies = Company::whereIn('slug', $companiesSlugArray)->get();

        return view('user.following_companies')
                        ->with('user', $user)
                        ->with('companies', $companies);
    }

    public function myMessages()
    {
        $user = User::findOrFail(Auth::user()->id);
        $messages = ApplicantMessage::where('user_id', '=', $user->id)
                ->orderBy('is_read', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();

        return view('user.applicant_messages')
                        ->with('user', $user)
                        ->with('messages', $messages);
    }

    public function applicantMessageDetail($message_id)
    {
        $user = User::findOrFail(Auth::user()->id);
        $message = ApplicantMessage::findOrFail($message_id);
        $message->update(['is_read' => 1]);

        return view('user.applicant_message_detail')
                        ->with('user', $user)
                        ->with('message', $message);
    }

    public function myAlerts()
    {
        $alerts = Alert::where('email', Auth::user()->email)
            ->orderBy('created_at', 'desc')
            ->get();
        //dd($alerts);
        return view('user.applicant_alerts')
            ->with('alerts', $alerts);
    }
    public function delete_alert($id)
    {
        $alert = Alert::findOrFail($id);
        $alert->delete();
        $arr = array('msg' => 'A Alert has been successfully deleted. ', 'status' => true);
        return Response()->json($arr);
    }

    public function profilePercentage(){
        
        $percentage_profile = ProfilePercentage::pluck('value','key')->toArray();
        $percentage = $percentage_profile['user_basic_info'];
        $user = Auth::user()??'';
        $percentage += count($user->userEducation) > 0 ? $percentage_profile['user_education'] : 0;
        $percentage += count($user->userExperience) > 0 ? $percentage_profile['user_experience'] : 0;
        $percentage += count($user->userSkills) > 0 ? $percentage_profile['user_skill'] : 0;
        $percentage += count($user->userProjects) > 0 ? $percentage_profile['user_project'] : 0;
        $percentage += count($user->userLanguages) > 0 ? $percentage_profile['user_language'] : 0;
        $percentage += ($user->countUserCvs() > 0) ? $percentage_profile['user_resume'] : 0;
        $percentage += $user->image != null ? $percentage_profile['user_profile'] : 0;
        
        $final_percentage = $percentage > 100 ? 100 : $percentage;

        return $final_percentage;
    }

    public function Notification($phone,$otp)
    {
        $phone =  str_replace("+","",$phone);
        if(!empty($phone))
        {
            $data = [
                "to"=>$phone,
                "messaging_product"=>"whatsapp",
                "type"=>"template",
                "template"=>[
                    "name"=>"verify_account",
                    "language"=>[
                        "code"=>"en_US"
                    ],
                    "components"=>[
                        [
                            "type"=>"body",
                            "parameters"=>[
                                [
                                    "type"=>"text",
                                    "text"=>"User Account"
                                ],
                                [
                                    "type"=>"text",
                                    "text"=>$otp
                                ]
                            ]
                        ]
                    ]            
                ]
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://graph.facebook.com/v15.0/108875332057674/messages");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));  //Post Fields
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
            $headers = [
                'Authorization: Bearer '.config('services.whatsapp.access_token'),
                'Content-Type: application/json' 
            ];
        
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
            $server_output = curl_exec ($ch);
        
            curl_close ($ch); 
        }

    }

}
