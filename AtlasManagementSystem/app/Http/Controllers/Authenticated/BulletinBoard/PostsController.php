<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use Auth;
use DB;

class PostsController extends Controller
{
    public function show(Request $request){
        $posts = Post::with('user', 'postComments')->get();
        $categories = MainCategory::get();
        $like = new Like;
        $post_comment = new Post;
        if(!empty($request->keyword)){
            $keyword = $request->keyword;
            $posts = Post::with('user', 'postComments','subCategories')
            ->where('post_title', 'like', '%'.$keyword.'%')
            ->orWhere('post', 'like', '%'.$keyword.'%')
            ->orWhereHas('subCategories',function ($q) use ($keyword){
                $q->where('sub_category', '=', $keyword );
            })->get();
        }else if($request->category_word){
            $sub_category = $request->category_word;
            $posts = Post::whereHas('subCategories',function ($q) use ($sub_category){
                $q->where('sub_category', $sub_category );
            })->get();

        }else if($request->like_posts){
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
            ->whereIn('id', $likes)->get();
        }else if($request->my_posts){
            $posts = Post::with('user', 'postComments')
            ->where('user_id', Auth::id())->get();
        }

        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput(){
        $main_categories = MainCategory::all();
        $sub_categories = SubCategory::query()
            ->whereIn('main_category_id',  $main_categories->pluck('id')->toArray())
            ->get();
        $main_categories = $main_categories->map(function (MainCategory $main_category) use ($sub_categories) {
        // map 配列情報を作成する
        // foreachのように一つのメインカテゴリーの取得が終われば次のメインカテゴリーを取りに行く
        $subs = $sub_categories->where('main_category_id', $main_category->id);
        // (カラム名：レコード)
        $main_category->setAttribute('sub_categories', $subs);
        return $main_category;
        });
        //  dd($main_categories);
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    public function postCreate(Request $request)
    {
        $validated = $request->validate([
            'post_category_id'  => 'required|max:250|exists:sub_categories,id',
            'post_title'        => 'required|max:100|string',
            'post'              => 'required|max:5000|string'
        ]);

        DB::beginTransaction();
        try{
            $post_sub_category = $request->post_category_id;
            $post_title = $request->post_title;
            $post = $request->post;

            $post_get = Post::create([
                'user_id'    => Auth::id(),
                'post_title' => $request->post_title,
                'post'       => $request->post
            ]);


            $posted_sub_category = Post::findOrFail($post_get->id);
            $posted_sub_category->subCategories()->attach($post_sub_category);
            DB::commit();
            return redirect()->route('post.show');
        }catch(\Exception $e){
            DB::rollback();
            return back();
        }
    }

    public function postEdit(Request $request){

        $validated = $request->validate([
            'post_title'       => 'required|string|max:100',
            'post_body'        => 'required|string|max:5000'
        ]);

        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }
    public function mainCategoryCreate(Request $request){
        $validated = $request->validate([
        'main_category_name' => 'required|max:100|string|unique:main_categories,main_category']);
        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }

    public function subCategoryCreate(Request $request){
        $validated = $request->validate([
            'main_category_id'   => 'required|exists:main_categories,id',
            'sub_category_name'  => 'required|max:100|string|unique:sub_categories,sub_category'
        ]);
        SubCategory::create([
            'sub_category' => $request->sub_category_name,
            'main_category_id' => $request->main_category_id
      ]);
        return redirect()->route('post.input');
    }

    public function commentCreate(Request $request){
        $validated = $request->validate([
            'comment'  => 'required|max:250|string'
        ]);
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
             ->where('like_post_id', $post_id)
             ->delete();

        return response()->json();
    }
}
