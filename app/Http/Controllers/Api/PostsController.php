<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Comment;
use App\Like;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    
   public function create(Request $request) {

        $post = new Post;
        $post->user_id = Auth::user()->id;
        $post->desc = $request->desc;
        
        //check if post has a photo
        if ($request->photo != '') {
            //chose a unique name for a photo
            $photo = time().'jpg';
            // need to link storage photo to public
            file_put_contents('storage/posts/'.$photo,base64_decode($request->photo));
            $post->photo = $photo;
        }

        //mistake 
        $post->save();
        $post->user;

        return response()->json([
            'success' => true ,
            'message' => 'posted', 
            'post' => $post
        ]);
    }

    public function update(Request $request) {
        $post = Post::find($request->id);
            //check if user is editing his own post
            if(Auth::user()->id != $request->id){
                return response()->json([
                    'success' => false,
                    'message' => 'unauthorized access (update)'
                ]);
            }
            $post->desc = $request->desc;
            $post->update();
            return response()->json([
                'success' => true,
                'message' => 'post edited'
            ]);
    }

    public function delete(Request $request) {
        $post = Post::find($request->id);
        //check if user is deletig his own post
        if(Auth::user()->id != $request->id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access (delete)'
            ]);
        }
        //check if post has photo to delete
        if($post->photo != ''){
            Storage::delete('public/posts/'.$post->photo);
        }
        $post->delete();
        return response()->json([
            'success' => true,
            'message' => 'post deleted'
        ]);
    }

    public function posts() {
        $posts = Post::orderBy('id','desc')->get();
        foreach($posts as $post){
            //get user of post
            $post->user;
            //comments count
            $post['commentsCount'] = count($posts->comments);
            //likes count
            $post['likesCount'] = count($posts->likes);
            //check if user liked his own post 
            $post['selflike'] = false;
            foreach($post->likes as $like){
                if($like->user_id == Auth::user()->id){
                    $post['selflike'] = true;
                }
            }
        }
       
        return response()->json([
            'success' => true,
            'message' => $posts
        ]);
    }

}
