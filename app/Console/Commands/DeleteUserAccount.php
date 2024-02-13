<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Model\AccountDeleteRequest;
use App\Model\JobAlert;
use App\Model\JobApply;
use App\Model\JobQuizCandidateAnswer;
use App\Model\JobAnalytics;
use App\Model\FavouriteJob;
use App\Model\JobRecentSearch;
use App\Model\UserActivity;
use App\Model\UserSummary;
use App\Model\UserEducationMajorSubject;
use App\Model\UserEducation;
use App\Model\UserExperience;
use App\Model\UserProject;
use App\Model\UserSkill;
use App\Model\UserLanguage;
use App\Model\UserCv;
use App\Model\User;
use App\Model\BlogView;
use App\Model\BlogLike;
use App\Model\JobViewedCandidate;
use App\Model\SuggestedCandidate;
use App\Model\DeletedAccount;
use App\Model\Message;
use App\Model\MessageContact;
use Carbon\Carbon;

class DeleteUserAccount extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:useraccount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete User Account';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
     
        $from = Carbon::now()->subDays(15)->startOfDay();
        $to = Carbon::now()->endOfDay(15)->endOfDay();

        $users = User::where(function($q) use($from,$to){
                        $q->where('account_delete_request_at', '>=' ,$from)
                        ->where('account_delete_request_at', '<=' ,$to);
                    })->pluck('id')->toArray();
        foreach($users as $user_id){
            $user = User::find($user_id);
            UserExperience::where('user_id',$user_id)->withTrashed()->forceDelete();
            UserProject::where('user_id',$user_id)->withTrashed()->forceDelete();
            UserSkill::where('user_id',$user_id)->withTrashed()->forceDelete();
            UserLanguage::where('user_id',$user_id)->withTrashed()->forceDelete();
            UserCv::where('user_id',$user_id)->forceDelete();

            //
            $edu_ids = UserEducation::where('user_id',$user_id)->withTrashed()->pluck('id')->toArray();
            if(count($edu_ids)!=0){
                UserEducationMajorSubject::whereIn('user_education_id',$edu_ids)->withTrashed()->forceDelete();
            }
            UserEducation::where('user_id',$user_id)->withTrashed()->forceDelete();
            UserActivity::where('user_id',$user_id)->delete();
            UserSummary::where('user_id',$user_id)->delete();
            JobAlert::where('user_id',$user_id)->withTrashed()->forceDelete();
            FavouriteJob::where('user_id',$user_id)->delete();
            
            $apply_ids = JobApply::where('user_id',$user_id)->withTrashed()->pluck('id')->toArray();
            if(count($apply_ids)!=0){
                JobAnalytics::whereIn('job_apply_id',$apply_ids)->delete();
                JobQuizCandidateAnswer::whereIn('apply_id',$apply_ids)->withTrashed()->forceDelete();    
            }
            JobApply::where('user_id',$user_id)->withTrashed()->forceDelete();
            JobRecentSearch::where('user_id',$user_id)->withTrashed()->forceDelete();
            JobViewedCandidate::where('user_id',$user_id)->delete();
            SuggestedCandidate::where('user_id',$user_id)->delete();            
            
            // BlogView::where(['user_type','candidate'],['user_id',$user_id])->delete();
            // BlogLike::where(['user_type','candidate'],['user_id',$user_id])->delete();

            $delete_user = new DeletedAccount();
            $delete_user->name = $user->getName();
            $delete_user->email = $user->email;
            $delete_user->phone = $user->phone;
            $delete_user->alternative_phone = $user->alternative_phone??'';
            $delete_user->gender = $user->gender??0;
            $delete_user->image = $user->image??'';
            $delete_user->date_of_birth = $user->date_of_birth??NULL;
            $delete_user->country_id = $user->country_id;
            $delete_user->location = $user->location??' ';
            $delete_user->account_id = $user->id;
            $delete_user->user_type = 'candidate';
            $delete_user->save();

            $user->forceDelete();
        }
    }

}
