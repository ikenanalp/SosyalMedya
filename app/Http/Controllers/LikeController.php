<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function userLike($id)
    {
        $like = Like::withTrashed()
            ->where('user_id', Auth::id())
            ->where('post_id', $id)
            ->first();

        if ($like) {
            if ($like->trashed()) {
                // Daha önce silinmiş -> geri getir (tekrar beğenme)
                $like->restore();
            } else {
                // Aktif -> sil (beğeniyi kaldır)
                $like->delete();
            }
        } else {
            // Hiç yok -> yeni oluştur
            Like::create([
                'user_id' => Auth::id(),
                'post_id' => $id,
            ]);
        }

        return redirect()->back();
    }





}
