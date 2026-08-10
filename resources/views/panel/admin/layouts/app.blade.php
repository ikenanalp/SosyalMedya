<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title> @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <style>
        :root{
            --navy:#0F1D33;
            --navy-soft:#16294A;
            --bg:#F3F5F8;
            --panel:#FFFFFF;
            --ink:#101522;
            --muted:#68707E;
            --line:#E4E8EE;
            --signal:#1F8A70;
            --signal-soft:#E4F4EF;
            --amber:#D98A2B;
            --amber-soft:#FBF0DF;
            --red:#C24444;
            --red-soft:#FBE9E9;
            --radius:10px;
        }
        *{box-sizing:border-box; margin:0; padding:0;}
        body{
            background:var(--bg);
            color:var(--ink);
            font-family:'Inter', sans-serif;
            -webkit-font-smoothing:antialiased;
        }
        .layout{display:grid; grid-template-columns:240px 1fr; min-height:100vh;}

        /* Sidebar */
        .sidebar{
            background:var(--navy);
            color:#C7D0E0;
            padding:28px 20px;
            display:flex;
            flex-direction:column;
            gap:34px;
        }
        .brand{display:flex; align-items:center; gap:10px;}
        .brand-mark{
            width:30px; height:30px; border-radius:8px;
            background:linear-gradient(135deg, var(--signal), #143E36);
            display:flex; align-items:center; justify-content:center;
            font-family:'Space Grotesk', sans-serif; font-weight:700; color:#fff; font-size:14px;
        }
        .brand-name{font-family:'Space Grotesk', sans-serif; font-weight:600; font-size:15.5px; color:#fff; letter-spacing:.2px;}
        .brand-sub{font-size:10.5px; color:#7C8AA5; letter-spacing:.6px; text-transform:uppercase; margin-top:1px;}

        nav{display:flex; flex-direction:column; gap:2px;}
        .nav-label{font-size:10.5px; text-transform:uppercase; letter-spacing:.8px; color:#5C6B87; margin:14px 10px 8px;}
        .nav-item{
            display:flex; align-items:center; gap:10px;
            padding:9px 10px; border-radius:8px;
            font-size:13.5px; color:#B6C1D9; text-decoration:none;
            transition:background .15s ease, color .15s ease;
        }
        .nav-item svg{width:16px; height:16px; opacity:.85; flex-shrink:0;}
        .nav-item:hover{background:var(--navy-soft); color:#fff;}
        .nav-item.active{background:var(--navy-soft); color:#fff; box-shadow:inset 3px 0 0 var(--signal);}

        .sidebar-foot{
            margin-top:auto; padding-top:16px; border-top:1px solid #24334F;
            display:flex; align-items:center; gap:10px;
        }
        .avatar{
            width:32px; height:32px; border-radius:50%;
            background:#2A3F63; color:#fff; font-size:12px; font-weight:600;
            display:flex; align-items:center; justify-content:center; font-family:'Space Grotesk', sans-serif;
        }
        .foot-name{font-size:12.5px; color:#EAEFF7; font-weight:500;}
        .foot-role{font-size:10.5px; color:#6F7EA0;}

        /* Main */
        main{padding:28px 34px 40px; max-width:1180px;}

        @media (max-width: 900px){
            .layout{grid-template-columns:1fr;}
            .sidebar{flex-direction:row; align-items:center; overflow-x:auto;}
            .sidebar nav, .sidebar-foot{display:none;}
        }

        a:focus-visible, input:focus-visible, .nav-item:focus-visible{
            outline:2px solid var(--signal); outline-offset:2px;
        }
        @media (prefers-reduced-motion: reduce){
            .pulse-dot, .pulse-line path{animation:none;}
        }
    </style>
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
            <a class="nav-item " href="{{route('admin.dashboard')}}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/></svg>
                Ana Sayfa
            </a>
            <a class="nav-item" href="{{route('posts.pending')}}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="7" r="3.2"/><path d="M2.5 20c0-3.6 2.9-6.4 6.5-6.4s6.5 2.8 6.5 6.4"/><circle cx="17.5" cy="7.5" r="2.5"/><path d="M15 13.6c2.8.3 5 2.7 5 5.9"/></svg>
                Post Onaylama
            </a>
            <a class="nav-item" href="{{route('show.posts.approved')}}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M8 4v5"/></svg>
                Onaylanan Postlar
            </a>
            <a class="nav-item" href="{{route('show.posts.rejected')}}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M8 4v5"/></svg>
                Reddedilen Postlar
            </a>
            <a class="nav-item" href="{{route('users.index')}}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 17l5-5 4 4 8-9"/></svg>
                Kullanıcı Ban Sayfası
            </a>



            <a href="{{ route('admin.feedback.index') }}" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 17l5-5 4 4 8-9"/></svg>
                Şikayet / Öneriler
            </a>



            <div class="nav-label">Sistem</div>

            <a class="nav-item" href={{route('panel.user.showMainPage')}}>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 9v4M12 17h.01"/><circle cx="12" cy="12" r="9"/></svg>
                Ana Sayfaya dön.
            </a>
        </nav>


        <div class="sidebar-foot">
            <div class="avatar">EA</div>
            <div>
                <div class="foot-name"> </div>
                <div class="foot-role">Sistem Yöneticisi</div>
            </div>
        </div>
    </aside>

    <main>

        @yield('content')

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
