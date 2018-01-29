@extends ('layout.admin')

@section('content')
<h1>Categories</h1>
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Created Date</th>
            <th>Updated Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($categories) > 0) {
            ?>
            @foreach ($categories AS $category )
            <tr>
                <td>{{ $category->id }}</td>
                <td><a href="{{route('admin.categories.edit', $category->id)}}">{{ $category->name }}</a></td>
                <td>{{ $category->created_at }}</td>
                <td>{{ $category->updated_at }}</td>
                <td>
                    <a class="button-a edit-button" href="{{route('admin.categories.edit', $category->id)}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;
                    <a class="button-a delete-button" href="{{route('admin.categories.destroy', $category->id)}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                </td>
            </tr>
            @endforeach
            <?php
        } else {
            echo '<tr><td> No Category </td></tr>';
        }
        ?>
    </tbody>
</table>
@endsection


