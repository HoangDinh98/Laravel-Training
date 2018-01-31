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
<img class="img-responsive" src="{{$post->photo ? asset($post->photo) : 'http://placehold.it/400x400' }}" alt="">

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
    <h4>Leave a Comment:</h4>


    <form action="">
        <input type="hidden" name="post_id" value="">
        <div class="form-group">
            <textarea class="form-control" rows="5" id="comment"></textarea>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Create Post" />
        </div>
    </form>
</div>


@endif



@stop


@section('scripts')

<script>

    $(".comment-reply-container .toggle-reply").click(function () {


        $(this).next().slideToggle("slow");




    });




</script>



@stop

