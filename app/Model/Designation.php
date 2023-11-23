<?php

namespace App\Model;

use App;
use App\Traits\Lang;
use App\Traits\IsDefault;
use App\Traits\Active;
use App\Traits\Sorted;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{

    use Lang;
    use IsDefault;
    use Active;
    use Sorted;

    protected $table = 'designations';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    protected $append = ['designation'];

    public function getDesignationAttribute()
    {       
        $designation = strtolower(preg_replace('/[!\/\\\\|\$\%\^\&\*\'\{\}\[\(\)\_\-\<\>\@\,\~\`\;\" "]+/', ' ', $this->title));
        // Special Character to String
        $designation = preg_replace('/[#]+/', ' sharp ', $designation);
        $designation = preg_replace('/[+]{2,}+/', ' plus plus ', $designation);
        $designation = preg_replace('/[+]+/', ' plus ', $designation);
        $designation = preg_replace('/[.]+/', ' dot ', $designation);  

        $designation = str_replace(" ", "-", $designation);

         return $designation;
    }

}
