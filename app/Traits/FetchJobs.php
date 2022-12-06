<?php 
namespace App\Traits;

use DB;
use App\Model\Job;
use App\Model\Company;
use App\Model\Skill;
use App\Model\JobSkill;
use App\Model\Country;
use App\Model\State;
use App\Model\City;
use App\Model\CareerLevel;
use App\Model\FunctionalArea;
use App\Model\Type;
use App\Model\Shift;
use App\Model\Gender;
use App\Model\Experience;
use App\Model\EducationLevel;
use App\Traits\JobTrait;

trait FetchJobs
{

    use JobTrait;

    private $fields = array(
        'jobs.id',
        'jobs.company_id',
        'jobs.title',
        'jobs.description',
        'jobs.country_id',
        'jobs.state_id',
        'jobs.city_id',
        // 'jobs.is_freelance',
        'jobs.career_level_id',
        'jobs.salary_from',
        'jobs.salary_to',
        'jobs.hide_salary',
        'jobs.functional_area_id',
        // 'jobs.type_id',
        // 'jobs.shift_id',
        'jobs.num_of_positions',
        'jobs.gender',
        'jobs.expiry_date',
        'jobs.education_level_id',
        // 'jobs.experience_id',
        'jobs.is_active',
        'jobs.is_featured',
        'jobs.slug',
        'jobs.created_at',
        'jobs.updated_at'
    );

    public function fetchJobs($search = '', $titles = array(), $company_ids = array(), $industry_ids = array(), $skill_ids = array(), $functional_area_ids = array(), $country_ids = array(), $state_ids = array(), $city_ids = array(), $is_freelance = -1, $career_level_ids = array(), $genders = array(), $education_level_ids = array(),$salary_from = 0, $salary_to = 0, $salary_currency = '', $is_featured = -1, $orderBy = 'id', $limit = 10)
    {
        $asc_desc = 'DESC';
        $query = Job::select($this->fields);
        $query = $this->createQuery($query, $search, $titles, $company_ids, $industry_ids, $skill_ids, $functional_area_ids, $country_ids, $state_ids, $city_ids, $is_freelance, $career_level_ids, $genders, $education_level_ids, $salary_from, $salary_to, $salary_currency, $is_featured);

        //$query->orderBy('jobs.is_featured', 'DESC');
        $query->orderBy('jobs.id', 'DESC');
        //echo $query->toSql();exit;
        return $query->paginate($limit);
    }

    public function fetchIdsArray($search = '', $titles = array(), $company_ids = array(), $industry_ids = array(), $skill_ids = array(), $functional_area_ids = array(), $country_ids = array(), $state_ids = array(), $city_ids = array(), $is_freelance = -1, $career_level_ids = array(), $genders = array(), $education_level_ids = array(), $salary_from = 0, $salary_to = 0, $salary_currency = '', $is_featured = -1, $field = 'jobs.id')
    {
        $query = Job::select($field);
        $query = $this->createQuery($query, $search, $titles, $company_ids, $industry_ids, $skill_ids, $functional_area_ids, $country_ids, $state_ids, $city_ids, $is_freelance, $career_level_ids, $genders, $education_level_ids, $salary_from, $salary_to, $salary_currency, $is_featured);
        $array = $query->pluck($field)->toArray();
        return array_unique($array);
    }

    public function createQuery($query, $search = '', $titles = array(), $company_ids = array(), $industry_ids = array(), $skill_ids = array(), $functional_area_ids = array(), $country_ids = array(), $state_ids = array(), $city_ids = array(), $is_freelance = -1, $career_level_ids = array(), $genders = array(), $education_level_ids = array(), $salary_from = 0, $salary_to = 0, $salary_currency = '', $is_featured = -1)
    {
    
       
         
        $active_company_ids_array = Company::where('is_active', 1)->pluck('id')->toArray();
        if (isset($company_ids[0]) && isset($active_company_ids_array[0])) {
            $company_ids = array_intersect($company_ids,$active_company_ids_array);
        }
        //dd($company_ids);
		$company_ids_array=array();
        if (isset($industry_ids[0])) {
            $company_ids_array = Company::whereIn('industry_id', $industry_ids)->pluck('id')->toArray();
            if (isset($company_ids[0]) && isset($company_ids_array[0])) {
                $company_ids = array_intersect($company_ids_array, $company_ids);
            }
            $company_ids = $company_ids_array;
        }
        
        
         
        if (isset($company_ids[0])) {
           // dd($company_ids[0]);
            $query->whereIn('jobs.company_id', $company_ids);
        }   
        $query->where('jobs.is_active', 1);
        if ($search != '') {
            $query = $query->whereRaw("MATCH (`search`) AGAINST ('$search*' IN BOOLEAN MODE)");
        }
        if (isset($titles[0])) {
            $query = $query->where('title', 'like', $titles[0]);
        }
             
        if (isset($skill_ids[0])) {
            $query->whereHas('skills', function($query) use ($skill_ids) {
                $query->whereIn('skill_id', $skill_ids);
            });
            //$job_ids = JobSkill::whereIn('skill_id',$skill_ids)->pluck('job_id')->toArray();
            //$query->whereIn('jobs.id', $job_ids);
        }
        if (isset($functional_area_ids[0])) {
            $query->whereIn('jobs.functional_area_id', $functional_area_ids);
        }
        if (isset($country_ids[0])) {
            $query->whereIn('jobs.country_id', $country_ids);
        }
        if (isset($state_ids[0])) {
            $query->whereIn('jobs.state_id', $state_ids);
        }
        if (isset($city_ids[0])) {
            $query->whereIn('jobs.city_id', $city_ids);
        }
        if ($is_freelance == 1) {
            $query->where('jobs.is_freelance', $is_freelance);
        }
        if (isset($career_level_ids[0])) {
            $query->whereIn('jobs.career_level_id', $career_level_ids);
        }
        // if (isset($type_ids[0])) {
        //     $query->whereIn('jobs.type_id', $type_ids);
        // }
        // if (isset($shift_ids[0])) {
        //     $query->whereIn('jobs.shift_id', $shift_ids);
        // }
        if (isset($genders[0])) {
            $query->whereIn('jobs.gender', $genders);
        }
        if (isset($education_level_ids[0])) {
            $query->whereIn('jobs.education_level_id', $education_level_ids);
        }
        // if (isset($experience_ids[0])) {
        //     $query->whereIn('jobs.experience_id', $experience_ids);
        // }
        if ((int) $salary_from > 0) {
            $query->where('jobs.salary_from', '>=', $salary_from);
        }
        if ((int) $salary_to > 0) {
            $query = $query->whereRaw("(`jobs`.`salary_to` - $salary_to) >= 0");
            //$query->where('jobs.salary_to', '<=', $salary_to);
        }
        if (!empty(trim($salary_currency))) {
            $query->where('jobs.salary_currency', 'like', $salary_currency);
        }
        if ($is_featured == 1) {
            $query->where('jobs.is_featured', '=', $is_featured);
        }
        $query->notExpire();
        return $query;
    }

    public function fetchSkillIdsArray($jobIdsArray = array())
    {
        $query = JobSkill::select('skill_id');
        $query->whereIn('job_id', $jobIdsArray);

        $array = $query->pluck('skill_id')->toArray();
        return array_unique($array);
    }

    public function fetchIndustryIdsArray($companyIdsArray = array())
    {
        $query = Company::select('industry_id');
        $query->whereIn('id', $companyIdsArray);

        $array = $query->pluck('industry_id')->toArray();
        return array_unique($array);
    }

    private function getSEO($functional_area_ids = array(), $country_ids = array(), $state_ids = array(), $city_ids = array(), $career_level_ids = array(), $genders = array(), $education_level_ids = array())
    {
        $description = 'Jobs ';
        $keywords = '';
        if (isset($functional_area_ids[0])) {
            foreach ($functional_area_ids as $functional_area_id) {
                $functional_area = FunctionalArea::where('functional_area_id', $functional_area_id)->lang()->first();
                if (null !== $functional_area) {
                    $description .= ' ' . $functional_area->functional_area;
                    $keywords .= $functional_area->functional_area . ',';
                }
            }
        }
        if (isset($country_ids[0])) {
            foreach ($country_ids as $country_id) {
                $country = Country::where('country_id', $country_id)->lang()->first();
                if (null !== $country) {
                    $description .= ' ' . $country->country;
                    $keywords .= $country->country . ',';
                }
            }
        }
        if (isset($state_ids[0])) {
            foreach ($state_ids as $state_id) {
                $state = State::where('state_id', $state_id)->lang()->first();
                if (null !== $state) {
                    $description .= ' ' . $state->state;
                    $keywords .= $state->state . ',';
                }
            }
        }
        if (isset($city_ids[0])) {
            foreach ($city_ids as $city_id) {
                $city = City::where('city_id', $city_id)->lang()->first();
                if (null !== $city) {
                    $description .= ' ' . $city->city;
                    $keywords .= $city->city . ',';
                }
            }
        }
        if (isset($career_level_ids[0])) {
            foreach ($career_level_ids as $career_level_id) {
                $career_level = CareerLevel::where('career_level_id', $career_level_id)->lang()->first();
                if (null !== $career_level) {
                    $description .= ' ' . $career_level->career_level;
                    $keywords .= $career_level->career_level . ',';
                }
            }
        }
        if (isset($type_ids[0])) {
            foreach ($type_ids as $type_id) {
                $type = Type::where('type_id', $type_id)->lang()->first();
                if (null !== $type) {
                    $description .= ' ' . $type->type;
                    $keywords .= $type->type . ',';
                }
            }
        }
        if (isset($shift_ids[0])) {
            foreach ($shift_ids as $shift_id) {
                $shift = Shift::where('shift_id', $shift_id)->lang()->first();
                if (null !== $shift) {
                    $description .= ' ' . $shift->shift;
                    $keywords .= $shift->shift . ',';
                }
            }
        }
        if (isset($genders[0])) {
            foreach ($genders as $gender) {
                $gender = Gender::where('gender', $gender)->lang()->first();
                if (null !== $gender) {
                    $description .= ' ' . $gender->gender;
                    $keywords .= $gender->gender . ',';
                }
            }
        }
        if (isset($education_level_ids[0])) {
            foreach ($education_level_ids as $education_level_id) {
                $education_level = EducationLevel::where('education_level_id', $education_level_id)->lang()->first();
                if (null !== $education_level) {
                    $description .= ' ' . $education_level->education_level;
                    $keywords .= $education_level->education_level . ',';
                }
            }
        }
        // if (isset($experience_ids[0])) {
        //     foreach ($experience_ids as $experience_id) {
        //         $experience = Experience::where('experience_id', $experience_id)->lang()->first();
        //         if (null !== $experience) {
        //             $description .= ' ' . $experience->experience;
        //             $keywords .= $experience->experience . ',';
        //         }
        //     }
        // }
        return ['keywords' => $keywords, 'description' => $description];
    }

}
