<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SuggestedCandidate extends Model
{

    protected $table = 'suggested_candidates';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [

        'user_id','job_id','percentage',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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

}
