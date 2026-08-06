@php use App\Models\Follower; @endphp
@extends('panel.layouts.app')
@section('title')
{{$user->username}}
@endsection

@section('content')

    <div class="container py-5">
        <!-- Profil Header -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center fw-bold me-3"
                     style="width: 60px; height: 60px; font-size: 1.5rem; color: #f8f9fa;">
                    {{ strtoupper(substr($user->username, 0, 1)) }}
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-dark">{{ $user->username }}</h4>

                    @php
                        $isFollowing = Follower::where('follower_id', auth()->id())
                            ->where('following_id', $user->id)
                            ->exists();

                        $followersCount = Follower::where('following_id', $user->id)->count();
                        $followingCount = Follower::where('follower_id', $user->id)->count();
                    @endphp

                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="small text-muted"><strong>{{ $followersCount }}</strong> Takipçi</span>
                        <span class="small text-muted"><strong>{{ $followingCount }}</strong> Takip</span>
                    </div>

                    @if (auth()->id() !== $user->id)
                        <form action="{{ route('user.toggleFollow', $user->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $isFollowing ? 'btn-outline-danger' : 'btn-primary' }} rounded-pill px-4">
                                {{ $isFollowing ? 'Takibi Bırak' : 'Takip Et' }}
                            </button>
                        </form>
                    @endif

                    <small class="text-muted">Profil sayfası</small>
                </div>
            </div>
        </div>

        <!-- Gönderiler -->
        <div class="d-flex flex-column gap-3">
            @forelse ($posts as $p)
                <div class="card shadow-sm border-0 post-card">
                    <div class="card-body">
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
                        <div class="d-flex align-items-center text-muted">
                            <i class="bi bi-clock me-1 mt-2"></i>
                            <small class="mt-2">{{ $p->created_at->locale('tr')->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-4 text-muted mb-3 d-block"></i>
                    <p class="text-muted fs-5">Bu kullanıcının henüz gönderisi yok.</p>
                </div>
            @endforelse
        </div>

        <!-- Sayfalama -->
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
        </div>
    </div>

    <style>
        .post-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
        }

        .post-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
    </style>

@endsection
