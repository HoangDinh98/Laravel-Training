@extends ('layout.admin');
@section ('content')
<link rel="stylesheet" href="{{ url('bootstrap-3.3.7/css/bootstrap.css') }}">
<script src="{{ url('bootstrap-3.3.7/js/bootstrap.js') }}"></script>
<script src="{{ url('bootstrap-3.3.7/js/jquery-3.2.1.js') }}"></script>

<h1 style="text-align: center; color: #123489;">
    Create User
</h1>

<div class="row">
    <div class="col-md-4">
        <form action="{{ route('admin.users.store') }}" method="post">
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
                <select id="role_id" name="role_id">
                    @foreach ($roles AS $role)
                    <option value="{{ $role->id }}" {{ $role->id==2?'selected':'' }} >
                        {{ $role->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class=" row form-group">
                <label for="role">Active: </label>
                <select id="is_active" name="is_active">
                    <option value="0">No</option>
                    <option value="1" selected="true">Yes</option>
                </select>
            </div>

            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-success" value="submit" />
            </div>
        </form>
    </div>
</div>
@endsection

