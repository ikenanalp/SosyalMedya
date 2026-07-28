<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Giriş Yap') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body p-4">

                    {{-- Validasyon hataları --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Session status mesajı --}}
                    @session('status')
                    <div class="alert alert-success">
                        {{ $value }}
                    </div>
                    @endsession

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('E-posta') }}</label>
                            <input id="email" type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required autofocus autocomplete="username">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Şifre') }}</label>
                            <input id="password" type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   required autocomplete="current-password">
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                            <label class="form-check-label" for="remember_me">
                                {{ __('Beni hatırla') }}
                            </label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none small" href="{{ route('password.request') }}">
                                    {{ __('Şifrenizi mi unuttunuz?') }}
                                </a>
                            @endif

                            <button type="submit" class="btn btn-primary">
                                {{ __('Giriş Yap') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
