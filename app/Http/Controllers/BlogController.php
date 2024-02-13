<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Blog;

use App\Model\BlogLike;

use App\Model\BlogView;

use Auth;



class BlogController extends Controller
{

    public function view(Request $request, $id){
        $blog = Blog::findOrFail($id);
        $more = Blog::where('id', '!=', $id)
                    ->latest()
                    ->take(2)
                    ->get();

        $like = '';

        if (Auth::check()) 
        {
            $like = BlogLike::where([
                ['user_id', auth()->user()->id],
                ['blog_id', $id],
                ['user_type', 'candidate']
            ])->first();

            BlogView::updateOrCreate(['user_id' => Auth::user()->id??0,'user_type'=>'candidate','blog_id'=>$id],['updated_at'=>now()]);
        }
        $count_v = BlogView::where('blog_id', $id)->count();
        $count_l = BlogLike::where('blog_id', $id)->count();
        return view('blog.view', compact('blog', 'more', 'like', 'count_l', 'count_v'));
    }

    public function blogs(Request $request){
        $sliders = Blog::latest()->take(3)->get();
        return view('blog.index', compact('sliders'));
    }

    public function searchs(Request $request){
        $query = $request->value;
        $page = $request->page;
        $search = Blog::where('title', 'LIKE', "%{$query}%");
        $data = $search->where('id','>', $page)->take(5)->get();
        $output = '';   
        if(count($data) > 0){
            $lastid = Blog::where('title', 'LIKE', "%{$query}%")->get()->last()->id;
            foreach($data as $row)
            {
                $count_v = BlogView::where('blog_id', $row->id)->count();
                $count_l = BlogLike::where('blog_id', $row->id)->count();
                if(Auth::check()){ 
                    $like = BlogLike::where([
                        ['user_id', auth()->user()->id],
                        ['blog_id', $row->id],
                        ['user_type', 'candidate']
                    ])->first();

                    if($like == null){ 
                        $ic = asset('images/blogs/likes.svg');
                     }else{
                        $ic =  asset('images/blogs/liked.svg');
                     }
                }else{
                    $ic = asset('images/blogs/likes.svg');
                }
                $output .= ' <div class="col-md-4 col-lg-4 col-xl-6 col-sm-6 lastids" id='.$lastid.'>
                                <div class="card top-placeholder" id='.$row->id.'>
                                    <div class="placeholder1">
                                        <a href='.url('view-blog', [$row->id, $row->slug]).'>
                                            <div class="card-body p-0 opacity-0">
                                                <img src='.$row->thumbnail_url.' alt="" class="img-fluid" draggable="false">
                                            </div>
                                        </a>
                                        <div class="card-footer opacity-0">
                                            <a href='.url('view-blog', [$row->id, $row->slug]).'>
                                                <h3>'.$row->title.'</h3>
                                                <p>'.$row->short_description.'</p>
                                            </a>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <a href='.url('view-blog', [$row->id, $row->slug]).'>
                                                        <span class="grayc">'.\Carbon\Carbon::parse($row->created_at)->format('D jS, M Y').'</span>
                                                    </a>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="row mjmhwq">
                                                        <div class="col-md-6">
                                                            <span class="likes_stns"><img src='.$ic.' alt="likes"><span class="count_l">'.$count_l.'</span> likes</span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <a href='.url('view-blog', [$row->id, $row->slug]).'>
                                                                <div class="right-hover" style="display:none">
                                                                    <img src='.asset('images/blogs/right_s.svg').' alt="right-side-arrow">
                                                                </div>
                                                                <div class="right-hover">
                                                                    <span class="readers"><img src='.asset('images/blogs/readers.svg').' alt="readers"> '.$count_v.' Reads</span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
            ['blog_id', $id],
            ['user_type', 'candidate']
        ])->first();
        if($user == null){
            $like = new BlogLike;
            $like->user_id = auth()->user()->id;
            $like->user_type = 'candidate';
            $like->blog_id = $id;
            $like->save();
            $val = 1;
        }else{
            $like = BlogLike::where([
            ['user_id', auth()->user()->id],
            ['blog_id', $id],
            ['user_type', 'candidate']])->delete();
            $val = 0;
        }
        return response()->json([$val, BlogLike::where('blog_id', $id)->count()]);
    }
}