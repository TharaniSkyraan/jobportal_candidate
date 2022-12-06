<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $table = 'roles';

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }

}
