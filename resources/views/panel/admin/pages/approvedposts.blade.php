@extends('panel.admin.layouts.app')

@section('title')

@endsection

@section('content')

    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <h2 class="text-center text-success fw-bold mb-4">
                    Onaylanan Postlar
                </h2>

                @forelse($posts as $post)

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">
                                    {{ $post->user->username }}
                                </h5>

                                <span class="badge bg-success">
                                Onaylandı
                            </span>
                            </div>

                            <p class="card-text fs-6">
                            @if ($post->content)
                                <p class="card-text mb-2">{{ $post->content }}</p>
                            @endif

                            @if ($post->images->count() > 0)
                                <div class="row g-1">
                                    @foreach ($post->images as $img)
                                        <div class="{{ $post->images->count() === 1 ? 'col-12' : 'col-6' }}">
                                            <img src="{{ asset('storage/' . $img->image_url) }}" class="img-fluid rounded-3" alt="Gönderi resmi">
                                        </div>
                                    @endforeach
                                </div>
                                @endif
                            </p>

                            <hr>

                            <div class="d-flex justify-content-between text-muted small">
                            <span>
                                <strong>Kabul Eden:</strong>
                                {{ $post->approver->username ?? '—' }}
                            </span>

                                @if($post->approved_at)
                                    <span>
                                    {{ $post->approved_at->diffForHumans() }}
                                </span>
                                @endif
                            </div>

                        </div>
                    </div>

                @empty

                    <div class="alert alert-info text-center">
                        Henüz onaylanmış post yok.
                    </div>

                @endforelse

                <div class="d-flex justify-content-center mt-4">
                    {{ $posts->links() }}
                </div>


            </div>
        </div>

    </div>
@endsection
