<?php

namespace App\Model;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobWalkIn extends Model
{

    use SoftDeletes;
    
    protected $table = 'job_walkin_info';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at'];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }
}
