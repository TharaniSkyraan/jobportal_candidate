<?php

namespace App\Http\Controllers\Job;

use Auth;
use Redirect;
use App\Model\Job;
use App\Model\FavouriteJob;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class FavouriteJobController extends Controller
{
   
    public function Savejob(Request $request, $job_slug)
    {
        $reload_page = false;
        
        if(Auth::check()){

            if(Auth::user()->is_active ==1){
                
                $is_login = $request->is_login ?? 0;
                $save_as_fav = $request->fav=='yes'? 'no' : 'yes';
                if(! $is_login){
                    $reload_page = true;
                }

                $user = Auth::user();
                $user_id = $user->id;
                $job = Job::where('slug', 'like', $job_slug)->first();

                
                if($save_as_fav == 'yes'){
                        
                    if(Auth::user()->isFavouriteJob($job_slug)==false){
                            
                        $jobFavourite = new FavouriteJob();
                        $jobFavourite->user_id = $user_id;
                        $jobFavourite->job_id = $job->id;
                        $jobFavourite->job_slug = $job->slug;
                        $jobFavourite->save();

                    }
                    $response = array("success" => true, "message" => "You have successfully saved this job", "return_to" => "");

                }
                if($save_as_fav == 'no'){
                        
                    if(Auth::user()->isFavouriteJob($job_slug)==true){
                        FavouriteJob::whereJobId($job->id)->whereUserId($user_id)->delete();
                    }
                    $response = array("success" => true, "message" => "You have remove from saved job", "return_to" => "");

                }
        
            }else{            
                $response = array("success" => false, "message" => "In active user.", "return_to" => "redirect_user");
            }

        }else{

            if(Auth::check()){
                $response = array("success" => false,
                            "message" => "Unauthorized user.", 
                            "return_to" => "company/postedjobslist"
                            );
            }

            $response = array("success" => false, 
                          "message" => "Unauthorized user.", 
                          "return_to" => "login"
                          );
        }

        $response['reload_page']=$reload_page;
        $response['fav']=$save_as_fav??$request->fav;
        
        return response()->json($response, SUCCESS);

    }

}