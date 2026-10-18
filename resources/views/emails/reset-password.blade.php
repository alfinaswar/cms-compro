<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .email-wrapper {
            width: 100%;
            background-color: #f4f7fa;
            padding: 40px 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .email-header {
            background: linear-gradient(135deg, #1a56db 0%, #0e3ba0 100%);
            padding: 35px 40px;
            text-align: center;
        }

        .email-header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 22px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .email-header p {
            color: rgba(255, 255, 255, 0.85);
            margin: 8px 0 0 0;
            font-size: 14px;
        }

        .email-body {
            padding: 40px;
        }

        .greeting {
            font-size: 16px;
            color: #333333;
            margin: 0 0 20px 0;
            line-height: 1.6;
        }

        .message {
            color: #555555;
            font-size: 15px;
            line-height: 1.7;
            margin: 0 0 25px 0;
        }

        .cta-wrap {
            text-align: center;
            margin: 30px 0;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #1a56db 0%, #0e3ba0 100%);
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 36px;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
        }

        .expire-box {
            background-color: #fff8e6;
            border-left: 4px solid #f5a623;
            border-radius: 6px;
            padding: 16px 20px;
            margin: 25px 0;
            color: #7a5b00;
            font-size: 14px;
            line-height: 1.6;
        }

        .fallback {
            background-color: #f8fafc;
            border-left: 4px solid #cbd5e1;
            border-radius: 6px;
            padding: 16px 20px;
            margin-top: 25px;
        }

        .fallback h3 {
            margin: 0 0 8px 0;
            color: #64748b;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .fallback a {
            color: #1a56db;
            word-break: break-all;
            font-size: 13px;
            text-decoration: none;
        }

        .email-footer {
            background-color: #f8fafc;
            padding: 25px 40px;
            text-align: center;
            border-top: 1px solid #eee;
        }

        .email-footer p {
            margin: 0;
            color: #888888;
            font-size: 12px;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Header -->
            <div class="email-header">
                <h1>🔐 Reset Kata Sandi</h1>
                <p>Permintaan pengaturan ulang kata sandi akun Anda</p>
            </div>

            <!-- Body -->
            <div class="email-body">
                <p class="greeting">
                    Halo, <strong>{{ $nama }}</strong>
                </p>

                <p class="message">
                    Kami menerima permintaan untuk mengatur ulang kata sandi akun yang terhubung dengan
                    <strong>{{ $email }}</strong>. Untuk melanjutkan, silakan klik tombol di bawah ini.
                </p>

                <div class="cta-wrap">
                    <a href="{{ $url }}" class="cta-button">Reset Kata Sandi</a>
                </div>

                <div class="expire-box">
                    ⏳ Tautan reset ini hanya berlaku selama <strong>{{ $expire }} menit</strong> sejak email ini
                    dikirim. Jika sudah kedaluwarsa, silakan ajukan permintaan reset baru.
                </div>

                <p class="message">
                    Jika Anda <strong>tidak</strong> merasa melakukan permintaan ini, abaikan saja email ini —
                    kata sandi Anda tidak akan berubah. Segera hubungi tim kami jika Anda mencurigai adanya
                    aktivitas tidak wajar pada akun Anda.
                </p>

                <div class="fallback">
                    <h3>Tombol tidak berfungsi?</h3>
                    Salin dan tempel tautan berikut ke browser Anda:<br>
                    <a href="{{ $url }}">{{ $url }}</a>
                </div>
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <p>
                    Email ini dikirim otomatis, mohon tidak membalas email ini.<br>
                    &copy; {{ date('Y') }} <strong>{{ config('app.name', 'Jasuindo') }}</strong>. All rights
                    reserved.
                </p>
            </div>
        </div>
    </div>
</body>

</html>
