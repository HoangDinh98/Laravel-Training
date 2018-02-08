<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use App\User;
use App\Role;
use App\Photo;
use App\Http\Controllers\Standard;

date_default_timezone_set("Asia/Ho_Chi_Minh");

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

//        $users = User::where('is_active', '=', 1)->orderBy('created_at', 'desc')->paginate(5);
         $users = User::orderBy('created_at', 'desc')->paginate(5);

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $roles = Role::all();
        return view('admin.users.create', ['roles' => $roles]);
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
                'email' => 'required|email|min:16|max:100|unique:users,email',
                'name' => 'required|min:5|max:30',
                'password' => 'required|min:8|max:20',
                'repassword' => 'required|same:password',
                'avatar' => 'mimes:jpg,jpeg,png|max:5000',
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
                'avatar.mimes' => 'Photo fomart must be jpg png jpeg',
            ]);

            $input = $request->all();
            $input['password'] = bcrypt($request->password);

            $input['name'] = Standard::standardize_data($input['name'], 1);

            $data = User::create($input);

//            Insert Image
//            $post = new Post();

            $user_id = $data->id;

            if ($file = $request->file('avatar')) {
                $year = date('Y');
                $month = date('m');
                $day = date('d');
                $sub_folder = 'users/' . $user_id . '/' . $year . '/' . $month . '/' . $day . '/';
                $upload_url = 'images/' . $sub_folder;

                if (!File::exists(public_path() . '/' . $upload_url)) {
                    File::makeDirectory(public_path() . '/' . $upload_url, 0777, true);
                }

                $name = time() . $file->getClientOriginalName();


                $file->move($upload_url, $name);
                Photo::create(['user_id' => $user_id, 'path' => $upload_url . $name]);

//                $input['photo_id'] = $photo->id;
            }


            Session::flash('notification', 'Add user <b>' . $input['name'] . '</b> Successful');
//            return redirect()->back();
            return redirect('/admin/users');
//            
//            
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
        $roles = Role::all();
//        echo '<script>alert("'.var_dump($user).'");</script>';
//        sleep(20);
        return view('admin.users.edit', ['user' => $user, 'roles' => $roles]);
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
                'name' => 'required|min:5|max:30',
                'avatar' => 'mimes:jpg,jpeg,png|max:5000',
                    ], [
                'name.required' => 'Name can not be empty',
                'name.min' => 'Name can not be shoter 5 letters',
                'name.max' => 'Name can not be over 30 letters',
                'avatar.mimes' => 'Photo fomart must be jpg png jpeg',
            ]);
        }
        $user = User::findOrFail($id);

        if (trim($request->password) == '') {
            $input = $request->except('password');
        } else {
            $input = $request->all();
            $input['password'] = bcrypt($request->password);
        }
        $input['name'] = Standard::standardize_data($input['name'], 1);
//        print_r($input);
        if(!isset($_POST['is_active'])) {
            $input['is_active'] = 0;
        }
        
        $user->update($input);

//        Upload photo if exist
        if ($file = $request->file('avatar')) {
            $user_id = $id;
            Photo::where('user_id', '=', $user_id)->update(['is_thumbnail' => 0]);
            
            $year = date('Y');
            $month = date('m');
            $day = date('d');
            $sub_folder = 'users/' . $user_id . '/' . $year . '/' . $month . '/' . $day . '/';
            $upload_url = 'images/' . $sub_folder;

            if (!File::exists(public_path() . '/' . $upload_url)) {
                File::makeDirectory(public_path() . '/' . $upload_url, 0777, true);
            }

            $name = time() . $file->getClientOriginalName();

            $file->move($upload_url, $name);
            Photo::create(['user_id' => $user_id, 'path' => $upload_url . $name]);
        }
        
        
        Session::flash('notification', 'Update user <b>' . $input['name'] . '</b> Successful');
        return redirect('/admin/users');
//        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $user = User::findOrFail($id);

        $user->update(['is_active' => 0]);
        Session::flash('notification', 'Delete user <b>' . $user->name . '</b> Successful');
        return redirect('/admin/users');
//        return redirect()->back();
    }

}
