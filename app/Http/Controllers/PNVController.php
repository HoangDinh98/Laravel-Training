<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PNVController extends Controller {

    public function showPnv() {
        $arr = ["Mercury", "Venus", "Earth", "Mars", "Jupiter", "Saturn", "Uranus", "Neptune"];
        return view('pnv', ['planet' => $arr]);
    }

    // Process submission of the login form by verifying user’s credentials
//    public function processLogin(Request $request) {
//        echo var_dump($_POST);
////    $username = Input::get('username');
////    $password = Input::get('password');
//        $username = $request->get('username');
//        $password = $request->get('password');
//
//        if ($username === 'prince' && $password === 'abc@123') {
//            return 'Access granted!';
//        } else {
//            return 'Access denied! Wrong username or password.';
//        }
//    }

    public function processLogin(Request $request) {
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

        $username = $request->get('username');
        $password = $request->get('password');

        if ($username === 'prince' && $password === 'abc@123') {
            return 'Access granted!';
        } else {
            return 'Access denied! Wrong username or password.';
        }
    }

}
