<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function createPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'nullable|min:3|max:250',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:4096',
        ], [
            'content.min' => 'İçerik en az 3 karakter olmalıdır.',
            'content.max' => 'İçerik en fazla 250 karakter olabilir.',

            'images.array' => 'Resimler geçersiz.',
            'images.max' => 'En fazla 5 resim yükleyebilirsiniz.',
            'images.*.image' => 'Yalnızca resim dosyası yükleyebilirsiniz.',
            'images.*.mimes' => 'İzin verilen formatlar: jpeg, png, jpg, gif.',
            'images.*.max' => 'Her resim en fazla 4 MB olabilir.',
        ]);

        $validator->after(function ($validator) use ($request) {

            $content = trim((string) $request->input('content'));

            if ($content === '' && !$request->hasFile('images')) {
                $validator->errors()->add('content', 'İçerik veya en az bir resim eklemelisiniz.');
            }

            if ($request->hasFile('images') && $content === '') {
                $validator->errors()->add('content', 'Resim yüklediğinizde içerik girmek zorundasınız.');
            }

            if ($content !== '' && mb_strlen($content) < 3) {
                $validator->errors()->add('content', 'İçerik en az 3 karakter olmalıdır.');
            }
        });

        $validator->validate();

        $post = new Post();
        $post->user_id = Auth::id();
        $post->content = trim((string) $request->content) ?: null;
        $post->status = 0;
        $post->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('posts', 'public');

                PostImage::create([
                    'post_id' => $post->id,
                    'image_url' => $path,
                    'position' => $index,
                ]);
            }
        }

        return redirect()->route('panel.user.showCreatePost')->with(['success'=>'Paylaşımınız başarıyla eklendi']);
    }

    public function deletePost($id){

        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Bu postu silme yetkiniz yok.');
        }

        foreach ($post->images as $img) {
            Storage::disk('public')->delete($img->image_url);
            $img->delete();
        }

        $post->delete();

        return redirect()->route('panel.user.showProfilePage')->with('success', 'Post silindi.');
    }


    public function showProfilePage(){

        $user = Auth::user();

        $post = $user->posts()->approved()->latest()->paginate(10);

        $followersCount = \App\Models\Follower::where('following_id', $user->id)->count();
        $followingCount = \App\Models\Follower::where('follower_id', $user->id)->count();

        return view('panel.userpages.profile', compact('user', 'post', 'followersCount', 'followingCount'));
    }


    public function showCreatePostPage(){
        return view('panel.userpages.createpost');
    }


    public function showMainPage(){

        $post = Post::approved()->with('user')->latest()->get();

        return view('panel.userpages.mainpage', compact('post'));
    }


    public function showMyFollowingPage()
    {
        $followingIds = Follower::where('follower_id', Auth::id())
            ->pluck('following_id');

        $post = Post::with(['user', 'comments.user', 'likes'])
            ->whereIn('user_id', $followingIds)
            ->approved()
            ->latest()
            ->paginate(10);

        return view('panel.userpages.myfollowingsend', compact('post'));
    }


}
