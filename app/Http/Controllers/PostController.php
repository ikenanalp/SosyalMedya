<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function createPost(Request $request)
    {
        $request->validate([
            'content'=>'required|min:3|max:250',
        ]);

        $post = new Post();
        $post->user_id = Auth::id() ;
        $post->content = $request->content;
        $post->save();

        return redirect()->route('panel.user.showCreatePost')->with(['success'=>'Paylaşımınız başarıyla eklendi']);
        }

        public function deletePost($id){

        $kategori = Post::find($id);
        $kategori->delete();


        return redirect()->route('panel.user.showProfilePage');
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
