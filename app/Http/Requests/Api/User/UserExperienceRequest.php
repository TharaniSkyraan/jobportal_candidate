<?php

namespace App\Http\Requests\Api\User;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserExperienceRequest extends Request
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
        
        $rules = [
            "title" => "required",
            "company" => "required|max:180",
            "country_id" => "required",
            "location" => "required|max:180",
            "date_start" => "required",
        ];

        if(empty($this->input('is_currently_working'))){
            $rules["date_end"] = "required";
        }

        return $rules;

    }
    public function failedValidation(Validator $validator)
    {
        $errors = array();
        $messages = $validator->errors()->messages();
        foreach ($messages as $key => $value) {
            $errors[$key] = $value[0];
        }
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'=> $errors
        ]));
    }

    public function messages()
    {
        return [
            'title.required' => 'Please enter Designation.',
            'company.required' => 'Please enter company.',
            'description.required' => 'Please enter description.',
            'country_id_dd.required' => 'Please select country.',
            'state_id_dd.required' => 'Please select state.',
            'location.required' => 'Please enter city.',
            'date_start.required' => 'Please set start date.',
            'date_end.required_if' => 'Please set end date.',
            'is_currently_working.required' => 'Are you currently working here?',
            'description.required' => 'Please enter experience description.',
        ];
    }

}