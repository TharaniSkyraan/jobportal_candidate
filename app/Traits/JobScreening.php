<?php

namespace App\Traits;
use App\Model\ScreeningQuestion;
use App\Model\JobScreeningQuiz;
use App\Model\Job;

trait JobScreening
{

    private function storeScreening($request, $job_id)
    {
        // dd($request->all());
        JobScreeningQuiz::where('job_id', '=', $job_id)->forceDelete();
        
        $job = Job::find($job_id);

        $quizs = $request->quiz??array();
        $quiz_ids = 'quiz_id_';
        $quiz_category_ids = 'quiz_category_id_';
        $candidate_questions = 'candidate_question_';
        $breakpoints = 'breakpoint_';
        $answer_txts = 'answer_txt_';
        $answer_dess = 'answer_des_';
        $answer_dds = 'answer_dd_';
        $answer_radios = 'answer_radio_';
        $answer_checks = 'answer_check_';

        foreach($quizs as $q){

            $quiz_id = $quiz_ids.$q;
            $quiz_category_id = $quiz_category_ids.$q;
            $candidate_question = $candidate_questions.$q;
            $breakpoint = $breakpoints.$q;
            $answer_txt = $answer_txts.$q;
            $answer_des = $answer_dess.$q;
            $answer_dd = $answer_dds.$q;
            $answer_radio = $answer_radios.$q;
            $answer_check = $answer_checks.$q;
            
            $quiz_insert = new JobScreeningQuiz();
            $quiz_insert->quiz_code = $q;
            $quiz_insert->job_id = $job->id;
            $quiz_insert->screening_question_id	 = $request[$quiz_id];
            $quiz_insert->category_id = $request[$quiz_category_id];
            $quiz_insert->breakpoint = $request[$breakpoint];
            if($request[$quiz_category_id]==0)   // Custom Question         
            {   
                $quiz_insert->question =$request[$candidate_question];
                $quiz_insert->candidate_question = $request[$candidate_question];
                $quiz_insert->answer_type = 'text';  
            }else
            {         
                
                $question = ScreeningQuestion::find($request[$quiz_id]);

                // Candidate question Frame
                $candidate_question = $question->candidate_question;
                $quiz = $question->question;
                if($question->candidate_is_fillable_tag=='yes'){
                    $candidate_question = str_replace('<text">',$request[$answer_txt],$candidate_question);
                }
                
                // Recruiter question 
                if($question->category->key=='willing_to_relocate'){
                    $work_location = explode(',',$job->work_locations);
                    $candidate_question = str_replace('<text">',$work_location[0],$candidate_question);
                }
                $quiz = str_replace('<text">',$request[$answer_txt],$quiz);
                $quiz = str_replace('<select">',$request[$answer_dd],$quiz);
                
                $quiz_insert->question = $quiz;
                $quiz_insert->candidate_question = $candidate_question;
                if($question->category->key=='experience'){
                    $quiz_insert->answer = $request[$answer_dd];
                }else{
                    $quiz_insert->answer = ($request[$answer_txt]??'').($request[$answer_des]??'').($request[$answer_dd]??'').($request[$answer_radio]??'').((!empty($request[$answer_check]))?json_encode($request[$answer_check], true):'');                
                }
                $quiz_insert->answer_type = $question->candidate_answer_type;
                $quiz_insert->candidate_options = $question->options->candidate_option??'';   
            }
            $quiz_insert->save();

        }
    }
   
    private function DuplicateScreening($job_id, $new_job_id)
    {
        JobScreeningQuiz::query()
            ->where('job_id',$job_id)
            ->each(function ($oldPost) use($new_job_id){
                $jobScreening = $oldPost->replicate();
                $jobScreening->job_id = $new_job_id;
                $jobScreening->quiz_code = $this->generateRandomString(7);
                $jobScreening->save();             
        }); 
    }

}
