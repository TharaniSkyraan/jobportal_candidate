<?php

namespace App\Http\Requests\Front;

use Auth;
use App\Http\Requests\Request;

class CompanyFrontRegisterFormRequest extends Request
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

        return [
            'name' => 'required|max:150',
            'industry_id' => 'required',
            'country_id' => 'required',
            'location' => 'required|max:180',
            'pin_code' => 'required|min:3|max:6',
            'address' => 'required|max:255',
            'no_of_employees' => 'required',
            'employer_name' => 'required|max:150',
            'employer_role_id' => 'required',
            // 'sub_industry_id' => 'required',
            // 'state_id' => 'required',
            // 'city_id' => 'required',
            // 'password' => 'required|confirmed|min:6|max:50',
            // 'terms_of_use' => 'required',
            // 'g-recaptcha-response' => 'required|captcha',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('Company Name is required'),
            'industry_id.required' => __('Please Select Industry'),
            'country_id.required' => __('Please Select country'),
            'state_id.required' => __('Please Select state'),
            'city_id.required' => __('Please Select city'),
            'pin_code.required' => __('Please Fill Pincode'),
            'pin_code.min' => __('The Pincode should be more than 3 characters long'),
            'pin_code.max' => __('The Pincode should be less than 6 characters long'),
            'pin_code.numeric' => __('Pincode should be numeric'),
            'sub_industry_id.required' => __('Please Select Sub Industry'),
            'address.required' => __('Please fill address'),
            'location.required' => __('Please enter city'),
            'no_of_employees.required' => __('Please Select No.of Working Employee'),
            'employer_name.required' => __('Employer Name is required'),
            'employer_role_id.required' => __('Please Select Employer Role'),

            // 'email.required' => __('Email is required'),
            // 'email.email' => __('The email must be a valid email address'),
            // 'email.unique' => __('This Email has already been taken'),
            // 'password.required' => __('Password is required'),
            // 'password.min' => __('The password should be more than 3 characters long'),
            // 'terms_of_use.required' => __('Please accept terms of use'),
            //'g-recaptcha-response.required' => __('Please verify that you are not a robot'),
            //'g-recaptcha-response.captcha' => __('Captcha error! try again later or contact site admin'),
        ];
    }

}
