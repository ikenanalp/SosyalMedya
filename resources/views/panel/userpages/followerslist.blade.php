@extends('panel.layouts.app')

@section('title')
    {{ $listType === 'followers' ? $profileUser->username . ' - Takipçiler' : $profileUser->username . ' - Takip Edilenler' }}
@endsection

@section('content')

    <div class="feed">

        <a href="{{ route('panel.user.showProfile', $profileUser->id) }}" class="back-link">← {{ $profileUser->username }} profiline dön</a>

        <h1 class="feed-heading">
            <span class="feed-kicker">{{ $listType === 'followers' ? 'Takipçiler' : 'Takip Edilenler' }}</span>
            {{ $profileUser->username }}
            {{ $listType === 'followers' ? "'ı takip edenler" : "'ın takip ettikleri" }}
        </h1>

        {{-- Sekmeler --}}
        <div class="search-card" style="display:flex; gap:8px;">
            <a href="{{ route('panel.user.followers', $profileUser->id) }}"
               class="follow-btn {{ $listType === 'followers' ? 'following' : '' }}">
                Takipçiler
            </a>
            <a href="{{ route('panel.user.following', $profileUser->id) }}"
               class="follow-btn {{ $listType === 'following' ? 'following' : '' }}">
                Takip Edilenler
            </a>
        </div>

        {{-- Kullanıcı Listesi --}}
        @forelse ($users as $listedUser)
            <div class="user-card">
                <div class="user-card-left">
                    @include('panel.partials.avatar', ['user' => $listedUser, 'size' => 'md'])
                    <span class="user-card-text">
                        <span class="username">{{ $listedUser->username }}</span>
                        @if (!empty($listedUser->bio))
                            <span class="user-card-bio">{{ $listedUser->bio }}</span>
                        @else
                            <span class="user-handle">&#64;{{ $listedUser->username }}</span>
                        @endif
                    </span>
                </div>

                <div style="display:flex; align-items:center; gap:10px;">
                    @if (auth()->check() && auth()->id() !== $listedUser->id)
                        @php
                            $isFollowingListed = \App\Models\Follower::where('follower_id', auth()->id())
                                ->where('following_id', $listedUser->id)
                                ->exists();
                        @endphp
                        <form action="{{ route('user.toggleFollow', $listedUser->id) }}" method="post">
                            @csrf
                            <button type="submit" class="follow-btn {{ $isFollowingListed ? 'following' : '' }}">
                                {{ $isFollowingListed ? 'Takibi Bırak' : 'Takip Et' }}
                            </button>
                        </form>
                    @endif

                    <a class="view-profile-btn" href="{{ route('panel.user.showProfile', $listedUser->id) }}">
                        Profili Gör
                    </a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-people"></i>
                <p>
                    @if ($listType === 'followers')
                        {{ $profileUser->username }} henüz kimse tarafından takip edilmiyor.
                    @else
                        {{ $profileUser->username }} henüz kimseyi takip etmiyor.
                    @endif
                </p>
            </div>
        @endforelse

        {{-- Sayfalama --}}
        <div class="pagination-wrap">
            {{ $users->links() }}
        </div>

    </div>

@endsection
