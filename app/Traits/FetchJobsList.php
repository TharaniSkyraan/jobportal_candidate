<?php 
namespace App\Traits;

use DB;
use App\Model\JobSearch;
use App\Helpers\DataArrayHelper;

trait FetchJobsList
{

    public function fetchJobs($designation = '', $location = '', $filter = '', $limit = 10)
    {        
        $query = $this->createQuery($designation, $location, $filter, $limit); 
        return $query;
    }

    public function createQuery($designation = '', $location = '', $filter = '', $limit = 10)
    {
        $searchValues = preg_split('/\s+/', $designation, -1, PREG_SPLIT_NO_EMPTY);
         
        $queries = JobSearch::where(function ($q) use ($searchValues){
                            foreach($searchValues as $value){
                                $q->where(function ($q1) use ($value) { 
                                    $q1->where(function ($query) use ($value) {                                     
                                        $query->where('title', 'like', "%{$value}%");
                                    })->orwhere(function ($query) use ($value) { 
                                        $query->where('title', 'like', "%{$value}%")
                                              ->orwhere('description', 'like', "%{$value}%");
                                    });
                                });
                            }
                        });
                        
        if ($queries->count()==0) {
            $queries = JobSearch::where(function ($q) use ($searchValues){
                foreach($searchValues as $value){
                    $q->orwhere(function ($query) use ($value) { 
                        $query->where('search', 'like', "%{$value}%");
                    });
                }
            });
        }
                        
        if (!empty($filter['citylFGid'])) { 
            $queries->where('city', 'REGEXP', $filter['citylFGid']);
        }  
                        
        if (!empty($filter['jobshiftFGid'])) { 
            $queries->where('job_shift', 'REGEXP', $filter['jobshiftFGid']);
        }  
                        
        if (!empty($filter['jobtypeFGid'])) { 
            $queries->where('job_type', 'REGEXP', $filter['jobtypeFGid']);
        }  
                        
        if (!empty($filter['salaryFGid'])) { 
            $salaries = $filter['salaryFGid'];
            $queries->where(function ($q) use ($salaries){
                foreach($salaries as $value){
                    $value = explode('to',$value);
                    if(isset($value[1])){
                        $q->where(function($q1) use($value){
                            $q1->where('annum_salary_from', '>=', $value[0])->where('annum_salary_from', '<=', $value[1]);
                        })->orwhere(function($q2) use($value){
                            $q2->where('annum_salary_to', '<=', $value[1])->where('annum_salary_to', '>=', $value[0]);
                        });
                    }else{
                        $q->where('annum_salary_from', '>=', $value[0]);
                    }
                }
            });
        }  
                        
        if (!empty($filter['edulevelFGid'])) { 
            $queries->whereIn('education_level', $filter['edulevelFGid']);
        }  
                        
        if (!empty($filter['wfhtypeFid'])) { 
            $queries->whereIn('work_from_home', $filter['wfhtypeFid']);
        }  
                        
        if (!empty($filter['industrytypeGid'])) { 
            $queries->whereIn('industry', $filter['industrytypeGid']);
        }  
                        
        if (!empty($filter['functionalareaGid'])) { 
            $queries->whereIn('functional_area', $filter['functionalareaGid']);
        }  

        if (!empty($filter['experienceFid'])) { 
            $queries->where('min_experience', '<=', $filter['experienceFid'])
                       ->where('max_experience', '>=', $filter['experienceFid']);
        }
        
        $filters = $this->getFilters($queries);
        $joblist = $queries->select('job_id','title','description','company_name','experience_string as experience','salary_string as salary','posted_date','quick_hiring_deadline as immediate_join','location','have_break_point','have_screening_quiz','slug');
        if (!empty($filter['sortBy']) && $filter['sortBy'] == 'date') { 
            $joblist->orderBy('posted_date', 'DESC');
        }else{  
            $joblist->orderBy('job_id', 'DESC');
        }
        $result['filters'] = $filters;
        $result['joblist'] = $joblist->paginate($limit);
        return $result;

    }

    // Filters

    public function getFilters($data = '')
    {
        $datas =  $data;
        $city = array_filter(array_unique(explode(',',$datas->select(DB::raw('group_concat(city) as city'))->pluck('city')->first())));
        $jobtype = array_filter(array_unique(explode(',',$datas->select(DB::raw('group_concat(job_type) as job_type'))->pluck('job_type')->first())));
        $jobshift = array_filter(array_unique(explode(',',$datas->select(DB::raw('group_concat(job_shift) as job_shift'))->pluck('job_shift')->first())));
        $educationlevel = array_unique($datas->select('education_level')->pluck('education_level')->toArray());
        $industry = array_unique($datas->select('industry')->pluck('industry')->toArray());
        $functional_area = array_unique($datas->select('functional_area')->pluck('functional_area')->toArray());
        $jobids = array_unique($datas->select('job_id')->pluck('job_id')->toArray());
        
        $filter = array();
        $filter['citylFGid'] = DataArrayHelper::jobWorkLocations($city, $jobids);
        $filter['industrytypeGid'] = DataArrayHelper::jobIndustries($industry, $jobids);
        $filter['functionalareaGid'] = DataArrayHelper::jobFunctionalarea($functional_area, $jobids);
        $filter['edulevelFGid'] = DataArrayHelper::jobEducationLevel($educationlevel, $jobids);
        $filter['jobtypeFGid'] = DataArrayHelper::jobTypes($jobtype, $jobids);
        $filter['jobshiftFGid'] = DataArrayHelper::jobShifts($jobshift, $jobids);
        $filter['wfhtypeFid'] = DataArrayHelper::jobWfhTypes($jobids);
        $filter['salaryFGid'] = DataArrayHelper::jobSalaries($jobids);
        $filter['salaryFGid'] = DataArrayHelper::jobSalaries($jobids);
        
        return $filter;

    }

}
