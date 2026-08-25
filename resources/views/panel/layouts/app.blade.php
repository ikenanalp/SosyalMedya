<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Lora:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/panel.css') }}">

    @stack('styles')
</head>

<body>

<header class="sm-header">
    <div class="sm-header-inner">

        <a href="{{ route('panel.user.showMainPage') }}" class="sm-brand">
            <i class="bi bi-hexagon"></i>
            <span>Sosyal Medya</span>
        </a>

        <div class="sm-header-right">

            <div class="nav-divider"></div>

            <button class="sm-toggle" type="button" id="navToggle" aria-controls="mainNav" aria-expanded="false" aria-label="Menüyü aç/kapat">
                <i class="bi bi-list"></i>
            </button>

            <div class="nav-menu" id="mainNav">
                <nav class="sm-nav">
                    <a class="{{ request()->routeIs('panel.user.showMainPage') ? 'is-active' : '' }}" href="{{ route('panel.user.showMainPage') }}">
                        <i class="bi bi-house"></i> Anasayfa
                    </a>
                    <a class="{{ request()->routeIs('panel.user.showMyFollowingPage') ? 'is-active' : '' }}" href="{{ route('panel.user.showMyFollowingPage') }}">
                        <i class="bi bi-people"></i> Takip Ettiklerim
                    </a>
                    <a class="{{ request()->routeIs('panel.user.showFindUserPage') ? 'is-active' : '' }}" href="{{ route('panel.user.showFindUserPage') }}">
                        <i class="bi bi-search"></i> Kullanıcı Ara
                    </a>
                    <a class="{{ request()->routeIs('panel.user.showCreatePost') ? 'is-active' : '' }}" href="{{ route('panel.user.showCreatePost') }}">
                        <i class="bi bi-plus-circle"></i> Gönderi Oluştur
                    </a>
                    <a class="{{ request()->routeIs('panel.user.showProfilePage') ? 'is-active' : '' }}" href="{{ route('panel.user.showProfilePage') }}">
                        <i class="bi bi-person"></i> Profil
                    </a>
                    <a class="{{ request()->routeIs('feedback.index') ? 'is-active' : '' }}" href="{{ route('feedback.index') }}">
                        <i class="bi bi-chat-square-text"></i> Şikayet/Öneri
                    </a>

                    @if(auth()->check() && auth()->user()->role == 1)
                        <a class="is-admin" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Admin Paneli
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sm-logout">
                            <i class="bi bi-box-arrow-right"></i>
                            {{ __('Çıkış Yap') }}
                        </button>
                    </form>
                </nav>
            </div>

        </div>

    </div>
</header>

<main class="sm-main">
    @yield('content')
</main>

<script>
    document.getElementById('navToggle')?.addEventListener('click', function () {
        var menu = document.getElementById('mainNav');
        var expanded = this.getAttribute('aria-expanded') === 'true';
        this.setAttribute('aria-expanded', String(!expanded));
        menu.classList.toggle('nav-menu-open');
    });
</script>

@yield('scripts')

</body>
</html>
