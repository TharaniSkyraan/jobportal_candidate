<?php

namespace App\Model;

use App;
use App\Traits\Lang;
use App\Traits\IsDefault;
use App\Traits\Active;
use App\Traits\Sorted;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{

    use Lang;
    use IsDefault;
    use Active;
    use Sorted;

    protected $table = 'institutes';

    // public function jobs()
    // {
    //     return $this->hasMany(Job::class, 'employer_role_id', 'employer_role_id');
    // }

}
