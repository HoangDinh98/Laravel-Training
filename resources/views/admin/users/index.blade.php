<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
?>

@extends ('layout.admin')

@section('content')
<h1>Users</h1>
@if (Session::has('notification'))
<div class="alert alert-success" id="notify">
    <button data-dismiss="alert" class="close">×</button>
    {!! Session::get('notification') !!}
</div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Avatar</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

        @if(count($users) > 0)
        @foreach ($users AS $key => $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>
                <img height="50" 
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
            </td>
            <td><a href="{{route('admin.users.edit', $user->id)}}">{{ $user->name }}</a></td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role() ? $user->role()->name:'Another' }}</td>
            <td>{{ $user->created_at }}</td>
            <td>
                <a class="button-a edit-button" href="{{route('admin.users.edit', $user->id)}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;
                @if($user->id !=1)
                <form action="{{route('admin.users.destroy', $user->id)}}" method="POST" class="form-delete"> 
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <button type="submit" name="submit" class="button-space button-a delete-button">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
        @else 
        <tr><td> No User </td></tr>;
        @endif
    </tbody>
</table>

<div class="row">
    <div class="col-lg-6 col-sm-offset-5">
        {{ $users->render() }}
    </div>

</div>

@endsection
