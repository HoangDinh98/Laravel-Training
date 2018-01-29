@extends('layout.admin')

@section('content')
@include('includes.tinyeditor')

<h1>Create Post</h1>

<div class="row">

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype='multipart/form-data'>
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        
        <div class=" form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Enter title" value="{{ old('title') }}">
            <span class="text-danger">{{ $errors->first('title') }}</span>
        </div>        
        <div class=" form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
            <label for="category_id">Category:</label>
            <select class="form-control" id="category_id" name="category_id" >
                @foreach ($categories as $id => $name  )
                <option value="{{$id}}">{{$name}}</option>
                @endforeach   
            </select>                
            <span class="text-danger">{{ $errors->first('category_id') }}</span>
        </div>  


        <div class="  form-group {{ $errors->has('photo_id') ? 'has-error' : '' }}">
            <label for="photo_id">Thumnail:</label>
            <input type="file" id="photo_id" name="photo_id" class="form-control" value="{{ old('photo_id') }}">
            <span class="text-danger">{{ $errors->first('photo_id') }}</span>
        </div> 


        <div class=" form-group {{ $errors->has('body') ? 'has-error' : '' }}">
            <label for="body">Title:</label>
            <textarea class="form-control" rows="5" id="body" name="body">{{ old('body') }}</textarea>
            <span class="text-danger">{{ $errors->first('body') }}</span>
        </div> 

        <div class="form-group">
            <input type="submit" class="btn btn-success" value="Create Post" />
        </div>
    </form>
</div>


<div class="row">
    @include('includes.form_error')
</div>
@stop
