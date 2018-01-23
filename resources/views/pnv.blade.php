<!--<section style="text-align: center">
    <div>
        <h1> Welcome to my Astronomy Club </h1>
        <h2>@if(count($planet)===1) We have only one planet
            @elseif(count($planet)>1) We have multi planet
            @else We don't have any planet
            @endif
        </h2>
        <div>
            @if(count($planet)>=1)
            We have some planet:
            @foreach( $planet as $planet)
            <p> {{$planet}}</p>
            @endforeach
            @endif
        </div>
    </div>
</section>-->

<!--<section style="text-align: center">
    <fieldset>
        <legend>Login Form</legend>
        <form action="pnv" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        Username:
        <input type="text" name="username"><br>
        Password:
        <input type="password" name="password">
        <input type="submit" value="Login">
    </form>
    </fieldset>
</section>-->

<link rel="stylesheet" href="{{ url('bootstrap-3.3.7/css/bootstrap.css') }}">
<script src="{{ url('bootstrap-3.3.7/js/bootstrap.js') }}"></script>
<script src="{{ url('bootstrap-3.3.7/js/jquery-3.2.1.js') }}"></script>

<section>
    <h1 style="text-align: center">Login</h1>
    <br>
    <br>
    <br>
    <br>
    @if(count($errors))
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.
        <br/>
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="container">
        <form action="pnv" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class=" row  form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Enter Email" value="{{ old('email') }}">
                <span class="text-danger">{{ $errors->first('email') }}</span>
            </div>


            <div class=" row form-group {{ $errors->has('firstname') ? 'has-error' : '' }}">
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
                <input type="submit" class="btn btn-success" value="submit" />
            </div>
        </form>
    </div>
</section>