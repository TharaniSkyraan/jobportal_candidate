<?php

namespace App\Model;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobType extends Model
{

    use SoftDeletes;
    protected $table = 'job_types';
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

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'type_id');
    }

    public function getType($field = '')
    {
        $type = $this->type()->lang()->first();
        if (null === $type) {
            $type = $this->type()->first();
        }
        if (null !== $type) {
            if (!empty($field)) {
                return $type->$field;
            } else {
                return $type;
            }
        }
    }

}
