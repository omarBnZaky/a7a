@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
		
				@if(session('response'))
				<div class="alert alert-success">{{session('response') }}</div>
			@endif
            <div class="panel panel-default">
                <div class="panel-heading text-center">Post View</div>

                <div class="panel-body">
                    <div class="col-md-4">
						<ul class="list-group">
							@if(count($category) > 0)
								@foreach($category->all() as $cat)
									<li  class="list-group-item" ><a href='{{url("/category/{$cat->id}")}}'>{{$cat->category}}</a></li>
								@endforeach
							@else
								<p>No Category found</p>
							@endif
							
						
						</ul>
					</div>
                   <div class="col-md-8 text-center">
						@if(count($posts) > 0)
							@foreach($posts->sortByDesc('created_at') as $post)
								<h4>{{ $post->post_title }}</h4>
						    <img src="{{ $post->post_image }}" alt="" style="max-width: 400px;height:300px"/>
						<br>
						<br>
							<p>{{$post->post_body}}</p>
							<ul class="nav nav-pills">
								<li role="presentation">
									<a href='{{ url("/like/{$post->id}") }}'>
										<span>like {{$likeCtr}}</span>
									</a>
								</li>
								
								<li role="presentation">
									<a href='{{ url("/dislike/{$post->id}") }}'>
										<span>dislike{{$dislikeCtr}}</span>
									</a>
								</li>
								
								<li role="presentation">
									<a href='{{ url("/comment/{$post->id}") }}'>
										<span>comment</span>
									</a>
								</li>
							
							</ul>
							<cite style="float:left">Posted in:{{$post->updated_at}}</cite>
						<hr>
							@endforeach
						@else
						<p>No post Available</p>
						@endif
					   <form method="post" action='{{ url("/comment/{$post->id}")}}'>
					   {{csrf_field()}}
					    <div class="form-group">
						   <textarea id="comment" row="6" class="form-control" name="comment" required autofocus></textarea>
						   </div>
						   <div class="form-group">
						    <button type="submit" class="btn btn-success">
							   post comment</button>
						   </div>
					   </form>
					   <h3>comments</h3>
					   		@if(count($comments) > 0)
								@foreach($comments->all() as $comment)
					   	 <p>{{$comment->name}}:{{$comment->comment}}</p>
					   		
					   				<hr>
								@endforeach
							@else
								<p>No Category found</p>
							@endif
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
