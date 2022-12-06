<?php

namespace App\Model;

use App;
use Illuminate\Database\Eloquent\Model;

class JobViewedCandidate extends Model
{

    protected $table = 'job_viewed_candidates';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

}
