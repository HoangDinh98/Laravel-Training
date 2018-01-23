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

Route::resource('admin/users',"AdminUsersController", array('as'=>'admin'));
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
