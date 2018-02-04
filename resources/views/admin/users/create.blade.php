@extends ('layout.admin');
@section ('content')

<h1 style="text-align: center; color: #123489;">
    Create User
</h1>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype='multipart/form-data'>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class=" row  form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Enter Email" value="{{ old('email') }}">
                <span class="text-danger">{{ $errors->first('email') }}</span>
            </div>


            <div class=" row form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                <label for="name">Full name:</label>
                <input type="text" id="username" name="name" class="form-control" placeholder="Enter full name" value="{{ old('name') }}">
                <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>        

            <div class=" row form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" value="{{ old('password') }}">
                <span class="text-danger">{{ $errors->first('password') }}</span>
            </div>

            <div class=" row form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="password">Re-Password:</label>
                <input type="password" id="repassword" name="repassword" class="form-control" value="{{ old('repassword') }}">
                <span class="text-danger">{{ $errors->first('repassword') }}</span>
            </div>

            <div class=" row form-group">
                <label for="role">Role: </label>
                <select id="role_id" name="role_id" class="form-control">
                    @foreach ($roles AS $role)
                    <option value="{{ $role->id }}" {{ $role->name=='User'?'selected':'' }} >
                        {{ $role->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class=" row form-group">
                <label for="role">Active: </label>
                <select id="is_active" name="is_active" class="form-control">
                    <option value="0">No</option>
                    <option value="1" selected="true">Yes</option>
                </select>
            </div>

            <div class=" row form-group {{ $errors->has('avatar') ? 'has-error' : '' }}">
                <label for="avatar">Avatar: </label>
                <input type="file" id="avatar" name="avatar" class="form-control" value="{{ old('avatar') }}">
                <span class="text-danger">{{ $errors->first('avatar') }}</span>
            </div> 

            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-success" value="submit" />
            </div>
        </form>
    </div>
</div>
@endsection

