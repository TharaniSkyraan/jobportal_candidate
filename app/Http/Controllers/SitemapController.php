<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Seo;

class SitemapController extends Controller
{
    //
    public function index()
    {
        $posts = Seo::all();
        return response()->view('sitemap.index', [
            'posts' => $posts
        ])->header('Content-Type', 'text/xml');

    }

}
