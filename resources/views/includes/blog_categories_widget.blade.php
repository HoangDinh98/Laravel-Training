<div class="well">
    <h4>Blog Categories</h4>
    <div class="row">
        <div class="col-lg-6">
            <ul class="list-unstyled">
                @foreach ($categories AS $key => $category)
                <li><a href="{{url('/home/category/'.$category->id)}}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
