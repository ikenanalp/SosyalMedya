@extends('panel.admin.layouts.app')

@section('title', 'Onaylanan Postlar')
@section('page-title', 'Onaylanan Postlar')

@section('content')

    @forelse ($posts as $post)
        <div class="review-card">
            <div class="review-card__head">
                <div class="review-user">
                    <div class="review-user__avatar">
                        @if (!empty($post->user->profile_photo_path))
                            <img src="{{ asset('storage/' . $post->user->profile_photo_path) }}" alt="{{ $post->user->username }}">
                        @else
                            {{ strtoupper(substr($post->user->username, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="review-user__name">{{ $post->user->username }}</div>
                        <div class="review-user__time">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                <span class="badge-pill badge-pill--approved"><i class="bi bi-check-circle"></i> Onaylandı</span>
            </div>

            @if ($post->content)
                <p class="review-card__content">{{ $post->content }}</p>
            @endif

            @if ($post->images->count() > 0)
                <div class="review-images {{ $post->images->count() > 1 ? 'multi' : '' }}">
                    @foreach ($post->images as $img)
                        <img src="{{ asset('storage/' . $img->image_url) }}" alt="Gönderi resmi">
                    @endforeach
                </div>
            @endif

            <div class="review-card__meta">
                <span><strong>Kabul Eden:</strong> {{ $post->approver->username ?? '—' }}</span>
                @if ($post->approved_at)
                    <span>{{ $post->approved_at->diffForHumans() }}</span>
                @endif
            </div>
        </div>
    @empty
        <div class="a-empty">
            <i class="bi bi-inbox"></i>
            <p>Henüz onaylanmış post yok.</p>
        </div>
    @endforelse

    <div class="pagination-wrap">
        {{ $posts->links() }}
    </div>

@endsection
