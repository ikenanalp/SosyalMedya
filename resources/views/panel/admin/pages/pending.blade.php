@extends('panel.admin.layouts.app')

@section('title')

@endsection

@section('content')
    <div class="container mt-4">

        <h3 class="mb-4">Onay Bekleyen Paylaşımlar</h3>

        @forelse($posts as $post)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="card-title mb-0">
                                {{ ucfirst($post->user->username) }}
                            </h5>
                            <small class="text-muted">
                                {{ $post->created_at->diffForHumans() }}
                            </small>
                        </div>

                        <span class="badge bg-warning text-dark">
                        Onay Bekliyor
                    </span>
                    </div>

                    <p class="card-text">
                        {{ $post->content }}
                    </p>

                    <hr>

                    <div class="d-flex gap-2">

                        <form action="{{ route('posts.approve', $post) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i>
                                Onayla
                            </button>
                        </form>

                        <form action="{{ route('posts.reject', $post) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-x-circle"></i>
                                Reddet
                            </button>
                        </form>

                    </div>

                </div>
            </div>

        @empty

            <div class="alert alert-info text-center shadow-sm">
                <h5 class="mb-1">Onay Bekleyen Post Yok</h5>
                <p class="mb-0">Şu anda moderasyon bekleyen herhangi bir paylaşım bulunmuyor.</p>
            </div>

        @endforelse

    </div>

        {{ $posts->links() }}
    </div>
@endsection
