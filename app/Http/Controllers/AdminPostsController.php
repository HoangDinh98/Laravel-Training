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
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;

date_default_timezone_set("Asia/Ho_Chi_Minh");

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
                ->where('photos.is_thumbnail', '=', 1)
                ->orderBy('posts.created_at', 'desc')
                ->paginate(5);

        return view('admin.posts.index', compact('posts'));
        echo var_dump(compact('posts'));
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

    public function showByAuthor($author_id) {
        $posts = DB::table('posts')
                ->join('photos', 'posts.id', '=', 'photos.post_id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->select('posts.*', 'photos.path AS photo', 'users.name AS owner', 'categories.name AS category')
                ->where([
                    ['posts.user_id', '=', $author_id],
                    ['photos.is_thumbnail', '=', 1]
                    ])
                ->orderBy('posts.created_at', 'desc')
                ->paginate(2);
        return view('admin.posts.show_by_author', compact('posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $post = DB::table('posts')
                ->join('photos', 'posts.id', '=', 'photos.post_id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'photos.path AS photo', 'users.name AS owner')
                ->where([
                    ['posts.id', '=', $id],
                    ['photos.is_thumbnail', '=', 1]
                ])
                ->first();
        $categories = Category::pluck('name', 'id')->all();

//        echo var_dump($post).'<br><br><br>';
//        echo var_dump($categories);
        return view('admin.posts.edit', compact('post', 'categories'));

//        echo '<br><br><br><br><br><br><br>'.var_dump(compact('post')).'<br><br><br>';
//        echo var_dump(compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $input = $request->all();
        $user = Auth::user();
        if ($user) {
            $post = Post::findOrFail($id);
            $post->update($request->all());

            if ($file = $request->file('photo_id')) {
                $post_id = $id;

                $photos = Photo::where('post_id', '=', $post_id)->update(['is_thumbnail' => 0]);

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $post = Post::findOrFail($id);
        if ($post) {
            $photos = Photo::where('post_id', $id)->first();
            $folder = str_before($photos->path, $id) . $id;
            File::deleteDirectory(public_path($folder));
            $post->delete();
        }
        return redirect('/admin/posts');
    }

}
