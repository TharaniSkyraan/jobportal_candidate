<?php

namespace App\Http\Requests\Api;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ForgetPasswordRequest extends Request
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
        $rules =  [
            'email' => 'required|email|exists:users',
        ];
        return $rules;
    }
    public function failedValidation(Validator $validator)
    {
        $errors = '';
        $messages = $validator->errors()->messages();
        $message = '';
        dd($message);
        foreach ($messages as $key => $value) {
            $errors[$key] = $value[0];
            if(empty($message)){
                $message = $value[0];
            }
        }
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => $message,
            'data'=> []
        ]));
    }

    public function messages()
    {
        return [
            'email.required' => __('Email is required'),
        ];
    }

}