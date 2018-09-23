<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use App\category;
use App\like;
use App\dislike;
use App\post;
use App\profile;
use App\comment;
use Auth;
class PostController extends Controller
{
	
		public function post(){

			$category = category::all();
			return view('posts.post',['category'=>$category]);
		}
		 public function addPost(Request $request){
		 $this->validate($request,[
			 'post_title'=>'required',
			 'post_body'=>'required',
			 'category_id'=>'required',
			 'post_image'=>'required',
		 ]);
		 $posts = new post;
		 $posts->post_title= $request->input('post_title');
		 $posts->user_id = Auth::user()->id;
		 $posts->post_body= $request->input('post_body');
		 $posts->category_id= $request->input('category_id');
			 
		if(Input::hasFile('post_image')){
			$file = Input::file('post_image');
			$file->move(public_path().'/postImages/',$file->getClientOriginalName());
			$url = URL::to("/").'/postImages/'.$file->getClientOriginalName();
		}
		 $posts->post_image= $url;
		 $posts->save();
		 return redirect('/home')->with('response','post Added Successfully');


	}
	public function view($post_id){
	  $posts= post::where('id','=',$post_id)->get();
	  $likePost   = post::find($post_id);
	  $likeCtr    = like::where(['post_id'=>$likePost->id])->count();
	  $dislikeCtr = dislike::where(['post_id'=>$likePost->id])->count();
	  $category = category::all();
		$comments=DB::table('users')
			->join('comments','users.id','=','comments.user_id')
		    ->join('posts','comments.post_id','=','posts.id')
			->select('users.name','comments.*')
			->where(['posts.id'=>$post_id])
			->get();	
	 return view('posts.view',['posts'=>$posts,'category'=>$category,'likeCtr'=>$likeCtr,'dislikeCtr'=>$dislikeCtr,'comments'=>$comments]);
	}
	public function edit($post_id){
		$category = category::all();
		$posts= post::find($post_id);
		$catId = category::find($posts->category_id);
		return view('posts.edit',['posts'=>$posts,'category'=>$category,'catId'=>$catId]);
	}
		public function editPost(Request $request, $post_id){
					 $this->validate($request,[
			 'post_title'=>'required',
			 'post_body'=>'required',
			 'category_id'=>'required',
			 'post_image'=>'required',
		 ]);
		 $posts = new post;
		 $posts->post_title= $request->input('post_title');
		 $posts->user_id = Auth::user()->id;
		 $posts->post_body= $request->input('post_body');
		 $posts->category_id= $request->input('category_id');
			 
		if(Input::hasFile('post_image')){
			$file = Input::file('post_image');
			$file->move(public_path().'/postImages/',$file->getClientOriginalName());
			$url = URL::to("/").'/postImages/'.$file->getClientOriginalName();
		}
		 $posts->post_image= $url;
		 $data = array(
		 'post_title' => $posts->post_title,
	     'user_id'    => $posts->user_id,
		 'post_body'  => $posts->post_body,
		 'category_id'=> $posts->category_id,
		 'post_image' => $posts->post_image
		 );
		 post::where('id',$post_id)->update($data);
		 $posts->update();
		 return redirect('/home')->with('response','post updated Successfully');
		
		}
		public function deletePost($post_id){
		post::where('id',$post_id)->delete();
		 return redirect('/home')->with('response','post deleted Successfully');
		}
	public function category($cat_id){
		$categories = category::all();
		$posts = DB::table('posts')
			->join('categories','posts.category_id','=','categories.id')
			->select('posts.*','categories.*')
			->where(['categories.id'=>$cat_id])
			->get();	
		return view('categories.catposts',['categories'=>$categories,'posts'=>$posts]);
	}
		public function like($id){
			$loggedin_user = Auth::user()->id;
			$like_user =like::where(['user_id'=>$loggedin_user,'post_id'=>$id])->first();
			if(empty($like_user->user_id)){
				$user_id = Auth::user()->id;
				$email = Auth::user()->email;
				$post_id =$id;
				$like =new like;
				$like->user_id = $user_id;
				$like->email = $email ;
				$like->post_id =$post_id ; 
				$like->save(); 
				return redirect("/view/{$id}");
			}else{
				return redirect("/view/{$id}");
			}
		}
	
	public function dislike($id){
			$loggedin_user = Auth::user()->id;
			$dislike_user =dislike::where(['user_id'=>$loggedin_user,'post_id'=>$id])->first();
			if(empty($dislike_user->user_id)){
				$user_id = Auth::user()->id;
				$email = Auth::user()->email;
				$post_id =$id;
				$dislike =new dislike;
				$dislike->user_id = $user_id;
				$dislike->email = $email ;
				$dislike->post_id =$post_id ; 
				$dislike->save(); 
				return redirect("/view/{$id}");
			}else{
				return redirect("/view/{$id}");
			}
		}
	 public function comment(Request $request, $post_id){
		 $this->validate($request,[	 
			 'comment'=>'required'
		 ]);
		 $comment = new comment;
		 $comment->user_id = Auth::user()->id;
		 $comment->post_id = $post_id;
		 $comment->comment = $request->input('comment');
		 $comment->save();
		 return redirect("/view/{$post_id}")->with('response','comment added Successfully');;

	 }
	public function search(Request $request){
		$user_id = Auth::user()->id;
		$profile = profile::find($user_id);
		$keyword = $request->input('search');
		$posts    = post::where('post_title','LIKE','%'.$keyword.'%')->get();
		return view('posts.searchposts',['profile'=>$profile,'posts'=>$posts]);
	}
	
}