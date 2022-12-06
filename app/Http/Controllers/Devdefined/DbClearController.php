<?php

namespace App\Http\Controllers\Devdefined;

use App\Http\Controllers\Controller;
use DB;

class DbClearController extends Controller
{
    
    public function allTableTruncate() {

        // 23 active tables only truncate

        DB::table('account_types')->truncate();
        DB::table('users')->truncate();
        DB::table('companies')->truncate();
        DB::table('jobs')->truncate();
        DB::table('job_contact_person_details')->truncate();
        DB::table('job_education_types')->truncate();
        DB::table('job_searchs')->truncate();
        DB::table('job_skills')->truncate();
        DB::table('job_shifts')->truncate();
        DB::table('job_apply')->truncate();
        DB::table('job_supplementals')->truncate();
        DB::table('job_benefits')->truncate();
        DB::table('job_types')->truncate();
        DB::table('job_walkin_info')->truncate();
        DB::table('job_work_locations')->truncate();
        DB::table('user_cvs')->truncate();
        DB::table('user_experiences')->truncate();
        DB::table('user_educations')->truncate();
        DB::table('user_skills')->truncate();
        DB::table('user_summaries')->truncate();
        DB::table('user_languages')->truncate();
        DB::table('user_projects')->truncate();
        DB::table('user_education_major_subjects')->truncate();

        return 'OK';

    }

}
