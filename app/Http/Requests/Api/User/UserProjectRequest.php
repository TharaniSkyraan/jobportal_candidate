<?php

namespace App\Http\Requests\Api\User;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserProjectRequest extends Request
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
            "name" => "required",
            "company_name" => "required",
            "country_id" => "required",
            "location" => "required|max:180",
            "noof_team_member" => "required_if:work_as_team,yes",
            "date_start" => "required",
            "description" => "required|max:4000",
        ];

        if(empty($this->is_on_going)){
            $rule['date_end'] = "required";
        }
        return $rule;

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
            'data'=> []
        ]));
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter Project title.',
            'image.required' => 'Only images can be uploaded.',
            'url.required' => 'Please enter project URL.',
            'date_start.required_if' => 'Please set start date.',
            'date_end.required_if' => 'Please set end date.',
            'noof_team_member.required_if' => 'Please enter no of team members.',
            'is_on_going.required' => 'Is this project ongoing?',
            'description.required' => 'Please enter project description.',
            'country_id.required' => 'Please Select Country.',
            'state_id.required' => 'Please Select State.',
            'location.required' => 'Please enter City.',
        ];
    }

}