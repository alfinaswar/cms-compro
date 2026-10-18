<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Lupa Kata Sandi | {{ $websiteSettings->NamaPerusahaan ?? 'Admin' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <style>
        body, input, button, select, textarea, .card, h5, h6, small, label, .alert {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

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
            <img src="{{ ($websiteSettings->PathLogo ?? null) ? asset('storage/' . $websiteSettings->PathLogo) : asset('assets/img/login/logo-login.png') }}"
                alt="{{ $websiteSettings->NamaPerusahaan ?? 'Admin' }} Logo" class="jasuindo-logo">

            <h5 class="fw-bold mb-1 mt-2">{{ $websiteSettings->NamaPerusahaan ?? 'PT Jasuindo Tiga Perkasa Tbk' }}</h5>
            <small class="text-secondary d-block mb-2">
                {{ $websiteSettings->DeskripsiSingkat ?? '-' }}
            </small>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="mb-1 text-center fw-semibold">Lupa Kata Sandi?</h6>
                <p class="text-center text-secondary small mb-3">
                    Masukkan alamat email Anda. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi.
                </p>

                @if (session('status'))
                    <div class="alert alert-success py-2 small">{{ session('status') }}</div>
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

                <form method="POST" action="{{ route('password.email') }}">
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
                    <div class="d-grid gap-2 mb-2">
                        <button type="submit" class="btn btn-primary fw-semibold">Kirim Tautan Reset</button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="link-secondary small">
                        <i class="bi bi-arrow-left"></i> Kembali ke Halaman Login
                    </a>
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
