<?php

namespace App\Http\Requests\User;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Hash;

class ChangePhoneNumberFormRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [            
            'phone' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'Please Enter Phone Number.',
        ];
    }

}