<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kayıt Ol</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-12 col-sm-8 col-md-6 col-lg-4">

            <div class="card shadow-sm">
                <div class="card-body p-4">

                    <div class="text-center mb-3">
                        <x-validation-errors class="mb-4" />
                    </div>

                    <h5 class="card-title text-uppercase text-center mb-4">Sosyal Medya</h5>

                    <form action="{{ route('register') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Ad - Soyad</label>
                            <input type="text" id="name" name="name" class="form-control"
                                   placeholder="Adınızı ve soyadınızı giriniz">
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Kullanıcı Adı</label>
                            <input type="text" id="username" name="username" class="form-control"
                                   placeholder="Kullanıcı adınızı giriniz">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-posta</label>
                            <input type="email" id="email" name="email" class="form-control"
                                   placeholder="Email adresinizi giriniz">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Şifre</label>
                            <input type="password" id="password" name="password" class="form-control"
                                   placeholder="Şifrenizi giriniz">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Şifre Doğrulama</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-control" placeholder="Şifrenizi tekrar giriniz">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Kayıt ol</button>

                    </form>

                </div>

                <div class="card-footer text-center py-3">
                    <p class="mb-0">Bir hesabın mı var? <a href="{{ route('login') }}">Buraya tıkla.</a></p>
                </div>
            </div>

        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
