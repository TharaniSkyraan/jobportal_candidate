<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserJsonData extends Model
{
    

    protected $table = 'user_json_datas';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
