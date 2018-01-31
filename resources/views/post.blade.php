<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
?>

@extends('layouts.blog-post')



@section('content')



<!-- Blog Post -->

<!-- Title -->
<h1>{{$post->title}}</h1>

<!-- Author -->
<p class="lead">
    by <a href="#">{{$post->owner}}</a>
</p>

<hr>

<!-- Date/Time -->
<p><span class="glyphicon glyphicon-time"></span> Posted {{Carbon::parse($post->created_at)->diffForHumans()}}</p>

<hr>

<!-- Preview Image -->
<img class="img-responsive" src="{{File::exists(public_path($post->photo))?asset($post->photo):'http://placehold.it/1200x800'}}" alt="">

<hr>

<!-- Post Content -->

<p>{{!! $post->body !!}}</p>

<hr>


@if(Session::has('comment_message'))

{{session('comment_message')}}


@endif

<!-- Blog Comments -->


@if(Auth::check())

<!-- Comments Form -->
<div class="well">


    <form method="POST" action="{{ route('user.posts.addComment', $post->id) }}">
        <h4>Leave a Comment:</h4>
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <input type="hidden" name="post_id" value="{{$post->id}}">
        <!--<input type="hidden" name="parent_id" value="0">-->
        <div class="form-group">
            <textarea class="form-control" rows="5" id="comment" name="body"></textarea>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Create Comment" />
        </div>
    </form>

</div>


@endif
<br><br><br>
@if(count($comments) > 0)
@foreach($comments as $comment)
<div class="col-md-12" style="padding: 5px 10px 10px 10px; border-bottom: 1px #ddd solid; background-color: #f8f8f8" >
    <div class="col-md-9">
        <h4 style="font-weight: bold" class="text-success"> {{$comment->author}}</h4>
    </div>
    <div class="col-md-3 pull-right">
        {{$comment->created_at->diffForHumans()}}
    </div>
    <div class="col-md-12">
        {{$comment->body}}
    </div>
    @if(Auth::check())
    <div class="col-md-12">
        <button data-toggle="collapse" data-target="#reply-{{$comment->id}}" class="btn btn-info">
            <i class="fa fa-reply" aria-hidden="true"></i>
            Reply
        </button>
        <div id="reply-{{$comment->id}}" class="collapse">
            <form method="POST" action="">
                <h4>Leave a Comment:</h4>
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="hidden" name="post_id" value="{{$post->id}}">
                <input type="hidden" name="parent_id" value="{{$comment->id}}">
                <div class="form-group">
                    <textarea class="form-control" rows="5" id="comment" name="body"></textarea>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Create Post" />
                </div>
            </form>
        </div>
    </div>
    @endif

</div>
@endforeach
<div class="row">
    <div class="col-lg-6 col-sm-offset-5">
        {{ $comments->render() }}
    </div>
</div>
@endif

@endsection
@section('categories')
@foreach($categories as $category)
<div class="col-md-6"><a href="{{url('blog/categories/'.$category->id)}}">{{$category->name}}</a></div>
@endforeach

@stop


@section('scripts')

<script>

    $(".comment-reply-container .toggle-reply").click(function () {


        $(this).next().slideToggle("slow");
    });




</script>



@stop

