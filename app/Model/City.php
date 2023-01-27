<?php

namespace App\Model;

use App;
use App\Traits\Lang;
use App\Traits\IsDefault;
use App\Traits\Active;
use App\Traits\Sorted;
use App\Traits\CountryStateCity;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    use Lang;
    use IsDefault;
    use Active;
    use Sorted;
    use CountryStateCity;

    protected $table = 'cities';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    protected $append = ['city_slug'];

    public function getCountry($field)
    {
        if (null !== $state = $this->getState()) {
            return $state->getCountry('country');
        }
    }

    public static function getCityById($id)
    {
        $city = self::where('cities.city_id', '=', $id)->lang()->active()->first();

        if (null === $city) {
            $city = self::where('cities.city_id', '=', $id)->active()->first();
        }

        return $city;
    }

    public function getCitySlugAttribute()
    {
        $location =  strtolower(preg_replace('/[!\/\\\|\$\%\^\&\*\'\(\)\_\-\<\>\@\,\~\`\;\""]+/', '', $this->city));
        
        $location = str_replace(" ", "-", $location);

        return $location;
    }
}
