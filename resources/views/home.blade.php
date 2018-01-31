@extends('layouts.blog-post')

@section('content')

   <div class="container">
       
       @if($posts)


            @foreach($posts as $post)

                      
            <div class="row">
                <div class="col-md-8">
                    <div class="media">
                      <div class="media-left">
                        <a href="#">
                          <img class="media-object" src="{{$post->photo ? asset( $post->photo->file ): 'http://placehold.it/400x400'}}"  alt="...">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading"><a href="{{ url('post/'. $post->id) }}">{{$post->title}}</a></h4>
                                <?php echo str_limit($post->body, 300);?>      
                      </div>
                    </div>
                </div>
                
            </div>
            
            
            @endforeach

            @endif
       
        <div class="row">
            <div class="col-lg-6 col-sm-offset-5">
                {{ $posts->render() }}
            </div>
        
     </div>

       
        </div>

@endsection
