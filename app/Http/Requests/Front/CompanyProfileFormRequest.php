<?php

namespace App\Http\Requests\Front;

use Auth;
use App\Http\Requests\Request;

class CompanyProfileFormRequest extends Request
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
        // $rules = [
        //     'email'  => ['required', 'email:rfc,dns,filter', 'unique:users,email,NULL,id,deleted_at,NULL'],
        // ];
        // return $rules;
        if($this->form=='companynameform'){
            $rules = [
                'name' => 'required',
            ];
        }
        if($this->form == 'companyaboutdetails')
        {
            $rules = [
                'description' => 'required',
            ];
        }
        if($this->form == 'companypersonaldetails')
        {
            $rules = [
                'CEO_name' => 'required',
                'founded_on' => 'required',
                'no_of_employees' => 'required',
                'industry_id' => 'required',
                'website_url' => 'required',
            ]; 
        }
        if($this->form == 'companylocationdetails')
        {
            $rules = [
                'address' => 'required',
                'country_id' => 'required',
                'city_id' => 'required',
                'pin_code' => 'required',
            ]; 
        }
        if($this->form=='basic'){
            $rules = [
                'employer_name' => 'required',
                'date_of_birth' => 'required',
            ];
        }
        if($this->form=='work'){
            $rules = [
                'name' => 'required|max:150',
                'employer_role_id' => 'required',
                'industry_id' => 'required',
                // 'state_id' => 'required',
                // 'city_id' => 'required',
                'pin_code' => 'required|min:3|max:6',
                'location' => 'required|max:180',
                'address' => 'required|max:255',
            ];
        }

        if($this->form=='about'){
            $rules = [
                'description' => 'required',
            ];
            if($this->website_url!=''){
                $rules['website_url']  = "url|max:150";
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => __('Company Name is required'),
            'date_of_birth.required' => __('Date of birth is required'),
            'industry_id.required' => __('Please Select Industry'),
            'state_id.required' => __('Please Select state'),
            'city_id.required' => __('Please Select city'),
            'pin_code.required' => __('Please Fill Pincode'),
            'pin_code.min' => __('The Pincode should be more than 3 characters long'),
            'pin_code.numeric' => __('Pincode should be numeric'),
            'pin_code.max' => __('The Pincode should be less than 6 characters long'),
            'sub_industry_id.required' => __('Please Select Sub Industry'),
            'address.required' => __('Please enter address'),
            'location.required' => __('Please enter City'),
            'employer_name.required' => __('Your Name is required'),
            'employer_role_id.required' => __('Please Select Employer Role'),
            'website_url.url' => __('Complete url of website required'),
          ];
    }

}
