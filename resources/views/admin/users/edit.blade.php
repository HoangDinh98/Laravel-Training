@extends ('layout.admin');
@section ('content')

<h1 style="text-align: center; color: #123489;">
    Edit User
</h1>

<div class="row">
    <div class="col-md-6 col-md-offset-2">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype='multipart/form-data'>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">

            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Enter Email" 
                       value="<?php if(old('email')!='') echo old('email'); else echo $user['email']?>" disabled>
                <span class="text-danger">{{ $errors->first('email') }}</span>
            </div>


            <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                <label for="name">Username:</label>
                <input type="text" id="username" name="name" class="form-control" placeholder="Enter user name" 
                       value="<?php if(isset($user)) echo $user['name']; else  echo old('name') ?>">
                <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>        

            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" value="{{ old('password') }}">
                <span class="text-danger">{{ $errors->first('password') }}</span>
            </div> 
            
            <div class="form-group" style="">
                <img width="400px" class="img-responsive img-display"
                     src="<?php
                     if ($user->avatar()) {
                         if (File::exists(public_path($user->avatar()->path)))
                             echo asset($user->avatar()->path);
                         else
                             echo 'http://placehold.it/1200x800';
                     } else {
                         echo 'http://placehold.it/1200x800';
                     }
                     ?>"
                >
            </div> <br>
            
            <div class="form-group {{ $errors->has('avatar') ? 'has-error' : '' }}">
                <label for="avatar">Avatar: </label>
                <input type="file" id="avatar" name="avatar" class="form-control" value="{{ old('avatar') }}">
                <span class="text-danger">{{ $errors->first('avatar') }}</span>
            </div> 
            
            <div class=" form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
                    <label for="category_id">Is active account:</label>
                    <input type="checkbox" id="is_active" name="is_active" value="1" @if ( $user->is_active == 1 ) checked   @endif />
                    <span class="text-danger">{{ $errors->first('is_active') }}</span>
            </div>

            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-success" value="submit" />
            </div>
            <?php 
            unset($user);
            ?>
        </form>
    </div>
</div>

@endsection

