<?php

namespace App\Traits;
use App\Model\JobApply;
use Carbon\Carbon;

trait JobTrait
{

    public function scopeNotExpire($query)
    {
        return $query->whereDate('expiry_date', '>', Carbon::now()); //where('expiry_date', '>=', date('Y-m-d'));
    }

    public function isJobExpired()
    {
        return ($this->expiry_date < Carbon::now())? true:false;
    }

    public function Notification($id,$phone)
    {
        $job = JobApply::find($id);

        if(!empty($phone)){

            $user =  $job->userdetail;
            $title = $job->job->title;
            $company_name = $job->job->company_name??'';
            $recruiter_name = $job->job->companyuser->name??'';
            $data = [
                "to"=>$phone,
                "messaging_product"=>"whatsapp",
                "type"=>"template",
                "template"=>[
                    "name"=>"candidate_applied",
                    "language"=>[
                        "code"=>"en_US"
                    ],
                    "components"=>[
                        [
                            "type"=>"body",
                            "parameters"=>[
                                [
                                    "type"=>"text",
                                    "text"=>$recruiter_name
                                ],
                                [
                                    "type"=>"text",
                                    "text"=>$user['name']
                                ],
                                [
                                    "type"=>"text",
                                    "text"=>"$title"
                                ],
                                [
                                    "type"=>"text",
                                    "text"=>"$company_name"
                                ],
                                [
                                    "type"=>"text",
                                    "text"=>$user['education']
                                ],
                                [
                                    "type"=>"text",
                                    "text"=>$user['total_experience']
                                ],
                                [
                                    "type"=>"text",
                                    "text"=>$user['location']
                                ],
                                [
                                    "type"=>"text",
                                    "text"=>$user['skill']
                                ]
                            ]
                        ],
                        [
                            "type"=> "button",
                            "sub_type"=> "url",
                            "index"=> 0,
                            "parameters"=> [
                                [
                                    "type"=> "text",
                                    "text"=> $job->id // dynamic url
                                ]
                            ]
                        ]
                    ]            
                ]
            ];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://graph.facebook.com/v17.0/184496344748646/messages");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));  //Post Fields
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
            $headers = [
                'Authorization: Bearer '.config('services.whatsapp.access_token'), 
                'Content-Type: application/json' 
            ];
        
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
            $server_output = curl_exec ($ch);
        
            curl_close ($ch); 
        }

    }

}

