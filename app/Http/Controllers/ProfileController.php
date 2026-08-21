<?php

namespace App\Http\Controllers;

use App\Models\UserAvatar;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Profil düzenleme formunu göster (avatar + biyografi + kullanıcı adı).
     */
    public function editProfile(): View
    {
        $user = Auth::user();

        return view('panel.userpages.editprofile', compact('user'));
    }

    /**
     * Avatar, biyografi ve kullanıcı adını güncelle.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => [
                'required', 'string', 'min:3', 'max:50',
                'regex:/^[a-zA-Z0-9._]+$/',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'bio' => 'nullable|string|max:160',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_avatar' => 'nullable|boolean',
        ], [
            'username.required' => 'Kullanıcı adı boş olamaz.',
            'username.min' => 'Kullanıcı adı en az 3 karakter olmalı.',
            'username.max' => 'Kullanıcı adı en fazla 50 karakter olabilir.',
            'username.regex' => 'Kullanıcı adı yalnızca harf, rakam, nokta ve alt çizgi içerebilir.',
            'username.unique' => 'Bu kullanıcı adı zaten alınmış.',
            'bio.max' => 'Biyografi en fazla 160 karakter olabilir.',
            'avatar.image' => 'Yalnızca resim dosyası yükleyebilirsiniz.',
            'avatar.mimes' => 'İzin verilen formatlar: jpg, jpeg, png, webp.',
            'avatar.max' => 'Resim boyutu en fazla 2MB olabilir.',
        ]);

        // Yeni avatar yüklendiyse: eskisini SİLMEDEN geçmişe ekle, yenisini aktif yap
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');

            $user->avatars()->create([
                'image_url' => $path,
                'position' => $user->avatars()->count(),
            ]);

            $user->profile_photo_path = $path;
        }
        // Avatar kaldırma isteği geldiyse (yeni dosya yoksa) — sadece aktif göstergeyi temizle,
        // geçmiş fotoğraflar silinmez, kullanıcı istediğinde tekrar birini seçebilir.
        elseif ($request->boolean('remove_avatar')) {
            $user->profile_photo_path = null;
        }

        $user->username = $validated['username'];
        $user->bio = $validated['bio'] ?? null;
        $user->save();

        return redirect()->route('panel.user.editProfile')
            ->with('success', 'Profiliniz başarıyla güncellendi.');
    }

    /**
     * Geçmişteki bir avatarı tekrar aktif profil fotoğrafı yapar.
     */
    public function useAvatar(UserAvatar $avatar): RedirectResponse
    {
        if ($avatar->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Bu işlemi yapma yetkiniz yok.');
        }

        $user = Auth::user();
        $user->profile_photo_path = $avatar->image_url;
        $user->save();

        return redirect()->route('panel.user.editProfile')
            ->with('success', 'Profil fotoğrafınız güncellendi.');
    }

    /**
     * Geçmişteki bir avatarı kalıcı olarak siler (şu an aktif olan hariç).
     */
    public function deleteAvatar(UserAvatar $avatar): RedirectResponse
    {
        $user = Auth::user();

        if ($avatar->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Bu işlemi yapma yetkiniz yok.');
        }

        if ($user->profile_photo_path === $avatar->image_url) {
            return redirect()->back()->with('error', 'Şu anda kullanılan avatarı silemezsiniz. Önce başka birini seçin.');
        }

        Storage::disk('public')->delete($avatar->image_url);
        $avatar->delete();

        return redirect()->route('panel.user.editProfile')
            ->with('success', 'Avatar silindi.');
    }
}
