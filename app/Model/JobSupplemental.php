<?php

namespace App\Model;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobSupplemental extends Model
{

    use SoftDeletes;
    
    protected $table = 'job_supplementals';
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

    public function supplemental()
    {
        return $this->belongsTo(Supplemental::class, 'supplemental_id', 'supplemental_id');
    }

    public function getSupplemental($field = '')
    {
        $supplemental = $this->supplemental()->lang()->first();
        if (null === $supplemental) {
            $supplemental = $this->supplemental()->first();
        }
        if (null !== $supplemental) {
            if (!empty($field)) {
                return $supplemental->$field;
            } else {
                return $supplemental;
            }
        }
    }

}
