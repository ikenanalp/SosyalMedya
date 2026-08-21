@extends('panel.layouts.app')

@section('title')
    Kullanıcı Ara
@endsection

@section('content')

    <div class="feed">

        <h1 class="feed-heading">
            <span class="feed-kicker">Dizin</span>
            Kullanıcı Ara
        </h1>

        {{-- Arama Formu --}}
        <div class="search-card">
            <form action="{{ route('panel.user.showFindUserPage') }}" method="GET" class="search-form">
                <div class="search-input-wrap">
                    <i class="bi bi-search search-icon"></i>
                    <input
                        type="text"
                        name="query"
                        class="search-input"
                        placeholder="Kullanıcı adı veya isim ara..."
                        value="{{ $query }}"
                    >
                </div>
                <button type="submit" class="search-submit">Ara</button>
            </form>
        </div>

        {{-- Kullanıcı Listesi --}}
        @forelse ($users as $user)
            <div class="user-card">
                <div class="user-card-left">
                    <span class="avatar">
                    @if (!empty($user->profile_photo_path))
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->username }}">
                        @else
                            <span class="avatar-initial">{{ strtoupper(substr($user->username, 0, 1)) }}</span>
                        @endif
                </span>
                    <span class="user-card-text">
                          <span class="username">{{ $user->username }}</span>
                          @if (!empty($user->bio))
                            <span class="user-card-bio">{{ $user->bio }}</span>
                        @else
                            <span class="user-handle">&#64;{{ $user->username }}</span>
                        @endif
                      </span>
                </div>
                <a class="view-profile-btn" href="{{ route('panel.user.showProfile', $user->id) }}">
                    Profili Gör
                </a>
            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-person-x"></i>
                <p>
                    @if($query)
                        "{{ $query }}" ile eşleşen kullanıcı bulunamadı.
                    @else
                        Aramaya başlamak için yukarıya yazın.
                    @endif
                </p>
            </div>
        @endforelse

        {{-- Sayfalama --}}
        <div class="pagination-wrap">
            {{ $users->appends(['query' => $query])->links() }}
        </div>

    </div>

@endsection
