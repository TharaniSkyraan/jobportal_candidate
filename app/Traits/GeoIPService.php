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
                'geoplugin_regionName' => $record->mostSpecificSubdivision->name,
                'geoplugin_regionCode' => $record->mostSpecificSubdivision->isoCode,
                'geoplugin_countryName' => $record->country->name,
                'geoplugin_countryCode' => $record->country->isoCode,
                'geoplugin_postalcode' => $record->postal->code,
                'geoplugin_latitude' => $record->location->latitude,
                'geoplugin_longitude' => $record->location->longitude,
            ];
        } catch (AddressNotFoundException $e) {
            return null;
        }
    }
}
