<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    public function toggleFollow($id)
    {
        // Kendini takip etmeyi engelle
        if ((int) $id === Auth::id()) {
            return redirect()->back()->with('error', 'Kendinizi takip edemezsiniz.');
        }

        // Soft-delete edilmişler dahil ara (like sistemindeki hatayı tekrarlamamak için)
        $follow = Follower::withTrashed()
            ->where('follower_id', Auth::id())
            ->where('following_id', $id)
            ->first();

        if ($follow) {
            if ($follow->trashed()) {
                // Daha önce takipten çıkılmış -> tekrar takip et
                $follow->restore();
            } else {
                // Aktif takip -> takibi bırak
                $follow->delete();
            }
        } else {
            // Hiç yok -> yeni takip kaydı oluştur
            Follower::create([
                'follower_id' => Auth::id(),
                'following_id' => $id,
            ]);
        }

        return redirect()->back();
    }
}
