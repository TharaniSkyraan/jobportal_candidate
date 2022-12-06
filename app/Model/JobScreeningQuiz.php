<?php

namespace App\Model;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobScreeningQuiz extends Model
{
    use SoftDeletes;

    protected $table = 'job_screening_quizs';
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

    public function screening_question()
    {
        return $this->belongsTo(ScreeningQuestion::class, 'screening_question_id', 'id');
    }
}
