@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
		
            <div class="panel panel-default">
                <div class="panel-heading text-center">Post View</div>

                <div class="panel-body">
                    <div class="col-md-4">
						<ul class="list-group">
							@if(count($categories) > 0)
								@foreach($categories->all() as $cat)
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
					
							<cite style="float:left">Posted in:{{$post->updated_at}}</cite>
						<hr>
							@endforeach
						@else
						<p>No post Available</p>
						@endif
					</div>
											<hr>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
