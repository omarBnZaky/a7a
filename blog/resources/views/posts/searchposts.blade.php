@extends('layouts.app')
<style type="text/css">
	.avatar{
		border-radius: 100%;
		max-width: 100px;
	}
</style>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
			@if(count($errors)>0)
					@foreach($errors->all() as $error)
						<div class="alert alert-danger">{{$errors}}</div>
					@endforeach
			@endif
			@if(session('response'))
				<div class="alert alert-success">{{session('response') }}</div>
			@endif
            <div class="panel panel-default">
                <div class="panel-heading">
				   <div class="row">
					  <div class="col-md-4">Dashbord</div>
					    <div class="col-md-8">
					   		<form method="post" action='{{url ("/search") }}'>
							{{ csrf_field() }}
								<div class="input-group">
								  <input type="text" name="search" class="form-control" placeholder="search for..">
									<span class="input-group-btn">
									 <button type="submit" class="btn btn-default">
										Search
									</button>
									</span>
								</div>
							
							</form>
					    </div>
					</div>
				</div>

                <div class="panel-body">
                    <div class="col-md-4">
						@if(!empty($profile))
								<img src="{{ $profile->profile_pic }}" 
								 class="avatar"
								 alt="" />
						@else
							<img src="{{ url('images/avatar.png') }}" 
							 class="avatar"
							 alt="" />
						@endif
						
						
						<p class="lead">{{$profile->name}}</p>
						<p>{{$profile->designation}}</p>
						
						<hr>
						
					</div>
                    <div class="col-md-8 text-center">
						@if(count($posts) > 0)
							@foreach($posts->sortByDesc('id') as $post)
								<h4>{{ $post->post_title }}</h4>
						    <img src="{{ $post->post_image }}" alt="" style="max-width: 400px;height:300px"/>
						<br>
						<br>
							<p>{{substr($post->post_body,0,150)}}..</p>
							<ul class="nav nav-pills">
								<li role="presentation">
									<a href='{{ url("/view/{$post->id}") }}'>
										<span>View</span>
									</a>
								</li>
								
								<li role="presentation">
									<a href='{{ url("/edit/{$post->id}") }}'>
										<span>edit</span>
									</a>
								</li>
								
								<li role="presentation">
									<a href='{{ url("/delete/{$post->id}") }}'>
										<span>delete</span>
									</a>
								</li>
							
							</ul>
							<cite style="float:left">Posted in:{{$post->updated_at}}</cite>
						<hr>
							@endforeach
						@else
						<p>No post Available</p>
						@endif
						
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
