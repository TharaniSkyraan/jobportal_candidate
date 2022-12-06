<?php

namespace App\Http\Requests\Front;

use App\Http\Requests\Request;

class JobEditFormRequest extends Request
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

        if($this->form == 'basic_form'){
            $rules = [
                "title" => "required|max:180", 
                "salary_period_id" => "required_if:hide_salary,==,1",
                "salary_from" => "required_if:hide_salary,==,1",
                "salary_to" => "required_if:hide_salary,==,1",
                "min_experience" => "required_if:experience,==,experienced",
                "max_experience" => "required_if:experience,==,experienced",
            ];
            if($this->work_from_home!='permanent'){                     
                $rules['location'] ='required|max:180';                  
                $rules['country_id'] ='required';
                // $rules['work_country_id.*'] ='required';
                // $rules['work_state_id.*'] ='required';
                // $rules['work_city_id.*'] ='required';
                // $rules['work_pincode.*'] ='required|min:3|max:6';
            }
        }else
        if($this->form == 'description_form'){
            
            $rules = ["description" => "required"];
            
        }else
        if($this->form == 'additional_description_form'){
            
            $rules = ["additional_description" => "required"];
            
        }else
        if($this->form == 'education_form'){

            $rules = [
                // "education_level_id" => "required",
                // "education_type_id" => "required",
                "skills" => "required",
                ];
                
            if(!isset($this->is_any_education_level)){
                $rules['education_level_id'] = 'required';
            }
        }else
        if($this->form == 'shift_form'){

            $rules = [                        
                "type_id" => "required",
                ];
                
            // if(in_array(5, explode(',',$this->type_id))){
            //     $rules['working_hours'] = 'required';

            // }
            // if(in_array(1, explode(',',$this->type_id)) || in_array(2, explode(',',$this->type_id)) || in_array(4, explode(',',$this->type_id))){
            //     $rules['working_deadline'] = 'required';
            //     $rules['working_deadline_period_id'] = 'required';
            // }
        }else
        if($this->form == 'benefits_form'){
            $rules = [
                // "benefits" => "required",
                // "supplementals" => "required",
            ];
        }else
        if($this->form == 'walkin_form'){
            // $rules = [
            //     // "interview_location" => "required_if:interview_type,==,face_to_face",
            //     // "state_id" => "required_if:interview_type,==,face_to_face",
            //     // "city_id" => "required_if:interview_type,==,face_to_face",
            // ];
            // if($this->interview_type=='face_to_face'){
            //     $rules['pin_code'] = 'required|min:3|max:6';
            // }
            $rules = array();
            if($this->walk_in_check=='1'){
                $rules['walk_in_from_date'] = 'required|date';
                $rules['walk_in_to_date'] = 'required|date';
                $rules['walk_in_from_time'] = 'required';
                $rules['walk_in_to_time'] = 'required';
                $rules['walk_in_location'] = 'required';
            }
            
        }else
        if($this->form == 'contact_person_form'){

            $rules = [
                "name" => "required",
                "email" => "required",
                "phone" => "required|max:30",
            ];
        }
    
        return $rules;

    }

    public function messages()
    {
        return [
            'name.required' => __('Please enter Name'),
            'email.required' => __('Please enter Email'),
            'phone.required' => __('Please enter Phone'),
            'description.required' => __('Please enter Job description'),
            'skill.required' => __('Please enter Job skills'),
            'expiry_date.required_if' => __('Please enter job expiry date'),
            'state_id.required_if' => __('Please select State'),
            'city_id.required_if' => __('Please select City'),
            'pin_code.required' => __('Please Fill Pincode'),
            'pin_code.numeric' => __('Pincode should be numeric'),
            'pin_code.min' => __('The Pincode should be more than 3 characters long'),
            'pin_code.max' => __('The Pincode should be less than 6 characters long'),
            'interview_location.required_if' => __('Please fill Interview Location'),
            'type_id.required' => __('Please select job type'),
            'shifts.required' => __('Please select job shift'),
            'start_date.required_if' => __('Please enter Job Start date'),
            'working_hours.required' => __('Please Fill Working hours'),
            'working_deadline.required' => __('Please Fill Working length'),
            'working_deadline_period_id.required' => __('Please Select Working time period'),
            'walk_in_from_date.required' => __('Please Select Walk-in from date'),
            'walk_in_to_date.required' => __('Please Select Walk-in to date'),
            'walk_in_from_time.required' => __('Please Select Walk-in from time'),
            'walk_in_to_time.required' => __('Please Select Walk-in to time'),
            'walk_in_location.required' => __('Please Select Walk-in location'),
            'salary_period_id.required_if' => __('Please Select Salary Period'),
            'salary_from.required_if' => __('Please enter Minimum Salary'),
            'salary_to.required_if' => __('Please enter Maximum Salary'),
            'min_experience.required_if' => __('Please enter Minimum Experience'),
            'max_experience.required_if' => __('Please enter Maximum Experience'),
            'location.required' => __('Please enter City'),
            // 'work_country_id.*.required' => __('Please select Country'),
            // 'work_state_id.*.required' => __('Please select State'),
            // 'work_city_id.*.required' => __('Please select City'),
            // 'work_pincode.*.required' => __('Please enter Pincode'),
            // 'work_pincode.*.numeric' => __('Pincode should be numeric'),
        ];
    }

}
