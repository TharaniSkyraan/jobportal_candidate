<?php

namespace App\Helpers;

use DB;
use Request;
use Carbon\Carbon;
use App\Model\JobSearch;
use App\Model\Language;
use App\Model\EducationLevel;
use App\Model\EducationType;
use App\Model\User;
use App\Model\Gender;
use App\Model\Category;
use App\Model\Country;
use App\Model\CountryDetail;
use App\Model\State;
use App\Model\City;
use App\Model\CareerLevel;
use App\Model\Industry;
use App\Model\SubIndustry;
use App\Model\FunctionalArea;
use App\Model\MajorSubject;
use App\Model\ResultType;
use App\Model\LanguageLevel;
use App\Model\Skill;
use App\Model\Experience;
use App\Model\Type;
use App\Model\Shift;
use App\Model\Title;
use App\Model\Location;
use App\Model\Company;
use App\Model\MaritalStatus;
use App\Model\OwnershipType;
use App\Model\SalaryPeriod;
use App\Model\Video;
use App\Model\Testimonial;
use App\Model\Slider;
use App\Model\Supplemental;
use App\Model\Benefit;
use App\Model\EmployerRole;
use App\Model\UserExperience;
use App\Model\BlockedKeyword;
use App\Model\Institute;
use App\Model\TopCompany;
use App\Model\NoticePeriod;


class DataArrayHelper
{

    
  
    public static function defaultStatesArray($country_id)
    {
        $array = State::select('states.state', 'states.state_id')->where('states.country_id', '=', $country_id)->isDefault()->active()->sorted()->pluck('states.state', 'states.state_id')->toArray();
        return $array;
    }

    /*     * **************************** */

    public static function defaultCitiesArray($state_id)
    {
        $array = City::select('cities.city', 'cities.city_id')->where('cities.state_id', '=', $state_id)->isDefault()->active()->sorted()->pluck('cities.city', 'cities.city_id')->toArray();
        return $array;
    }
    public static function defaultCitiesArrayCountryWise($country_id)
    {
        $array = City::select('cities.city', 'cities.city_id')->where('cities.country_id', '=', $country_id)->isDefault()->active()->sorted()->pluck('cities.city', 'cities.city_id')->toArray();
        return $array;
    }

    /*     * **************************** */

    public static function langStatesArray($country_id)
    {
        $array = State::select('states.state', 'states.state_id')->where('states.country_id', '=', $country_id)->lang()->active()->sorted()->pluck('states.state', 'states.state_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultStatesArray($country_id);
        }
        return $array;
    }

    /*     * **************************** */

    public static function langCitiesArray($state_id)
    {
        $array = City::select('cities.city', 'cities.city_id')->where('cities.state_id', '=', $state_id)->lang()->active()->sorted()->pluck('cities.city', 'cities.city_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultCitiesArray($state_id);
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultEducationTypesArray($education_level_id)
    {
        $array = EducationType::select('education_types.education_type', 'education_types.education_type_id')->where('education_level_id', '=', $education_level_id)->isDefault()->active()->sorted()->pluck('education_types.education_type', 'education_types.education_type_id')->toArray();
        return $array;
    }

    public static function langEducationTypesArray($education_level_id)
    {
        $array = EducationType::select('education_types.education_type', 'education_types.education_type_id')->where('education_level_id', '=', $education_level_id)->lang()->active()->sorted()->pluck('education_types.education_type', 'education_types.education_type_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultEducationTypesArray($education_level_id);
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultGendersArray()
    {
        $array = Gender::select('genders.gender', 'genders.gender_id')->isDefault()->active()->sorted()->pluck('genders.gender', 'genders.gender_id')->toArray();
        return $array;
    }

    public static function langGendersArray()
    {
        $array = Gender::select('genders.gender', 'genders.gender_id')->lang()->active()->sorted()->pluck('genders.gender', 'genders.gender_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultGendersArray();
        }
        return $array;
    }


    public static function langGendersApiArray()
    {
        $array = Gender::select('gender', 'gender_id as id')->lang()->active()->sorted()->get();
        return $array;
    }

    /*     * **************************** */

    public static function defaultMaritalStatusesArray()
    {
        $array = MaritalStatus::select('marital_statuses.marital_status', 'marital_statuses.marital_status_id')->isDefault()->active()->sorted()->pluck('marital_statuses.marital_status', 'marital_statuses.marital_status_id')->toArray();
        return $array;
    }

    public static function langMaritalStatusesArray()
    {
        $array = MaritalStatus::select('marital_statuses.marital_status', 'marital_statuses.marital_status_id')->lang()->active()->sorted()->pluck('marital_statuses.marital_status', 'marital_statuses.marital_status_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultMaritalStatusesArray();
        }
        return $array;
    }

    public static function langMaritalStatusesApiArray()
    {
        $array = MaritalStatus::select('marital_status', 'marital_status_id as id')->lang()->active()->sorted()->get();
        return $array;
    }

    /*     * **************************** */

    public static function defaultNationalitiesArray()
    {
        $array = Country::select('countries.nationality', 'countries.country_id')->isDefault()->active()->sorted()->pluck('countries.nationality', 'countries.country_id')->toArray();
        return $array;
    }

    public static function langNationalitiesArray()
    {
        $array = Country::select('countries.nationality', 'countries.country_id')->lang()->active()->sorted()->pluck('countries.nationality', 'countries.country_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultNationalitiesArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultCountriesArray()
    {
        $array = Country::select('countries.country','countries.country', 'countries.country_id')->isDefault()->active()->sorted()->pluck('countries.country', 'countries.country_id')->toArray();
        return $array;
    }

    public static function langCountriesArray()
    {
        $array = Country::select('countries.country', 'countries.country_id')->lang()->active()->sorted()->pluck('countries.country', 'countries.country_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultCountriesArray();
        }
        return $array;
    }

    public static function CountriesArray()
    {
        $array = Country::lang()->active()->sorted()->get();
        if ((int) count($array) === 0) {
            $array = self::defaultCountriesArray();
        }
        
        $attributes = $array->mapWithKeys(function ($item) {
            return [$item->country_id => ['data-code' => $item->country_detail->sort_name]];
        })->toArray();

        $country['value'] = $array->pluck('country', 'country_id')->toArray();
        $country['attribute'] = $attributes;
       return $country;
    }

    /*     * **************************** */

    public static function defaultCareerLevelsArray()
    {
        $array = CareerLevel::select('career_levels.career_level', 'career_levels.career_level_id')->isDefault()->active()->sorted()->pluck('career_levels.career_level', 'career_levels.career_level_id')->toArray();
        return $array;
    }

    public static function langCareerLevelsArray()
    {
        $array = CareerLevel::select('career_levels.career_level', 'career_levels.career_level_id')->lang()->active()->sorted()->pluck('career_levels.career_level', 'career_levels.career_level_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultCareerLevelsArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultIndustriesArray()
    {
        $array = Industry::select('industries.industry', 'industries.industry_id')->isDefault()->active()->sorted()->pluck('industries.industry', 'industries.industry_id')->toArray();
        return $array;
    }
    public static function industryParticular($id)
    {
        $industrycount=Industry::where('id',$id)->count();
        if($industrycount > 0)
        {
            return Industry::where('id',$id)->pluck('industry')[0];
        }
        else
        {
            return 'NIL';
        }
       
    } 
    public static function cityParticular($id)
    {
        $citycount=City::where('id',$id)->count();
        if($citycount > 0)
        {
            return City::where('id',$id)->pluck('city')[0];
        }
        else
        {
            return 'NIL';
        }
       
    } 
    public static function stateParticular($id)
    {
        $statecount=City::where('id',$id)->count();
        if($statecount > 0)
        {
            return State::where('id',$id)->pluck('state')[0];
        }
        else
        {
            return 'NIL';
        }
       
    } 
    public static function countryParticular($id)
    {
        $countrycount=Country::where('id',$id)->count();
        if($countrycount > 0)
        {
            return Country::where('id',$id)->pluck('country')[0];
        }
        else
        {
            return 'NIL';
        }
       
    } 
 
    public static function langIndustriesArray()
    {
        $array = Industry::select('industries.industry', 'industries.industry_id')->lang()->active()->sorted()->pluck('industries.industry', 'industries.industry_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultIndustriesArray();
        }
        return $array;
    }


    //===========Sub Industries================//

    public static function defaultSubIndustriesArray($industry_id)
    {
        $array = SubIndustry::select('sub_industries.sub_industry', 'sub_industries.sub_industry_id')->where('sub_industries.industry_id', '=', $industry_id)->isDefault()->active()->sorted()->pluck('sub_industries.sub_industry', 'sub_industries.sub_industry_id')->toArray();
        return $array;
    }

    public static function langSubIndustriesArray($industry_id)
    {
        $array = SubIndustry::select('sub_industries.sub_industry', 'sub_industries.sub_industry_id')->where('sub_industries.industry_id', '=', $industry_id)->lang()->active()->sorted()->pluck('sub_industries.sub_industry', 'sub_industries.sub_industry_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultSubIndustriesArray();
        }
        return $array;
    }
    /*     * **************************** */

    public static function defaultFunctionalAreasArray()
    {
        $array = FunctionalArea::select('functional_areas.functional_area', 'functional_areas.functional_area_id')->isDefault()->active()->sorted()->pluck('functional_areas.functional_area', 'functional_areas.functional_area_id')->toArray();
        return $array;
    }

    public static function langFunctionalAreasArray()
    {
        $array = FunctionalArea::select('functional_areas.functional_area', 'functional_areas.functional_area_id')->lang()->active()->sorted()->pluck('functional_areas.functional_area', 'functional_areas.functional_area_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultFunctionalAreasArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultEducationlevelsArray()
    {
        $array = EducationLevel::select('education_levels.education_level', 'education_levels.education_level_id')->isDefault()->active()->sorted()->pluck('education_levels.education_level', 'education_levels.education_level_id')->toArray();
        return $array;
    }

    public static function langEducationlevelsArray()
    {
        $array = EducationLevel::select('education_levels.education_level', 'education_levels.education_level_id')->lang()->active()->sorted()->pluck('education_levels.education_level', 'education_levels.education_level_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultEducationlevelsArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultResultTypesArray()
    {
        $array = ResultType::select('result_types.result_type', 'result_types.result_type_id')->isDefault()->active()->sorted()->pluck('result_types.result_type', 'result_types.result_type_id')->toArray();
        return $array;
    }

    public static function langResultTypesArray()
    {
        $array = ResultType::select('result_types.result_type', 'result_types.result_type_id')->lang()->active()->sorted()->pluck('result_types.result_type', 'result_types.result_type_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultResultTypesArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultMajorSubjectsArray()
    {
        $array = MajorSubject::select('major_subjects.major_subject', 'major_subjects.major_subject_id')->isDefault()->active()->sorted()->pluck('major_subjects.major_subject', 'major_subjects.major_subject_id')->toArray();
        return $array;
    }

    public static function langMajorSubjectsArray()
    {
        $array = MajorSubject::select('major_subjects.major_subject', 'major_subjects.major_subject_id')->lang()->active()->sorted()->pluck('major_subjects.major_subject', 'major_subjects.major_subject_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultMajorSubjectsArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function languagesArray()
    {
        $array = Language::select('languages.lang', 'languages.id')->pluck('languages.lang', 'languages.id')->toArray();
        return $array;
    }

    public static function languagesNativeCodeArray()
    {
        $array = Language::select('languages.native', 'languages.iso_code')->active()->sorted()->pluck('languages.native', 'languages.iso_code')->toArray();
        return $array;
    }

    /*     * **************************** */

    public static function defaultLanguageLevelsArray()
    {
        $array = LanguageLevel::select('language_levels.language_level', 'language_levels.language_level_id')->isDefault()->active()->sorted()->pluck('language_levels.language_level', 'language_levels.language_level_id')->toArray();
        return $array;
    }

    public static function langLanguageLevelsArray()
    {
        $array = LanguageLevel::select('language_levels.language_level', 'language_levels.language_level_id')->lang()->active()->sorted()->pluck('language_levels.language_level', 'language_levels.language_level_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultLanguageLevelsArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultSkillsArray()
    {
        $array = Skill::select('skills.skill', 'skills.skill_id')->isDefault()->active()->sorted()->pluck('skills.skill', 'skills.skill_id')->toArray();
        return $array;
    }

    public static function langSkillsArray()
    {
        $array = Skill::select('skills.skill', 'skills.skill_id')->lang()->active()->sorted()->pluck('skills.skill', 'skills.skill_id')->toArray();

        if ((int) count($array) === 0) {
            $array = self::defaultSkillsArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultExperiencesArray()
    {
        $array = Experience::select('experiences.experience', 'experiences.experience_id')->isDefault()->active()->sorted()->pluck('experiences.experience', 'experiences.experience_id')->toArray();
        return $array;
    }

    public static function langExperiencesArray()
    {
        $array = Experience::select('experiences.experience', 'experiences.experience_id')->lang()->active()->sorted()->pluck('experiences.experience', 'experiences.experience_id')->toArray();

        if ((int) count($array) === 0) {
            $array = self::defaultExperiencesArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultTypesArray()
    {
        $array = Type::select('types.type', 'types.type_id')->isDefault()->active()->sorted()->pluck('types.type', 'types.type_id')->toArray();
        return $array;
    }

    public static function langTypesArray()
    {
        $array = Type::select('types.type', 'types.type_id')->lang()->active()->sorted()->pluck('types.type', 'types.type_id')->toArray();

        if ((int) count($array) === 0) {
            $array = self::defaultTypesArray();
        }
        return $array;
    }

    public static function defaultTypesArray1($category)
    {
        $array = Type::select('types.type', 'types.type_id')->where('category',$category)->isDefault()->active()->sorted()->pluck('types.type', 'types.type_id')->toArray();
        return $array;
    }

    public static function langTypesArray1($category)
    {
        $array = Type::select('types.type', 'types.type_id')->where('category',$category)->lang()->active()->sorted()->pluck('types.type', 'types.type_id')->toArray();

        if ((int) count($array) === 0) {
            $array = self::defaultTypesArray1($category);
        }
        return $array;
    }
    
    /*     * **************************** */

    public static function defaultShiftsArray()
    {
        $array = Shift::select('shifts.shift', 'shifts.shift_id')->isDefault()->active()->sorted()->pluck('shifts.shift', 'shifts.shift_id')->toArray();
        return $array;
    }

    public static function langShiftsArray()
    {
        $array = Shift::select('shifts.shift', 'shifts.shift_id')->lang()->active()->sorted()->pluck('shifts.shift', 'shifts.shift_id')->toArray();

        if ((int) count($array) === 0) {
            $array = self::defaultShiftsArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function currenciesArray()
    {
        $array = CountryDetail::select('countries_details.code')->whereNotNull('countries_details.code')->orderBy('countries_details.code')->pluck('countries_details.code', 'countries_details.code')->toArray();
        return $array;
    }

    /*     * **************************** */

    public static function companiesArray()
    {
        $array = Company::select('companies.name', 'companies.id')->active()->pluck('companies.name', 'companies.id')->toArray();
        return $array;
    }

    /*     * **************************** */

    public static function usersArray()
    {
        $array = User::select('users.id', 'users.name')->orderBy('users.name')->pluck('users.name', 'users.id')->toArray();
        return $array;
    }

    /*     * **************************** */

    public static function defaultTitlesArray()
    {
        $array = Title::select('titles.title', 'titles.title_id')->isDefault()->sorted()->pluck('titles.title', 'titles.title_id')->toArray();
        return $array;
    }

    public static function langTitlesArray()
    {
        $array = Title::select('titles.title', 'titles.title_id')->lang()->sorted()->pluck('titles.title', 'titles.title_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultTitlesArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultOwnershipTypesArray()
    {
        $array = OwnershipType::select('ownership_types.ownership_type', 'ownership_types.ownership_type_id')->isDefault()->active()->sorted()->pluck('ownership_types.ownership_type', 'ownership_types.ownership_type_id')->toArray();
        return $array;
    }

    public static function langOwnershipTypesArray()
    {
        $array = OwnershipType::select('ownership_types.ownership_type', 'ownership_types.ownership_type_id')->lang()->active()->sorted()->pluck('ownership_types.ownership_type', 'ownership_types.ownership_type_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultOwnershipTypesArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultSalaryPeriodsArray()
    {
        $array = SalaryPeriod::select('salary_periods.salary_period', 'salary_periods.salary_period_id')->isDefault()->active()->sorted()->pluck('salary_periods.salary_period', 'salary_periods.salary_period_id')->toArray();
        return $array;
    }

    public static function langSalaryPeriodsArray()
    {
        $array = SalaryPeriod::select('salary_periods.salary_period', 'salary_periods.salary_period_id')->lang()->active()->sorted()->pluck('salary_periods.salary_period', 'salary_periods.salary_period_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultSalaryPeriodsArray();
        }
        return $array;
    }

    /*     * **************************** */

    //===================Benefits & Supplemental====================//

    public static function defaultBenefitsArray()
    {
        $array = Benefit::select('benefits.benefit', 'benefits.benefit_id')->isDefault()->active()->sorted()->pluck('benefits.benefit', 'benefits.benefit_id')->toArray();
        return $array;
    }

    public static function langBenefitsArray()
    {
        $array = Benefit::select('benefits.benefit', 'benefits.benefit_id')->lang()->active()->sorted()->pluck('benefits.benefit', 'benefits.benefit_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultBenefitsArray();
        }
        return $array;
    }


    public static function defaultSupplementalsArray()
    {
        $array = Supplemental::select('supplementals.supplemental', 'supplementals.supplemental_id')->isDefault()->active()->sorted()->pluck('supplementals.supplemental', 'supplementals.supplemental_id')->toArray();
        return $array;
    }

    public static function langSupplementalsArray()
    {
        $array = Supplemental::select('supplementals.supplemental', 'supplementals.supplemental_id')->lang()->active()->sorted()->pluck('supplementals.supplemental', 'supplementals.supplemental_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultSupplementalsArray();
        }
        return $array;
    }

    //===================================================//

    public static function defaultVideosArray()
    {
        $array = Video::select('videos.video_title', 'videos.video_id')->isDefault()->active()->sorted()->pluck('videos.video_title', 'videos.video_id')->toArray();
        return $array;
    }

    public static function langVideosArray()
    {
        $array = Video::select('videos.video_title', 'videos.video_id')->lang()->active()->sorted()->pluck('videos.video_title', 'videos.video_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultVideosArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultTestimonialsArray()
    {
        $array = Testimonial::select('testimonials.testimonial_by', 'testimonials.testimonial_id')->isDefault()->active()->sorted()->pluck('testimonials.testimonial_by', 'testimonials.testimonial_id')->toArray();
        return $array;
    }

    public static function langTestimonialsArray()
    {
        $array = Testimonial::select('testimonials.testimonial_by', 'testimonials.testimonial_id')->lang()->active()->sorted()->pluck('testimonials.testimonial_by', 'testimonials.testimonial_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultTestimonialsArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultSlidersArray()
    {
        $array = Slider::select('sliders.slider_heading', 'sliders.slider_id')->isDefault()->active()->sorted()->pluck('sliders.slider_heading', 'sliders.slider_id')->toArray();
        return $array;
    }

    public static function langSlidersArray()
    {
        $array = Slider::select('sliders.slider_heading', 'sliders.slider_id')->lang()->active()->sorted()->pluck('sliders.slider_heading', 'sliders.slider_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultSlidersArray();
        }
        return $array;
    }

    /*     * **************************** */
    

    /*     * **************************** */

    public static function defaultNoticePeriodsArray()
    {
        $array = NoticePeriod::select('notice_periods.notice_period', 'notice_periods.notice_period_id')->isDefault()->active()->sorted()->pluck('notice_periods.notice_period', 'notice_periods.notice_period_id')->toArray();
        return $array;
    }


    public static function langNoticePeriodsArray()
    {
        $array = NoticePeriod::select('notice_periods.notice_period', 'notice_periods.notice_period_id')->lang()->active()->sorted()->pluck('notice_periods.notice_period', 'notice_periods.notice_period_id')->toArray();

        if ((int) count($array) === 0) {
            $array = self::defaultNoticePeriodsArray();
        }
        return $array;
    }

    public static function defaultCategoryArray()
    {
        $array = Category::select('category', 'category_id')->isDefault()->active()->sorted()->pluck('category', 'category_id')->toArray();
        return $array;
    }
    
    public static function langCategorysArray()
    {
        $array = Category::select('category', 'category_id')->lang()->active()->sorted()->pluck('category', 'category_id')->toArray();

        if ((int) count($array) === 0) {
            $array = self::defaultCategorysArray();
        }
        return $array;
    }

    public static function defaultInstitutesArray()
    {
        $array = Institute::select('institutes.institute', 'institutes.institute_id')->isDefault()->active()->sorted()->pluck('institutes.institute', 'institutes.institute_id')->toArray();
        return $array;
    }

    public static function langInstitutesArray()
    {
        $array = Institute::select('institutes.institute', 'institutes.institute_id')->lang()->active()->sorted()->pluck('institutes.institute', 'institutes.institute_id')->toArray();

        if ((int) count($array) === 0) {
            $array = self::defaultInstitutesArray();
        }
        return $array;
    }

    public static function defaultEmployerRolesArray()
    {
        $array = EmployerRole::select('employer_roles.employer_role', 'employer_roles.employer_role_id')->isDefault()->active()->sorted()->pluck('employer_roles.employer_role', 'employer_roles.employer_role_id')->toArray();
        return $array;
    }

    public static function langEmployerRolesArray()
    {
        $array = EmployerRole::select('employer_roles.employer_role', 'employer_roles.employer_role_id')->lang()->active()->sorted()->pluck('employer_roles.employer_role', 'employer_roles.employer_role_id')->toArray();

        if ((int) count($array) === 0) {
            $array = self::defaultEmployerRolesArray();
        }
        return $array;
    }

    /*     * **************************** */
    

    public static function userExperiencedCompaniesArray($user_id)
    {
        $array = UserExperience::select('user_experiences.company', 'user_experiences.id')->where('user_experiences.user_id', '=', $user_id)->pluck('user_experiences.company', 'user_experiences.id')->toArray();
        return $array;
    }

    
    public static function usedTools($user_id)
    {
        $usedtools = UserExperience::whereUserId($user_id)
                                ->whereNotNull('used_tools')
                                ->orderBy('id','desc')
                                ->pluck('used_tools')->toArray();
        $skill_id = array();
        foreach($usedtools as $tool){
            $skill_id[] = Skill::whereIn('skill',explode(',',$tool))->lang()->active()->pluck('id')->toArray();
        } 

        return call_user_func_array('array_merge', $skill_id);
    }
    
    public static function suggestionSkills($key,$skill_id='')
    {
        $skills = Skill::select('id as id','skill as value')
                        ->where('skill', 'like', '%' . $key . '%');
        if(!empty($skill_id)){
           $skills = $skills->whereNotIn('id',$skill_id);
        }
        return $skills->isDefault()->lang()->active()->take(10)->get();
    }

    public static function suggestionResultType()
    {
        $array = ResultType::select('result_type', 'result_type_id as id')->isDefault()->active()->sorted()->get();

        return $array;
    }

    public static function suggestionLanguageLevel()
    {
        $array = LanguageLevel::select('language_level as level', 'language_level_id as id')->isDefault()->active()->sorted()->get();

        return $array;
    }

    public static function suggestionLanguage($language_id)
    {
        $array = Language::select('lang as language', 'id');
        if(!empty($language_id)){
            $array = $array->whereNotIn('id',$language_id);
         }
         
        return $array->get();
    }
    
    /************ autocomplete */
    
    public static function autocompleteDesignation($key='')
    {
        $titles = Title::select('title as name')->where('title', 'like', "$key%")->isDefault()->lang()->active()->take(10)->get();
        
        return $titles;
    }
    
    public static function autocompleteLocation($key='',$country_code='')
    {
        if($country_code!=''){
            $locations = City::select('location as name')->where('location', 'like', "$key%")->where('country_code', $country_code)->isDefault()->lang()->active()->take(10)->get();
        }else{
            $locations = City::select('location as name')->where('location', 'like', "$key%")->isDefault()->lang()->active()->take(10)->get();
        }
                
        return $locations;
    }
    
    public static function autocompleteCity($key='',$country_code='')
    {
        
        if($country_code!=''){
            $locations = City::select('id as id','city as value')->where('city', 'like', "$key%")->where('country_code', $country_code)->isDefault()->lang()->active()->take(10)->get();
        }else{
            $locations = City::select('id as id','city as value')->where('city', 'like', "$key%")->isDefault()->lang()->active()->take(10)->get();
        }
        
        return $locations;
    }
    
    public static function autocompleteEducationLevel($education_level_id='')
    {     
        $array = EducationLevel::select('id','education_level as name');
        if(!empty($education_level_id)){
           $array = $array->whereNotIn('id',$education_level_id);
        }
        return $array->isDefault()->active()->take(10)->get();
    }

    public static function autocompleteEducationType($key='',$education_level_id='')
    {            
        $array = EducationType::select('id','education_type as name')->where('education_level_id',$education_level_id)->where('education_type', 'like', "%$key%")->isDefault()->active()->take(10)->get();
        return $array;
    }
    
    public static function autocompleteInstitute($key='',$country_code='')
    {
        if($country_code!=''){
            $array = Institute::select('institute as name')->where('institute', 'like', "%$key%")->where('country_code', $country_code)->isDefault()->active()->take(10)->get();
        }else{
            $array = Institute::select('institute as name')->where('institute', 'like', "%$key%")->isDefault()->active()->take(10)->get();
        }
        return $array;
    }
    
    public static function autocompleteTitle($key='')
    {
        $array = Title::select('title as name')->where('title', 'like', "%$key%")->isDefault()->active()->take(10)->get();
        return $array;
    }
    /***************blocked keywords */
    
    
    public static function blockedKeywords()
    {
        $keywords = BlockedKeyword::isDefault()->lang()->active()->pluck('blocked_keyword')->toArray();
        
        return $keywords;
    }
    
    public static function defaultBlockedKeywordsArray()
    {
        $array = BlockedKeyword::select('blocked_keywords.blocked_keyword', 'blocked_keywords.blocked_keyword_id')->isDefault()->active()->sorted()->pluck('blocked_keywords.blocked_keyword', 'blocked_keywords.blocked_keyword_id')->toArray();
        return $array;
    }
    
    public static function defaultTopCompanyArray()
    {
        $array = TopCompany::select('top_companies.top_company', 'top_companies.top_company_id')->isDefault()->active()->sorted()->pluck('top_companies.top_company', 'top_companies.top_company_id')->toArray();
        return $array;
    }


    /***************Filter keywords */
    
    public static function jobIndustries($ids, $jobids)
    {
        
        $result = Industry::whereIn('job_searchs.job_id', $jobids)
                            ->leftJoin('job_searchs', 'job_searchs.industry', '=', 'industries.id')
                            ->select('industries.id as id', \DB::raw('COUNT(job_searchs.job_id) as count'),'industries.industry as label'); 
        if(!empty($ids))
        {
            $result = $result->whereIn('industries.id', $ids);
        }
        return $result->lang()->groupBy('id')->groupBy('label')->get();
        
    }
    
    public static function jobFunctionalarea($ids, $jobids)
    {
            $result = FunctionalArea::whereIn('job_searchs.job_id', $jobids)
                                    ->leftJoin('job_searchs', 'job_searchs.functional_area', '=', 'functional_areas.id')
                                    ->select('functional_areas.id as id', \DB::raw('COUNT(job_searchs.job_id) as count'),'functional_areas.functional_area as label');
        if(!empty($ids))
        {
            $result = $result->whereIn('functional_areas.id', $ids);
        }
        return $result->lang()->groupBy('id')->groupBy('label')->get();
    }
    
    public static function jobEducationLevel($ids, $jobids)
    {
        
        $result =  EducationLevel::whereIn('job_searchs.job_id', $jobids)
                                ->leftJoin('job_searchs', 'job_searchs.education_level', '=', 'education_levels.id')
                                ->select('education_levels.id as id', \DB::raw('COUNT(job_searchs.job_id) as count'),'education_levels.education_level as label');
        if(!empty($ids))
        {
            $result = $result->whereIn('education_levels.id', $ids);
        }
        return $result->lang()->groupBy('id')->groupBy('label')->get();
                            
    }

    public static function jobWorkLocations($ids, $jobids)
    {
        
        $result =  City::select('cities.id as id', \DB::raw('COUNT(job_work_locations.job_id) as count'), 'cities.city as label')
                      ->whereIn('job_work_locations.job_id', $jobids)
                      ->leftJoin('job_work_locations', 'job_work_locations.city_id', '=', 'cities.id');
        if(!empty($ids))
        {
            $result = $result->whereIn('cities.id', $ids);
        }
        return $result->lang()->groupBy('id')->groupBy('label')->get();
    }
    
    public static function jobTypes($ids, $jobids)
    {
        $result = Type::whereIn('job_types.job_id', $jobids)
                    ->leftJoin('job_types', 'job_types.type_id', '=', 'types.id')
                    ->select('types.id as id', \DB::raw('COUNT(job_types.job_id) as count'),'types.type as label');
                    
        if(!empty($ids))
        {
            $result = $result->whereIn('types.id', $ids);
        }
        return $result->lang()->groupBy('id')->groupBy('label')->get();
    }
    
    public static function jobShifts($ids, $jobids)
    {
        
        $result =  Shift::whereIn('job_shifts.job_id', $jobids)
            ->leftJoin('job_shifts', 'job_shifts.shift_id', '=', 'shifts.id')
            ->select('shifts.id as id', \DB::raw('COUNT(job_shifts.job_id) as count'),'shifts.shift as label');
                     
        if(!empty($ids))
        {
            $result = $result->whereIn('shifts.id', $ids);
        }
        return $result->lang()->groupBy('id')->groupBy('label')->get();
        
    }
    
    public static function jobSalaries($jobids)
    {

        $result = array(
            array(
                'id'=>'0to3',
                'label'=>'0 to 3 Lakhs / annum', 
                'count'=>JobSearch::whereIn('job_id',$jobids)->where(function($q){
                    $q->where(function($q1){
                        $q1->where('annum_salary_from', '>=', 0)->where('annum_salary_from', '<=', 3);
                    })->orwhere(function($q2){
                        $q2->where('annum_salary_to', '<=', 3)->where('annum_salary_to', '>=', 0);
                    });
                })->count()
            ),
            array(
                'id'=>'3to6',
                'label'=>'3 to 6 Lakhs / annum', 
                'count'=>JobSearch::whereIn('job_id',$jobids)->where(function($q){
                    $q->where(function($q1){
                        $q1->where('annum_salary_from', '>=', 3)->where('annum_salary_from', '<=', 6);
                    })->orwhere(function($q2){
                        $q2->where('annum_salary_to', '<=', 6)->where('annum_salary_to', '>=', 3);
                    });
                })->count()
            ),
            array(
                'id'=>'6to10',
                'label'=>'6 to 10 Lakhs / annum', 
                'count'=>JobSearch::whereIn('job_id',$jobids)->where(function($q){
                    $q->where(function($q1){
                        $q1->where('annum_salary_from', '>=', 6)->where('annum_salary_from', '<=', 10);
                    })->orwhere(function($q2){
                        $q2->where('annum_salary_to', '<=', 10)->where('annum_salary_to', '>=', 6);
                    });
                })->count()
            ),
            array(
                'id'=>'10to15',
                'label'=>'10 to 15 Lakhs / annum',
                'count'=>JobSearch::whereIn('job_id',$jobids)->where(function($q){
                    $q->where(function($q1){
                        $q1->where('annum_salary_from', '>=', 10)->where('annum_salary_from', '<=', 15);
                    })->orwhere(function($q2){
                        $q2->where('annum_salary_to', '<=', 15)->where('annum_salary_to', '>=', 10);
                    });
                })->count()
            ),
            array(
                'id'=>'15to25',
                'label'=>'15 to 25 Lakhs / annum',
                'count'=>JobSearch::whereIn('job_id',$jobids)->where(function($q){
                    $q->where(function($q1){
                        $q1->where('annum_salary_from', '>=', 15)->where('annum_salary_from', '<=', 25);
                    })->orwhere(function($q2){
                        $q2->where('annum_salary_to', '<=', 25)->where('annum_salary_to', '>=', 15);
                    });
                })->count()
            ),
            array(
                'id'=>'25to50',
                'label'=>'25 to 50 Lakhs / annum',
                'count'=>JobSearch::whereIn('job_id',$jobids)->where(function($q){
                    $q->where(function($q1){
                        $q1->where('annum_salary_from', '>=', 25)->where('annum_salary_from', '<=', 50);
                    })->orwhere(function($q2){
                        $q2->where('annum_salary_to', '<=', 50)->where('annum_salary_to', '>=', 25);
                    });
                })->count()
            ),
            array(
                'id'=>'50to75',
                'label'=>'50 to 75 Lakhs / annum',
                'count'=>JobSearch::whereIn('job_id',$jobids)->where(function($q){
                    $q->where(function($q1){
                        $q1->where('annum_salary_from', '>=', 50)->where('annum_salary_from', '<=', 75);
                    })->orwhere(function($q2){
                        $q2->where('annum_salary_to', '<=', 75)->where('annum_salary_to', '>=', 50);
                    });
                })->count()
            ),
            array(
                'id'=>'75to100',
                'label'=>'75 to 100 Lakhs / annum',
                'count'=>JobSearch::whereIn('job_id',$jobids)->where(function($q){
                    $q->where(function($q1){
                        $q1->where('annum_salary_from', '>=', 75)->where('annum_salary_from', '<=', 100);
                    })->orwhere(function($q2){
                        $q2->where('annum_salary_to', '<=', 100)->where('annum_salary_to', '>=', 75);
                    });
                })->count()
            ),
            array(
                'id'=>'100',
                'label'=>'100+ Lakhs / annum', 
                'count'=>JobSearch::whereIn('job_id',$jobids)->where('annum_salary_from', '>=', 100)->count()
            ),
        );
        $arr =  array();
        foreach($result as $row){
            if($row['count'] != 0 || empty($jobids)){
                $arr[]=$row;
            }
        }

        return $arr;

    }

    
    public static function jobPostedDate($jobids)
    {
        $endDate = Carbon::now();
        $result = array(
            array(
                'id'=>'all',
                'label'=>'All', 
                'count'=>JobSearch::whereIn('job_id',$jobids)->count()
            ),
            array(
                'id'=>'1',
                'label'=>'Last 24 hours', 
                'count'=>JobSearch::whereIn('job_id',$jobids)->where(function($q) use($endDate){
                                        $startDate = $endDate->subDays(1);
                                        $q->where('posted_date', '>=', $startDate);
                                    })->count()
            ),
            array(
                'id'=>'3',
                'label'=>'Last 3 days', 
                'count'=>JobSearch::whereIn('job_id',$jobids)->where(function($q) use($endDate){
                                        $startDate = $endDate->subDays(3);
                                        $q->where('posted_date', '>=', $startDate);
                                    })->count()
            ),
            array(
                'id'=>'7',
                'label'=>'Last 7 days',
                'count'=>JobSearch::whereIn('job_id',$jobids)->where(function($q) use($endDate){
                                        $startDate = $endDate->subDays(7);
                                        $q->where('posted_date', '>=', $startDate);
                                    })->count()
            ),
            array(
                'id'=>'14',
                'label'=>'Last 14 days',
                'count'=>JobSearch::whereIn('job_id',$jobids)->where(function($q) use($endDate){
                                        $startDate = $endDate->subDays(14);
                                        $q->where('posted_date', '>=', $startDate);
                                    })->count()
            )
        );
        $arr =  array();
        foreach($result as $row){
            if($row['count'] != 0 || empty($jobids)){
                $arr[]=$row;
            }
        }

        return $arr;

    }
    
    public static function jobWfhTypes($jobids)
    {        
       return $result = array(
            array(
                'id'=>'permanent',
                'label'=>'Remote Permanent', 
                'count'=>JobSearch::whereIn('job_id',$jobids)->whereWorkFromHome('permanent')->count()
            ),
            array
            (
                'id'=>'temporary',
                'label'=>'Remote Covid-19', 
                'count'=>JobSearch::whereIn('job_id',$jobids)->whereWorkFromHome('temporary')->count()
            ),
        );
    }

    public static function blockedkeylist(){
        return $result = array("alpha"=>'abcd', "beta"=>"efgh");
    }
    public static function checkfunction()
    {
        return 123;
    }

}
