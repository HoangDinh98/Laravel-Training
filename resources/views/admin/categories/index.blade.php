@extends ('layout.admin')

@section('content')
<h1>Categories</h1>
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
                <td><a id="name_{{$category->id}}" href="{{route('admin.categories.edit', $category->id)}}">{{ $category->name }}</a></td>
                <td>{{ $category->created_at }}</td>
                <td>{{ $category->updated_at }}</td>
                <td>
                    <a class="button-a edit-button" href="{{route('admin.categories.edit', $category->id)}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;
                    <!--<a class="button-a delete-button" href="{{route('admin.categories.destroy', $category->id)}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>-->
                    <form id="category_{{$category->id}}" action="{{route('admin.categories.destroy', $category->id)}}" method="POST" class="form-delete"> 
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <!--                        <button type="submit" name="submit" class="button-space button-a delete-button">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </button>-->

                        <button type="button" name="buttonZ" class="button-space button-a delete-button delete-fnt"
                                data-type="category" data-id="{{ $category->id }}">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                    </form>
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

<div class="row">
    <div class="col-lg-6 col-sm-offset-5">
        {{ $categories->render() }}
    </div>

</div>
@endsection


