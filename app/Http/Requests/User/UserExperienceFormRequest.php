<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class UserExperienceFormRequest extends Request
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
        switch ($this->method()) {
            case 'PUT':
            case 'POST': {
                    $id = (int) $this->input('id', 0);
                    $rules = [
                        "title" => "required",
                        "company" => "required|max:180",
                        "country_id_dd" => "required",
                        "location" => "required|max:180",
                        // "state_id_dd" => "required",
                        // "city_id_dd" => "required",
                        "date_start" => "required",
                        // "description" => "required|max:4000",
                    ];

                    if(empty($this->input('is_currently_working'))){
                        $rules["date_end"] = "required";
                    }

                    return $rules;
                }
            default:break;
        }
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
