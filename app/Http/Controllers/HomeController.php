<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(3);
        $categories = Category::get();
        
        return view('home', ['posts'=>$posts, 'categories' => $categories]);
    }
    
    public function post($id) {


        $post = Post::findOrFail($id);
        $categories = Category::get();

        return view('post', compact('post', 'categories'));
    }
}
