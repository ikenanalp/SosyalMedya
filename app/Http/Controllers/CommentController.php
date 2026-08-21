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
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:4096',
        ], [
            'comment.required' => 'Yorum boş olamaz.',
            'comment.max' => 'Yorum en fazla 300 karakter olabilir.',
            'images.max' => 'En fazla 5 resim ekleyebilirsiniz.',
            'images.*.image' => 'Yalnızca resim dosyası yükleyebilirsiniz.',
            'images.*.mimes' => 'İzin verilen formatlar: jpeg, png, jpg, gif.',
            'images.*.max' => 'Her resim en fazla 4 MB olabilir.',
        ]);

        $validator->after(function ($validator) use ($request) {
            if (trim((string) $request->input('comment')) === '') {
                $validator->errors()->add('comment', 'Yorum boş olamaz.');
            }
        });

        $validator->validate();

        $comment = new Comment();

        $comment->user_id = Auth::id();
        $comment->post_id = $id;
        $comment->comment = trim((string) $request->comment);
        $comment->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('comments', 'public');

                $comment->images()->create([
                    'image_url' => $path,
                    'position' => $index,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Yorumunuz eklendi.');
    }

    public function deleteComment($id){

        $comment = Comment::findOrFail($id);

        if($comment->user_id !== Auth::id()){
            return redirect()->back()->with('error', 'Bu yorumunu silemezsiniz.');
        }

        foreach ($comment->images as $img) {
            Storage::disk('public')->delete($img->image_url);
            $img->delete();
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Yorumunuz silindi.');

    }

}
