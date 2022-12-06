<?php

namespace App\Model;

use App\Traits\CountryStateCity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserExperience extends Model
{

    use CountryStateCity, SoftDeletes;

    protected $table = 'user_experiences';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at', 'date_start', 'date_end'];

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

}
