<?php

namespace App\Model;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobBenefit extends Model
{
    use SoftDeletes;

    protected $table = 'job_benefits';
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

    public function benefit()
    {
        return $this->belongsTo(Benefit::class, 'benefit_id', 'benefit_id');
    }

    public function getBenefit($field = '')
    {
        $benefit = $this->benefit()->lang()->first();
        if (null === $benefit) {
            $benefit = $this->benefit()->first();
        }
        if (null !== $benefit) {
            if (!empty($field)) {
                return $benefit->$field;
            } else {
                return $benefit;
            }
        }
    }

}
