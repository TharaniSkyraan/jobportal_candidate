<?php

namespace App\Model;

use App\Traits\CountryStateCity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserEducation extends Model
{

    use CountryStateCity, SoftDeletes;

    protected $table = 'user_educations';
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

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'education_level_id', 'education_level_id');
    }

    public function getEducationLevel($field = '')
    {
        $educationLevel = $this->educationLevel()->lang()->first();
        if (null === $educationLevel) {
            $educationLevel = $this->educationLevel()->first();
        }
        if (null !== $educationLevel) {
            if (empty($field))
                return $educationLevel;
            else
                return $educationLevel->$field;
        } else {
            return '';
        }
    }

    public function educationType()
    {
        return $this->belongsTo(EducationType::class, 'education_type_id', 'education_type_id');
    }

    public function getEducationType($field = '')
    {
        $educationType = $this->educationType()->lang()->first();
        if (null === $educationType) {
            $educationType = $this->educationType()->first();
        }
        if (null !== $educationType) {
            if (empty($field))
                return $educationType;
            else
                return $educationType->$field;
        } else {
            return '';
        }
    }

    public function resultType()
    {
        return $this->belongsTo(ResultType::class, 'result_type_id', 'result_type_id');
    }

    public function getResultType($field = '')
    {
        $resultType = $this->resultType()->lang()->first();
        if (null === $resultType) {
            $resultType = $this->resultType()->first();
        }
        if (null !== $resultType) {
            if (empty($field))
                return $resultType;
            else
                return $resultType->$field;
        } else {
            return '';
        }
    }

    public function userEducationMajorSubjects()
    {
        return $this->hasMany(UserEducationMajorSubject::class, 'user_education_id', 'id');
    }

    public function getUserEducationMajorSubjectsArray()
    {
        return $this->userEducationMajorSubjects->pluck('major_subject_id')->toArray();
    }

    public function getUserEducationMajorSubjectsStr()
    {
        $majorSubjects = $this->userEducationMajorSubjects;
        if (null !== $majorSubjects) {
            $majorSubjectArray = [];
            foreach ($majorSubjects as $profileEduMajorSubject) {
                $majorSubjectArray[] = $profileEduMajorSubject->getMajorSubject('major_subject');
            }
        }
        return implode(', ', $majorSubjectArray);
    }

}
