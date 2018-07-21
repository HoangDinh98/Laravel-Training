@extends('layouts.blog-post')

@section('content')

<div class="container">

    @if(isset($is_search))
    <div>
        <p><b>{{ $posts->total() }}</b> Result for: <b>"{{ $search_text }}"</b></p>
    </div>
    @endif

    @if(count($posts) > 0 )

    @foreach($posts as $post)


    <div class="row">
        <div class="col-md-8 post-box">
            <div class="media">
                <div class="media-left">
                    <a href="#">
                        @if(isset($is_search))
                        <div>
                            <img class="media-object" src="{{File::exists(public_path($post->photo_thumbnail()->path))?asset($post->photo_thumbnail()->path):'http://placehold.it/1200x800'}}"  alt="..." width="200px">
                        </div>
                        @else
                        <img class="media-object" src="{{File::exists(public_path($post->photo))?asset($post->photo):'http://placehold.it/1200x800'}}"  alt="..." width="200px">
                        @endif
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><a href="{{ url('post/'. $post->id) }}">{{$post->title}}</a></h4>
                    <?php // echo str_limit($post->body, 300) ?>
                    {{ str_limit(strip_tags($post->body), 300)}}
                </div>
            </div>
        </div>

    </div>


    @endforeach

    @endif

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            {{ $posts->render() }}
        </div>

    </div>


</div>

@endsection
