<?php 
namespace App\Traits;

use DB;
use App\Model\JobSearch;
use App\Model\Title;
use App\Model\City;
use App\Model\TitleDraft;
use App\Model\CityDraft;
use App\Helpers\DataArrayHelper;
use Illuminate\Http\Request;

trait BlockedKeywords
{

    // public function checkKeywords($designation = '', $location = '')
    public function checkKeywords(Request $request, $d ='', $l = '')    
    {

        $designation = strtolower(preg_replace('/[!\/\\\\|\$\%\^\&\*\'\{\}\[\(\)\_\-\<\>\@\,\~\`\;\" "]+/', ' ', $request->designation??$d));
        // Special Character to String
        $designation = preg_replace('/[#]+/', ' sharp ', $designation);
        $designation = preg_replace('/[+]{2,}+/', ' plus plus ', $designation);
        $designation = preg_replace('/[+]+/', ' plus ', $designation);
        $designation = preg_replace('/[.]+/', ' dot ', $designation);        
        $location = $locations =  strtolower(preg_replace('/[!\/\\\|\$\%\^\&\*\'\(\)\_\-\<\>\@\,\~\`\;\""]+/', '', $request->location??$l));
        $words = DataArrayHelper::blockedKeywords();
        $designation_slug = $location_slug = '';

        $check_designation = Title::whereTitle($designation)->first();
        
        if(empty($check_designation)){
                
            // Designation Check with Location
            foreach(explode(' ',$designation) as $key => $value){

                $check_title = Title::whereTitle($value)
                                    ->orwhereRaw('FIND_IN_SET("'.$value.'",title)')
                                    ->first();
                if(empty($check_title)){

                    $check_location = City::whereLocation($value)
                                        ->orwhere('city',$value)
                                        // ->orwhereRaw('FIND_IN_SET("'.$value.'",keywords)')
                                        ->whereCountryId(101)
                                        ->first();

                    // Find out location in designtaion and store in location variable
                    if(isset($check_location))
                    {
                        $city_full_string = strtolower((!empty($check_location->city))?$check_location->city:$check_location->location);
                        $city = implode('-',array_filter(explode(' ',$city_full_string)));
                        if(!in_array($city, explode(',',$location))){
                            $location .= (strlen($location)!=0)? ','.$city : $city;
                            $locations .= (strlen($locations)!=0)? ','.$city_full_string : $city_full_string;
                        }
                        $designation = str_replace("  "," ", str_replace($value,"",$designation));
                    }
                }

            }
        }
       // get special character from slug
        $request_designation = implode(' ',array_filter(explode(' ',$designation)));
        $request_designation = str_replace('. ', '.', str_replace(' #', '#', str_replace(' +', '+', str_replace('dot', '.', str_replace('sharp', '#', str_replace('plus', '+', $request_designation))))));
       
        // Slug merge 
        $designation_slug = implode('-',array_filter(preg_split('/[\s|,]/', $designation)));
        $location_slug = implode('-',array_filter(preg_split('/[\s|,]/', $location)));
        $designation_slug = ((strlen($designation_slug)==0)? '' :$designation_slug.'-');
        $location_slug = ((strlen($location_slug)==0)? '' : '-in-'.$location_slug);
        $slug = $designation_slug.'jobs'.$location_slug;

        $result = array('success' => true, 
                        'd' => $request_designation, 
                        'l' => $location,
                        'sl' => $slug,
                        'dbk' => $this->checkTitleBlockedKeywords($designation, $words),
                        'lbk' => $this->checkLocationBlockedKeywords($request->location, $words),
                    );
        if(!empty($d) || !empty($l)){
            return $result;
        }
        return response()->json($result);
    }


    private function checkTitleBlockedKeywords($designation, $words)
    {

        $title_key_blocked = 'no';
        // // Remove blocked keywords
        $searchValues = explode(' ',$designation);

        // Designation Check and Update in designation draft and check blocked keywords
        foreach($searchValues as $key => $value){
            // blocked keywords
            if(in_array($value, $words) || strlen($value)>60){
                $title_key_blocked = 'yes';
            }
        }
        // Designation Check and Update in designation draft
        if(!empty($designation) && !in_array($designation, $words)){
            

            $title = Title::where('title', $designation)->whereIsDefault(1)->whereIsActive(1)->whereLang(config('default_lang'))->first();
            $title_draft = TitleDraft::select('id','hit_count')->where('title', $designation)->whereIsDefault(1)->whereIsActive(1)->whereLang(config('default_lang'))->first();
        
            if(!isset($title)){
                $hit_count = 1;
                
                if(isset($title_draft)){
                    $title_draft = TitleDraft::findOrFail($title_draft->id);
                    $title_draft->hit_count += 1;
                }else{
                    $title_draft = new TitleDraft();
                    $title_draft->title = $designation;
                    $title_draft->is_active = 1;
                    $title_draft->lang = config('default_lang');
                    $title_draft->is_default = 1;
                    $title_draft->hit_count = $hit_count;
                }
                $title_draft->save();

            }else{
                Title::where('id',$title->id)->update(['hit_count'=>DB::raw('hit_count+1')]);
            } 
        }
        
        if((count($searchValues)==1 && strlen($searchValues[0])>60)){
            $title_key_blocked = 'yes';
        } 

        return $title_key_blocked;
    }

    private function checkLocationBlockedKeywords($location, $words)
    {
        $searchlocationValues = explode(',',$location);
        $location_key_blocked = 'no';
        
        // Location Check and Update in location draft and check blocked keywords
        foreach($searchlocationValues as $value){
            // blocked keywords
            if(in_array($value, $words) || strlen($value)>60){
                $location_key_blocked = 'yes';
            }else{                
                // Location Check and Update in location draft
                if(!empty($value)){  

                    $locations = City::where('location', $value)->whereIsDefault(1)->whereIsActive(1)->whereLang(config('default_lang'))->first();
                    $location_draft = CityDraft::select('id','hit_count')->where('location', $value)->whereIsDefault(1)->whereIsActive(1)->whereLang(config('default_lang'))->first();
                    
                    if(!isset($locations)){    

                        $hit_count = 0;
                        
                        if(isset($location_draft)){
                            $location_draft = CityDraft::findOrFail($location_draft->id);
                            $location_draft->hit_count += 1;
                            $hit_count = $location_draft->hit_count;
                        }else{
                            $location_draft = new CityDraft();
                            $location_draft->location = $value;
                            $location_draft->is_active = 1;
                            $location_draft->lang = config('default_lang');
                            $location_draft->is_default = 1;
                            $location_draft->hit_count = 1;
                        }
                        $location_draft->save();

                    }else{
                        City::where('id',$locations->id)->update(['hit_count'=>DB::raw('hit_count+1')]);

                    }   

                } 
            }
        }

        if((count($searchlocationValues)==1 && strlen($searchlocationValues[0])>60)){
            $location_key_blocked = 'yes';
        }

        return $location_key_blocked;

    }
    
}
