<?php

namespace App\Model;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobAlert extends Model
{
    
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function getJobType()
    {
        return Type::whereIn('id',explode(',',$this->jobtypeFGid))->pluck('type')->toArray();
    }
    public function getShift()
    {
        return Shift::whereIn('id',explode(',',$this->jobshiftFGid))->pluck('shift')->toArray();
    }
    public function getSalary()
    {
        $salarydata = "";
        $salaryFGid = explode(',',$this->salaryFGid);

        if(in_array("0to3",$salaryFGid)){
            $salarydata .="0 to 3 Lakhs / annum";
        }
        if(in_array("3to6",$salaryFGid)){
            $salarydata .=((!empty($salaryFGid))?", ":"")."3 to 6 Lakhs / annum";
        }
        if(in_array("6to10",$salaryFGid)){
            $salarydata .=((!empty($salaryFGid))?", ":"")."6 to 10 Lakhs / annum";
        }
        if(in_array("10to15",$salaryFGid)){
            $salarydata .=((!empty($salaryFGid))?", ":"")."10 to 15 Lakhs / annum";
        }
        if(in_array("15to25",$salaryFGid)){
            $salarydata .=((!empty($salaryFGid))?", ":"")."15 to 25 Lakhs / annum";
        }
        if(in_array("25to50",$salaryFGid)){
            $salarydata .=((!empty($salaryFGid))?", ":"")."25 to 50 Lakhs / annum";
        }
        if(in_array("50to75",$salaryFGid)){
            $salarydata .=((!empty($salaryFGid))?", ":"")."50 to 75 Lakhs / annum";
        }
        if(in_array("75to100",$salaryFGid)){
            $salarydata .=((!empty($salaryFGid))?", ":"")."75 to 100 Lakhs / annum";
        }
        return $salarydata.(!empty($salarydata))?".":"";
    }
    public function getDatePosted()
    {
        if($this->posteddateFid=='all'){
            return 'Last 24 hours, Last 3 days, Last 7 days, Last 14 days.';
        }else{
            $posteddate = "";
            $posteddates = explode(',',$this->posteddateFid);

            if(in_array("1",$posteddates)){
                $posteddate .="Last 24 hours";
            }
            if(in_array("3",$posteddates)){
                $posteddate .=((!empty($posteddate))?", ":"")."Last 2 days";
            }
            if(in_array("7",$posteddates)){
                $posteddate .=((!empty($posteddate))?", ":"")."Last 7 days";
            }
            if(in_array("14",$posteddates)){
                $posteddate .=((!empty($posteddate))?", ":"")."Last 14 days";
            }
            return $posteddate.(!empty($posteddate))?".":"";
        } 
    }
    public function getEducationLevel()
    {
        return EducationLevel::whereIn('id',explode(',',$this->edulevelFGid))->pluck('education_level')->toArray();
    }
    public function getFunctionalArea()
    {
        return FunctionalArea::whereIn('id',explode(',',$this->functionalareaGid))->pluck('functional_area')->toArray();
    }
    public function getIndustryType()
    {
       return Industry::whereIn('id',explode(',',$this->industrytypeGid))->pluck('industry')->toArray();
    }
    public function getWFH()
    {
        $wfh = "";
        $wfhs = explode(',',$this->wfhtypeFid);

        if(in_array("permanent",$wfhs)){
            $wfh .="Remote Permanent";
        }
        if(in_array("temporary",$wfhs)){
            
            $wfh .=((!empty($wfh))?", ":"")."Remote Covid-19";
        }
        return $wfh.(!empty($wfh))?".":"";     
    }

}
