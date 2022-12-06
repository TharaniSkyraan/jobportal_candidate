<?php

namespace App\Model;

use App;
use App\Model\cms;
use App\Traits\Lang;
use App\Traits\Active;
use Illuminate\Database\Eloquent\Model;

class CmsContent extends Model
{

    use Lang;
    use Active;

    protected $table = 'cms_content';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    public function page()
    {
        return $this->belongsTo(Cms::class, 'page_id', 'id');
    }

    public static function getContentByPageId($id)
    {
        $cmsContent = self::where('page_id', '=', $id)->where('lang', 'like', \App::getLocale())->first();
        if (null === $cmsContent) {
            $cmsContent = self::where('page_id', '=', $id)->first();
        }

        return $cmsContent;
    }

    public static function getContentBySlug($slug)
    {
        $cms = Cms::where('page_slug', 'like', $slug)->first();
        $cmsContent = self::where('page_id', '=', $cms->id)->where('lang', 'like', \App::getLocale())->first();
        if (null === $cmsContent) {
            $cmsContent = self::where('page_id', '=', $cms->id)->first();
        }

        return $cmsContent;
    }

}
