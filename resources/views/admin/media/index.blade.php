<?php

use Carbon\Carbon;
?>

@extends ('layout.admin')

@section('content')
<h1>All Media</h1>
<div class="box-content">
    @if (Session::has('notification'))
    <div class="alert alert-success" id="notify">
        <button data-dismiss="alert" class="close">×</button>
        {{ Session::get('notification') }}
    </div>
    @endif
    <h2>Thumbnail</h2>
    @if(count($media) > 0)
    <div class="row">
        @foreach($media AS $key => $value)
        @if(File::exists(public_path($value->photo)))
        <form id="photo_{{$value->photo_id}}" action="{{ route('admin.media.destroy', $value->photo_id)}}" method="POST" class="media-box">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <img src="{{$value->photo?asset($value->photo):'http://placehold.it/400x300'}}" width="300px" alt="" class="img-responsive img-round">
            <h4 id="name_{{$value->photo_id}}">{{$value->post_name}}</h4>
            <!--<input type="submit" name="submit" class="btn btn-danger" value="Delete">-->

            <button type="button" name="buttonZ" class="btn btn-danger delete-fnt"
                    data-type="photo" data-id="{{ $value->photo_id }}" >
                Delete
            </button>
        </form>
        @endif
        @endforeach
        <div class="col-lg-6 col-sm-offset-5">
            {{ $media->render() }}
        </div>
    </div>
    @else
    <p>No Thumbnail</p>
    @endif
</div>
<div class="box-content">
    <h2>Extra Media</h2>
    @if(count($mediafull) > 0)
    <div class="row">
        @foreach($mediafull AS $key => $value)
        @if(File::exists(public_path($value->photo)))
        <form id="photo_{{$value->photo_id}}" action="{{ route('admin.media.destroy', $value->photo_id)}}" method="POST" class="media-box">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <img src="{{$value->photo?asset($value->photo):'http://placehold.it/400x300'}}" width="300px" alt="" class="img-responsive img-round">
            <h4 id="name_{{$value->photo_id}}">{{$value->post_name}}</h4>
            <!--<input type="submit" name="submit" class="btn btn-danger" value="Delete">-->

            <button type="button" name="buttonZ" class="btn btn-danger delete-fnt"
                    data-type="photo" data-id="{{ $value->photo_id }}">
                Delete
            </button>
        </form>
        @endif
        @endforeach
        <div class="col-lg-6 col-sm-offset-5">
            {{ $mediafull->render() }}
        </div>
    </div>
    @else
    <p>No Extra Media</p>
    @endif
</div>
@endsection



