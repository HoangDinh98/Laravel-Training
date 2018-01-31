@extends ('layout.admin');
@section ('content')

<h1 style="text-align: center; color: #123489;">
    Create Category
</h1>
<br><br>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">
            
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">Category Name:</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter Category Name"
                       value="{{ old('name')!=NULL?old('name'):$category->name }}">
                <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>

            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-success" value="submit" />
            </div>
        </form>
        
        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <input type="submit" name="delete_submit" class="btn btn-danger" value="Delete">
        </form>
    </div>
</div>
@endsection