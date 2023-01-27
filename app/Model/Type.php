<?php

namespace App\Model;

use App;
use App\Traits\Lang;
use App\Traits\IsDefault;
use App\Traits\Active;
use App\Traits\Sorted;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{

    use Lang;
    use IsDefault;
    use Active;
    use Sorted;

    protected $table = 'types';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    protected $append = ['type_slug'];


    public function getTypeSlugAttribute()
    {
        $type =  strtolower(preg_replace('/[!\/\\\|\$\%\^\&\*\'\(\)\_\-\<\>\@\,\~\`\;\""]+/', '', $this->type));
        
        $type = str_replace(" ", "-", $type);

        return $type;
    }
}
