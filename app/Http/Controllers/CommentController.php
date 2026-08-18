<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function createComment(Request $request,$id){

        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|max:300',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ], [
            'comment.required' => 'Yorum boş olamaz.',
            'comment.max' => 'Yorum en fazla 300 karakter olabilir.',
            'image.image' => 'Yalnızca resim dosyası yükleyebilirsiniz.',
            'image.mimes' => 'İzin verilen formatlar: jpeg, png, jpg, gif.',
            'image.max' => 'Resim boyutu en fazla 4 MB olabilir.',
        ]);

        $validator->validate();

        $comment = new Comment();

        $comment->user_id = Auth::id();
        $comment->post_id = $id;
        $comment->comment = $request->comment;

        if ($request->hasFile('image')) {
            $comment->image = $request->file('image')->store('comments', 'public');
        }

        $comment->save();

        return redirect()->back()->with('success', 'Yorumunuz eklendi.');
    }

    public function deleteComment($id){

        $comment = Comment::findOrFail($id);

        if($comment->user_id !== Auth::id()){
            return redirect()->back()->with('error', 'Bu yorumunu silemezsiniz.');
        }

        if ($comment->image) {
            Storage::disk('public')->delete($comment->image);
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Yorumunuz silindi.');

    }

}
