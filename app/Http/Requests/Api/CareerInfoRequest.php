<?php

namespace App\Http\Requests\Api;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CareerInfoRequest extends Request
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
            'career_title' => 'required',
            'expected_salary' => 'required',
            'country_id' => 'required',
            'prefered_location' => 'required',
            'employment_status' => 'required',
        ];

        if($this->employment_status=='experienced'){
            $rule["exp_in_year"] = "required";
            $rule["exp_in_month"] = "required";
        }
        return $rules;
    }
    public function failedValidation(Validator $validator)
    {
        $errors = array();
        $messages = $validator->errors()->messages();
        $message = '';
        foreach ($messages as $key => $value) {
            $errors[$key] = $value[0];
            if(empty($message)){
                $message = $value[0];
            }
        }
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => $message,
            'data'=> $errors
        ]));
    }

    public function messages()
    {
        return [
            'employment_status.required' => __('Experience is required'),
        ];
    }

}