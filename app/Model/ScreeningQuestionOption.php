<?php

namespace App\Model;

use App;
use App\Traits\Lang;
use App\Traits\IsDefault;
use App\Traits\Active;
use App\Traits\Sorted;
use Illuminate\Database\Eloquent\Model;

class ScreeningQuestionOption extends Model
{

    use Lang;
    use IsDefault;
    use Active;
    use Sorted;

    protected $table = 'screening_question_options';

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    
}
