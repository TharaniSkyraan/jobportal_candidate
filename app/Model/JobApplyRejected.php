<?php



namespace App\Model;



use DB;

use App;

use Illuminate\Database\Eloquent\Model;



class JobApplyRejected extends Model

{



    protected $table = 'job_apply_rejected';

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



    public function job()

    {

        return $this->belongsTo(Job::class, 'job_id', 'id');

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

