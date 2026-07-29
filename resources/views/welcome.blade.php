<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sosyal Medya</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:600,700,800|inter:400,500,600" rel="stylesheet" />

    <!-- Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --accent: #8b5cf6;
            --accent-2: #ff6b6b;
        }

        html, body {
            height: 100%;
        }

        body {
            background-color: #0a0a0c;
            background-image:
                radial-gradient(circle at 15% 20%, rgba(139,92,246,0.18) 0, transparent 42%),
                radial-gradient(circle at 85% 10%, rgba(255,107,107,0.14) 0, transparent 38%),
                radial-gradient(circle at 70% 90%, rgba(139,92,246,0.12) 0, transparent 45%);
            color: #f4f3f7;
            font-family: 'Inter', system-ui, sans-serif;
            display: flex;
            flex-direction: column;
        }

        .brand {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 1.3rem;
            letter-spacing: -0.02em;
            color: #ffffff !important;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
        }

        .brand-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--accent-2);
            display: inline-block;
        }

        .btn-outline-light {
            border-radius: 999px;
            font-weight: 600;
            font-size: .9rem;
            padding: .55rem 1.4rem;
        }

        .btn-accent {
            border-radius: 999px;
            font-weight: 600;
            font-size: .9rem;
            padding: .55rem 1.4rem;
            background: #ffffff;
            color: #0a0a0c;
            border: none;
        }

        .btn-accent:hover {
            background: var(--accent);
            color: #fff;
        }

        .eyebrow {
            font-size: .8rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--accent);
        }

        h1.headline {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: clamp(2.2rem, 6vw, 3.5rem);
            line-height: 1.08;
            letter-spacing: -0.03em;
            color: #ffffff;
        }

        h1.headline .accent-word {
            color: var(--accent);
        }

        p.lede {
            font-size: 1.05rem;
            line-height: 1.6;
            color: #b9b6c6;
            max-width: 480px;
        }

        .cta-btn {
            padding: .8rem 1.8rem;
            font-size: 1rem;
        }

        .node-card {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: #16151c;
            border: 1.5px solid #2a2833;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 6px 20px rgba(0,0,0,0.4);
        }

        .node-card.filled {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
            font-weight: 700;
        }

        .node-link {
            width: 44px;
            height: 1.5px;
            background: #2a2833;
        }

        footer {
            color: #7c7889;
            font-size: .85rem;
        }

        footer a {
            color: #d9d5ea;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>

@if (Route::has('login'))
    <header class="container-fluid py-4 px-4 px-lg-5">
        <div class="d-flex align-items-center justify-content-between" style="max-width:1100px;margin:0 auto;">
            <a href="{{ url('/') }}" class="brand"><span class="brand-dot"></span>Sosyal Medya</a>
            <nav class="d-flex align-items-center gap-2">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-accent">Sayfana git</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light">Giriş yap</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-accent">Kayıt ol</a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>
@endif

<main class="flex-grow-1 d-flex align-items-center justify-content-center px-3 py-5">
    <div class="text-center" style="max-width:620px;">
        <h1 class="headline mb-3">İnsanların <span class="accent-word">Sohbet</span> Yeri </h1>
        <p class="lede mx-auto mb-5">
            Arkadaşlarınla paylaş, yeni insanlarla tanış.
            Sosyal Medya, seni doğru insanlara bağlamak için burada.
        </p>

        <div class="d-flex flex-wrap justify-content-center gap-3 mb-5">
            @if (Route::has('register') && !Auth::check())
                <a href="{{ route('register') }}" class="btn btn-accent cta-btn">Ücretsiz katıl</a>
                <a href="{{ route('login') }}" class="btn btn-outline-light cta-btn">Hesabım var</a>
            @elseif (Auth::check())
                <a href="{{ url('/dashboard') }}" class="btn btn-accent cta-btn">Sayfana dön</a>
            @endif
        </div>

    </div>
</main>

<footer class="text-center py-4">
    &copy; {{ date('Y') }} Sosyal Medya — Laravel ile geliştirildi
</footer>

</body>
</html>
