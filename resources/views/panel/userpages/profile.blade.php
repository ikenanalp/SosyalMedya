@extends('panel.layouts.app')

@section('title')
    Profilim
@endsection

@section('content')

    <div class="feed">

        {{-- Profil Kartı --}}
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
                    <p class="profile-bio profile-bio-empty">Henüz bir biyografi eklenmemiş.</p>
                @endif

                <div class="profile-stats">
                    <span><strong>{{ $post->total() }}</strong> Gönderi</span>
                    <a href="{{ route('panel.user.followers', $user->id) }}"><strong>{{ $followersCount }}</strong> Takipçi</a>
                    <a href="{{ route('panel.user.following', $user->id) }}"><strong>{{ $followingCount }}</strong> Takip</a>
                </div>

                @if (auth()->check() && auth()->id() !== $user->id)
                    <div class="profile-actions">
                        <form action="{{ route('user.toggleFollow', $user->id) }}" method="post">
                            @csrf
                            <button type="submit" class="follow-btn {{ $isFollowing ? 'following' : '' }}">
                                {{ $isFollowing ? 'Takibi Bırak' : 'Takip Et' }}
                            </button>
                        </form>
                    </div>
                @else
                    <div class="profile-actions">
                        <a href="{{ route('panel.user.editProfile') }}" class="follow-btn">
                            <i class="bi bi-pencil"></i> Profili Düzenle
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Gönderiler --}}
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
                             <span class="username">{{ $p->user->username }}</span>
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
                    $commentCount = $p->comments()->count();
                    $isLiked = $p->likes()->where('user_id', auth()->id())->exists();
                @endphp

                <div class="post-meta">
                     <span class="meta-item">
                         <i class="bi {{ $isLiked ? 'bi-heart-fill liked-icon' : 'bi-heart' }}"></i>
                         {{ $likeCount }}
                     </span>
                    <span class="meta-item">
                         <i class="bi bi-chat"></i>
                         {{ $commentCount }}
                     </span>
                    <span class="meta-date">{{ $p->created_at->locale('tr')->diffForHumans() }}</span>
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

                <form action="{{ route('panel.user.deletePost', $p->id) }}" method="post"
                      class="delete-post-form"
                      onsubmit="return confirm('Bu gönderiyi silmek istediğinize emin misiniz?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-post-btn">
                        <i class="bi bi-trash"></i> Sil
                    </button>
                </form>
            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-pencil"></i>
                <p>Henüz bir gönderi paylaşmadın.</p>
            </div>
        @endforelse

    </div>

@endsection
