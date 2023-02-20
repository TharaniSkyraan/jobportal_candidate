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

class SitemapController extends Controller
{
    //
    public function index()
    {
        // dd('test');
        return response()->view('sitemap.index')->header('Content-Type', 'text/xml');

    }
    public function jobTitle()
    {
        $titles = Title::all();
        return response()->view('sitemap.job_title', compact('titles'))->header('Content-Type', 'text/xml');
    }
    public function jobLocation()
    {
        $locations = City::whereCountryId(101)->get();
        return response()->view('sitemap.job_location', compact('locations'))->header('Content-Type', 'text/xml');
    }
    public function jobTitleLocation()
    {
        $titles = Title::all();
        return response()->view('sitemap.job_title_location', compact('titles'))->header('Content-Type', 'text/xml');
    }
    public function jobTitleLocations($designation)
    {
        $locations = City::whereCountryId(101)->get();
        return response()->view('sitemap.job_title_locations', compact('designation','locations'))->header('Content-Type', 'text/xml');
    }

    public function jobType()
    {
        $types = Type::all();
        return response()->view('sitemap.job_type', compact('types'))->header('Content-Type', 'text/xml');
    }
    
    public function jobTypeTitle()
    {
        $types = Type::all();
        $titles = Title::all();
        return response()->view('sitemap.job_type_title', compact('types','titles'))->header('Content-Type', 'text/xml');
    }
    
    public function jobTypeTitles($id)
    {
        $titles = Title::all();
        return response()->view('sitemap.job_type_titles', compact('id','titles'))->header('Content-Type', 'text/xml');
    }
    
    public function jobTypeLocation()
    {
        $types = Type::all();
        $locations = City::whereCountryId(101)->get();
        return response()->view('sitemap.job_type_location', compact('types','locations'))->header('Content-Type', 'text/xml');
    }
    
    public function jobTypeLocations($id)
    {
        $locations = City::whereCountryId(101)->get();
        return response()->view('sitemap.job_type_locations', compact('id','locations'))->header('Content-Type', 'text/xml');
    }
    
    public function jobTypeTitleLocation()
    {
        $types = Type::all();
        $titles = Title::all();
        return response()->view('sitemap.job_type_title_location', compact('types','titles'))->header('Content-Type', 'text/xml');
    }
    
    public function jobTypeTitleLocations($designation, $id)
    {
        $locations = City::whereCountryId(101)->get();
        return response()->view('sitemap.job_type_title_locations', compact('designation', 'id','locations'))->header('Content-Type', 'text/xml');
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
