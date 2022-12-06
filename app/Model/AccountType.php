<?php

namespace App\Model;

use App;

use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{

    protected $table = 'account_types';
    public $timestamps = true;
    protected $guarded = ['id'];
    
    protected $dates = ['created_at', 'updated_at'];

    protected $with = ['user','company'];


    protected $fillable = [

        'account_type','email','name','phone','next_process_level','verified','is_active','provider','provider_id'
    ];


    
    public function user()
    {
        return $this->hasOne(User::class, 'account_type_id', 'id');
    }

    
    public function company()
    {
        return $this->hasOne(Company::class, 'account_type_id', 'id');
    }

}
