<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{asset('panel/assets/css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('panel/assets/css/templatemo-cyborg-gaming.css')}}">
    <link rel="stylesheet" href="{{asset('panel/assets/css/owl.css')}}">
    <link rel="stylesheet" href="{{asset('panel/assets/css/animate.css')}}">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>


<style> @yield('headcss') </style>

</head>

<body>

<!-- ***** Preloader Start ***** -->
<div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
        <span class="dot"></span>
        <div class="dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>
<!-- ***** Preloader End ***** -->

<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="index.html" class="logo">
                        <img src="{{asset('panel/assets/images/logo.png')}}" alt="">
                    </a>
                    <!-- ***** Logo End ***** -->

                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li><a href="{{route('panel.user.showMainPage')}}">Anasayfa</a></li>
                        <li><a href="{{route('panel.user.showMyFollowingPage')}}"> Takip Ettiklerim </a> </li>
                        <li><a href="{{route('panel.user.showFindUserPage')}}"> Kullanıcı Ara </a></li>
                        <li><a href="{{route('panel.user.showCreatePost')}}">Gönderi Oluştur </a></li>
                        <li><a href="{{route('panel.user.showProfilePage')}}">Profil </a></li>
                        <li><form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    {{ __('Çıkış Yap') }}
                                </button>
                            </form></li>
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- ***** Header Area End ***** -->

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-content">

                <!-- ***** Gaming Library Start ***** -->

                @yield('content')

                <!-- ***** Gaming Library End ***** -->
            </div>
        </div>
    </div>
</div>



<!-- Scripts -->
<!-- Bootstrap core JavaScript -->
<script src="{{asset('panel/assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('panel/assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script src="{{asset('panel/assets/js/isotope.min.js')}}"></script>
<script src="{{asset('panel/assets/js/owl-carousel.js')}}"></script>
<script src="{{asset('panel/assets/js/tabs.js')}}"></script>
<script src="{{asset('panel/assets/js/popup.js')}}"></script>
<script src="{{asset('panel/assets/js/custom.js')}}"></script>


</body>

</html>
