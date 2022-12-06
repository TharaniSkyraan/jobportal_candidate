<?php

namespace App\Model;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobEducationType extends Model
{
    use SoftDeletes;
    protected $table = 'job_education_types';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

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

    public function education_type()
    {
        return $this->belongsTo(EducationType::class, 'education_type_id', 'education_type_id');
    }

    public function getEducationType($field = '')
    {
        $education_type = $this->education_type()->lang()->first();
        if (null === $education_type) {
            $education_type = $this->education_type()->first();
        }
        if (null !== $education_type) {
            if (!empty($field)) {
                return $education_type->$field;
            } else {
                return $education_type;
            }
        }
    }

}
