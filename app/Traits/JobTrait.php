<?php



namespace App\Traits;

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


}

