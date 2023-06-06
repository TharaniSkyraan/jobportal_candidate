<?php

namespace App\Model;

use DB;
use App;
use App\Traits\Active;
use App\Traits\Featured;
use App\Traits\CountryStateCity;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class Job extends Model
{
    use Active, featured, CountryStateCity, SoftDeletes;

    protected $table = 'jobs';
    public $timestamps = true;
    protected $guarded = ['id'];
// protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at', 'expiry_date', 'posted_date'];
    protected $appends = ['designation','experience_string','salary_string','work_locations','benefits','supplementals','shortlistedcount'];
    protected $fillable = [
        'company_id', 'employer_name', 'jkey', 'employer_role_id', 'start_date', 'is_active', 'expiry_date'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function getCompany($field = '')
    {
        if (null !== $company = $this->company()->first()) {
            if (!empty($field)) {
                return $company->$field;
            } else {
                return $company;
            }
        }
    }

    public function employer_role()
    {
        return $this->belongsTo(EmployerRole::class, 'employer_role_id', 'employer_role_id');
    }

    public function getEmployerRole($field = '')
    {
        if (null !== $employer_role = $this->employer_role()->first()) {
            if (!empty($field)) {
                return $employer_role->$field;
            } else {
                return $employer_role;
            }
        }
    }

    // Job Skill->table
    public function skills()
    {
        return $this->hasMany(JobSkill::class, 'job_id', 'id')->withTrashed();
    }

    public function getSkillsArray()
    {
        return $this->skills()->pluck('skill_id')->toArray();
    }

    public function getSkillsStr()
    {
        $str = '';
        if ($this->skills()->count()) {
            $skills = $this->skills();
            
            foreach ($skills->get() as $jobSkill) {
                $str .= $jobSkill->getSkill('skill').',';
            }
        }
           
        if(!empty($str)){
            $str = rtrim($str, ",");
        }
        return $str;
    }

    public function companyuser()
    {
        return $this->belongsTo(CompanySubuser::class, 'created_by', 'id');
    }

    public function getSkillsList()
    {
        $str = '';
        if ($this->skills->count()) {
            $skills = $this->skills;
            foreach ($skills as $jobSkill) {
                $skill = $jobSkill->getSkill();
                $str .= '<li><a href="' . route('job.list', ['skill_id[]' => $skill->skill_id]) . '">' . $skill->skill . '</a></li>';
            }
        }
        return $str;
    }

    //======================//

    public function careerLevel()
    {
        return $this->belongsTo(CareerLevel::class, 'career_level_id', 'career_level_id');
    }

    public function getCareerLevel($field = '')
    {
        $careerLevel = $this->careerLevel()->lang()->first();
        if (null === $careerLevel) {
            $careerLevel = $this->careerLevel()->first();
        }
        if (null !== $careerLevel) {
            if (!empty($field)) {
                return $careerLevel->$field;
            } else {
                return $careerLevel;
            }
        }
    }

    public function functionalArea()
    {
        return $this->belongsTo(FunctionalArea::class, 'functional_area_id', 'functional_area_id');
    }

    public function getFunctionalArea($field = '')
    {
        $functionalArea = $this->functionalArea()->lang()->first();
        if (null === $functionalArea) {
            $functionalArea = $this->functionalArea()->first();
        }
        if (null !== $functionalArea) {
            if (!empty($field)) {
                return $functionalArea->$field;
            } else {
                return $functionalArea;
            }
        }
    }

    // public function type()
    // {
    //     return $this->belongsTo(Type::class, 'type_id', 'type_id');
    // }

    // public function getType($field = '')
    // {
    //     $type = $this->type()->lang()->first();
    //     if (null === $type) {
    //         $type = $this->type()->first();
    //     }
    //     if (null !== $type) {
    //         if (!empty($field)) {
    //             return $type->$field;
    //         } else {
    //             return $type;
    //         }
    //     }
    // }
    
    // public function shift()
    // {
    //     return $this->belongsTo(Shift::class, 'shift_id', 'shift_id');
    // }

    // public function getShift($field = '')
    // {
    //     $shift = $this->shift()->lang()->first();
    //     if (null === $shift) {
    //         $shift = $this->shift()->first();
    //     }
    //     if (null !== $shift) {
    //         if (!empty($field)) {
    //             return $shift->$field;
    //         } else {
    //             return $shift;
    //         }
    //     }
    // }

    /*****Job Type, Shift, Benefits,Supplemental Pay***** */
    public function jobtypes()
    {
        return $this->hasMany(JobType::class, 'job_id', 'id')->withTrashed();
    }

    public function getTypesArray()
    {
        return $this->jobtypes->pluck('type_id')->toArray();
    }

    public function getTypesStr()
    {
        $str = '';
        if ($this->jobtypes->count()) {
            $types = $this->jobtypes;
            foreach ($types as $jobType) {
                $str .= ' ' . $jobType->getType('type');
            }
        }
        return $str;
    }
    //-----------------     *shift*           ----------------//

    public function jobshifts()
    {
        return $this->hasMany(JobShift::class, 'job_id', 'id')->withTrashed();
    }

    public function getShiftsArray()
    {
        return $this->jobshifts->pluck('shift_id')->toArray();
    }

    public function getShiftsStr1()
    {
        return $this->jobshifts->pluck('shift_id')->toArray();
    }

    public function getShiftsStr()
    {
        $str = '';
        if ($this->jobshifts->count()) {
            $shifts = $this->jobshifts;
            foreach ($shifts as $jobShift) {
                $str .= $jobShift->getShift('shift').',';
            }
        }

        return rtrim($str, ",");
    }

    //-----------------     *benefits*           ----------------//

    public function jobbenefits()
    {
        return $this->hasMany(JobBenefit::class, 'job_id', 'id')->withTrashed();
    }

    public function getBenefitsArray()
    {
        return $this->jobbenefits->pluck('benefit_id')->toArray();
    }

    public function getBenefitsStr()
    {
        $str = '';
        if ($this->jobbenefits->count()) {
            $benefits = $this->jobbenefits;
            foreach ($benefits as $jobBenefit) {
                $str .= ' ' . $jobBenefit->getBenefit('benefit');
            }
        }
        return $str;
    }

    //-----------------     *supplementals*           ----------------//

    public function jobsupplementals()
    {
        return $this->hasMany(JobSupplemental::class, 'job_id', 'id')->withTrashed();
    }

    public function getSupplementalsArray()
    {
        return $this->jobsupplementals->pluck('supplemental_id')->toArray();
    }

    public function getSupplementalsStr()
    {
        $str = '';
        if ($this->jobsupplementals->count()) {
            $supplementals = $this->jobsupplementals;
            foreach ($supplementals as $jobSupplemental) {
                $str .= ' ' . $jobSupplemental->getSupplemental('supplemental');
            }
        }
        return $str;
    }
    //================--------------------------------------=======//

    public function salaryPeriod()
    {
        return $this->belongsTo(SalaryPeriod::class, 'salary_period_id', 'salary_period_id');
    }

    public function getSalaryPeriod($field = '')
    {
        $salaryPeriod = $this->salaryPeriod()->lang()->first();
        if (null === $salaryPeriod) {
            $salaryPeriod = $this->salaryPeriod()->first();
        }
        if (null !== $salaryPeriod) {
            if (!empty($field)) {
                return $salaryPeriod->$field;
            } else {
                return $salaryPeriod;
            }
        }
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender', 'gender');
    }

    public function getGender($field = '')
    {
        $gender = $this->gender()->lang()->first();
        if (null === $gender) {
            $gender = $this->gender()->first();
        }
        if (null !== $gender) {
            if (!empty($field)) {
                return $gender->$field;
            } else {
                return $gender;
            }
        } else {
            return __('No Preference');
        }
    }

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
        if (!empty($field)) {
            return $educationLevel->$field??'Any Degree';
        } else {
            return $educationLevel;
        }
    }

    // public function experience()
    // {
    //     return $this->belongsTo(Experience::class, 'experience_id', 'experience_id');
    // }

    // public function getExperience($field = '')
    // {
    //     $experience = $this->experience()->lang()->first();
    //     if (null === $experience) {
    //         $experience = $this->experience()->first();
    //     }
    //     if (null !== $experience) {
    //         if (!empty($field)) {
    //             return $experience->$field;
    //         } else {
    //             return $experience;
    //         }
    //     }
    // }

    /*     * ****************************** */

    public function suggestedUsers()
    {
        return $this->hasMany(SuggestedCandidate::class, 'job_id', 'id');
    }

    public function appliedUsers()
    {
        return $this->hasMany(JobApply::class, 'job_id', 'id');
    }

    public function getAppliedUserIdsArray()
    {
        return $this->appliedUsers->pluck('user_id')->toArray();
    }

    // Job Skill->table
    public function jobWorkLocation()
    {
        return $this->hasMany(JobWorkLocation::class, 'job_id', 'id')->withTrashed();
    }

    public function getWorkLocationArray()
    {
        return $this->jobWorkLocation->pluck('city')->toArray();
    }

    //Job Education Type ID
    public function education_types()
    {
        return $this->hasMany(JobEducationType::class, 'job_id', 'id')->withTrashed();
    }

    public function getEducationTypesArray()
    {
        return $this->education_types->pluck('education_type_id')->toArray();
    }

    public function getEducationTypesStr()
    {   
        $str = '';  
        if($this->is_any_education!='yes'){   
            $count = $this->education_types->count() - 1;
            $education_types = $this->education_types;        
            foreach ($education_types as $key => $jobEducationType) {
                if($key == $count){
                    $str .=  $jobEducationType->getEducationType('education_type');
                }else{
                    $str .=  $jobEducationType->getEducationType('education_type').',';
                }
            }
        }
        if($str==''){
            $str='Any';
        }
        return $str;
    }
    
    public function walkin()
    {
        return $this->hasOne(JobWalkIn::class, 'job_id', 'id')->withTrashed();
    }
    
    public function screeningquiz()
    {
        return $this->hasMany(JobScreeningQuiz::class, 'job_id', 'id')->withTrashed();
    }
    
    public function screeningquizcategory()
    {
        return JobScreeningQuiz::select('category_id', DB::raw('count(category_id) as count'))
                                ->whereJobId($this->id)
                                ->groupBy('category_id')
                                ->pluck('count','category_id');
    }

    /*     * ***************************** */
    public function contact_person_details()
    {
        return $this->hasOne(JobContactPersonDetail::class, 'job_id', 'id')->withTrashed();
    }
    /*     * ***************************** */
    public function NoticePeriod()
    {
        return $this->belongsTo(NoticePeriod::class, 'quick_hiring_deadline', 'id');
    }
    /*     * ***************************** */

    public function getExperienceStringAttribute()
    {
        $experience = ($this->experience == 'experienced') ? $experience = $this->min_experience .' - '.  $this->max_experience .' '. Str::plural('year', $this->max_experience) : $this->experience;

        return ucwords($experience);
    }

    public function getSalaryStringAttribute()
    {
        $salary = '';
        $salary_from = $this->salary_from;
        $salary_to = $this->salary_to;
        $salary_currency = isset($this->salary_currency)&&!empty($this->salary_currency) ? ' '.$this->salary_currency : '' ;
        if($this->salary_from > 0 && $this->salary_to > 0){
            if($this->getSalaryPeriod('salary_period') == 'Monthly'){
                $salary_from = $this->salary_from * 12;
                $salary_to = $this->salary_to * 12;
            }
            if($this->getSalaryPeriod('salary_period') == 'Weekly'){
                
                $salary_from = $this->salary_from * 52;
                $salary_to = $this->salary_to * 52;
            }
            
            $salary = $salary_currency.' '. preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $salary_from) .' - '.  preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $salary_to) .' PA.';

        }
        return $salary;
    }

    public function getWorkLocationsAttribute()
    {
        $locations = '';
        if($this->work_from_home=='permanent'){
            $locations = 'Remote';
        }else{                
            foreach($this->getWorkLocationArray() as $location){
                $locations .= ucwords($location).', ';
            }
        }

        return rtrim($locations, ", ");
    }

    public function getBenefitsAttribute()
    {
        $str = '';
        $benefits = $this->jobbenefits;
        foreach ($benefits as $benefit) {
            $str .= ucwords($benefit->benefit->benefit).', ';
        }
        return $str;
    }

    public function getSupplementalsAttribute()
    {
        $str = '';
        $supplementals = $this->jobsupplementals;
        foreach ($supplementals as $supplemental) {
            $str .= ucwords($supplemental->supplemental->supplemental).', ';
        }
        return $str;
    }

    public function getShortlistedcountAttribute()
    {
        $str = '0';
        // $appliedUsers = $this->appliedUsers;
        $str = JobApply::whereJobId($this->id)->where('application_status','shortlist')->count();
       
        return $str;
    }
    /**
     * Get the model's original attribute values.
    *
    * @param  string|null  $key
    * @param  mixed  $default
    * @return array
    */
    public function getOriginal($key = null, $default = null)
    {
        return Arr::get($this->original, $key, $default);
    }
    
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
