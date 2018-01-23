<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminUsersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        return view('admin.users.create-user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if (isset($_POST['submit'])) {
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

            if (!$request->session()->exists('users'))
                $request->session()->put('users', array());

            $child = array();
            $child[] = $_POST['username'];
            $child[] = $_POST['email'];
            $child[] = $_POST['password'];
            $child[] = date("Y-m-d h:i:sa");
            $parent = $request->session()->get('users');
            array_push($parent, $child);
            $request->session()->put('users', $parent);
        }
        return view('admin.users.create-user');
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