<?php

namespace App\Model;

use App\Traits\CountryStateCity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProject extends Model
{
    use CountryStateCity, SoftDeletes;

    protected $table = 'user_projects';
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
            if (empty($field))
                return $user;
            else
                return $user->$field;
        } else {
            return '';
        }
    }

    public function user_experience()
    {
        return $this->belongsTo(UserExperience::class, 'user_experience_id', 'id');
    }

    public function getCompany($field = '')
    {
        if($this->user_experience_id!=''){
            // $user_experience = $this->user_experience()->lang()->first();
            // if (null === $user_experience) {
            //     $user_experience = $this->user_experience()->first();
            // }
            $user_experience = $this->user_experience()->first();

            if (null !== $user_experience) {
                if (!empty($field)) {
                    return $user_experience->$field.'.';
                } else {
                    return $user_experience;
                }
            }else{
                return 'Other';
            }
        }
        return '';
       
    }

}
