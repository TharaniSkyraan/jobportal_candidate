<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class UserEducationFormRequest extends Request
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
                    $rule = ["education_level_id" => "required"];
                    $rule["country_id_dd"] = "required";
                    if($this->institution!=""){
                        $rule["institution"] = "required|max:180";
                    }
                    $rule["location"] = "required|max:180";
                    $rule["from_year"] = "required|date";
                    if(!isset($this->pursuing)){
                        $rule["to_year"] = "required|date";
                    }
                    return $rule;
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'education_level_id.required' => 'Please select education level.',
            'education_type_id.required' => 'Please select education type.',
            'education_title.required' => 'Please enter education title.',
            'major_subjects.required' => 'Please select major subjects.',
            'country_id_dd.required' => 'Please select country.',
            'state_id_dd.required' => 'Please select state.',
            'city_id_dd.required' => 'Please select city.',
            'institution.required' => 'Please enter institution.',
            'location.required' => 'Please enter city.',
            'to_year.required' => 'Please set to date.',
            'from_year.required' => 'Please set from date.',
            'year_completion.required' => 'Please set completion date.',
            'percentage.required' => 'Please enter result.',
            'result_type_id.required' => 'Please select result type.',
            'university_board.required' => 'Please Enter University / Board.',
        ];
    }

}
