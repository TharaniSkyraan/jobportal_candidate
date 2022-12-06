<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class UserProjectFormRequest extends Request
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

                    $rule = [
                        "name" => "required",
                        // "user_experience_id" => "required",
                        // "country_id_dd" => "required",
                        // "location" => "required|max:180",
                        // "noof_team_member" => "required_if:work_as_team,'yes'",
                        // "date_start" => "required",
                        "description" => "required|max:255",
                    ];

                    // if(empty($this->is_on_going)){
                    //     $rule['date_end'] = "required";
                    // }
                    return $rule;
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'user_experience_id.required' => 'Please Select Your Project Done By.',
            'name.required' => 'Please enter Project title.',
            'image.required' => 'Only images can be uploaded.',
            'url.required' => 'Please enter project URL.',
            'date_start.required_if' => 'Please set start date.',
            'date_end.required_if' => 'Please set end date.',
            'noof_team_member.required_if' => 'Please enter no of team members.',
            'is_on_going.required' => 'Is this project ongoing?',
            'description.required' => 'Please enter project description.',
            'country_id_dd.required' => 'Please Select Country.',
            'state_id_dd.required' => 'Please Select State.',
            'location.required' => 'Please enter City.',
        ];
    }

}
