<?php

namespace App\Traits;

use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

trait GeoIPService
{
    protected $reader;

    public function __construct()
    {
        $this->reader = new Reader(storage_path('app/GeoLite2-City.mmdb'));
    }

    public function getCity($ip)
    {
        try {
            $record = $this->reader->city($ip);
            return [
                'geoplugin_city' => $record->city->name,
                'geoplugin_regionName' => $record->mostSpecificSubdivision->isoCode,
                'geoplugin_countryName' => $record->country->name,
            ];
        } catch (AddressNotFoundException $e) {
            return null;
        }
    }
}
