<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Login | {{ $websiteSettings->NamaPerusahaan }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <style>
        body {
            background: #f7f7f7;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
            margin: 30px auto;
        }

        .jasuindo-logo {
            max-width: 135px;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <div class="text-center mb-3">
            <img src="{{ $websiteSettings->PathLogo ? asset('storage/' . $websiteSettings->PathLogo) : asset('assets/img/login/logo-login.png') }}"
                alt="{{ $websiteSettings->NamaPerusahaan }} Logo" class="jasuindo-logo">

            <h5 class="fw-bold mb-1 mt-2">PT Jasuindo Tiga Perkasa Tbk</h5>
            <small class="text-secondary d-block mb-2">
                {{ $websiteSettings->DeskripsiSingkat ?? '-' }}
            </small>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="mb-3 text-center fw-semibold">Masuk ke Akun Anda</h6>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mb-2">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autofocus class="form-control @error('email') is-invalid @enderror"
                                placeholder="nama@email.com">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input id="password" type="password" name="password" required
                                class="form-control @error('password') is-invalid @enderror" placeholder="********">
                        </div>
                    </div>
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }} />
                        <label class="form-check-label" for="remember">Ingat Saya</label>
                    </div>
                    <div class="d-grid gap-2 mb-2">
                        <button type="submit" class="btn btn-primary fw-semibold">Masuk</button>
                    </div>
                </form>

                <div class="text-center my-3">
                    <small class="text-secondary">- atau -</small>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('password.request') }}" class="link-secondary small">Lupa Kata Sandi?</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="link-primary small text-decoration-underline">
                            Daftar akun baru
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <footer class="mt-4 text-center text-muted small">
            Copyright &copy; {{ date('Y') }} PT Jasuindo Tiga Perkasa Tbk (JTPE).

        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
</body>

</html>
