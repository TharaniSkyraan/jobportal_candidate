<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Contracts\Validation\Rule;
use App\Model\User;
use Illuminate\Support\Facades\Auth;

class UniquePhoneAndAlternative implements Rule
{
    public function passes($attribute, $value)
    {
        $userId = Auth::id(); // Get the ID of the authenticated user

        // Check if the value is unique in both phone and alternative_number columns
        $userCount = User::where(function ($query) use ($value, $userId) {
            $query->where('phone', $value)
                  ->orWhere('alternative_phone', $value);
        })
        ->where('id', '<>', $userId) // Exclude the authenticated user
        ->count();

        return $userCount === 0;
    }

    public function message()
    {
        return 'This :attribute number is already registered. Please choose a different one.';
    }
}
