@extends('panel.layouts.app')

@section('title')
Profilim
@endsection

@section('content')

    <div class="card shadow-sm border-0 rounded-4 mt-3 mb-5">
        <div class="card-body">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center fw-bold"
                     style="width: 64px; height: 64px; font-size: 1.5rem; color: #f8f9fa;">
                    {{ strtoupper(substr($user->username, 0, 1)) }}
                </div>

                <div>
                    <h4 class="fw-bold mb-1 text-dark">{{ $user->username }}</h4>
                    <div class="d-flex gap-3 mb-2">
                        <span class="small text-muted"><strong class="text-dark">{{ $followersCount }}</strong> Takipçi</span>
                        <span class="small text-muted"><strong class="text-dark">{{ $followingCount }}</strong> Takip</span>
                    </div>

                    @if (auth()->check() && auth()->id() !== $user->id)
                        <form action="{{ route('user.toggleFollow', $user->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $isFollowing ? 'btn-outline-danger' : 'btn-primary' }} rounded-pill px-4">
                                {{ $isFollowing ? 'Takibi Bırak' : 'Takip Et' }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @foreach($post as $p)
        <div class="card shadow-sm mb-3 border-0 rounded-4">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                         style="width: 40px; height: 40px; font-weight: bold; font-size: 18px;">
                        {{ strtoupper(substr($p->user->username, 0, 1)) }}
                    </div>
                    <span class="fw-semibold">{{ $p->user->username }}</span>
                </div>

                <p class="card-text mb-3">{{ $p->content }}</p>

                @php
                    $likeCount = $p->likes()->count();
                    $commentCount = $p->comments()->count();
                    $isLiked = $p->likes()->where('user_id', auth()->id())->exists();
                @endphp

                {{-- Beğeni ve yorum sayısı --}}
                <div class="d-flex gap-3 text-muted mb-2">
                <span>
                    <i class="bi {{ $isLiked ? 'bi-heart-fill text-danger' : 'bi-heart' }} me-1"></i>
                    {{ $likeCount }}
                </span>
                    <span>
                    <i class="bi bi-chat me-1"></i>
                    {{ $commentCount }}
                </span>
                    <span><small>{{ $p->created_at->locale('tr')->diffForHumans() }}</small></span>
                </div>

                {{-- Sil butonu --}}
                <form action="{{ route('panel.user.deletePost', $p->id) }}" method="post"
                      onsubmit="return confirm('Bu gönderiyi silmek istediğinize emin misiniz?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-trash me-1"></i> Sil
                    </button>
                </form>
            </div>
        </div>
    @endforeach


@endsection
