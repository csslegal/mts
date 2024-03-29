<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage/logo.png') }}" />
    <meta name="robots" content="noindex, noimageindex, nofollow, nosnippet">

    <title>CSS Legal - Müşteri Takip Sistemi</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container px-4">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10">
                <div class="text-center p-3">
                    <img class="w-75 p-3"
                        src="{{ asset('storage/logo.png') }}" alt="logo">
                </div>
                <div class="card mt-3">
                    <div class="card-header justify-content-center bg-danger text-white">
                        <h3 class="fw-light my-2">Kullanıcı Girişi</h3>
                    </div>
                    <div class="card-body">
                        @if (session()->has('mesaj'))
                            <div class="alert alert-danger">{{ session()->get('mesaj') }}</div>
                        @endif
                        <form action="giris" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="email">E-mail</label>
                                <input name="email" value="{{ old('email') }}" class="form-control" id="email"
                                    type="text" placeholder="E-mail Adresiniz">
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Şifre</label>
                                <input name="password" value="{{ old('password') }}" class="form-control" id="password"
                                    type="password" placeholder="Şifreniz">
                                @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Form Group (login box)-->
                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <button type="submit" class="btn btn-secondary">Giriş Yap</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>
