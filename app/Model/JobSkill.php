<?php

namespace App\Model;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class JobSkill extends Model
{
    use SoftDeletes;
    
    protected $table = 'job_skills';
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

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id', 'skill_id');
    }

    public function getSkill($field = '')
    {
        $skill = $this->skill()->lang()->first();
        if (null === $skill) {
            $skill = $this->skill()->first();
        }
        if (null !== $skill) {
            if (!empty($field)) {
                return $skill->$field;
            } else {
                return $skill;
            }
        }
    }

}
