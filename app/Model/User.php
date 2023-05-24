<?php



namespace App\Model;



use Mail;
use Auth;
use App\Model\Skill;
use App\Model\CompanyMessage;
use Illuminate\Notifications\Notifiable;
use App\Notifications\UserResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\CountryStateCity;
use App\Traits\CommonUserFunctions;
use App\Mail\UserResetPasswordMailable;

use Laravel\Passport\HasApiTokens;


class User extends Authenticatable

{



    use Notifiable, CountryStateCity, CommonUserFunctions, HasApiTokens;



    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    protected $fillable = [

        'first_name','middle_name','last_name','father_name','marital_status_id',
        'date_of_birth','gender','country_id','state_id','city_id','name', 'email', 
        'password','employment_status','notice_period','verified','verify_otp','session_otp',
        'is_active', 'token', 'location', 'career_title', 'expected_salary', 
        'current_salary', 'total_experience','provider_id','provider','next_process_level'

    ];

    protected $dates = ['created_at', 'updated_at', 'date_of_birth', 'package_start_date', 'package_end_date'];



    /**

     * The attributes that should be hidden for arrays.

     *

     * @var array

     */

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        return Mail::send(new UserResetPasswordMailable($token, $this->email, $this->getName()));
    }

    public function userSummary()
    {
        return $this->hasMany(UserSummary::class, 'user_id', 'id');
    }

    public function getUserSummary($field = '')
    {

        if (null !== $this->userSummary->first()) {

            $userSummary = $this->userSummary->first();

            if ($field != '') {

                return $userSummary->$field;

            } else {

                return $userSummary;

            }

        } else {

            return '';

        }

    }



    public function userProjects()

    {

        return $this->hasMany(UserProject::class, 'user_id', 'id');

    }



    public function getUserProjectsArray()

    {

        return $this->userProjects->pluck('id')->toArray();

    }



    public function getDefaultCv()

    {

        $cv = UserCv::where('user_id', '=', $this->id)->where('is_default', '=', 1)->first();



        if (null === $cv)

            $cv = UserCv::where('user_id', '=', $this->id)->first();



        return $cv;

    }



    public function UserCvs()

    {

        return $this->hasMany(UserCv::class, 'user_id', 'id');

    }


    public function getUserCvsArray()

    {

        return $this->UserCvs->pluck('id')->toArray();

    }

    public function countUserCvs()

    {

        return $this->UserCvs->count();

    }



    public function userExperience()

    {

        return $this->hasMany(UserExperience::class, 'user_id', 'id');

    }



    public function userEducation()

    {

        return $this->hasMany(UserEducation::class, 'user_id', 'id')->orderBy('to_year','DESC');

    }

    public function getuserEducationLast()
    {
        $education = $this->userEducation->first();

        return isset($education)?$education->getEducationLevel('education_level'):'';
    }


    public function userSkills()

    {

        return $this->hasMany(UserSkill::class, 'user_id', 'id');

    }



    public function getUserSkills()

    {

        return $this->userSkills->get();

    }



    public function getUserSkillsStr()
    {
        $userSkills = $this->userSkills()->get();
        $str = '';
        if ($userSkills !== null) {
            foreach ($userSkills as $userSkill) {
                $skill = Skill::where('skill_id', '=', $userSkill->skill_id)->lang()->first();
                
                if(isset($skill->skill) && !empty($skill->skill)){
                    $str .= $skill->skill. ',';
                }
            }
        }
        
        if(!empty($str)){
            $str = rtrim($str, ",");
        }
        
        return $str;
    }



    public function userLanguages()

    {

        return $this->hasMany(UserLanguage::class, 'user_id', 'id');

    }



    public function favouriteJobs()

    {

        return $this->hasMany(FavouriteJob::class, 'user_id', 'id');

    }



    public function getFavouriteJobSlugsArray()

    {

        return $this->favouriteJobs->pluck('job_slug')->toArray();

    }



    public function isFavouriteJob($job_slug)

    {

        $return = false;

        if (Auth::check()) {

            $count = FavouriteJob::where('user_id', Auth::user()->id)->where('job_slug', 'like', $job_slug)->count();

            if ($count > 0)

                $return = true;

        }

        return $return;

    }



    public function favouriteCompanies()

    {

        return $this->hasMany(FavouriteCompany::class, 'user_id', 'id');

    }



    public function getFavouriteCompanies()

    {

        return $this->favouriteCompanies->pluck('company_slug')->toArray();

    }



    /*     * ****************************** */



    public function isAppliedOnJob($job_id)

    {

        $return = false;

        if (Auth::check()) {

            $count = JobApply::where('user_id', Auth::user()->id)->where('job_id', '=', $job_id)->count();

            if ($count > 0)

                $return = true;

        }

        return $return;

    }



    public function appliedJobs()

    {

        return $this->hasMany(JobApply::class, 'user_id', 'id');

    }
    public function getAppliedJobIdsArray()
    {
        return $this->appliedJobs->pluck('job_id')->toArray();
    }
    /*     * ***************************** */
    public function isFavouriteCompany($company_slug)
    {

        $return = false;

        if (Auth::check()) {

            $count = FavouriteCompany::where('user_id', Auth::user()->id)->where('company_slug', 'like', $company_slug)->count();

            if ($count > 0)

                $return = true;

        }

        return $return;

    }

    /**************************** */

    public function isViewedJob($job_slug)

    {
        
        $return = false;

        if (Auth::check()) {

            $count = JobViewedCandidate::where('user_id', Auth::user()->id)->where('job_slug', 'like', $job_slug)->count();

            if ($count > 0)

                $return = true;

        }

        return $return;

    }

    /**************************** */

    public function profileMatch($job_id)
    {
        $job = Job::where('id', $job_id)->first();
        $percentage = 0;
        $jobSkill=explode(",",$job->getSkillsStr());
        $userSkill=explode(",",$this->getUserSkillsStr());
        
        if(!empty($job->getSkillsStr()) && !empty($this->getUserSkillsStr()))
        {
            $result=array_intersect($jobSkill,$userSkill);
            $percentage = round(((count($result)*100)/count($jobSkill)),0);   
        }
        else
        {
            similar_text($this->career_title,$job->title,$percent);
            $percentage = round($percent,2);
        }

        return $percentage;

    }
    /******************** */
    public function printUserImage($width = 0, $height = 0)
    {        
        $image = (string)$this->image;
        $image = (!empty($image)) ? $image : 'no-no-image.gif';
        return \ImgUploader::print_image("user_images/$image", $width, $height, '/admin_assets/no-image.png', $this->getName());
    }

    public function printUserCoverImage($width = 0, $height = 0)
    {
        $cover_image = (string) $this->cover_image;
        $cover_image = (!empty($cover_image)) ? $cover_image : 'no-no-image.gif';
        return \ImgUploader::print_image("user_images/$cover_image", $width, $height, '/admin_assets/no-cover.jpg', $this->getName());
    }

	

    public function getName()

    {

        $html = '';

        if (!empty($this->first_name))

            $html .= ucwords($this->first_name);



        if (!empty($this->middle_name))

            $html .= ' ' . $this->middle_name;



        if (!empty($this->last_name))

            $html .= ' ' . $this->last_name;

        return $html;

    }



    public function getAge()

    {

        if (

            (!empty((string)$this->date_of_birth)) && (null !== $this->date_of_birth)

        ) {

            return $this->date_of_birth->age;

        }

    }

    // public function experience()
    // {
    //     return $this->belongsTo(Experience::class, 'experience_id', 'experience_id');
    // }

    // public function getExperience($field = '')
    // {
    //     $experience = $this->experience()->lang()->first();

    //     if (null === $experience) {

    //         $experience = $this->experience()->first();

    //     }

    //     if (null !== $experience) {

    //         if (!empty($field))

    //             return $experience->$field;

    //         else

    //             return $experience;

    //     }

    // }

    public function getuserCurrentDesignation()
    {
        $experience = $this->userExperience->where('is_currently_working',1)->first();

        return isset($experience)?$experience->title:'Fresher';
    }


    public function gender()

    {

        return $this->belongsTo(Gender::class, 'gender', 'gender_id');

    }



    public function getGender($field = '')
    {

        $gender = $this->gender()->lang()->first();

        if (null === $gender) {

            $gender = $this->gender()->first();

        }

        if (null !== $gender) {

            if (!empty($field))

                return $gender->$field;

            else

                return $gender;

        }

    }

    public function maritalStatus()

    {

        return $this->belongsTo(MaritalStatus::class, 'marital_status_id', 'marital_status_id');

    }



    public function getMaritalStatus($field = '')

    {

        $maritalStatus = $this->maritalStatus()->lang()->first();

        if (null === $maritalStatus) {

            $maritalStatus = $this->maritalStatus()->first();

        }

        if (null !== $maritalStatus) {

            if (!empty($field))

                return $maritalStatus->$field;

            else

                return $maritalStatus;

        }

    }



    public function followingCompanies()

    {

        return $this->hasMany(FavouriteCompany::class, 'user_id', 'id');

    }



    public function getFollowingCompaniesSlugArray()

    {

        return $this->followingCompanies()->pluck('company_slug')->toArray();

    }



    public function countFollowings()

    {

        return FavouriteCompany::where('user_id', '=', $this->id)->count();

    }



    public function countApplicantMessages()

    {

        return ApplicantMessage::where('user_id', '=', $this->id)->where('is_read', '=', 0)->count();

    }



    public function package()

    {

        return $this->hasOne(Package::class, 'id', 'package_id');

    }



    public function getPackage($field = '')

    {

        $package = $this->package()->first();

        if (null !== $package) {

            if (!empty($field)) {

                return $package->$field;

            } else {

                return $package;

            }

        }

    }



    public function industry()

    {

        return $this->belongsTo(Industry::class, 'industry_id', 'industry_id');

    }



    public function getIndustry($field = '')

    {

        $industry = $this->industry()->lang()->first();

        if (null === $industry) {

            $industry = $this->industry()->first();

        }

        if (null !== $industry) {

            if (!empty($field))

                return $industry->$field;

            else

                return $industry;

        }

    }



    public function functionalArea()

    {

        return $this->belongsTo(FunctionalArea::class, 'functional_area_id', 'functional_area_id');

    }



    public function getFunctionalArea($field = '')

    {

        $functionalArea = $this->functionalArea()->lang()->first();

        if (null === $functionalArea) {

            $functionalArea = $this->functionalArea()->first();

        }

        if (null !== $functionalArea) {

            if (!empty($field))

                return $functionalArea->$field;

            else

                return $functionalArea;

        }

    }

    public function countUserMessages()
    {
        return CompanyMessage::where('seeker_id', '=', $this->id)->where('status', '=', 'unviewed')->where('type', '=', 'message')->count();
    }



    public function countMessages($id)



    {



        return CompanyMessage::where('seeker_id', '=', $this->id)->where('company_id', '=', $id)->where('status', '=', 'unviewed')->where('type', '=', 'message')->count();



    }
    
    public function NoticePeriod()
    {
        return $this->belongsTo(NoticePeriod::class, 'notice_period', 'id');
    }
}

