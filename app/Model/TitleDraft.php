<?php

namespace App\Model;

use App;
use App\Traits\Lang;
use App\Traits\IsDefault;
use App\Traits\Active;
use Illuminate\Database\Eloquent\Model;

class TitleDraft extends Model
{

    use Lang;
    use IsDefault;
    use Active;

    protected $table = 'title_drafts';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

}
