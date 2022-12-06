<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEducationMajorSubject extends Model
{

    use SoftDeletes;

    protected $table = 'user_education_major_subjects';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    public function userEducation()
    {
        return $this->belongsTo(UserEducation::class, 'user_education_id', 'id');
    }

    public function getUserEducation($field = '')
    {
        if (null !== $userEducation = $this->userEducation()->first()) {
            if (empty($field))
                return $userEducation;
            else
                return $userEducation->$field;
        } else {
            return '';
        }
    }

    public function majorSubject()
    {
        return $this->belongsTo(MajorSubject::class, 'major_subject_id', 'major_subject_id');
    }

    public function getMajorSubject($field = '')
    {
        if (null !== $majorSubject = $this->majorSubject()->first()) {
            if (empty($field))
                return $majorSubject;
            else
                return $majorSubject->$field;
        } else {
            return '';
        }
    }

}
