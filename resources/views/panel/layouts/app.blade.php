<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title') </title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">


    <style>
        /* Arka plan rengi */
        body {
            background-color: #1e1f22;
            color: #e0e0e0;
            font-family: system-ui, -apple-system, sans-serif;
        }

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
            transition: color 0.2s ease;
        }

        .custom-nav .nav-link:hover {
            color: #ffffff;
        }

        /* Vurgulanan link (Admin Paneline Git) */
        .custom-nav .nav-link.active-bold {
            color: #ffffff;
            font-weight: 700;
        }

        /* Çıkış Yap Butonu */
        .btn-outline-logout {
            color: #ff4d4d;
            border: 1px solid #8b2020;
            background-color: transparent;
            font-size: 0.85rem;
            padding: 0.375rem 0.85rem;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .btn-outline-logout:hover {
            background-color: #8b2020;
            color: #ffffff;
            border-color: #8b2020;
        }

        /* Sayfa Ortasındaki Yuvarlatılmış Koyu Kutu */
        .content-card {
            background-color: #2b2d31;
            border-radius: 16px;
            min-height: 120px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        @yield('headcss')

    </style>
</head>
<body>

<!-- Header / Navbar -->
<header class="py-3">
    <div class="container-fluid px-4 d-flex align-items-center justify-content-end">

        <!-- Sol Dikey Ayraç -->
        <div class="nav-divider me-3"></div>

        <!-- Menü Linkleri -->
        <nav class="nav custom-nav align-items-center gap-1">
            <a class="nav-link" href="{{route('panel.user.showMainPage')}}">Anasayfa</a>
            <a class="nav-link" href="{{route('panel.user.showMyFollowingPage')}}">Takip Ettiklerim</a>
            <a class="nav-link" href="{{route('panel.user.showFindUserPage')}}">Kullanıcı Ara</a>
            <a class="nav-link" href="{{route('panel.user.showCreatePost')}}">Gönderi Oluştur</a>
            <a class="nav-link" href="{{route('panel.user.showProfilePage')}}">Profil</a>

            @if(auth()->check() && auth()->user()->role == 1)
            <a class="nav-link active-bold me-2" href="{{ route('admin.dashboard') }}">Admin Paneline Git </a>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    {{ __('Çıkış Yap') }}
                </button>
            </form>

        </nav>

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
</body>
</html>
