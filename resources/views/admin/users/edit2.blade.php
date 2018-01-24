@extends('layout.admin')




@section('content')


<h1>Edit Users</h1>

<div class="row">

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <input type="hidden" name="_method" value="PUT">


        <div class=" form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Enter name" value="{{ $user->name  }}">
            <span class="text-danger">{{ $errors->first('name') }}</span>
        </div>   

        <div class="  form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <label for="email">Email:</label>
            <input type="text" disabled="" id="email" name="email" class="form-control" placeholder="Enter Email" value="{{ $user->email  }}">
            <span class="text-danger">{{ $errors->first('email') }}</span>
        </div>

        <!--            <div class=" form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
                            <label for="category_id">Is active account:</label>
                            <input type="checkbox" id="is_active" name="is_active" value="1" @if ( $user->is_active == 1 ) checked   @endif />
                                          
                            <span class="text-danger">{{ $errors->first('is_active') }}</span>
                    </div>  -->

        <div class="  form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" value="">
            <span class="text-danger">{{ $errors->first('password') }}</span>
        </div> 


        <div class="form-group">
            <input type="submit" class="btn btn-success" value="Edit User" />
        </div>
    </form>

    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" >
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <div class="form-group">
            <input type="submit" class="btn btn-danger" value="Delete User" />

        </div>
    </form>

</div>    
@stop