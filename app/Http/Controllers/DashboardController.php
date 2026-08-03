<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function showAdminDashboard()
    {
        $user = Auth::user();


        return view('panel.admin.pages.adminmainpage', compact('user'));
    }


    public function showPendingPosts()
    {
        $posts = Post::pending()->with('user')->latest()->paginate(20);

        return view('panel.admin.pages.pending', compact('posts'));
    }

    // Post onaylama ve yayınlama

    public function showApprovedPosts(Request $request,Post $post)
    {
        $post->update([
            'status'      => Post::STATUS_APPROVED,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Post onaylandi ve yayinlandi.');
    }

    public function showRejectedPosts(Request $request,Post $post)
    {
        $request->validate([
            'reject_reason' => 'nullable|string|max:500',
        ]);

        $post->update([
            'status'      => Post::STATUS_REJECTED,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Post reddedildi.');

    }

}
