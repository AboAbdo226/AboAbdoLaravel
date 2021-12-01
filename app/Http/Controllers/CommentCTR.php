<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentCTR extends Controller
{
    public function addComment(Request $request)
    {
        $product = Product::find($request->product_id);
        $comment = new Comment();
        $comment->user_name = auth()->user()->email;
        $comment->comment = $request->comment;
        //$comment->product_id=$product->id;
        $product->comments()->save($comment);
        return $comment;
    }

   // @param  int  $id
    public function showComments($id)
    {
        $product = Product::find($id);
        return $product->comments;
       
    
    }


    public function canIEditComment($id)
    {
        $comment = Comment::find($id);
        if(auth()->user()->email == $comment->user_name)
            return true;
        return response([
                message => 'you cant edit this comment'
            ]);
    }


        public function editComment(Request $request,$id)
    {
        $comment = Comment::find($id);
        if(auth()->user()->email == $comment->user_name)
            {$comment->update($request->all());
            return $comment;
        }
            return false;
    }
        public function deleteComment($id)
    {
        $comment = Comment::find($id);
        if(auth()->user()->email == $comment->user_name)
            {$comment->destroy();
            return true;
            }
            return response([
                message => 'you cant delete this comment'
            ]);
    }
}
