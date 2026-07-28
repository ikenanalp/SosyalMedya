@extends('panel.layouts.app')

@section('title')
Kullanıcı Ara
@endsection

@section('content')

    <div class="container py-5">
        <!-- Arama Formu -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <form action="{{ route('panel.user.showFindUserPage') }}" method="GET" class="d-flex gap-2">
                    <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                        <input
                            type="text"
                            name="query"
                            class="form-control border-start-0 ps-0"
                            placeholder="Kullanıcı adı veya isim ara..."
                            value="{{ $query }}"
                        >
                    </div>
                    <button type="submit" class="btn btn-primary px-4">Ara</button>
                </form>
            </div>
        </div>

        <!-- Kullanıcı Listesi -->
        <div class="d-flex flex-column gap-2">
            @forelse ($users as $user)
                <div class="card shadow-sm border-0 user-card">
                    <div class="card-body d-flex align-items-center justify-content-between py-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center fw-bold me-3"
                                 style="width: 42px; height: 42px; font-size: 1.1rem; color: #f8f9fa;">
                                {{ strtoupper(substr($user->username, 0, 1)) }}
                            </div>
                            <span class="username fw-semibold text-dark">&#64;{{ $user->username }}</span>
                        </div>
                        <a class="btn btn-outline-primary btn-sm view-profile"
                           href="{{ route('panel.user.showProfile', $user->id) }}">
                            Profili Gör
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-person-x display-4 text-muted mb-3 d-block"></i>
                    <p class="empty text-muted fs-5 mb-0">
                        @if($query)
                            "{{ $query }}" kullanıcı adıyla eşleşen sonuç bulunamadı.
                        @else
                            Aramaya başlamak için yukarıya yazın.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Sayfalama -->
        <div class="d-flex justify-content-center mt-4">
            {{ $users->appends(['query' => $query])->links() }}
        </div>
    </div>

    <style>
        .user-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .user-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.12) !important;
        }

        .input-group:focus-within .input-group-text {
            border-color: #86b7fe;
        }

        .input-group input:focus {
            box-shadow: none;
        }

        .view-profile {
            white-space: nowrap;
        }
    </style>


@endsection
