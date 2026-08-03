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
}

