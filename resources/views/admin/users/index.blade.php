@extends ('layout.admin')

@section('content')
<h1>Users</h1>
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($users)) {
            ?>
            @foreach ($users AS $key => $value)
            <tr>
                <td>{{ $value->id }}</td>
                <td><a href="{{route('admin.users.edit', $value->id)}}">{{ $value->name }}</a></td>
                <td>{{ $value->email }}</td>
                <td>{{ $value->role ? $value->role->name:'Another' }}</td>
                <td>{{ $value->created_at }}</td>
                <td>
                    <a class="button-a edit-button" href="{{route('admin.users.edit', $value->id)}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;
                    @if($value->id !=1)
                    <form action="{{route('admin.users.destroy', $value->id)}}" method="POST" class="form-delete"> 
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
            <?php
        } else {
            echo '<tr><td> No User </td></tr>';
        }
        ?>
    </tbody>
</table>
@endsection
