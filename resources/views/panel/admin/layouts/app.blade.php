<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') · Kontrol Odası</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- Admin panelinin tüm stilleri tek dosyada: public/css/admin.css --}}
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
</head>

<body>
<div class="layout">

    <aside class="sidebar">
        <div class="brand">
            <div class="brand-mark">KO</div>
            <div>
                <div class="brand-name">Kontrol Odası</div>
                <div class="brand-sub">Yönetim Paneli</div>
            </div>
        </div>

        <nav>
            <a class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid-1x2-fill"></i> Ana Sayfa
            </a>
            <a class="nav-item {{ request()->routeIs('posts.pending') ? 'active' : '' }}" href="{{ route('posts.pending') }}">
                <i class="bi bi-hourglass-split"></i> Post Onaylama
            </a>
            <a class="nav-item {{ request()->routeIs('show.posts.approved') ? 'active' : '' }}" href="{{ route('show.posts.approved') }}">
                <i class="bi bi-check-circle"></i> Onaylanan Postlar
            </a>
            <a class="nav-item {{ request()->routeIs('show.posts.rejected') ? 'active' : '' }}" href="{{ route('show.posts.rejected') }}">
                <i class="bi bi-x-circle"></i> Reddedilen Postlar
            </a>
            <a class="nav-item {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
                <i class="bi bi-people"></i> Kullanıcı Ban Sayfası
            </a>
            <a class="nav-item {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}" href="{{ route('admin.feedback.index') }}">
                <i class="bi bi-chat-square-text"></i> Şikayet / Öneriler
            </a>

            <div class="nav-label">Sistem</div>

            <a class="nav-item" href="{{ route('panel.user.showMainPage') }}">
                <i class="bi bi-house"></i> Ana Sayfaya dön
            </a>
        </nav>

        <div class="sidebar-foot">
            @php $adminUser = auth()->user(); @endphp
            <div class="avatar">
                @if ($adminUser && !empty($adminUser->profile_photo_path))
                    <img src="{{ asset('storage/' . $adminUser->profile_photo_path) }}" alt="{{ $adminUser->username }}">
                @else
                    {{ $adminUser ? strtoupper(substr($adminUser->username, 0, 1)) : '?' }}
                @endif
            </div>
            <div>
                <div class="foot-name">{{ $adminUser->username ?? 'Yönetici' }}</div>
                <div class="foot-role">Sistem Yöneticisi</div>
            </div>
        </div>
    </aside>

    <main>
        @hasSection('page-title')
            <div class="a-topbar">
                <h1 class="a-topbar-title">@yield('page-title')</h1>
                @hasSection('page-subtitle')
                    <p class="a-topbar-sub">@yield('page-subtitle')</p>
                @endif
            </div>
        @endif

        @yield('content')
    </main>

</div>

<script>
    // Bootstrap JS'e ihtiyaç duymadan basit uyarı (alert) kapatma davranışı.
    document.addEventListener('click', function (event) {
        var closeBtn = event.target.closest('[data-dismiss="alert"]');
        if (!closeBtn) return;
        var alertBox = closeBtn.closest('.alert-a');
        if (alertBox) alertBox.remove();
    });
</script>

</body>
</html>
