<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Seo;
use App\Model\Title;
use App\Model\City;
use App\Model\Shift;
use App\Model\Type;
use App\Model\Industry;
use App\Model\FunctionalArea;
use App\Model\JobSearch;
use App\Model\JobType;
use App\Model\Job;
use App\Model\JobWorkLocation;

class SitemapController extends Controller
{
    //
    public function index()
    {
        return response()->view('sitemap.index')->header('Content-Type', 'text/xml');
    }
    public function jobTitle()
    {
        $titles = Job::orderBy('created_at','DESC')->get()->unique('title');
        if($titles->count()!=0)
        {
            return response()->view('sitemap.job_title', compact('titles'))->header('Content-Type', 'text/xml');
        }
    }
    public function jobLocation()
    {
        $cities    = JobWorkLocation::pluck('city_id')->toArray();
        $locations = City::whereIn('id',$cities)->whereCountryId(101)->get();
        if($locations->count()!=0)
        {        
            return response()->view('sitemap.job_location', compact('locations'))->header('Content-Type', 'text/xml');
        }    
    }

    public function jobTitleLocation()
    { 
        $titles = Job::orderBy('created_at','DESC')->get()->unique('title');
        if($titles->count()!=0){
            return response()->view('sitemap.job_title_location', compact('titles'))->header('Content-Type', 'text/xml');
        }
    }
    public function jobTitleLocations($designation)
    {
        $cities    = JobWorkLocation::pluck('city_id')->toArray();
        $locations = City::whereIn('id',$cities)->whereCountryId(101)->get();
        if($locations->count()!=0)
        { 
            return response()->view('sitemap.job_title_locations', compact('designation','locations'))->header('Content-Type', 'text/xml');
        }
    }

    public function jobType()
    {
        $ids   = JobType::pluck('type_id')->toArray();
        $types = Type::whereIn('id',$ids)->get();
        if($types->count()){
            return response()->view('sitemap.job_type', compact('types'))->header('Content-Type', 'text/xml');
        }
    }
    
    public function jobTypeTitle()
    {
        $ids    = JobType::pluck('type_id')->toArray();
        $types  = Type::whereIn('id',$ids)->get();
        $titles = Job::orderBy('created_at','DESC')->get()->unique('title');
        if($titles->count()!=0)
        {
            return response()->view('sitemap.job_type_title', compact('types','titles'))->header('Content-Type', 'text/xml');
        }
    }
    
    public function jobTypeTitles($id)
    {
        $titles = Job::orderBy('created_at','DESC')->get()->unique('title');
        if($titles->count()!=0)
        {
            return response()->view('sitemap.job_type_titles', compact('id','titles'))->header('Content-Type', 'text/xml');
        }
    }
    
    public function jobTypeLocation()
    {
        $ids       = JobType::pluck('type_id')->toArray();
        $types     = Type::whereIn('id',$ids)->get();
        $cities    = JobWorkLocation::pluck('city_id')->toArray();
        $locations = City::whereIn('id',$cities)->whereCountryId(101)->get();
        if($locations->count()!=0)
        { 
            return response()->view('sitemap.job_type_location', compact('types','locations'))->header('Content-Type', 'text/xml');
        }
    }
    
    public function jobTypeLocations($id)
    {
        $cities    = JobWorkLocation::pluck('city_id')->toArray();
        $locations = City::whereIn('id',$cities)->whereCountryId(101)->get();
        if($locations->count()!=0)
        { 
            return response()->view('sitemap.job_type_locations', compact('id','locations'))->header('Content-Type', 'text/xml');
        }
    }
    
    public function jobTypeTitleLocation()
    {
        $ids    = JobType::pluck('type_id')->toArray();
        $types  = Type::whereIn('id',$ids)->get();      
        $titles = Job::orderBy('created_at','DESC')->get()->unique('title');
        if($titles->count() != 0)
        {
            return response()->view('sitemap.job_type_title_location', compact('types','titles'))->header('Content-Type', 'text/xml');
        }
    }
    
    public function jobTypeTitleLocations($designation, $id)
    {
        $cities    = JobWorkLocation::pluck('city_id')->toArray();
        $locations = City::whereIn('id',$cities)->whereCountryId(101)->get();
        if($locations->count()!=0)
        { 
            return response()->view('sitemap.job_type_title_locations', compact('designation', 'id','locations'))->header('Content-Type', 'text/xml');
        }
    }

    public function jobSlug()
    {
        $jobs = JobSearch::all();
        return response()->view('sitemap.job_slug',compact('jobs'))->header('Content-Type', 'text/xml');
    }
    
    public function staticPages()
    {
        return response()->view('sitemap.static_pages')->header('Content-Type', 'text/xml');
    }

}
