<?php

namespace App\Model;

use App;
use Illuminate\Database\Eloquent\Model;

class MessageContact extends Model
{

    public $timestamps = true;
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['employer_active_status'];

    public function company()
    {
        return $this->belongsTo(CompanySubUser::class, 'sub_user_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function message()
    {
        return $this->hasMany(Message::class, 'message_id', 'message_id')->where('send_by','candidate')->where('is_read','0');
    }
    
    public function getTitleAttribute()
    {
        return $this->job?$this->job->title:'';
    }
    
    public function getContactNumberAttribute()
    {
        $contact_number = '';
        if(isset($this->job->contact_person_details)){
            if(!empty($this->job->contact_person_details->phone_1)){
                $contact_number = $this->job->contact_person_details->phone_1;
            } 
            if(!empty($this->job->contact_person_details->phone_2)){
                $contact_number = (!empty($contact_number)?',':'').$this->job->contact_person_details->phone_2;
            }
        }
        return $contact_number;
    }
    
    public function getJobLocationAttribute()
    {
        return $this->job?$this->job->work_locations:'';
    }
    
    public function getUserNameAttribute()
    {
        return $this->user?$this->user->getName():'';
    }
    
    public function getCompanyNameAttribute()
    {
        return $this->company->company?$this->company->company->name:'';
    }
    
    public function getUserImageAttribute()
    {
        return ($this->user)?$this->user->image:'';
    }
    
    public function getCompanyImageAttribute()
    {
        return ($this->company->company)?$this->company->company->company_image:'';
    }
    
    public function getUnreadAttribute()
    {
        return ($this->message->count()==0)?'':'unread';
    }

    public function getUserAvatarAttribute()
    {
        return ($this->user->getName()[0]??ucwords($this->user->email[0]));
    }

    public function getCompanyAvatarAttribute()
    {
        return ($this->company->company->name[0]??ucwords($this->company->company->email[0]));
    }
    
}
