<?php

namespace App\Http\Requests\User;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordFormRequest extends Request
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
        $rule = [            
            'old_password' => 'required',
            'password' => 'required|min:8|different:old_password',
            'confirm_password' => 'required|same:password',
        ];
        return $rule;
    }

    public function messages()
    {
        $messages = [
            'old_password.required' => 'Please Enter Old Password.',
            'password.required' => 'Please Enter Password.',
            'password.min' => __('The password should be more than 8 characters long'),
            'confirm_password.required' => 'Please Enter Confirm Password.',
            'confirm_password.same' => 'Passwords didn’t match. Try again.'
        ];
        return $messages;
    }

}