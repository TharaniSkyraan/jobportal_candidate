<?php

namespace App\Model;

use App;
use App\Traits\Active;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobSearch extends Model
{
    
    use SoftDeletes;
    use Active;
    
    protected $table = 'job_searchs';
    
    // protected  $dateFormat = 'U';
    
    protected  $dates=['posted_date'];
    
    protected $fillable = [

        'job_id', 'search', 'title', 'company_name', 'description', 'additional_description', 'city', 'location', 'industry', 'functional_area', 'experience', 'experience_string', 'min_experience', 'max_experience', 'job_shift','job_type', 'education_level', 'annum_salary_from', 'annum_salary_to', 'salary_string', 'posted_date', 'is_active', 'active_at', 'quick_hiring_deadline', 'expiry_date', 'work_from_home', 'have_screening_quiz', 'have_break_point', 'slug'

    ];
    
    public function jobWorkLocation()
    {
        return $this->hasMany(JobWorkLocation::class, 'job_id', 'job_id');
    }
    
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }
}
