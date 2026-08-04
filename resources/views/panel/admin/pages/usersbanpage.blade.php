@extends('panel.admin.layouts.app ')

@section('content')
    <div class="container py-5">

        <div class="card bg-dark text-white shadow-lg border-secondary">

            <div class="card-header border-secondary">
                <h2 class="mb-0">Kullanıcılar</h2>
            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @foreach($users as $user)

                    <div class="card bg-secondary bg-opacity-25 border-secondary text-white mb-3">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center flex-wrap">

                                <div>
                                    <h5 class="mb-1">{{ $user->username }}</h5>
                                    <p class="mb-2 text-light">{{ $user->email }}</p>

                                    @if($user->is_banned)
                                        <span class="badge bg-danger">
                                        Banlı
                                    </span>
                                        <p class="mt-2 mb-0">
                                            <strong>Ban Sebebi:</strong>
                                            {{ $user->ban_reason }}
                                        </p>
                                    @endif
                                </div>

                                <div class="mt-3 mt-md-0">

                                    @if(! $user->is_banned)

                                        <form action="{{ route('users.ban', $user) }}" method="POST">
                                            @csrf

                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    name="ban_reason"
                                                    class="form-control bg-dark text-white border-secondary"
                                                    placeholder="Ban sebebi"
                                                    required
                                                >

                                                <button class="btn btn-danger">
                                                    Banla
                                                </button>
                                            </div>

                                        </form>

                                    @else

                                        <form action="{{ route('users.unban', $user) }}" method="POST">
                                            @csrf

                                            <button class="btn btn-success">
                                                Banı Kaldır
                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </div>

                        </div>
                    </div>

                @endforeach

                <div class="d-flex justify-content-center mt-4">
                    {{ $users->links() }}
                </div>

            </div>
        </div>

    </div>
@endsection
