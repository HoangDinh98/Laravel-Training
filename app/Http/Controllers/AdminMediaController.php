<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Photo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

date_default_timezone_set("Asia/Ho_Chi_Minh");

class AdminMediaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $media = DB::table('posts')
                ->join('photos', 'posts.id', '=', 'photos.post_id')
                ->select('posts.title AS post_name', 'photos.id AS photo_id', 'photos.path AS photo')
                ->where('photos.is_thumbnail', '=', 1)
                ->orderBy('posts.created_at', 'desc')
                ->paginate(6);

        $mediafull = DB::table('posts')
                ->join('photos', 'posts.id', '=', 'photos.post_id')
                ->select('posts.title AS post_name', 'photos.id AS photo_id', 'photos.path AS photo')
                ->where('photos.is_thumbnail', '!=', 1)
                ->orderBy('posts.created_at', 'desc')
                ->paginate(6);

        return view('admin.media.index', compact('media', 'mediafull'));
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
        $photo = Photo::findOrFail($id);
        if ($photo) {
            $file = $photo->path;

            if ($photo->is_thumbnail == 1) {
                File::delete($file);
            } else {
                File::delete($file);
                $photo->delete();
            }
            
            Session::flash('notification','Delete Photo Successful');
        }
        return redirect('/admin/media');
//        return redirect()->back();
    }
}
