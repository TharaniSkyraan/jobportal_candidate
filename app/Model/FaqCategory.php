<?php

namespace App\Model;

use App;
use App\Traits\Lang;
use App\Traits\IsDefault;
use App\Traits\Active;
use App\Traits\Sorted;
use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{

    use Lang;
    use IsDefault;
    use Active;
    use Sorted;
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'faq_category_id', 'faq_category_id');
    }
}
