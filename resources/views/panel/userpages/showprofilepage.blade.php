@php use App\Models\Follower; @endphp
@extends('panel.layouts.app')

@section('title')
    {{ $user->username }}
@endsection

@section('content')

    <div class="feed">

        {{-- Profil Başlığı --}}
        <div class="profile-card">
           {{-- @include('panel.partials.avatar', ['user' => $user, 'size' => 'lg']) --}}

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
                    <span><strong>{{ $followersCount }}</strong> Takipçi</span>
                    <span><strong>{{ $followingCount }}</strong> Takip</span>
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

                <div class="post-meta">
                    <span class="meta-item">
                        <i class="bi bi-clock"></i>
                        {{ $p->created_at->locale('tr')->diffForHumans() }}
                    </span>
                </div>
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
