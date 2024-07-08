<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Blog;

class BlogXmlController extends Controller
{
    public function index(Request $request){
        $blog = Blog::where('is_active', 1)->whereUserType('candidate')->count(); 
        if($blog <= 20){
            $count = 1; 
        }else{
            $count = intval($blog / 20); 
        }
        return response()->view('blog.sitemap.category-pages', [
            'count' => $count
        ])->header('Content-Type', 'text/xml');
    }

    public function view(Request $request, $id){
        $paginate = 20 * $id;
        if($paginate <= 20){
            $blog = Blog::where('is_active', 1)->whereUserType('candidate')->take(20)->get();
        }else{
            $blog = Blog::where('is_active', 1)->whereUserType('candidate')->skip($paginate)->take(20)->get();
        }       
        return response()->view('blog.sitemap.index', [
            'blog' => $blog,
        ])->header('Content-Type', 'text/xml');
    }
}

