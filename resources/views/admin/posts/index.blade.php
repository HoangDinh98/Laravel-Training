<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
?>

@extends ('layout.admin')

@section('content')
<h1>Posts</h1>
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
            <th>Photo</th>
            <th>Owner</th>
            <th>Category</th>
            <th>Title</th>
            <th>Content</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th style="width: 20%">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(count($posts) > 0)
        @foreach($posts as $post)

        <tr>
            <td>{{$post->id}}</td>
            <td>
                <img height="50" 
                     src="{{ File::exists(public_path($post->photo))?asset($post->photo):'http://placehold.it/1200x800' }}" alt="">
            </td>
            <td><a href="{{ route('admin.posts.showByAuthor', $post->user_id) }}">{{ $post->owner }}</a></td>
            <td>{{ $post->category }}</td>
            <td><a href="{{ url('admin/posts/'. $post->id.'/edit') }}" id="name_{{$post->id}}">{{$post->title}}</a></td>
            <td>{{str_limit(strip_tags($post->body), 30)}}</td>
            <td>{{Carbon::parse($post->created_at)->diffForHumans()}}</td>
            <td>{{Carbon::parse($post->updated_at)->diffForHumans()}}</td>
            <td>
                <a class="button-a view-button" href="{{route('home.post', $post->id)}}"><i class="fa fa-eye" aria-hidden="true"></i></a>&nbsp;
                <a class="button-a edit-button" href="{{route('admin.posts.edit', $post->id)}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;
                <a class="button-a view-cmt-button" href="{{route('admin.posts.show', $post->id)}}"><i class="fa fa-comments-o" aria-hidden="true"></i></a>&nbsp;
                <form id="post_{{ $post->id }}" action="{{route('admin.posts.destroy', $post->id)}}" method="POST" class="form-delete"> 
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <!--                    <button type="button" name="buttonZ" class="button-space button-a delete-button delete-fnt"
                                                onclick="confirmBeforeDelete({{ $post->id }}, 'post')">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>-->

                    <button type="button" name="buttonZ" class="button-space button-a delete-button delete-fnt"
                            data-type="post" data-id="{{ $post->id }}">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </button>
                </form>

                <!--                <button type="button" name="submit" data-post-id="{{ $post->id }}" class="button-space button-a delete-button"
                                        onclick="confirmBeforeDelete(1, 'a')">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>-->
            </td>
        </tr>

        @endforeach

        @else 
        <tr>
            <td>No Posts</td>
        </tr>
        @endif

    </tbody>
</table>


<div class="row">
    <div class="col-lg-6 col-sm-offset-5">
        {{ $posts->render() }}
    </div>

</div>

@endsection

