<?php

namespace App\Model;

use App;
use App\Traits\Lang;
use App\Traits\IsDefault;
use App\Traits\Active;
use App\Traits\Sorted;
use Illuminate\Database\Eloquent\Model;

class ScreeningQuestion extends Model
{

    use Lang;
    use IsDefault;
    use Active;
    use Sorted;

    protected $table = 'screening_questions';
    protected $with = ['options'];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    
    public function options()
    {
        return $this->hasOne(ScreeningQuestionOption::class, 'question_id', 'id');
    }
}
