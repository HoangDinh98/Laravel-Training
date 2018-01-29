<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\User;
use App\Photo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminPostsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
//        $posts = Post::orderBy('created_at', 'desc')->paginate(2);
        $posts = DB::table('posts')
                ->join('photos', 'posts.id', '=', 'photos.post_id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->select('posts.*', 'photos.path AS photo', 'users.name AS owner', 'categories.name AS category')
                ->orderBy('posts.created_at', 'desc')
                ->paginate(2);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $categories = Category::pluck('name', 'id')->all();
        // var_dump($categories);
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $input = $request->all();
        $user = Auth::user();
        if ($user) {
            $input['user_id'] = $user->id;
            $post = new Post();
            $data = $post->create($input);

            $post_id = $data->id;

            if ($file = $request->file('photo_id')) {
                $year = date('Y');
                $month = date('m');
                $day = date('d');
                $sub_folder = 'posts/' . $post_id . '/' . $year . '/' . $month . '/' . $day . '/';
                $upload_url = 'images/' . $sub_folder;

                if (!File::exists(public_path() . '/' . $upload_url)) {
                    File::makeDirectory(public_path() . '/' . $upload_url, 0777, true);
                }

                $name = time() . $file->getClientOriginalName();


                $file->move($upload_url, $name);
                Photo::create(['post_id' => $post_id, 'path' => $upload_url . $name]);

//                $input['photo_id'] = $photo->id;
            }

            return redirect('/admin/posts');
        } else {
            return view("errors.submit-error", ["data" => "Please login as administrator!"]);
        }
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
