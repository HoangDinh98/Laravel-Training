<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Photo;
use App\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
//        $posts = Post::orderBy('created_at', 'desc')->paginate(3);
        $posts = DB::table('posts')
                ->join('photos', 'posts.id', '=', 'photos.post_id')
                ->select('posts.*', 'photos.path AS photo')
                ->where('photos.is_thumbnail', '=', 1)
                ->orderBy('posts.created_at', 'desc')
                ->paginate(3);
        $categories = Category::get();
        return view('home', ['posts' => $posts, 'categories' => $categories]);
    }

    public function post($id) {
//        $post = Post::findOrFail($id);
        $post = DB::table('posts')
                ->join('photos', 'posts.id', '=', 'photos.post_id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'photos.path AS photo', 'users.name AS owner')
                ->where([
                    ['posts.id', '=', $id],
                    ['photos.is_thumbnail', '=', 1]
                ])
                ->first();
        $comments = Comment::where('post_id', $id)->orderBy('created_at', 'desc')->paginate(5);
        $categories = Category::all();
        return view('post', compact('post', 'comments', 'categories'));
    }

    public function showByCategory($id) {
        $category = Category::findOrFail($id);
        $posts = DB::table('posts')
                ->join('photos', 'posts.id', '=', 'photos.post_id')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->select('posts.*', 'photos.path AS photo', 'categories.name AS category')
                ->where([
                    ['posts.category_id', '=', $id],
                    ['photos.is_thumbnail', '=', 1]
                ])
                ->orderBy('posts.created_at', 'desc')
                ->paginate(3);
        $category_name = $category->name;
        $categories = Category::get();
        return view('show_by_category', ['posts' => $posts, 'categories' => $categories, 'category_name' => $category_name]);
    }

}
