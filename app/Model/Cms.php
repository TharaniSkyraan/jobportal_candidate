<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{

    protected $table = 'cms';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    public function cmsPages()
    {
        return $this->hasMany(CmsPages::class, 'page_id', 'id')
                        ->orderBy('lang', 'ASC');
    }

}
