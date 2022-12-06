<?php



namespace App\Model;



use DB;

use App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class JobApply extends Model

{


    use SoftDeletes;
    
    protected $table = 'job_apply';

    public $timestamps = true;

    protected $guarded = ['id'];

    //protected $dateFormat = 'U';

    protected $dates = ['created_at', 'updated_at'];


    public function user()
    {

        return $this->belongsTo(User::class, 'user_id', 'id');

    }



    public function getUser($field = '')

    {

        if (null !== $user = $this->user()->first()) {

            if (!empty($field)) {

                return $user->$field;

            } else {

                return $user;

            }

        }

    }

    public function getUserdetailAttribute()
    {
        $user = User::find($this->user_id);

        if(isset($user)){
                
            $user_data = array(
                'name' => $user->getName(),
                'gender' => $user->getGender('gender'),
                'age' => $user->getAge(),
                'career_title' => !empty($user->career_title)? $user->career_title : $user->getuserCurrentDesignation(),
                'total_experience' => ($user->employment_status=='experienced')?$user->total_experience:'Fresher',
                'availability_to_join' => !empty($user->NoticePeriod)?$user->NoticePeriod->notice_period:null,
                'email' => $user->email,
                'location' => $user->location,
                'phone' => $user->phone,
                'education' => $user->getuserEducationLast(),
                'skill' => $user->getUserSkillsStr(),
                'image' => $user->image,
                'is_image' => !empty($user->image)?'yes':'no',
                'avatar' => $user->getName()[0]??ucwords($user->email[0]),
                'cv' => $user->getDefaultCv()->id??'',
            );
        }

        return $user_data??'no_data';

    }
    
    public function candidateanswer()
    {
        return $this->hasMany(JobQuizCandidateAnswer::class, 'apply_id', 'id')->withTrashed();
    }
    
    public function candidatetotalunanswered()
    {
        return $this->hasMany(JobQuizCandidateAnswer::class, 'apply_id', 'id')->whereNull('answer')->withTrashed();
    }

    public function job()
    {

        return $this->belongsTo(Job::class, 'job_id', 'id')->withTrashed();

    }



    public function getJob($field = '')

    {

        if (null !== $job = $this->job()->first()) {

            if (!empty($field)) {

                return $job->$field;

            } else {

                return $job;

            }

        }

    }



    public function UserCv()

    {

        return $this->belongsTo(UserCv::class, 'cv_id', 'id');

    }



    public function getUserCv($field = '')

    {

        if (null !== $UserCv = $this->UserCv()->first()) {

            if (!empty($field)) {

                return $UserCv->$field;

            } else {

                return $UserCv;

            }

        }

    }



}

