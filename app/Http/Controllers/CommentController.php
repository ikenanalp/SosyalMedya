<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function createComment(Request $request,$id){

        $comment = new Comment();

        $comment->user_id = Auth::id();
        $comment->post_id = $id;
        $comment->comment = $request->comment;
        $comment->save();

        return redirect()->route('panel.user.showMainPage') ->with('success', 'Yorumunuz eklendi.');
    }

    public function deleteComment($id){

    $comment = Comment::findOrFail($id);

    if($comment->user_id !== Auth::id()){
        return redirect()->route('panel.user.showMainPage')->with('error', 'Bu yorumunu silemezsiniz.');
    }


    $comment->delete();

    return redirect()->route('panel.user.showMainPage')->with('success', 'Yorumunuz silindi.');

    }

}
