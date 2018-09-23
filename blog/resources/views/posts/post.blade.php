@extends('layouts.app')

@section('content')
@if(Auth::id() ==1)

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Posts</div>

                <div class="panel-body">
                  <div class="row">
					
					 <form class="form-horizontal" method="POST" action="{{ url('/addPost') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('post_title') ? ' has-error' : '' }}">
                            <label for="post_title" class="col-md-4 control-label">Enter Title</label>

                            <div class="col-md-6">
                                <input id="post_title" type="text" class="form-control" name="post_title" value="{{ old('post_title') }}" required autofocus>

                                @if ($errors->has('post_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('post_title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('post_body') ? ' has-error' : '' }}">
                            <label for="post_body" class="col-md-4 control-label">Enter post</label>

                            <div class="col-md-6">
								<textarea id="post_body"  rows="7"  class="form-control" name="post_body" required></textarea>

                                @if ($errors->has('post_body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('post_body') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
								  
				   <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label for="category_id" class="col-md-4 control-label">category</label>

                            <div class="col-md-6">
								<select id="category_id" type="input" class="form-control" name="category_id" required>
										<option value="">Select</option>
									@if(count($category) > 0)
										@foreach($category->all() as $cat)
											 <option value="{{$cat->id}}">{{$cat->category}}</option>
										@endforeach
									@endif
								 
								 </select>

                                @if ($errors->has('category_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
							  
					 <div class="form-group{{ $errors->has('post_image') ? ' has-error' : '' }}">
                            <label for="profile_pic" class="col-md-4 control-label">post image</label>

                            <div class="col-md-6">
                                <input id="post_image" type="file" class="form-control" name="post_image" required>

                                @if ($errors->has('post_image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('post_image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                    

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary ">
                                    publish  post
								</button>
                            </div>
                        </div>
                    </form>
					
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
 <h3 class="text-center">You are not allowed to enter this page</h3>
@endif
@endsection
