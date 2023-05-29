<?php

namespace App\Traits;

trait WhatsappNotification
{

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 1);
    }

}
