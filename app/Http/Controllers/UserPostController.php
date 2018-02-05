<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Post;
use App\Category;

date_default_timezone_set("Asia/Ho_Chi_Minh");

class UserPostController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addComment(Request $request) {
        $input = $request->all();
        $user = Auth::user();
        if ($user) {
            $comment = new Comment();
            $input['author'] = $user->name;
            $input['email'] = $user->email;
//            $input['is_active'] = 1;
            $input['parent_id'] = 0;
            $comment->create($input);
        }

        return redirect()->back();
    }
    
    public function addChildComment(Request $request, $post_id, $parent_id) {
        $input = $request->all();
        $user = Auth::user();
        if ($user) {
            $comment = new Comment();
            $input['author'] = $user->name;
            $input['email'] = $user->email;
            $input['post_id'] = $post_id;
            $input['parent_id'] = $parent_id;
//            print_r($input);
//            var_dump($input);
            $comment->create($input);
        }
        return redirect()->back();
    }

    public function search() {
        
        $posts = Post::search($_GET['search_text'])->paginate(3);
        $posts->setPath('search?search_text='.$_GET['search_text']);
        $search_text = $_GET['search_text'];
        $is_search = 1;
        $categories = Category::all();
//        print_r($posts);
        return view('home', compact('posts', 'is_search', 'search_text', 'categories'));
    }

    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
