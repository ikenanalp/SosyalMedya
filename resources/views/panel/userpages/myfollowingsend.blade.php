@extends('panel.layouts.app')

@section('title')
    Takip Ettiklerim
@endsection

@section('content')

    <div class="feed">

        <h1 class="feed-heading">
            <span class="feed-kicker">Takip Ettiklerim</span>
            Takip Ettiklerinin Gönderileri
        </h1>

        @forelse($post as $p)
            <div class="post-card">
                <div class="post-header">
                    <div class="post-user">
                        <span class="avatar">
                    @if (!empty($p->user->profile_photo_path))
                                <img src="{{ asset('storage/' . $p->user->profile_photo_path) }}" alt="{{ $p->user->username }}">
                            @else
                                <span class="avatar-initial">{{ strtoupper(substr($p->user->username, 0, 1)) }}</span>
                            @endif
                </span>
                        <span class="post-user-text">
                               <a href="{{ route('panel.user.showProfile', $p->user->id) }}" class="username">{{ $p->user->username }}</a>
                               <span class="post-date">{{ $p->created_at->locale('tr')->diffForHumans() }}</span>
                           </span>
                    </div>

                    @if ($p->content)
                        <p class="post-content">{{ $p->content }}</p>
                    @endif
                </div>

                @if ($p->images->count() > 0)
                    <div class="post-images {{ $p->images->count() > 1 ? 'multi' : '' }}">
                        @foreach ($p->images as $img)
                            <div class="post-image-wrap">
                                <img src="{{ asset('storage/' . $img->image_url) }}" alt="Gönderi resmi">
                            </div>
                        @endforeach
                    </div>
                @endif

                @php
                    $likeCount = $p->likes()->count();
                    $isLiked = $p->likes()->where('user_id', auth()->id())->exists();
                @endphp

                <div class="post-actions">
                    <form action="{{ route('user.likeSystem', $p->id) }}" method="post" class="like-form">
                        @csrf
                        <button type="submit" class="like-btn {{ $isLiked ? 'liked' : '' }}" aria-label="Beğen">
                            <i class="bi {{ $isLiked ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                        </button>
                        <span class="like-count">{{ $likeCount }} beğeni</span>
                    </form>
                </div>

                {{-- Yorumlar --}}
                <div class="comments">
                    @forelse($p->comments()->latest()->with(['user', 'images'])->get() as $com)
                        <div class="comment">
                            <span class="avatar avatar-sm">
                    @if (!empty($com->user->profile_photo_path))
                                    <img src="{{ asset('storage/' . $com->user->profile_photo_path) }}" alt="{{ $com->user->username }}">
                                @else
                                    <span class="avatar-initial">{{ strtoupper(substr($com->user->username, 0, 1)) }}</span>
                                @endif
                </span>
                            <div class="comment-body">
                                <a href="{{ route('panel.user.showProfile', $com->user->id) }}" class="comment-username">{{ $com->user->username }}</a>
                                @if ($com->comment)
                                    <span class="comment-text">{{ $com->comment }}</span>
                                @endif
                                @if ($com->images->count() > 0)
                                    <div class="comment-images {{ $com->images->count() > 1 ? 'multi' : '' }}">
                                        @foreach ($com->images as $img)
                                            <img src="{{ asset('storage/' . $img->image_url) }}" alt="Yorum resmi">
                                        @endforeach
                                    </div>
                                @endif
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
                <form action="{{ route('user.createComment', $p->id) }}" method="post" class="comment-form" enctype="multipart/form-data">
                    @csrf
                    <label class="comment-attach-label">
                        <i class="bi bi-image"></i>
                        <input type="file" name="images[]" class="comment-attach-input" accept="image/*" multiple
                               onchange="this.closest('.comment-attach-label').classList.toggle('has-file', this.files.length>0)">
                    </label>
                    <input type="text" name="comment" placeholder="Bir yorum yazınız..." class="comment-input" required>
                    <button type="submit" class="comment-submit">Gönder</button>
                </form>
            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-people"></i>
                <p>Takip ettiğin kişilerin henüz gönderisi yok.</p>
            </div>
        @endforelse
    </div>

@endsection
