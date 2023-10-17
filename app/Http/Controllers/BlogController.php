<?php



namespace App\Http\Controllers;



use App;

use App\Model\Seo;

use App\Model\Job;

use App\Model\Company;

use App\Model\FunctionalArea;

use App\Model\Country;

use App\Model\Video;

use App\Model\Industry;

use App\Model\Testimonial;

use App\Model\Slider;

use App\Model\Blog;

use App\Model\Blog_category;

use App\Model\Total_jobs;

use App\Model\BlogLike;

use App\Model\BlogView;

use Redirect;

use Illuminate\Http\Request;

use App\Traits\CompanyTrait;

use App\Traits\FunctionalAreaTrait;

use App\Traits\CityTrait;

use App\Traits\JobTrait;

use App\Traits\Active;

use App\Helpers\DataArrayHelper;

use App\Traits\Lang;

use DB;

use Cache;

use Session;

use Auth;



class BlogController extends Controller

{



    //use CompanyTrait;

    //use FunctionalAreaTrait;

    // use CityTrait;

    //use JobTrait;

     use Lang;



    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        //$this->middleware('auth');

    }



    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $data['blogs'] = Blog::orderBy('id', 'DESC')->where('lang', 'like', \App::getLocale())->paginate(10);

        $data['categories'] = Blog_category::get();

        return view('blog')->with($data);

    }



    public function details($slug)

    {

        $data['blog'] = Blog::where('slug','like','%'. $slug.'%')->where('lang', 'like', \App::getLocale())->first();

        $data['blog_categories'] = Blog_category::get();

		$data['categories'] = Blog_category::get();

         $data['seo'] = (object) array(

                    'seo_title' => $data['blog']->meta_title,

                    'seo_description' => $data['blog']->meta_keywords,

                    'seo_keywords' => $data['blog']->meta_descriptions,

                    'seo_other' => ''

        );

        return view('blog_detail')->with($data);

    }

    public function categories($slug)

    {

        $category = Blog_category::where('slug', $slug)->first();

        $data['category'] = $category;

        $data['blogs_categories'] = Blog_category::get();

        $data['blogs'] = Blog::whereRaw("FIND_IN_SET('$category->id',cate_id)")->where('lang', 'like', \App::getLocale())->orderBy('id', 'DESC')->paginate(10);

        return view('blog_categories_details')->with($data);

    }

    public function search(Request $request)

    { 

        $data['serach_result'] = $request->get('search');

        $data['blogs'] =Blog::where('heading', 'like', $request->get('search'))

                ->orWhere('content', 'like','%' . $request->get('search') . '%')->where('lang', 'like', \App::getLocale())

                ->paginate(1);

        $data['categories'] = Blog_category::get();

        return view('blog_search')->with($data);

    }

    public function view(Request $request, $id){
        $blog = Blog::findOrFail($id);
        $more = Blog::where('id', '!=', $id)
             ->latest()
             ->take(2)
             ->get();

        if(Auth::check()){
            $like = BlogLike::where([
                ['user_id', auth()->user()->id],
                ['blog_id', $id]
            ])->first();
        }else{
            $like = '';
        }

        if (Auth::check()) {
            $check = BlogView::where('blog_id', $id)
                          ->where('user_id', auth()->user()->id)
                          ->get();
        
            if ($check->isEmpty()) {
                BlogView::create([
                    'user_id' => auth()->user()->id,
                    'blog_id' => $id,
                ]);
            } else {
                $update = BlogView::find($check->first()->id);
                $update->user_id = auth()->user()->id;
                $update->blog_id = $id;
                $update->updated_at = now();
                $update->save();
            }
        }
        $count_v = BlogView::where('blog_id', $id)->count();

        $count_l = BlogLike::where('blog_id', $id)->count();
        return view('blog.view', compact('blog', 'more', 'like', 'count_l', 'count_v'));
    }

    public function blogs(Request $request){
        $sliders = Blog::latest()->take(5)->get();
        return view('blog.index', compact('sliders'));
    }

    public function searchs(Request $request){
        $query = $request->value;
        $page = $request->page;
        $search = Blog::where('title', 'LIKE', "%{$query}%");
        if($page == 'undefined'){
            $data = $search->take(5)->get();
            $last = $search;
        }else{
            $data = $search->where('id','>', $page)->take(5)->get();
            $last = $search->where('id','>', $page);
        }
        $output = '';   
        if(count($data) > 0){
            $lastid = $last->get()->last()->id;
            foreach($data as $row)
            {
                $output .= ' <div class="col-md-6 lastids" id='.$lastid.'>
                                <a href='.url('view-blog', [$row->id, $row->slug]).'>
                                    <div class="card top-placeholder" id='.$row->id.'>
                                        <div class="placeholder1">
                                            <div class="card-body p-0 opacity-0">
                                                <img src='.$row->thumbnail_url.' alt="" class="img-fluid" draggable="false">
                                            </div>
                                            <div class="card-footer opacity-0">
                                                <h3>'.$row->title.'</h3>
                                                <p>'.$row->short_description.'</p>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <span class="grayc">'.\Carbon\Carbon::parse($row->created_at)->format('D jS, M Y').'</span>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <span class="likes_stns"><img src='.asset('images/blogs/likes.svg').' alt="likes"> 2.5k likes</span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="right-hover" style="display:none">
                                                                    <img src='.asset('images/blogs/right_s.svg').' alt="right-side-arrow">
                                                                </div>
                                                                <div class="right-hover">
                                                                    <span class="readers"><img src='.asset('images/blogs/readers.svg').' alt="readers"> 102 Reads</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>';
            }
        }else{
            $output .= '<div class="not_fnfi"><span>result not found</span></div>';
        }
        echo $output;
    }

    public function likeblog(Request $request, $id){
        $user = BlogLike::where([
            ['user_id', auth()->user()->id],
            ['blog_id', $id]
        ])->first();
        if($user == null){
            $like = new BlogLike;
            $like->user_id = auth()->user()->id;
            $like->blog_id = $id;
            $like->save();
            $val = 1;
        }else{
            $like = BlogLike::where([
            ['user_id', auth()->user()->id],
            ['blog_id', $id]])->delete();
            $val = 0;
        }
        return response()->json([$val, BlogLike::where('blog_id', $id)->count()]);
    }
}