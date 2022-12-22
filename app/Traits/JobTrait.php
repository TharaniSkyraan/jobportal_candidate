<?php



namespace App\Traits;


use Auth;
use DB;
use Input;
use Redirect;
use Carbon\Carbon;
use App\Model\Category;
use App\Model\Job;
use App\Model\Title;
use App\Model\JobType;
use App\Model\JobScreeningQuiz;
use App\Model\JobSkill;
use App\Model\JobShift;
use App\Model\JobSupplemental;
use App\Model\JobBenefit;
use App\Model\JobWalkIn;
use App\Model\JobContactPersonDetail;
use App\Model\JobWorkLocation;
use App\Model\JobEducationType;
use App\Model\JobSearch;
use App\Model\Company;
use App\Model\Skill;
use App\Model\Country;
use App\Model\CountryDetail;
use App\Model\State;
use App\Model\City;
use App\Model\CareerLevel;
use App\Model\FunctionalArea;
use App\Model\Type;
use App\Model\Shift;
use App\Model\Gender;
use App\Model\Experience;
use App\Model\EducationLevel;
use App\Model\SalaryPeriod;
use App\Model\AccountType;


use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use App\Http\Requests\Front\JobFrontFormRequest;
use App\Http\Requests\Front\JobEditFormRequest;
use App\Http\Controllers\Controller;

use App\Traits\JobSkills;
use App\Traits\JobShifts;
use App\Traits\JobTypes;
use App\Traits\JobBenefits;
use App\Traits\JobSupplementals;
use App\Traits\JobWorkLocations;
use App\Traits\JobEducationTypes;
use App\Traits\JobWalkInInfo;
use App\Traits\JobContactPersonDetails;
use App\Traits\JobScreening;

use App\Events\JobPosted;

use App\Jobs\JobPost; // Queue Job
use App\Helpers\RegexHelper;

trait JobTrait

{

    use JobShifts,
        JobTypes,
        JobSkills,
        JobBenefits,
        JobSupplementals,
        JobWorkLocations,
        JobEducationTypes,
        JobWalkInInfo,
        JobContactPersonDetails,
        JobScreening;
      

    private function updateFullTextSearch($job)
    {

        $str = '';
        $str .= $job->getCompany('name').' '.$job->company->industry->industry;   
        $str .= ' ' . $job->title;
        $str .= ' ' . strip_tags($job->description);
        $str .= ' ' . strip_tags($job->additional_description);        
        $str .= ($job->skill !='')?implode(', ',array_column(json_decode($job->skill), 'value')):'';
        $str .= $job->getTypesStr().' '.$job->getShiftsStr();
        $str .= ' ' . $job->getFunctionalArea('functional_area');
        $str .= ' ' . $job->experience;
        $str .= ' ' . $job->getEducationLevel('education_level') .' '. $job->getBenefitsStr() .' '. $job->getSupplementalsStr().' '. $job->other_benefits;
        $str .= ' ' . $job->major_subjects;                
        $job->search = $str;

        $job->update();

    }

    /*     * *************************************** */
    /*        signup with job
    /*     * *************************************** */

    private function assignJobValues($job, $request)
    {

        if($request->level == 'job_info'){
            $job->title = $request->input('title');
            $job->description = $request->input('description');
            $job->additional_description = $request->input('additional_description');
            $job->country_id = $request->input('country_id');
            // $job->state_id = $request->input('state_id');
            // $job->city_id = $request->input('city_id');
            $job->location = $request->input('location'); // Work location
            // $job->location = $request->input('interview_location'); 
            $job->interview_type = $request->input('interview_type');
            $job->salary_from = (int) str_replace(',',"",$request->input('salary_from'));
            $job->salary_to = (int) str_replace(',',"",$request->input('salary_to'));
            $job->salary_currency = $request->input('salary_currency');
            $job->hide_salary = $request->input('hide_salary');
            $job->functional_area_id = $request->input('functional_area_id');
            $job->num_of_positions = $request->input('num_of_positions');
            $job->salary_period_id = $request->input('salary_period_id');
            $job->have_start_plan = $request->input('have_start_plan')??'no';
            $job->start_date = $request->input('start_date');
            $job->work_from_home = $request->input('work_from_home')??Null;
            $job->postal_code = $request->input('pin_code');
            $job->interv_loc_google_map_url = $request->input('interv_loc_google_map_url');
            $job->working_hours = $request->input('working_hours');
            $job->working_deadline = $request->input('working_deadline');
            $job->working_deadline_period_id = $request->input('working_deadline_period_id');
            $job->quick_hiring_deadline = $request->input('quick_hiring_deadline');
            if(empty($job->jkey)){                    
                $jkey = $this->generateRandomString(10).'-'.$job->id;
                $job->slug = Str::slug($job->title, '-') . '-' . $jkey;
                $job->jkey = $jkey;
            }
        }else
        
        if($request->level == 'job_requirements'){
        
            $job->education_level_id = $request->input('education_level_id');
            $job->course_type = $request->input('course_type'); 
            $job->experience = $request->input('experience'); //Str::plural('year', $request->input('max_experience'))
            $job->min_experience = ($request->input('experience') == 'experienced')? $request->input('min_experience') : null;
            $job->max_experience = ($request->input('experience') == 'experienced')? $request->input('max_experience') : null;
            $job->is_any_education = $request->input('is_any_education')??null;
            $job->is_any_education_level = $request->input('is_any_education_level')??null;
            $job->any_major_subject = $request->input('any_major_subject'); 
            $job->major_subjects = ($request->input('major_subjects')!=null)?implode(',',$request->input('major_subjects')):null;
            $job->skill = $request->skills;
            $job->is_need_resume = $request->input('is_need_resume');
            $job->expiry_date = $request->input('expiry_date'); 
            $job->quick_hiring_deadline = $request->input('quick_hiring_deadline'); 
             
        }else

        if($request->level == 'benefits'){
            $job->other_benefits = $request->input('other_benefits'); 
        }

        // $job->employer_name = $request->input('employer_name');
        // $job->employer_role_id = $request->input('employer_role_id');
        // $job->employer_conversation = $request->input('employer_conversation');
        // $job->employer_conversation_deadline = $request->input('employer_conversation_deadline');
        // $job->type_id = $request->input('type_id');
        // $job->shift_id = $request->input('shift_id');
        // $job->gender = $request->input('gender');
        // $job->is_freelance = $request->input('is_freelance');
        // $job->career_level_id = $request->input('career_level_id');

        return $job;

    }

    /**
     * 
     *   Update signup level based on job post to complete signup 
     * 
     */ 
    private function signupLevelUpdate($level, $account_type_id)
    {
        $masterTable = Company::findorFail($account_type_id);
        // Update Signup Processing Level
        if($level == 'job_info'){                
            if($masterTable->next_process_level == 'job_info'){
                $masterTable->next_process_level = 'job_requirements';
                $masterTable->save();
            }
        }else
        if($level == 'job_requirements'){  
            if($masterTable->next_process_level == 'job_requirements'){
                $masterTable->next_process_level = 'benefits';
                $masterTable->save();
            }
        }else
        if($level == 'benefits'){                
            if($masterTable->next_process_level == 'benefits'){
                $masterTable->next_process_level = 'contact_person_details';
                $masterTable->save();
            }
        } else
        if($level == 'contact_person_details'){                
            if($masterTable->next_process_level == 'contact_person_details'){
                $masterTable->next_process_level = 'screening';
                $masterTable->save();
            }
        }
        if($level == 'screening'){                
            if($masterTable->next_process_level == 'screening'){
                $masterTable->next_process_level = 'job_preview';
                $masterTable->save();
            }
        } 

    }
    /**
     *  Update job post to complete signup
     * 
     *  Based on Category - jobinfo, job_requirements, benefits, contact_person_details
    */    
    public function updateSignupJob($id, JobFrontFormRequest $request)
    {
        $job = Job::findOrFail($id);
        $account_type_id = $company_id = $job->company_id;
		$job = $this->assignJobValues($job, $request);
        $job->update();

        /*         * ************************************ */
        $this->updateFullTextSearch($job);
        /*         * ************************************ */

        if($request->level=='job_info'){
            
            $this->storeJobTypes($request, $job->id);
            $this->storeJobShifts($request, $job->id);
            $this->storeJobWorkLocations($request, $job->id);
            $this->storeWalkinDetails($request, $job->id);
            
            $this->signupLevelUpdate($request->level, $account_type_id);
            
            return \Redirect::route('job_requirements');
        }else

        if($request->level=='job_requirements'){

            $this->storeJobEducationTypes($request, $job->id);
            $this->storeJobSkills($request, $job->id);
            
            $this->signupLevelUpdate($request->level, $account_type_id);

            return \Redirect::route('benefits');
        }else

        if($request->level=='benefits'){

            $this->storeJobSupplementals($request, $job->id);  
            $this->storeJobBenefits($request, $job->id);   

            $this->signupLevelUpdate($request->level, $account_type_id);

            return \Redirect::route('contact_person_details');
        }else if($request->level=='contact_person_details'){

            $this->storeContactPersonDetails($request, $job->id); 

            $this->signupLevelUpdate($request->level, $account_type_id);

            return \Redirect::route('screening');
        }else
        if($request->level=='screening'){
            
            if(empty($request->screening_skip)){
                $this->storeScreening($request, $job->id); 
            }
            $this->signupLevelUpdate($request->level, $account_type_id);
            
            return \Redirect::route('job_preview');

        }
        
        return false;

    }

    /**
     *
     *  Create new job or existing option blade file 
     *
    */    
    public function postJob(){
        return view('company.jobs.post-job.post_job');
    }

    /**
     *
     *  Redirect to create job or existing jobs list blade file
     *
    */
    public function previousJobPost(Request $request){

        if($request->choose_job_post == 'new'){
            return \Redirect::route('job.create', ['job_info','']);
        }else{
            $company_id = Auth::user()->id;
            $jobs = Job::whereCompanyId($company_id)
                       ->where('is_active','!=',0)
                       ->orderBy('id','desc')
                       ->select('title','id','expiry_date')
                       ->get();
            return view('company.jobs.post-job.previous_jobs', compact('jobs'));
        }

    }
    /**
     
     * New Post and New Post from existing post
     
     * view blade file base on category - job_info, job_requirements, benefits, contact_person_details
      
     */
    public function createForm(Request $request,$form, $id = null)
    {
        
        
        $company = Company::findOrFail(Auth::user()->id);
        $job = null;
        $id = $request->input('id')??$id;
        $key_term = '';

        
        if($id!=null){
            $job = Job::findOrFail($id);
            if(!empty($request->input('id'))){
                $key_term = 'new_from_exist_post';
            }
        }
        
        if($form == 'job_info'){
            $countries = DataArrayHelper::CountriesArray();
            $currencies = array_unique(DataArrayHelper::currenciesArray());
            $functionalAreas = DataArrayHelper::langFunctionalAreasArray();
            $types = DataArrayHelper::langTypesArray();
            $shifts = DataArrayHelper::langShiftsArray();
            $experiences = DataArrayHelper::langExperiencesArray();
            $salaryPeriods = DataArrayHelper::langSalaryPeriodsArray();
            
            return view('company.jobs.post-job.job_info', compact('countries','currencies', 'functionalAreas','types','shifts','job', 'company','salaryPeriods','key_term'));
        }else
        if($form == 'job_requirements'){
            $skills = DataArrayHelper::langSkillsArray(10);
            $educationLevels = DataArrayHelper::langEducationLevelsArray();
            $majorSubjects = DataArrayHelper::langMajorSubjectsArray();
            $experiences = DataArrayHelper::defaultExperiencesArray();
            $noticePeriod = DataArrayHelper::langNoticePeriodsArray();
            $skillIds = array();

            return view('company.jobs.post-job.job_requirements', compact('skills','skillIds','educationLevels','job','company', 'majorSubjects','experiences','noticePeriod'));
        }else
        if($form == 'benefits'){
            $benefits = DataArrayHelper::defaultBenefitsArray();
            $supplementals = DataArrayHelper::defaultSupplementalsArray();
    
            return view('company.jobs.post-job.benefits', compact('benefits','supplementals','job','company'));    
        }else
        if($form == 'contact_person_details'){
            return view('company.jobs.post-job.contact_person_details', compact('job','company'));
        }else
        if($form == 'screening'){
            $categories = Category::select('category', 'category_id', 'length', 'key', 'id')
                                  ->lang()->active()
                                  ->sorted()->get();
            return view('company.jobs.post-job.screening', compact('job','categories'));
        }else{

            return view('company.jobs.post-job.job_preview', compact('job','company'));
        }

    }

    /**
     
     * Store New Post and New Post from existing post
     
     * Store post data based on category - job_info, job_requirements, benefits, contact_person_details
      
     */
    public function storeFrontJob(JobFrontFormRequest $request, $id = null)
    {
        $company = Auth::user();
        if($id == null){    

            if($request->key_term=='new_from_exist_post')
            {
                
                /** New Post From Exist Post */
                $existjob =  Job::findOrFail($request->id);
                $job = $existjob->replicate();
                $job->created_at = Carbon::now();
                $job->is_active = 0;
                $job->save();
                $jkey = $this->generateRandomString(10).'-'.$job->id;
                $job = Job::findOrFail($job->id);
                $job = $this->assignJobValues($job, $request); 
                $job->jkey = $jkey;
                $job->slug = Str::slug($job->title, '-') . '-' . $jkey;
                $job->update();
                
                $this->DuplicateJobWorkLocations($request->id, $job->id);
                $this->DuplicateJobTypes($request->id, $job->id);
                $this->DuplicateJobSkills($request->id, $job->id);
                $this->DuplicateJobShifts($request->id, $job->id);
                $this->DuplicateWalkinDetails($request->id, $job->id);
                $this->DuplicateJobSupplementals($request->id, $job->id);  
                $this->DuplicateJobBenefits($request->id, $job->id);  
                $this->DuplicateJobEducationTypes($request->id, $job->id);
                $this->DuplicateContactPersonDetails($request->id, $job->id); 
                $this->DuplicateScreening($request->id, $job->id); 
            }else{
                /** New Post */
                $job = new Job();
                $job->company_id = $company->id;
                $job = $this->assignJobValues($job, $request);                                  
                $job->save();     
                $jkey = $this->generateRandomString(10).'-'.$job->id;
                $job = Job::findOrFail($job->id);
                $job->jkey = $jkey;
                $job->slug = Str::slug($job->title, '-') . '-' . $jkey;
                $job->update();
            }
            // $company = Company::findOrFail($company->id);
            // $company->availed_jobs_quota = $company->availed_jobs_quota + 1;
            // $company->update();     
        }else
        {
            /** Update New Post */
            $job = Job::findOrFail($id);
            $job = $this->assignJobValues($job, $request);
            $job->update();
        }        
        
        /*         * ************************************ */
        $this->updateFullTextSearch($job);
        /*         * ************************************ */

        if($request->level=='job_info'){
            
            $this->storeJobTypes($request, $job->id);
            $this->storeJobShifts($request, $job->id);
            $this->storeJobWorkLocations($request, $job->id);
            $this->storeWalkinDetails($request, $job->id);
                     
            return \Redirect::route('job.create', ['job_requirements',$job->id]);
        }

        if($request->level=='job_requirements'){
            $this->storeJobEducationTypes($request, $job->id);
            $this->storeJobSkills($request, $job->id);

            return \Redirect::route('job.create', ['benefits',$job->id]);
        }

        if($request->level=='benefits'){
            $this->storeJobSupplementals($request, $job->id);  
            $this->storeJobBenefits($request, $job->id);   
            
            return \Redirect::route('job.create', ['contact_person_details',$job->id]);
        }

        if($request->level=='contact_person_details'){
            $this->storeContactPersonDetails($request, $job->id); 
            
            return \Redirect::route('job.create', ['screening',$job->id]);
        }
        
        if($request->level=='screening'){
            
            if(empty($request->screening_skip)){
                $this->storeScreening($request, $job->id); 
            }
            
            return \Redirect::route('job.create', ['job_preview',$job->id]);

        }
        
        return false;
    }
    /**
     * Complete new post and send mail
     */
    public function completePost($id)
    {
        $job = Job::findOrFail($id);
        $job->is_active = 1;
        $job->expiry_date = Carbon::parse($job->created_at)->addDays(30);
        $job->update(); 

        // add job in queue
        $job = (new JobPost($job->id))->onConnection('database');
        $this->dispatch($job);
                
        return \Redirect::route('home')->with('message', 'Job Posted Successfully..');
    }
    
    public function completeEdit($id)
    {

        return \Redirect::route('home')->with('message', 'Job Update Successfully..');

    }
    /*     * *************************************** */

    /*     * *************************************** */

    private function assignupdateJobValues($job, $request)
    {

        if($request->form == 'basic_form'){            
            $job->title            = $request->input('title');
            $job->salary_from      = (int) str_replace(',',"",$request->input('salary_from'));
            $job->salary_to        = (int) str_replace(',',"",$request->input('salary_to'));
            $job->salary_currency  = $request->input('salary_currency');
            $job->salary_period_id = $request->input('salary_period_id');
            $job->hide_salary      = $request->input('hide_salary');
            $job->experience       = $request->input('experience'); //Str::plural('year', $request->input('max_experience'))
            $job->min_experience   = ($request->input('experience') == 'experienced')? $request->input('min_experience') : null;
            $job->max_experience   = ($request->input('experience') == 'experienced')? $request->input('max_experience') : null;
            $job->work_from_home   = $request->input('work_from_home')??Null;
            $job->location         = $request->input('location'); // Work location
            $job->country_id       = $request->input('country_id');
        }else if($request->form == 'description_form')
        {
            $job->description = $request->input('description');
        }else if($request->form == 'additional_description_form')
        {            
            $job->additional_description = $request->input('additional_description');
        }else if($request->form == 'education_form')
        {   
            $job->is_any_education = $request->input('is_any_education')??null;
            $job->is_any_education_level = $request->input('is_any_education_level')??null;            
            $job->education_level_id = $request->input('education_level_id');
            $job->course_type = $request->input('course_type'); 
            $job->any_major_subject = $request->input('any_major_subject'); 
            $job->major_subjects = ($request->input('major_subjects')!=null)?implode(',',$request->input('major_subjects')):null;
            $job->skill = $request->skills;
        }else if($request->form == 'shift_form')
        {     
            $job->working_hours = $request->input('working_hours');
            $job->working_deadline = $request->input('working_deadline');
            $job->working_deadline_period_id = $request->input('working_deadline_period_id');
        }else if($request->form == 'benefits_form')
        {   
            $job->other_benefits = $request->input('other_benefits'); 
        }
        return $job;

    }
    /**
     * view job detail to edit
     */
    public function editFrontJob($id)
    {
        $job = Job::findOrFail($id);
        if($job==NULL){
            abort(404);
        }
        return view('company.jobs.post-job.job-edit', compact('job'));
    }
    /**
     * open modal to edit ajax
     */
    public function editModal(Request $request)
    {
        $form = $request->form;
        $job_id = $request->job_id;
        $countries = DataArrayHelper::CountriesArray();
        $job = Job::findOrFail($job_id);
        $company = Company::findOrFail($job->company_id);
        $types = DataArrayHelper::langTypesArray();
        $shifts = DataArrayHelper::langShiftsArray(); 
        $educationLevels = DataArrayHelper::langEducationLevelsArray();
        $benefits = DataArrayHelper::defaultBenefitsArray();
        $majorSubjects = DataArrayHelper::langMajorSubjectsArray();
        $salaryPeriods = DataArrayHelper::langSalaryPeriodsArray();
        $supplementals = DataArrayHelper::defaultSupplementalsArray();

        $returnHTML = view('company.jobs.preview.edit-form.'.$form,compact('salaryPeriods','company','countries','job','types', 'majorSubjects','supplementals', 'shifts','educationLevels','benefits'))->render();
       
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
    /**
     * edit and update job
     */
    public function updateJob($id, JobEditFormRequest $request)
    {
        $job = Job::findOrFail($id);
		$job = $this->assignupdateJobValues($job, $request);        
        $job->update();

        /*         * ************************************ */
        $this->updateFullTextSearch($job);
        /*         * ************************************ */
        // dd($job);
        $jobs = array();
        if($request->form == 'basic_form')
        {
            $success = 'Basic';
            $this->storeJobWorkLocations($request, $id);  
            $job = Job::findOrFail($id); 
            $jobs['title']                  = $job->title;
            $jobs['experience_string']      = $job->experience_string;
            $jobs['salary_string']          = $job->salary_string;
            $jobs['hide_salary']            = $job->hide_salary;
            $jobs['work_locations']         = $job->work_locations;         
        }
        else if($request->form == 'description_form')
        {
            $success = 'Job description';
            // return data
            $jobs['description'] = $job->description;
        }
        else if($request->form == 'additional_description_form')
        {
            $success = 'Job additional description';
            // return data
            $jobs['additional_description'] = $job->additional_description;
            
        }
        else if($request->form=='education_form')
        {            
            $success = 'Education';
            $this->storeJobEducationTypes($request, $job->id);
            $this->storeJobSkills($request, $job->id);
            // return data
            $job = Job::findOrFail($id);
            $jobs['skill'] = $job->skill;
            $jobs['education_Level'] = $job->getEducationLevel('education_level');  
            $jobs['education_type'] = $job->getEducationTypesStr();  
            $jobs['any_education_level'] = $job->is_any_education_level;  

        }
        else if($request->form == 'shift_form')
        {
            $success = 'Shift';
            $this->storeJobTypes($request, $job->id);
            $this->storeJobShifts($request, $job->id);
            // return data
            $job = Job::findOrFail($id);
            $jobs['shifts'] = Shift::whereIn('shift_id',$job->getShiftsArray())
                                ->lang()->active()
                                ->pluck('shift')->toArray();
            $jobs['types'] = Type::whereIn('type_id',$job->getTypesArray())
                                ->lang()->active()->orderBy('sort_order','asc')->get(['type', 'type_id'])
                                ->toArray();
            $jobs['working_deadline']           = $job->working_deadline;
            $jobs['working_deadline_period_id'] = $job->working_deadline_period_id;
            $jobs['working_hours']              = $job->working_hours;

        }
        else if($request->form == 'walkin_form')
        {
            $success = 'Walkin Information';
            $this->storeWalkinDetails($request, $job->id);
            // return data
            $job = Job::findOrFail($id);
            $excldays = isset($job->walkin->exclude_days)&&!empty($job->walkin->exclude_days) ? ' (Excluding : '.$job->walkin->exclude_days.')' :'';
            $jobs['walkin_date']       = $job->walkin?'<b >From </b>'.Carbon::parse($job->walkin->walk_in_from_date)->format('d F, Y').' to '.Carbon::parse($job->walkin->walk_in_to_date)->format('d F, Y').$excldays.'.':'';
            $jobs['walkin_time']       = $job->walkin?'<b>Time between:</b>'.Carbon::parse($job->walkin->walk_in_from_time)->format('h:i A').' to '.Carbon::parse($job->walkin->walk_in_to_time)->format('h:i A'):'';
            $jobs['walkin_location']   = $job->walkin?$job->walkin->walk_in_location:'';
            $jobs['walk_in_google_map_url'] = $job->walkin?$job->walkin->walk_in_google_map_url:'';
           
        }
        else if($request->form=='benefits_form')
        {
            $success = 'Benefits';
            $this->storeJobSupplementals($request, $job->id);  
            $this->storeJobBenefits($request, $job->id);   
            // return data
            $job = Job::findOrFail($id);
            $jobs['benefits']       = $job->benefits;
            $jobs['other_benefits'] = $job->other_benefits;
            $jobs['supplementals']  = $job->supplementals;
        }
        else if($request->form=='contact_person_form')
        {
            $success = 'Contact Person Information';
            // return data
            $this->storeContactPersonDetails($request, $job->id);
            $job = Job::findOrFail($id);
            $jobs['contactPersonDetails'] = $job->contact_person_details??null;

        }

        // add job in queue
        $job = (new JobPost($job->id))->onConnection('database');
        $this->dispatch($job);

        // $this->jobSearchsUpdate($job->id, 'update');

        // Send Mail to Admin
        // event(new JobPosted($job));      

        return response()->json(array('success' => $success, 'job' => $jobs));
    }

    /**
     *  Job work location add more render html to job post page
     * 
     */
    public function getMoreWorkLocationForm(Request $request)
    {
        $key = $request->key+1;
		$countries = DataArrayHelper::CountriesArray();
        $returnHTML = view('company.attributes.work_location', compact(['key','countries']))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function scopeNotExpire($query)
    {
        return $query->whereDate('expiry_date', '>', Carbon::now()); //where('expiry_date', '>=', date('Y-m-d'));
    }

    public function isJobExpired()
    {
        return ($this->expiry_date < Carbon::now())? true:false;
    }

    /**
     
     * Delete Job both forcedelete and softdelete
     
     */
    public function deleteJob(Request $request)
    {
        
        $id = $request->input('job_id');
        try {
            $company_id = Auth::user()->id;
            $job = Job::whereCompanyId($company_id)->where('id',$id)->first();
            if(isset($job)){

                if($job->is_active==0){
                    $job = Job::findOrFail($id);
                    JobBenefit::where('job_id', '=', $id)->forceDelete();
                    JobContactPersonDetail::where('job_id', '=', $id)->forceDelete();
                    JobEducationType::where('job_id', '=', $id)->forceDelete();
                    JobSkill::where('job_id', '=', $id)->forceDelete();
                    JobType::where('job_id', '=', $id)->forceDelete();
                    JobShift::where('job_id', '=', $id)->forceDelete();
                    JobSupplemental::where('job_id', '=', $id)->forceDelete();
                    JobWalkIn::where('job_id', '=', $id)->forceDelete();
                    JobWorkLocation::where('job_id', '=', $id)->forceDelete();
                    JobSearch::where('job_id', '=', $id)->forceDelete();
                    // JobApply::where('job_id', '=', $id)->delete();
                    $job->forceDelete();
                }else{
                    $job = Job::findOrFail($id);
                    JobBenefit::where('job_id', '=', $id)->delete();
                    JobContactPersonDetail::where('job_id', '=', $id)->delete();
                    JobEducationType::where('job_id', '=', $id)->delete();
                    JobSkill::where('job_id', '=', $id)->delete();
                    JobType::where('job_id', '=', $id)->delete();
                    JobShift::where('job_id', '=', $id)->delete();
                    JobSupplemental::where('job_id', '=', $id)->delete();
                    JobWalkIn::where('job_id', '=', $id)->delete();
                    JobWorkLocation::where('job_id', '=', $id)->delete();
                    JobSearch::where('job_id', '=', $id)->forceDelete();
                    // JobApply::where('job_id', '=', $id)->delete();
                    $job->delete();
                }               
                
                return response()->json(array('success' => true, 'message' => 'Deleted Successfully.'));
    
            }
            return response()->json(array('success' => false, 'message' => 'Job Doesn\'t Exist'));


        } catch (ModelNotFoundException $e) {
            
            return response()->json(array('success' => false, 'message' => ''));

        }

    }

    /**
     * Job Preview Content ajax function
     * return render view page
     */
    public function previewJob(Request $request)
    {
        $job = Job::findOrFail($request->job_id);        
        $jobscreening = JobScreeningQuiz::where('job_id', $job->id)->pluck('candidate_question');

        $returnHTML = view('company.jobs.preview.preview',compact('job','jobscreening'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    /**
     * Job added in job search table
     */
    public function jobSearchsUpdate($job_id, $method){

        $job = Job::find($job_id);
        
        $cityid = $job->jobWorkLocation->pluck('city_id')->toArray();
        $jobtypes = $job->getTypesArray();
        $jobshifts = $job->getShiftsArray();       

        $city_id = (count($cityid) !=0)?','.implode(',',$cityid).',':'';
        $job_type_id = (count($jobtypes) !=0)?','.implode(',',$jobtypes).',':'';
        $job_shift_id = (count($jobshifts) !=0)?','.implode(',',$jobshifts).',':'';
        $month_salary_from = $month_salary_to = $annum_salary_from = $annum_salary_to = null;
        
        if($job->hide_salary!=1){
            if($job->salary_period_id==1){
                $month_salary_from = $job->salary_from;
                $month_salary_to = $job->salary_to;
                $annum_salary_from = ($job->salary_from * 12) / 100000;
                $annum_salary_to = ($job->salary_to * 12) / 100000;
            }
            if($job->salary_period_id==2){
                $month_salary_from = $job->salary_from / 12;
                $month_salary_to = $job->salary_to / 12;
                $annum_salary_from = $job->salary_from / 100000;
                $annum_salary_to = $job->salary_to / 100000;
            }
            if($job->salary_period_id==3){
                $annum_salary_from = ($job->salary_from * 52) / 100000;
                $annum_salary_to = ($job->salary_to * 52) / 100000;
                $month_salary_from = ($job->salary_from * 52) / 12;
                $month_salary_to = ($job->salary_to * 52) / 12;
            }
        }

        $data = [
            'job_id' => $job->id,
            'company_name' => $job->company->name??'',
            'city' => $city_id,
            'location' => $job->work_locations,
            'title' => $job->title,
            'description' => RegexHelper::DescTrim(strip_tags($job->description)),
            'additional_description' => RegexHelper::DescTrim(strip_tags($job->additional_description)),
            'industry' => $job->company->industry_id,
            'functional_area' => $job->functional_area_id,
            'experience' => $job->experience,
            'min_experience' => $job->min_experience,
            'max_experience' => $job->max_experience,
            'experience_string' => $job->experience_string,
            'salary_string' => ($job->hide_salary!=1)?$job->salary_string:"Not Disclosed",
            // 'month_salary_from' => $month_salary_from,
            // 'month_salary_to' => $month_salary_to,
            'annum_salary_from' => number_format($annum_salary_from,2),
            'annum_salary_to' => number_format($annum_salary_to,2),
            'quick_hiring_deadline' => $job->NoticePeriod !=null?$job->NoticePeriod->notice_period:'',
            'job_shift' => $job_shift_id,
            'job_type' => $job_type_id,
            'education_level' => $job->education_level_id,
            'slug' => $job->slug,
            'search' => $job->search,
            'work_from_home' => $job->work_from_home,
            'posted_date' => Carbon::now(),
            'expiry_date' => Carbon::parse($job->created_at)->addDays(30),
            'active_at' => Carbon::now(),
        ];
        $job->posted_date = Carbon::now();
        $job->save();

        if(JobSearch::where('job_id',$job->id)->doesntExist()){
            JobSearch::create($data);
        }else{
            JobSearch::where('job_id',$job->id)->update($data);
        }
        if(Title::where('title', $job->title)->whereIsDefault(1)->whereIsActive(1)->whereLang(config('default_lang'))->doesntExist()){
            
            $title_id = Title::whereIsDefault(1)->whereIsActive(1)->whereLang(config('default_lang'))->orderBy('sort_order','desc')->pluck('title_id')->first() + 1;
            $title = new Title();
            $title->title = $job->title;
            $title->title_id = $title_id;
            $title->is_active = 1;
            $title->lang = config('default_lang');
            $title->is_default = 1;
            $title->sort_order = $title_id;
            $title->save();
        }

    }

}

