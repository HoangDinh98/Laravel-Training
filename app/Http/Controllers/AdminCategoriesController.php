<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Category;
use App\Post;
use App\Photo;
use App\Http\Controllers\Standard;

date_default_timezone_set("Asia/Ho_Chi_Minh");

class AdminCategoriesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $categories = Category::orderBy('created_at', 'desc')->paginate(5);
        ;
        return view('admin.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
                ], [
            'name.required' => 'Category Name can not be empty'
        ]);

        $input = ['name' => Standard::standardize_data($request->input('name'), 0)];

        Category::create($input);

        Session::flash('notification', 'Add Category <b>' . $input['name'] . '</b> Successful');
        return $this->index();
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
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
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
            'name' => 'required'
                ], [
            'name.required' => 'Category Name can not be empty'
        ]);

        $category = Category::findOrFail($id);

        $input = $request->all();
        $input['name'] = Standard::standardize_data($input['name'], 0);
        $category->update($input);

        Session::flash('notification', 'Update Category <b>' . $input['name'] . '</b> Successful');

//        return redirect('/admin/categories');
        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $category = Category::findOrFail($id);
        if ($category) {
            $posts = Post::where('category_id', $id)->get();
            if ($posts) {
                foreach ($posts AS $key => $post) {
                    $photo = Photo::where('post_id', $post->id)->first();
                    $folder = str_before($photo->path, $post->id) . $post->id;
                    File::deleteDirectory(public_path($folder));
                    $post->delete();
                }
            }
            $category->delete();

            Session::flash('notification', 'Delete Category <b>' . $category->name . '</b> Successful');
        }
//        return redirect('/admin/categories');
        return redirect()->route('admin.categories.index');
    }

}
