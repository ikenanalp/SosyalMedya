@extends('panel.layouts.app')

@section('title')
Ana Sayfa
@endsection

@section('content')


    @foreach($post as $p)
        <div class="card shadow-sm border-0 mt-3 rounded-4">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center fw-bold me-2"
                         style="width: 36px; height: 36px; font-size: 1rem; color: #f8f9fa;">
                        {{ strtoupper(substr($p->user->username, 0, 1)) }}
                    </div>
                    <span class="fw-semibold text-dark">{{ $p->user->username }}</span>
                </div>
                @if ($p->content)
                    <p class="card-text mb-2">{{ $p->content }}</p>
                @endif

                @if ($p->images->count() > 0)
                    <div class="row g-1">
                        @foreach ($p->images as $img)
                            <div class="{{ $p->images->count() === 1 ? 'col-12' : 'col-6' }}">
                                <img src="{{ asset('storage/' . $img->image_url) }}" class="img-fluid rounded-3" alt="Gönderi resmi">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            @php
                $likeCount = $p->likes()->count();
                $isLiked = $p->likes()->where('user_id', auth()->id())->exists();
            @endphp

            <div class="px-3 pb-2 d-flex align-items-center gap-3">
                <form action="{{ route('user.likeSystem', $p->id) }}" method="post" class="d-flex align-items-center gap-1">
                    @csrf
                    <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent">
                        @if ($isLiked)
                            <i class="bi bi-heart-fill text-danger fs-5"></i>
                        @else
                            <i class="bi bi-heart text-secondary fs-5"></i>
                        @endif
                    </button>
                    <span class="small text-muted">{{ $likeCount }}</span>
                </form>
            </div>

            {{-- Yorumlar --}}
            <div class="bg-light border-top px-3 py-2">
                @forelse($p->comments()->latest()->with('user')->get() as $com)
                    <div class="d-flex align-items-start gap-2 py-2 border-bottom">
                        <div class="bg-secondary bg-gradient rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                             style="width: 26px; height: 26px; font-size: 0.7rem; color: #f8f9fa;">
                            {{ strtoupper(substr($com->user->username, 0, 1)) }}
                        </div>
                        <div class="d-flex flex-column small flex-grow-1">
                            <span class="fw-semibold text-primary">{{ $com->user->username }}</span>
                            <span class="text-dark">{{ $com->comment }}</span>
                        </div>

                        @if (auth()->id() === $com->user_id)
                            <form action="{{ route('user.deleteComment', $com->id) }}" method="post" onsubmit="return confirm('Bu yorumu silmek istediğinize emin misiniz?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-link text-danger p-0">Sil</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-muted small mb-0 py-2">Henüz yorum yapılmamış.</p>
                @endforelse
            </div>

            {{-- Yorum ekleme formu --}}
            <form action="{{ route('user.createComment', $p->id) }}" method="post" class="d-flex gap-2 border-top p-3">
                @csrf
                <input type="text" name="comment" class="form-control rounded-pill" placeholder="Bir yorum yazınız...">
                <button type="submit" class="btn btn-primary rounded-pill px-4">Gönder</button>
            </form>
        </div>
    @endforeach


@endsection
