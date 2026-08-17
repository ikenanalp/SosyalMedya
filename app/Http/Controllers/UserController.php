<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showFindUserPage(Request $request)
    {
        $query = $request->input('query');

        $users = User::query()
            ->when($query, function ($q) use ($query) {
                $q->where('username', 'like', "%{$query}%");
            })
            ->paginate(15);

        return view('panel.userpages.finduser', compact('users', 'query'));
    }


    public function userProfilePage(User $user)
    {
        $posts = $user->posts()->approved()->latest()->paginate(10);


        return view('panel.userpages.showprofilepage', compact('user', 'posts'));
    }

    // Bir kullanıcının takipçi listesi
    public function followersList(User $user)
    {
        $followerIds = Follower::where('following_id', $user->id)->pluck('follower_id');

        $users = User::whereIn('id', $followerIds)->paginate(15);

        return view('panel.userpages.followerslist', [
            'profileUser' => $user,
            'users' => $users,
            'listType' => 'followers',
        ]);
    }

    // Bir kullanıcının takip ettiği kişilerin listesi
    public function followingList(User $user)
    {
        $followingIds = Follower::where('follower_id', $user->id)->pluck('following_id');

        $users = User::whereIn('id', $followingIds)->paginate(15);

        return view('panel.userpages.followerslist', [
            'profileUser' => $user,
            'users' => $users,
            'listType' => 'following',
        ]);
    }
}
