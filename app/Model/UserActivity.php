<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{

    protected $table = 'user_activities';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['user_id','last_active_at'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
