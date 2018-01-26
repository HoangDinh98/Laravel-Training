<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\User;
use App\Role;

class AdminUsersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
//        $users = User::all();
//        Use ORM
//        $users = DB::table('users')
//                ->join('roles', 'users.role_id', '=', 'roles.id')
//                ->select('users.*', 'roles.name AS role')
//                ->get();
        
//        Use Relation
        
        $users = User::all();
        
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $roles = Role::all();
        return view('admin.users.create-user', ['roles' => $roles]);
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
                'name' => 'required|min:5|max:30',
                'password' => 'required|min:8|max:20',
                'repassword' => 'required|same:password',
                    ], [
                'email.required' => 'Email can not be empty',
                'email.min' => 'Email can not be shoter 6 letters',
                'email.max' => 'Email too long',
                'name.required' => 'Name can not be empty',
                'name.min' => 'Name can not be shoter 5 letters',
                'name.max' => 'Name can not be over 30 letters',
                'password.required' => 'Password can not be empty',
                'password.min' => 'Password can not be shoter 8 letters',
                'password.max' => 'Password can not be over 20 letters',
            ]);


            $input = $request->all();
            $input['password'] = bcrypt($request->password);

            User::create($input);

            $users = User::all();

            return view('admin.users.index', ['users' => $users]);
//            if (!$request->session()->exists('users'))
//                $request->session()->put('users', array());
//
//            $child = array();
//            $child[] = $_POST['username'];
//            $child[] = $_POST['email'];
//            $child[] = $_POST['password'];
//            $child[] = date("Y-m-d h:i:sa");
//            $parent = $request->session()->get('users');
//            array_push($parent, $child);
//            $request->session()->put('users', $parent);
        }
//        return view('admin.users.create-user');
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
//        echo '<script>alert("'.$id.'");</script>';
        $user = User::find($id);
//        echo '<script>alert("'.var_dump($user).'");</script>';
//        sleep(20);
        return view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        if (isset($_POST['submit'])) {
            $this->validate($request, [
                'email' => 'required|email|min:16|max:100',
                'name' => 'required|min:5|max:30',
                'password' => 'required|min:8|max:20',
                    ], [
                'email.required' => 'Email can not be empty',
                'email.email' => 'This is not Email',
                'email.min' => 'Email can not be shoter 6 letters',
                'email.max' => 'Email too long',
                'name.required' => 'Name can not be empty',
                'name.min' => 'Name can not be shoter 5 letters',
                'name.max' => 'Name can not be over 30 letters',
                'password.required' => 'Password can not be empty',
                'password.min' => 'Password can not be shoter 8 letters',
                'password.max' => 'Password can not be over 20 letters',
            ]);

            if (count($errors) >= 1) {
//                return view('admin.users.edit');
                return redirect('admin/users/edit');
            }
        }
        $user = User::findOrFail($id);

        if (trim($request->password) == '') {

            $input = $request->except('password');
        } else {
            $input = $request->all();
            $input['password'] = bcrypt($request->password);
        }

        $user->update($input);
        return redirect('/admin/users');
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
