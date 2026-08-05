<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserBanController extends Controller
{
    // Kullanicilari admin paneline listeler
    public function index()
    {
        $users = User::latest()->paginate(20);

        return view('panel.admin.pages.usersbanpage', compact('users'));
    }

    // Kullaniciyi banlar
    public function banUsers(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kendi hesabınızı banlayamazsınız.');
        }

        $request->validate([
            'ban_reason' => 'nullable|string|max:255',
        ]);

        $user->update([
            'is_banned'  => true,
            'ban_reason' => $request->input('ban_reason'),
            'banned_by'  => auth()->id(),
            'banned_at'  => now(),
        ]);

        return back()->with('success', 'Kullanici banlandi.');
    }

    // Kullanicinin banini kaldirir
    public function unbanUsers(Request $request, User $user)
    {
        $user->update([
            'is_banned'  => false,
            'ban_reason' => null,
            'banned_by'  => null,
            'banned_at'  => null,
        ]);

        return back()->with('success', 'Kullanicinin bani kaldirildi.');
    }
}
