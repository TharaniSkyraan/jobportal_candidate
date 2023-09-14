<?php
namespace App\Model;

use DB;
use App;
use Illuminate\Database\Eloquent\Model;

class JobAnalytics extends Model

{
    
    protected $table = 'job_analytics';

    public $timestamps = true;

    protected $guarded = ['id'];

    //protected $dateFormat = 'U';

    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'job_apply_id','job_id','application_status','updated_by'
    ];



}

