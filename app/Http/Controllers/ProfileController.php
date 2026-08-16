<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Profil düzenleme formunu göster (avatar + biyografi).
     */
    public function editProfile(): View
    {
        $user = Auth::user();

        return view('panel.userpages.editprofile', compact('user'));
    }

    /**
     * Avatar ve biyografiyi güncelle.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'bio' => 'nullable|string|max:160',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_avatar' => 'nullable|boolean',
        ], [
            'bio.max' => 'Biyografi en fazla 160 karakter olabilir.',
            'avatar.image' => 'Yalnızca resim dosyası yükleyebilirsiniz.',
            'avatar.mimes' => 'İzin verilen formatlar: jpg, jpeg, png, webp.',
            'avatar.max' => 'Resim boyutu en fazla 2MB olabilir.',
        ]);

        // Yeni avatar yüklendiyse: eskisini sil, yenisini kaydet
        if ($request->hasFile('avatar')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $user->profile_photo_path = $request->file('avatar')->store('avatars', 'public');
        }
        // Avatar kaldırma isteği geldiyse (yeni dosya yoksa)
        elseif ($request->boolean('remove_avatar') && $user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $user->profile_photo_path = null;
        }

        $user->bio = $validated['bio'] ?? null;
        $user->save();

        return redirect()->route('panel.user.editProfile')
            ->with('success', 'Profiliniz başarıyla güncellendi.');
    }
}
