<?php

namespace App\Model;

use App;
use App\Traits\Lang;
use App\Traits\IsDefault;
use App\Traits\Active;
use App\Traits\Sorted;
use Illuminate\Database\Eloquent\Model;

class EducationType extends Model
{

    use Lang;
    use IsDefault;
    use Active;
    use Sorted;

    protected $table = 'education_types';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'education_level_id', 'education_level_id');
    }

    public function getEducationLevel($field = '')
    {
        $educationLevel = $this->educationLevel()->lang()->first();
        if (null === $educationLevel) {
            $educationLevel = $this->educationLevel()->first();
        }
        if (null !== $educationLevel) {
            if (!empty($field))
                return $educationLevel->$field;
            else
                return $educationLevel;
        }
    }

}
