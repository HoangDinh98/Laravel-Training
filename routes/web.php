<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/pnv', function () {
//    $arr = ["Mercury", "Venus", "Earth", "Mars", "Jupiter", "Saturn", "Uranus", "Neptune"];
//    return view('pnv', ['planet'=>$arr]);
//});
//Route::get('/adminshow', function () {
//    return view('adminshow');
//});
//
//Route::get('/admin', function () {
//    return view('admin.post.index');
//});
/////////////////////////////////////////////
//Route::get('/pnv',"PNVController@showPnv");
//Route::post('/pnv',"PNVController@processLogin");
//
//Route::get('/admin/user',"ExController@showUserIndex");
//Route::post('/admin/user/create',"ExController@createUser");
//****************************************************//
// Old version without Middleware
//****************************************************//
//Route::resource('admin/users',"AdminUsersController", array('as'=>'admin'));
//Auth::routes();
//
//Route::resource('admin/categories',"AdminCategoriesController", array('as'=>'admin'));
//Auth::routes();
//
//Route::resource('admin/posts',"AdminPostsController", array('as'=>'admin'));
//Auth::routes();
//
//Route::resource('admin/media',"AdminMediaController", array('as'=>'admin'));
//Auth::routes();
//
//Route::get('admin/posts/showByAuthor/{id}', 'AdminPostsController@showByAuthor')->name('admin.posts.showByAuthor');
//Auth::routes();
//****************************************************//
// New version within Middleware
//****************************************************//
Route::group(['middleware' => 'admin'], function() {
    Route::resource('admin/users', "AdminUsersController", array('as' => 'admin'));

    Route::resource('admin/categories', "AdminCategoriesController", array('as' => 'admin'));

    Route::resource('admin/posts', "AdminPostsController", array('as' => 'admin'));

    Route::resource('admin/media', "AdminMediaController", array('as' => 'admin'));

    Route::get('admin/posts/showByAuthor/{id}', 'AdminPostsController@showByAuthor')->name('admin.posts.showByAuthor');
});

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/home/category/{id}', 'HomeController@showByCategory')->name('home.showByCategory');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/post/{id}', ['as' => 'home.post', 'uses' => 'HomeController@post']);

Route::resource('/posts', "UserPostController", array('as' => 'user'));
Auth::routes();

Route::post('/posts/addComment/{id}', "UserPostController@addComment")->name('user.posts.addComment');
Auth::routes();

Route::post('/posts/addChildComment/{post_id}/{parent_id}', "UserPostController@addChildComment")->name('user.posts.addChildComment');
Auth::routes();

//Route::post('/user/search/{text}',"UserPostController@search")->name('user.search');
//Auth::routes();

Route::get('/user/search', "UserPostController@search")->name('user.search');
Auth::routes();
