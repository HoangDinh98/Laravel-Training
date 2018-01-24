@extends ('layout.admin');
@section ('content')
<link rel="stylesheet" href="{{ url('bootstrap-3.3.7/css/bootstrap.css') }}">
<script src="{{ url('bootstrap-3.3.7/js/bootstrap.js') }}"></script>
<script src="{{ url('bootstrap-3.3.7/js/jquery-3.2.1.js') }}"></script>

<h1 style="text-align: center; color: #123489;">
    Edit User
</h1>

<div class="row">
    <div class="col-md-6">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">

            <div class=" row  form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Enter Email" 
                       value="<?php if(old('email')!='') echo old('email'); else echo $user['email']?>">
                <span class="text-danger">{{ $errors->first('email') }}</span>
            </div>


            <div class=" row form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                <label for="name">Username:</label>
                <input type="text" id="username" name="name" class="form-control" placeholder="Enter user name" 
                       value="<?php if(isset($user)) echo $user['name']; else  echo old('name') ?>">
                <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>        

            <div class=" row form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" value="{{ old('password') }}">
                <span class="text-danger">{{ $errors->first('password') }}</span>
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

