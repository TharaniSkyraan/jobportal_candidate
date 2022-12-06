<?php

namespace App\Model;

use App;
use App\Traits\Lang;
use App\Traits\IsDefault;
use App\Traits\Active;
use App\Traits\Sorted;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{

    use Lang;
    use IsDefault;
    use Active;
    use Sorted;

    protected $table = 'industries';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    public static function getUsingIndustries($limit = 10)
    {
        $companyIds = App\Model\Job::select('company_id')->pluck('company_id')->toArray();
        $industryIds = App\Model\Company::select('industry_id')->whereIn('id', $companyIds)->pluck('industry_id')->toArray();
        return App\Model\Industry::whereIn('industry_id', $industryIds)->lang()->active()->inRandomOrder()->paginate($limit);
    }
     public function jobsearch(){
        return $this->hasMany(JobSearch::class, 'industry', 'id');
     }

}
