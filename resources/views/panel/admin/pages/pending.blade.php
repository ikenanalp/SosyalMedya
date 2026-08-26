@extends('panel.admin.layouts.app')

@section('title', 'Post Onaylama')
@section('page-title', 'Onay Bekleyen Paylaşımlar')

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
                <span class="badge-pill badge-pill--pending"><i class="bi bi-hourglass-split"></i> Onay Bekliyor</span>
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

            <div class="review-card__actions">
                <form action="{{ route('posts.approve', $post) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-a btn-a--success">
                        <i class="bi bi-check-circle"></i> Onayla
                    </button>
                </form>

                <form action="{{ route('posts.reject', $post) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-a btn-a--danger">
                        <i class="bi bi-x-circle"></i> Reddet
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="a-empty">
            <i class="bi bi-inbox"></i>
            <p>Şu anda moderasyon bekleyen herhangi bir paylaşım bulunmuyor.</p>
        </div>
    @endforelse

    <div class="pagination-wrap">
        {{ $posts->links() }}
    </div>

@endsection
