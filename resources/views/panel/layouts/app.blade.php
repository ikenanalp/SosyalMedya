<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Arka plan rengi */
        body {
            background-color: #1e1f22;
            color: #e0e0e0;
            font-family: system-ui, -apple-system, sans-serif;
        }

        /* Marka / logo alanı */
        .brand {
            color: #ffffff;
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: 0.02em;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .brand:hover { color: #ffffff; }
        .brand i { color: #7c8cff; }

        /* Sol taraftaki dikey çizgi ayracı */
        .nav-divider {
            border-left: 1px solid #36373b;
            height: 25px;
        }

        /* Menü link tasarımları */
        .custom-nav .nav-link {
            color: #a0a5ad;
            font-size: 0.9rem;
            padding: 0.5rem 0.9rem;
            border-radius: 8px;
            transition: color 0.2s ease, background-color 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            white-space: nowrap;
        }

        .custom-nav .nav-link:hover {
            color: #ffffff;
            background-color: #2b2d31;
        }

        /* Aktif sayfa vurgusu */
        .custom-nav .nav-link.is-active {
            color: #ffffff;
            background-color: #2b2d31;
        }

        /* Vurgulanan link (Admin Paneline Git) */
        .custom-nav .nav-link.active-bold {
            color: #ffffff;
            font-weight: 700;
            background-color: rgba(124, 140, 255, 0.12);
        }
        .custom-nav .nav-link.active-bold:hover {
            background-color: rgba(124, 140, 255, 0.2);
        }

        /* Çıkış Yap Butonu */
        .btn-outline-logout {
            color: #ff4d4d;
            border: 1px solid #8b2020;
            background-color: transparent;
            font-size: 0.85rem;
            padding: 0.375rem 0.85rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-outline-logout:hover {
            background-color: #8b2020;
            color: #ffffff;
            border-color: #8b2020;
        }

        /* Navbar toggler (mobil) */
        .custom-toggler {
            border: 1px solid #36373b;
            background-color: transparent;
            border-radius: 8px;
            padding: 0.35rem 0.6rem;
            color: #e0e0e0;
        }
        .custom-toggler:hover { background-color: #2b2d31; }

        header {
            border-bottom: 1px solid #2a2b2f;
        }

        /* Sayfa Ortasındaki Yuvarlatılmış Koyu Kutu */
        .content-card {
            background-color: #2b2d31;
            border-radius: 16px;
            min-height: 120px;
            padding: 1.75rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.25s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 991.98px) {
            .custom-nav {
                flex-direction: column;
                align-items: stretch !important;
                gap: 0.25rem;
                padding-top: 0.75rem;
            }
            .nav-divider { display: none; }
            .content-card { padding: 1.25rem; }
        }

        /* Mobil menü: Bootstrap'ın "collapse" class'ı yerine özel bir mekanizma
           kullanılıyor çünkü Tailwind CDN de aynı isimde bir utility class
           tanımlıyor (visibility: collapse) ve ikisi çakışınca menü görünmez
           oluyordu. */
        .nav-menu { display: none; }
        .nav-menu.nav-menu-open { display: block; }

        @media (min-width: 992px) {
            .nav-menu { display: flex !important; }
        }

        @yield('headcss')

    </style>
</head>

<body>

<!-- Header / Navbar -->
<header class="py-3">
    <div class="container-fluid px-4 d-flex align-items-center justify-content-between">

        <!-- Marka -->
        <a href="{{ route('panel.user.showMainPage') }}" class="brand">
            <i class="bi bi-hexagon-fill"></i>
            <span>Sosyal Medya</span>
        </a>

        <div class="d-flex align-items-center">

            <!-- Sol Dikey Ayraç -->
            <div class="nav-divider mx-3 d-none d-lg-block"></div>

            <!-- Mobil Menü Butonu -->
            <button class="custom-toggler d-lg-none" type="button" id="navToggle" aria-controls="mainNav" aria-expanded="false" aria-label="Menüyü aç/kapat">
                <i class="bi bi-list fs-5"></i>
            </button>

            <!-- Menü Linkleri -->
            <div class="nav-menu" id="mainNav">
                <nav class="nav custom-nav align-items-lg-center gap-1">
                    <a class="nav-link {{ request()->routeIs('panel.user.showMainPage') ? 'is-active' : '' }}" href="{{ route('panel.user.showMainPage') }}">
                        <i class="bi bi-house"></i> Anasayfa
                    </a>
                    <a class="nav-link {{ request()->routeIs('panel.user.showMyFollowingPage') ? 'is-active' : '' }}" href="{{ route('panel.user.showMyFollowingPage') }}">
                        <i class="bi bi-people"></i> Takip Ettiklerim
                    </a>
                    <a class="nav-link {{ request()->routeIs('panel.user.showFindUserPage') ? 'is-active' : '' }}" href="{{ route('panel.user.showFindUserPage') }}">
                        <i class="bi bi-search"></i> Kullanıcı Ara
                    </a>
                    <a class="nav-link {{ request()->routeIs('panel.user.showCreatePost') ? 'is-active' : '' }}" href="{{ route('panel.user.showCreatePost') }}">
                        <i class="bi bi-plus-circle"></i> Gönderi Oluştur
                    </a>
                    <a class="nav-link {{ request()->routeIs('panel.user.showProfilePage') ? 'is-active' : '' }}" href="{{ route('panel.user.showProfilePage') }}">
                        <i class="bi bi-person-circle"></i> Profil
                    </a>
                    <a class="nav-link {{ request()->routeIs('feedback.index') ? 'is-active' : '' }}" href="{{ route('feedback.index') }}">
                        <i class="bi bi-chat-square-text"></i> Şikayet/Öneri
                    </a>

                    @if(auth()->check() && auth()->user()->role == 1)
                        <a class="nav-link active-bold me-lg-2" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Admin Paneline Git
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="mt-2 mt-lg-0 ms-lg-1">
                        @csrf
                        <button type="submit" class="btn btn-outline-logout btn-sm w-100">
                            <i class="bi bi-box-arrow-right"></i>
                            {{ __('Çıkış Yap') }}
                        </button>
                    </form>
                </nav>
            </div>

        </div>

    </div>
</header>

<!-- Ana İçerik Alanı (Kutu) -->
<main class="container my-4">
    <div class="content-card">

        @yield('content')

    </div>
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Mobil menü aç/kapat (Bootstrap'ın .collapse mekanizması yerine,
    // Tailwind çakışmasını önlemek için)
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
