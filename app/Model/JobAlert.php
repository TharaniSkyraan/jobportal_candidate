<?php

namespace App\Model;

use App;
use Illuminate\Database\Eloquent\Model;

class JobAlert extends Model
{

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function getJobType()
    {
       
    }
    public function getShift()
    {
        
    }
    public function getCities()
    {
        
    }
    public function getSalary()
    {
        
    }
    public function getDatePosted()
    {
        
    }
    public function getEducationLevel()
    {
        
    }
    public function getFunctionalArea()
    {
        
    }
    public function getIndustryType()
    {
        
    }
    public function getExperience()
    {
        
    }
    public function getWFH()
    {
        
    }

}
