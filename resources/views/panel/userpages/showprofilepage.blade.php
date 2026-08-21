@php use App\Models\Follower; @endphp
@extends('panel.layouts.app')

@section('title')
    {{ $user->username }}
@endsection

@section('content')

    <div class="feed">

        {{-- Profil Başlığı --}}
        <div class="profile-card">
            <span class="avatar avatar-lg">
                    @if (!empty($user->profile_photo_path))
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->username }}">
                @else
                    <span class="avatar-initial">{{ strtoupper(substr($user->username, 0, 1)) }}</span>
                @endif
                </span>

            <div class="profile-info">
                <h1 class="profile-name">{{ $user->username }}</h1>
                <span class="profile-handle">&#64;{{ $user->username }}</span>

                @if (!empty($user->bio))
                    <p class="profile-bio">{{ $user->bio }}</p>
                @else
                    <p class="profile-bio profile-bio-empty">Bu kullanıcı henüz bir biyografi eklemedi.</p>
                @endif

                @php
                    $isFollowing = Follower::where('follower_id', auth()->id())
                        ->where('following_id', $user->id)
                        ->exists();

                    $followersCount = Follower::where('following_id', $user->id)->count();
                    $followingCount = Follower::where('follower_id', $user->id)->count();
                @endphp

                <div class="profile-stats">
                    <span><strong>{{ $posts->total() }}</strong> Gönderi</span>
                    <a href="{{ route('panel.user.followers', $user->id) }}"><strong>{{ $followersCount }}</strong> Takipçi</a>
                    <a href="{{ route('panel.user.following', $user->id) }}"><strong>{{ $followingCount }}</strong> Takip</a>
                </div>

                @if (auth()->id() !== $user->id)
                    <div class="profile-actions">
                        <form action="{{ route('user.toggleFollow', $user->id) }}" method="post">
                            @csrf
                            <button type="submit" class="follow-btn {{ $isFollowing ? 'following' : '' }}">
                                {{ $isFollowing ? 'Takibi Bırak' : 'Takip Et' }}
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        {{-- Gönderiler --}}
        @forelse ($posts as $p)
            <div class="post-card">
                <div class="post-header">
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
                        <button type="submit" class="like-btn {{ $isLiked ? 'liked' : '' }}"
                                aria-label="{{ $isLiked ? 'Beğeniyi kaldır' : 'Beğen' }}">
                            <i class="bi {{ $isLiked ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                        </button>
                        <span class="like-count">{{ $likeCount }} beğeni</span>
                    </form>

                    <span class="post-time">
                        <i class="bi bi-clock"></i>
                        {{ $p->created_at->locale('tr')->diffForHumans() }}
                    </span>
                </div>

                {{-- Yorumlar --}}
                <div class="comments">
                    @forelse ($p->comments()->latest()->with(['user', 'images'])->get() as $com)
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

                {{-- Yorum ekleme --}}
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
                <i class="bi bi-inbox"></i>
                <p>Bu kullanıcının henüz gönderisi yok.</p>
            </div>
        @endforelse

        {{-- Sayfalama --}}
        <div class="pagination-wrap">
            {{ $posts->links() }}
        </div>

    </div>

@endsection
