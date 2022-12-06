<?php

namespace App\Model;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobQuizCandidateAnswer extends Model
{
    use SoftDeletes;

    protected $table = 'job_quiz_candidate_answers';
    public $timestamps = true;
    protected $guarded = ['id'];
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

    public function quiz()
    {
        return $this->belongsTo(JobScreeningQuiz::class, 'job_screening_quiz_id', 'id');
    }


}
