@extends ('layout.admin')

@section('content')
<h1>Posts</h1>
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
                <td>{{ $value->name }}</td>
                <td>{{ $value->email }}</td>
                <td>{{ $value->role_id==1?'Admin':($value->role_id==2?'User':'Another') }}</td>
                <td>{{ $value->created_at }}</td>
                <td>
                    <a href="{{route('admin.users.edit', $value->id)}}">Edit</a> &nbsp;&nbsp;
                    <a href="{{route('admin.users.destroy', $value->id)}}">Delete</a> &nbsp;&nbsp;
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
