<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function commentList(Request $request)
    {
        $items=$request->per_page;
        $comment=Comment::with('user:id,name')->with('product:id,product_code')->paginate($items);
        return response()->json($comment);
    }
    public function replyComment(Request $request)
    {
         $reply=Comment::find($request->comment_id);
         $reply->reply=$request->replyText;
         $reply->save();
         $replied=Comment::where('id',$request->comment_id)->with('user:id,name')->with('product:id,product_code')->first();
         return response()->json($replied);
    }
    public function delete(Request $request)
    {
         Comment::where('id',$request->comment_id)->delete();
    }
}
