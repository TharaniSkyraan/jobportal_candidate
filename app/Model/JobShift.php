<?php

namespace App\Model;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class JobShift extends Model
{
    use SoftDeletes;
    
    protected $table = 'job_shifts';
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

    
    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'shift_id');
    }

    public function getShift($field = '')
    {
        $shift = $this->shift()->lang()->first();
        if (null === $shift) {
            $shift = $this->shift()->first();
        }
        if (null !== $shift) {
            if (!empty($field)) {
                return $shift->$field;
            } else {
                return $shift;
            }
        }
    }

}
