<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExController extends Controller {

    public function showUserIndex() {
        return view('admin.user.index');
    }

    public function createUser() {
        $this->validate($request, [
            'email' => 'required|email|min:16|max:100',
            'username' => 'required|min:5|max:30',
            'password' => 'required|min:8|max:20',
                ], [
            'email.required' => 'Email can not be empty',
            'email.min' => 'Email can not be shoter 6 letters',
            'email.max' => 'Email too long',
            'username.required' => 'Username can not be empty',
            'username.min' => 'Username can not be shoter 5 letters',
            'username.max' => 'Username can not be over 30 letters',
            'password.required' => 'Password can not be empty',
            'password.min' => 'Password can not be shoter 8 letters',
            'password.max' => 'Password can not be over 20 letters',
        ]);
        
        if (!$request->session()->exists('categories'))
            $request->session()->put('categories', array());
        
        $cates = array();
        $cates[] = strtoupper($cate);
        $cates[] = date("Y-m-d h:i:sa");
        $categories = $request->session()->get('categories');
        array_push($categories, $cates);
        $request->session()->put('categories', $categories);
        
        return view('admin.user.create-user');
    }

}
