@extends('panel.layouts.app')

@section('title')
    Şikayet / Önerilerim
@endsection

@section('content')

    <div class="feed">

        <div class="page-head">
            <h1><span class="feed-kicker">Geri Bildirim</span>Şikayet / Önerilerim</h1>
            <a href="{{ route('feedback.create') }}" class="view-profile-btn">
                <i class="bi bi-plus"></i> Yeni Gönder
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="fb-list">
            @forelse ($feedbackList as $item)
                @php
                    $statusClass = match($item->status) {
                        0 => 'is-pending',
                        1 => 'is-review',
                        2 => 'is-done',
                        3 => 'is-rejected',
                        default => '',
                    };
                    $statusText = match($item->status) {
                        0 => 'Beklemede',
                        1 => 'İnceleniyor',
                        2 => 'Çözüldü',
                        3 => 'Reddedildi',
                        default => '-',
                    };
                @endphp
                <a href="{{ route('feedback.show', $item) }}" class="fb-row">
                    <span>
                        <span class="fb-subject">{{ $item->subject }}</span>
                        <span class="fb-meta">
                            {{ $item->type == 1 ? 'Şikayet' : 'Öneri' }} · {{ $item->created_at->format('d.m.Y H:i') }}
                        </span>
                    </span>
                    <span class="status-tag {{ $statusClass }}">{{ $statusText }}</span>
                </a>
            @empty
                <div class="empty-state">
                    <i class="bi bi-chat-square-text"></i>
                    <p>Henüz gönderdiğin bir şikayet/öneri yok.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrap">
            {{ $feedbackList->links() }}
        </div>

    </div>

@endsection
