@extends('panel.layouts.app')

@section('headcss')
    /* ===== Genel Ayarlar ===== */
    :root {
    --primary: #6366f1;
    --primary-dark: #4f46e5;
    --danger: #ef4444;
    --text-main: #1a1a2e;
    --text-muted: #6b7280;
    --border: #eef0f4;
    --bg: #f4f5f9;
    --card-bg: #ffffff;
    --radius: 16px;
    --shadow: 0 2px 10px rgba(20, 20, 43, 0.06);
    --shadow-hover: 0 6px 20px rgba(20, 20, 43, 0.1);
    }

    body {
    }

    /* ===== Akış Kapsayıcı ===== */
    .feed {
    max-width: 600px;
    margin: 32px auto;
    display: flex;
    flex-direction: column;
    gap: 24px;
    padding: 0 16px;
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    color: var(--text-main);
    }

    /* ===== Gönderi Kartı ===== */
    .post-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    transition: box-shadow 0.2s ease, transform 0.2s ease;
    }

    .post-card:hover {
    box-shadow: var(--shadow-hover);
    }

    .post-header {
    padding: 18px 20px 4px;
    }

    .post-user {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 10px;
    }

    .avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), #a855f7);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 15px;
    flex-shrink: 0;
    box-shadow: 0 2px 6px rgba(99, 102, 241, 0.35);
    }

    .avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 13px;
    }

    .username {
    font-weight: 600;
    font-size: 15px;
    color: var(--text-main);
    }

    .post-content {
    font-size: 15px;
    line-height: 1.55;
    margin: 0 0 12px;
    color: #33344a;
    white-space: pre-line;
    }

    /* ===== Gönderi Görselleri ===== */
    .post-images {
    display: grid;
    grid-template-columns: 1fr;
    gap: 3px;
    }

    .post-images.multi {
    grid-template-columns: 1fr 1fr;
    }

    .post-image-wrap {
    overflow: hidden;
    background: #000;
    }

    .post-image-wrap img {
    width: 100%;
    height: 100%;
    max-height: 480px;
    object-fit: cover;
    display: block;
    transition: transform 0.35s ease;
    }

    .post-image-wrap:hover img {
    transform: scale(1.03);
    }

    /* ===== Aksiyonlar (Beğeni) ===== */
    .post-actions {
    padding: 12px 20px;
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    }

    .like-form {
    display: flex;
    align-items: center;
    gap: 8px;
    background: none;
    border: none;
    }

    .like-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 20px;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 6px;
    border-radius: 50%;
    transition: transform 0.15s ease, background 0.15s ease, color 0.15s ease;
    }

    .like-btn:hover {
    background: #fdecec;
    transform: scale(1.1);
    }

    .like-btn.liked {
    color: var(--danger);
    }

    .like-btn:active {
    transform: scale(0.9);
    }

    .like-count {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-muted);
    }

    /* ===== Yorumlar ===== */
    .comments {
    padding: 12px 20px 4px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-height: 260px;
    overflow-y: auto;
    }

    .comment {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    position: relative;
    }

    .comment-body {
    background: var(--bg);
    border-radius: 14px;
    padding: 8px 14px;
    display: flex;
    flex-direction: column;
    gap: 2px;
    max-width: 85%;
    }

    .comment-username {
    font-size: 13px;
    font-weight: 700;
    color: var(--text-main);
    }

    .comment-text {
    font-size: 14px;
    color: #3b3c50;
    line-height: 1.4;
    word-break: break-word;
    }

    .comment-delete-form {
    margin-left: auto;
    }

    .comment-delete-btn {
    background: none;
    border: none;
    color: var(--text-muted);
    font-size: 12px;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 6px;
    transition: color 0.15s ease, background 0.15s ease;
    }

    .comment-delete-btn:hover {
    color: var(--danger);
    background: #fdecec;
    }

    .no-comments {
    font-size: 13px;
    color: var(--text-muted);
    font-style: italic;
    padding: 4px 0 10px;
    }

    /* ===== Yorum Ekleme Formu ===== */
    .comment-form {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 20px 18px;
    }

    .comment-input {
    flex: 1;
    border: 1px solid var(--border);
    background: var(--bg);
    border-radius: 999px;
    padding: 10px 16px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.15s ease, background 0.15s ease;
    }

    .comment-input:focus {
    border-color: var(--primary);
    background: #fff;
    }

    .comment-submit {
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 999px;
    padding: 10px 18px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.15s ease, transform 0.15s ease;
    white-space: nowrap;
    }

    .comment-submit:hover {
    background: var(--primary-dark);
    }

    .comment-submit:active {
    transform: scale(0.96);
    }

    /* ===== Mobil Uyum ===== */
    @media (max-width: 480px) {
    .feed {
    margin: 12px auto;
    gap: 16px;
    padding: 0 8px;
    }

    .post-header {
    padding: 14px 14px 4px;
    }

    .post-actions {
    padding: 10px 14px;
    }

    .comments {
    padding: 10px 14px 4px;
    }

    .comment-form {
    padding: 12px 14px 14px;
    }
    }

@endsection

@section('title')
    Ana Sayfa
@endsection

@section('content')
    <div class="feed">
        @foreach($post as $p)
            <div class="post-card">
                <div class="post-header">
                    <div class="post-user">
                        <div class="avatar">
                            {{ strtoupper(substr($p->user->username, 0, 1)) }}
                        </div>
                        <span class="username">{{ $p->user->username }}</span>
                    </div>
                    @if ($p->content)
                        <p class="post-content">{{ $p->content }}</p>
                    @endif
                    @if ($p->images->count() > 0)
                        <div class="post-images {{ $p->images->count() > 1 ? 'multi' : '' }}">
                            @foreach ($p->images as $img)
                                <div class="post-image-wrap">
                                    <img src="{{ asset('storage/' . $img->image_url) }}" alt="Gönderi resmi">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                @php
                    $likeCount = $p->likes()->count();
                    $isLiked = $p->likes()->where('user_id', auth()->id())->exists();
                @endphp

                <div class="post-actions">
                    <form action="{{ route('user.likeSystem', $p->id) }}" method="post" class="like-form">
                        @csrf
                        <button type="submit" class="like-btn {{ $isLiked ? 'liked' : '' }}">
                            @if ($isLiked)
                                <i class="bi bi-heart-fill"></i>
                            @else
                                <i class="bi bi-heart"></i>
                            @endif
                        </button>
                        <span class="like-count">{{ $likeCount }}</span>
                    </form>
                </div>

                {{-- Yorumlar --}}
                <div class="comments">
                    @forelse($p->comments()->latest()->with('user')->get() as $com)
                        <div class="comment">
                            <div class="avatar avatar-sm">
                                {{ strtoupper(substr($com->user->username, 0, 1)) }}
                            </div>
                            <div class="comment-body">
                                <span class="comment-username">{{ $com->user->username }}</span>
                                <span class="comment-text">{{ $com->comment }}</span>
                            </div>
                            @if (auth()->id() === $com->user_id)
                                <form action="{{ route('user.deleteComment', $com->id) }}" method="post"
                                      class="comment-delete-form"
                                      onsubmit="return confirm('Bu yorumu silmek istediğinize emin misiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="comment-delete-btn">Sil</button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <p class="no-comments">Henüz yorum yapılmamış.</p>
                    @endforelse
                </div>

                {{-- Yorum ekleme formu --}}
                <form action="{{ route('user.createComment', $p->id) }}" method="post" class="comment-form">
                    @csrf
                    <input type="text" name="comment" placeholder="Bir yorum yazınız..." class="comment-input">
                    <button type="submit" class="comment-submit">Gönder</button>
                </form>
            </div>
        @endforeach
    </div>
@endsection
