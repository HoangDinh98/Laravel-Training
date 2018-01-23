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
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Enter user name" value="{{ old('username') }}">
                <span class="text-danger">{{ $errors->first('username') }}</span>
            </div>        

            <div class=" row form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" value="{{ old('password') }}">
                <span class="text-danger">{{ $errors->first('password') }}</span>
            </div> 

            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-success" value="submit" />
            </div>
        </form>
    </div>
    <div class="col-md-8">
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Create Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (Session::has('users')) {
                    foreach (Session::get('users') as $key => $values) {
                        ?>
                        <tr>
                            <td><?php echo ($key + 1) ?></td>
                            <td><?php echo ($values[0]) ?></td>
                            <td><?php echo ($values[1]) ?></td>
                            <td><?php echo ($values[2]) ?></td>
                            <td><?php echo ($values[3]) ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td>No user</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
@endsection

