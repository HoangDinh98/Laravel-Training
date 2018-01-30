@extends('layout.admin')

@section('content')
@include('includes.tinyeditor')

<h1>Create Post</h1>

<div class="row">

    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype='multipart/form-data'>
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <input type="hidden" name="_method" value="PUT">


        <div class=" form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Enter title" value="{{ old('title')?old('title'):$post->title }}">
            <span class="text-danger">{{ $errors->first('title') }}</span>
        </div>        
        <div class=" form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
            <label for="category_id">Category:</label>
            <select class="form-control" id="category_id" name="category_id" >
                @foreach ($categories as $id => $name  )
                <option value="{{$id}}"   {{ $id == $post->category_id ? 'selected="selected"' : '' }}
                    >
                    {{$name}}
                </option>
                @endforeach   
            </select>                
            <span class="text-danger">{{ $errors->first('category_id') }}</span>
        </div>  
        <div class="form-group " style="">
            <img src="{{$post->photo?asset($post->photo):'http://placehold.it/400x300'}}" width="400px" alt="" class="img-responsive img-rounded img-display">
        </div> <br>

        <div class="  form-group {{ $errors->has('photo_id') ? 'has-error' : '' }}">
            <label for="photo_id">Thumnail:</label>
            <input type="file" id="photo_id" name="photo_id" class="form-control" value="{{ old('photo_id') }}">
            <span class="text-danger">{{ $errors->first('photo_id') }}</span>
        </div> 


        <div class=" form-group {{ $errors->has('body') ? 'has-error' : '' }}">
            <label for="body">Content:</label>
            <textarea class="form-control" rows="5" id="body" name="body">{{ old('body')?old('body'):$post->body }}</textarea>
            <span class="text-danger">{{ $errors->first('body') }}</span>
        </div> 

        <div class="form-group">
            <input type="submit" class="btn btn-success" value="Update Post" />
        </div>
    </form>
    
    <form action="{{ route('admin.posts.destroy', $post->id)}}" method="POST">
        <div class="form-group">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <input type="submit" name="delete_submit" class="btn btn-danger" value="Delete Post">
        </div>
    </form>
</div>


<div class="row">


    @include('includes.form_error')



</div>




@stop
