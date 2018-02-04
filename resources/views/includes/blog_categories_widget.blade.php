<div class="well">
    <h4>Blog Categories</h4>
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-unstyled category-style">
                @foreach ($categories AS $key => $category)
                <li><a href="{{url('/home/category/'.$category->id)}}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
