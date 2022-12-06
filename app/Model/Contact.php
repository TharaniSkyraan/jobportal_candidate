<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    protected $table = 'contact_us';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

}
