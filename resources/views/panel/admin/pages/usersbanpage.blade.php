@extends('panel.admin.layouts.app')

@section('title', 'Kullanıcılar')
@section('page-title', 'Kullanıcılar')
@section('page-subtitle', 'Kural ihlali yapan kullanıcıları banlayabilir, banı kaldırabilirsiniz.')

@section('content')

    @if (session('success'))
        <div class="alert-a alert-a--success">
            <span>{{ session('success') }}</span>
            <button type="button" class="alert-a__close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert-a alert-a--danger">
            <span>{{ session('error') }}</span>
            <button type="button" class="alert-a__close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="a-card">
        <div class="user-list">
            @foreach ($users as $user)
                <div class="user-row">
                    <div class="user-row__info">
                        <div class="user-row__name">
                            {{ $user->username }}
                            @if ($user->is_banned)
                                <span class="badge-pill badge-pill--banned">Banlı</span>
                            @endif
                        </div>
                        <div class="user-row__email">{{ $user->email }}</div>
                        @if ($user->is_banned && $user->ban_reason)
                            <div class="user-row__reason"><strong>Ban Sebebi:</strong> {{ $user->ban_reason }}</div>
                        @endif
                    </div>

                    <div class="user-row__actions">
                        @if (! $user->is_banned)
                            <form action="{{ route('users.ban', $user) }}" method="POST" class="ban-form">
                                @csrf
                                <input type="text" name="ban_reason" placeholder="Ban sebebi" required>
                                <button type="submit" class="btn-a btn-a--danger btn-a--sm">Banla</button>
                            </form>
                        @else
                            <form action="{{ route('users.unban', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-a btn-a--success btn-a--sm">Banı Kaldır</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="pagination-wrap">
        {{ $users->links() }}
    </div>

@endsection
