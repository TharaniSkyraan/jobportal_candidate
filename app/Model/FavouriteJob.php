<?php

namespace App\Model;

use App;
use Illuminate\Database\Eloquent\Model;

class FavouriteJob extends Model
{

    protected $table = 'favourites_job';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }
}
