<?php



namespace App\Model;


use Mail;

use Auth;

use App;

use Carbon\Carbon;

use App\Traits\Active;

use App\Traits\Featured;
 
use App\Traits\JobTrait;

use App\Traits\CountryStateCity;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;

use App\Notifications\CompanyResetPassword;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Mail\CompanyResetPasswordMailable;



class Company extends Authenticatable

{



    use Active;

    use Featured;

    use Notifiable;

    use JobTrait;

    use CountryStateCity;

    protected $table = 'companies';

    public $timestamps = true;

    protected $guarded = ['id'];

    //protected $dateFormat = 'U';

    protected $dates = ['created_at', 'updated_at', 'package_start_date', 'package_end_date','date_of_birth','founded_on'];

    protected $fillable = [

        'CEO_name','founded_on','name', 'phone', 'email', 'date_of_birth', 'gender', 'country_id',
        'state_id', 'city_id', 'pin_code', 'description', 'address', 'location', 'industry_id', 
        'sub_industry_id', 'company_type', 'no_of_employees', 'password', 'slug', 'account_type_id', 'verified', 'is_active', 'token',
        'employer_name', 'employer_role_id', 'website_url','fb_url','twitter_url','insta_url','linkedin_url','profile_file_path','profile_exact_path' 

    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        return Mail::send(new CompanyResetPasswordMailable($token, $this->email, $this->name));
    }

    public function printCompanyImage($width = 0, $height = 0)
    {
        $logo = (string)$this->logo;
        $logo = (null!==($logo)) ? $logo : 'no-no-image.gif';
        return \ImgUploader::print_image("company_logos/$logo", $width, $height, '/admin_assets/no-image.png', $this->name);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'company_id', 'id');
    }

    public function openJobs()
    {
        return Job::where('company_id', '=', $this->id)->active()->whereDate('expiry_date', '>', Carbon::now());

    }

    public function getOpenJobs()
    {
        return $this->openJobs()->get();
    }

    public function countOpenJobs()
    {
        return $this->openJobs()->count();
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id', 'id');
    }
    
    public function getIndustry($field = '')
    {

        $industry = $this->industry()->lang()->first();
        if (null === $industry) {
            $industry = $this->industry()->first();
        }
        if (null !== $industry) {
            if (!empty($field)) {
                return $industry->$field;
            } else {
                return $industry;
            }

        }

    }

    public function ownershipType()
    {
        return $this->belongsTo(OwnershipType::class, 'ownership_type_id', 'id');
    }

    public function getOwnershipType($field = '')

    {

        $ownershipType = $this->ownershipType()->lang()->first();

        if (null === $ownershipType) {

            $ownershipType = $this->ownershipType()->first();

        }

        if (null !== $ownershipType) {

            if (!empty($field)) {

                return $ownershipType->$field;

            } else {

                return $ownershipType;

            }

        }

    }



    public function countFollowers()

    {

        return FavouriteCompany::where('company_slug', 'like', $this->slug)->count();

    }



    public function getFollowerIdsArray()

    {

        return FavouriteCompany::where('company_slug', 'like', $this->slug)->pluck('user_id')->toArray();

    }



    public function countCompanyMessages()

    {

        return CompanyMessage::where('company_id', '=', $this->id)->where('status', '=', 'unviewed')->where('type', '=', 'reply')->count();

    }

    public function countMessages($id)

    {

        return CompanyMessage::where('company_id', '=', $this->id)->where('seeker_id', '=', $id)->where('type', 'reply')->where('status', '=', 'unviewed')->count();

    }



    public function getSocialNetworkHtml()

    {

        $html = '';

        if (!empty($this->facebook))

            $html .= '<a href="' . $this->facebook . '" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>';



        if (!empty($this->twitter))

            $html .= '<a href="' . $this->twitter . '" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a>';



        if (!empty($this->linkedin))

            $html .= '<a href="' . $this->linkedin . '" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>';



        if (!empty($this->google_plus))

            $html .= '<a href="' . $this->google_plus . '" target="_blank"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a>';



        if (!empty($this->pinterest))

            $html .= '<a href="' . $this->pinterest . '" target="_blank"><i class="fa fa-pinterest-square" aria-hidden="true"></i></a>';



        return $html;

    }



    public function isFavouriteApplicant($user_id, $job_id, $company_id)

    {

        $return = false;

        if (Auth::check()) {

            $count = FavouriteApplicant::where('user_id', $user_id)

                ->where('job_id', $job_id)

                ->where('company_id', $company_id)

                ->count();

            if ($count > 0)

                $return = true;

        }

        return $return;

    }


    public function isHiredApplicant($user_id, $job_id, $company_id)

    {

        $return = false;

        if (Auth::check()) {

            $count = FavouriteApplicant::where('user_id', $user_id)

                ->where('job_id', $job_id)

                ->where('company_id', $company_id)

                ->where('status', 'hired')

                ->count();

            if ($count > 0)

                $return = true;

        }

        return $return;

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

    public function cvs_package()
    {
        return $this->hasOne(Package::class, 'id', 'cvs_package_id');
    }

    public function cvs_getPackage($field = '')

    {
        $package = $this->cvs_package()->first();
        if (null !== $package) {
            if (!empty($field)) {
                return $package->$field;
            } else {
                return $package;
            }
        }
    }
    

    public function AccountType()

    {

        return $this->belongsTo(AccountType::class, 'account_type_id', 'id');

    }

    public function employer_role()
    {
        return $this->belongsTo(EmployerRole::class, 'employer_role_id', 'employer_role_id');
    }

    public function getEmployerRole($field = '')
    {
        if (null !== $employer_role = $this->employer_role()->first()) {
            if (!empty($field)) {
                return $employer_role->$field;
            } else {
                return $employer_role;
            }
        }
    }
}

