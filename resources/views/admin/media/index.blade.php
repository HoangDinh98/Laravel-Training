<?php

use Carbon\Carbon;
?>

@extends ('layout.admin')

@section('content')
<h1>All Media</h1>
<div class="box-content">
    <h2>Thumbnail</h2>
    @if(count($media) > 0)
    <div class="row">
        @foreach($media AS $key => $value)
        <form action="{{ route('admin.media.destroy', $value->photo_id)}}" method="POST" class="media-box">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <img src="{{$value->photo?asset($value->photo):'http://placehold.it/400x300'}}" width="400px" alt="" class="img-responsive img-rounded img-display">
            <input type="submit" name="submit" class="btn btn-danger" value="Delete">
        </form>
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
        <form action="{{ route('admin.media.destroy', $value->photo_id)}}" method="POST" class="media-box">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <img src="{{$value->photo?asset($value->photo):'http://placehold.it/400x300'}}" width="400px" alt="" class="img-responsive img-round">
            <p>{{}}</p>
            <input type="submit" name="submit" class="btn btn-danger" value="Delete">
<!--            <button type="submit" name="submit" class="button-space button-a delete-button">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
            </button>-->
        </form>
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



