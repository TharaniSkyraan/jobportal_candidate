<?php

namespace App\Http\Controllers;

use Mail;
use DB;
use Input;
use Session;
use Form;
use Auth;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Traits\CountryStateCity;
// use Twilio\Rest\Client as Clients;
use Twilio\Jwt\ClientToken;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Model\Job;

use App\Model\JobApply;
use App\Model\Company;
use App\Model\SuggestedCandidate;


use App\Model\City;
use App\Model\Title;
use App\Model\JobSearch;
use App\Model\Industry;
use App\Model\SiteSetting;
use App\Model\companygalary;
use App\Model\JobWorkLocation;

class AjaxController extends Controller
{

    use CountryStateCity;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function DeleteParticularGalary(Request $request, $id)
    {

        $company = Auth::user();
        $status=companygalary::where('company_id',$company->id)->where('id',$id)->delete();
        if($status == true)
        {
            $data['success']=1;
        }
        else
        {
            $data['success']=0;
        }
    return response()->json(array('data' => $data));
    }
    public function getAllGalariesCompanyParticular(Request $request)
    {
        $company = Auth::user();
        $data = companygalary::where('company_id',$company->id)->where('id',$request->id)->get();
        return response()->json(array('success' => true, 'data' => $data));
    }
    public function getAllGalariesCompany(Request $request)
    {
        $company = Auth::user();

        $data = companygalary::where('company_id',$company->id)->get();
        
        return response()->json(array('success' => true, 'data' => $data));
    }


    public function getourcompanygallery(Request $request, $id)
    {
        
        $data = companygalary::where('company_id',$id)->get();
        
        return response()->json(array('success' => true, 'data' => $data));
    }
    




    public function optionValue(Request $request)
    {
        $type = $request->option_value;
        if($type=='education')
        {
            $data = DataArrayHelper::langEducationlevelsArray();
        }
        if($type=='shift'){
            $data = DataArrayHelper::langShiftsArray();
        }
        if($type=='experience'){
            $data = DataArrayHelper::langExperiencesArray();
        }
        return response()->json(array('success' => true, 'data' => $data??''));
    }
    public function filterDefaultStates(Request $request)
    {
        $country_id = $request->input('country_id');
        $state_id = $request->input('state_id');
        $new_state_id = $request->input('new_state_id', 'state_id');
        $states = DataArrayHelper::defaultStatesArray($country_id);
       
        return response()->json(array('success' => true, 'data' => $states));
    }
    public function filterDefaultCities(Request $request)
    {
        $state_id = $request->input('state_id');
        $city_id = $request->input('city_id');
        $cities = DataArrayHelper::defaultCitiesArray($state_id);
        return response()->json(array('success' => true, 'data' => $cities));
    }
    public function filterDefaultCitiesCountryWise(Request $request)
    {
        $country_id = $request->input('country_id');
        $city_id = $request->input('city_id');
        $cities = DataArrayHelper::defaultCitiesArrayCountryWise($country_id);
        return response()->json(array('success' => true, 'data' => $cities));
    }
    public function filterDefaultCountries(Request $request) 
    {
        $countries = DataArrayHelper::defaultCountriesArray();
        return response()->json(array('success' => true, 'data' => $countries));
    }
    /*     * ***************************************** */

    public function filterLangStates(Request $request)
    {
        $input_name = $request->input('input_name')??'state_id';
        $country_id = $request->input('country_id');
        $state_id = $request->input('state_id');
        // $new_state_id = $request->input('new_state_id', 'state_id');
        $states = DataArrayHelper::langStatesArray($country_id);
        // $dd = Form::select($input_name, ['' => __('Select State')] + $states, $state_id, array('id' => $input_name, 'class' => 'form-control state_id'));
        
        return response()->json(array('success' => true, 'data' => $states));
        
    }

    public function filterLangCities(Request $request)
    {
        $input_name = $request->input('input_name')??'city_id';
        $state_id = $request->input('state_id');
        $city_id = $request->input('city_id');
        $cities = DataArrayHelper::langCitiesArray($state_id);

        // $dd = Form::select($input_name, ['' => 'Select City'] + $cities, $city_id, array('id' => $input_name, 'class' => 'form-control city_id'));

        return response()->json(array('success' => true, 'data' => $cities));

    }

    /*     * ***************************************** */

    public function filterEducationTypes(Request $request)
    {
        $education_level_id = $request->input('education_level_id');
        $education_type_id = $request->input('education_type_id');

        $educationTypes = DataArrayHelper::langEducationTypesArray($education_level_id);
        $dd = Form::select('education_type_id', ['' => 'Select education type'] + $educationTypes, $education_type_id, array('id' => 'education_type_id', 'class' => 'form-select required education_type_id'));

        if(count($educationTypes)>0){
            echo $dd; exit;
        }
        echo '';
    }

    public function filterMultiselectEducationTypes(Request $request)
    {
        $education_level_id = $request->input('education_level_id');
        $education_type_id = explode(',',$request->input('education_type_id'));

        $educationTypes = DataArrayHelper::langEducationTypesArray($education_level_id);

        $dd = Form::select('education_type_id[]', $educationTypes, $education_type_id, array('id' => 'education_type_id', 'class' => 'required', 'multiple' => 'multiple'));
        
        if(count($educationTypes)>0){
            echo $dd; exit;
        }
        echo '';
    }

    public function filterDefaultSubIndustries(Request $request)
    {
        $industry_id = $request->input('industry_id');
        $sub_industry_id = $request->input('sub_industry_id');
        $new_sub_industry_id = $request->input('new_sub_industry_id', 'sub_industry_id');
        $sub_industries = DataArrayHelper::defaultSubIndustriesArray($industry_id);
        $dd = Form::select('sub_industry_id', ['' => __('Select Sub Industries')] + $sub_industries, $sub_industry_id, array('id' => $new_sub_industry_id, 'class' => 'form-control sub_industry_id'));
        echo $dd;
    }

    public function SkillData()
    {

        $skills = array_values(DataArrayHelper::langSkillsArray());      
        
        return response()->json(array('success' => true, 'skills' => $skills));
    }

    public function SkillDatas(Request $request)
    {

        $skills = DataArrayHelper::suggestionSkills($request->key);      
        
        echo $skills;
    }

    public function filterSubIndustries(Request $request)
    {
        $industry_id = $request->input('industry_id');
        $sub_industry_id = $request->input('sub_industry_id');
        $new_sub_industry_id = $request->input('new_sub_industry_id', 'sub_industry_id');
        $sub_industries = DataArrayHelper::defaultSubIndustriesArray($industry_id);
        $dd = Form::select('sub_industry_id', ['' => __('Select Sub Industries')] + $sub_industries, $sub_industry_id, array('id' => $new_sub_industry_id, 'class' => 'form-control sub_industry_id'));
        
        if(count($sub_industries)>0){
            echo $dd; exit;
        }
        echo '';
    }

    public function getDesignation(Request $request)
    {
        $term = $request->q;
        $results = DataArrayHelper::autocompleteDesignation($term);
        return response()->json($results);
    }

    public function getDefaultDesignation()
    {
        $results = DataArrayHelper::autocompleteDesignation();
        return response()->json($results);
    }
    
    public function getLocation(Request $request)
    {
        $term = $request->q;
        $country_code = $request->country_code;
        $results = DataArrayHelper::autocompleteLocation($term,$country_code);
        return response()->json($results);
    }
    
    public function getInstitute(Request $request)
    {
        $term = $request->q??'';
        $country_code = $request->country_code??'';
        $results = DataArrayHelper::autocompleteInstitute($term,$country_code);
        return response()->json($results);
    }

    public function getTitle(Request $request)
    {
        $term = $request->q??'';
        $results = DataArrayHelper::autocompleteTitle($term);
        return response()->json($results);
    }

    public function getDefaultLocation()
    {
        $results = DataArrayHelper::autocompleteLocation();
        return response()->json($results);
    }
    
    public function getCity(Request $request)
    {
        $term = $request->key;
        $country_code = $request->country_code;
        $results = DataArrayHelper::autocompleteCity($term,$country_code);
        
        echo $results;
    }

    public function SendOtp()
    {   
        
        $settings = SiteSetting::findOrFail(1272);
        
        $account_sid = $settings->twilio_account_sid;
        $auth_token = $settings->twilio_auth_token;   
        $twilio_number = $settings->twilio_number;
        $client = new Client(['auth' => [$account_sid, $auth_token]]);
        $result = $client->post('https://api.twilio.com/2010-04-01/Accounts/'.$account_sid.'/Messages.json',
                ['form_params' => [
                    'Body' => 'CODE: 4567886', //set message body
                    'To' => '+917402171681',
                    'From' => $twilio_number //we get this number from twilio
                    ]
                ]);
    }

    public function SendMessage()
    {
        
        $settings = SiteSetting::findOrFail(1272);
        
        $account_sid = $settings->twilio_account_sid;
        $auth_token = $settings->twilio_auth_token;   
        $twilio_number = $settings->twilio_number;
        $client = new Clients($account_sid, $auth_token);
        $client->messages->create('+917402171681', ['from' => $twilio_number, 'body' => 'test']);

    }
    
    public function SendtestMail()
    {
          $data = array('name'=>"Tharani");
   
          Mail::send(['text'=>'mail'], $data, function($message) {
             $message->to('tharaniaxeraan@gmail.com', 'Tes Mail')->subject
                ('Testing Mail');
             $message->from('support@quranpoint.com','Job Portal');
          });
          echo "Basic Email Sent. Check your inbox.";

    }

}
