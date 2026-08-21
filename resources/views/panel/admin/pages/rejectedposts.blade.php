@extends('panel.admin.layouts.app')

@section('title', 'Reddedilen Postlar')
@section('page-title', 'Reddedilen Postlar')

@section('content')

    @if (session('success'))
        <div class="alert-a alert-a--success">
            <span>{{ session('success') }}</span>
            <button type="button" class="alert-a__close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @forelse ($posts as $post)
        <div class="review-card">
            <div class="review-card__head">
                <div class="review-user">
                    <div class="review-user__avatar">{{ strtoupper(substr($post->user->username, 0, 1)) }}</div>
                    <div>
                        <div class="review-user__name">{{ $post->user->username }}</div>
                        <div class="review-user__time">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                <span class="badge-pill badge-pill--rejected"><i class="bi bi-x-circle"></i> Reddedildi</span>
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
                <span><strong>Reddeden:</strong> {{ $post->approver->username ?? '—' }}</span>
                @if ($post->approved_at)
                    <span>{{ $post->approved_at->diffForHumans() }}</span>
                @endif
            </div>
        </div>
    @empty
        <div class="a-empty">
            <i class="bi bi-inbox"></i>
            <p>Henüz reddedilen bir post bulunmuyor.</p>
        </div>
    @endforelse

    <div class="pagination-wrap">
        {{ $posts->links() }}
    </div>

@endsection
