<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Lamaran</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .email-header h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .email-header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .email-body {
            padding: 30px;
        }

        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }

        .message {
            color: #555;
            margin-bottom: 25px;
            font-size: 15px;
        }

        .info-card {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .info-card h3 {
            color: #333;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .info-label {
            font-weight: 600;
            color: #555;
            width: 150px;
            flex-shrink: 0;
        }

        .info-value {
            color: #333;
            flex: 1;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            background-color: #ffc107;
            color: #000;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 5px;
        }

        .next-steps {
            background-color: #e7f3ff;
            border: 1px solid #b3d9ff;
            padding: 20px;
            border-radius: 4px;
            margin: 25px 0;
        }

        .next-steps h3 {
            color: #0066cc;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .next-steps ul {
            margin-left: 20px;
            color: #555;
            font-size: 14px;
        }

        .next-steps li {
            margin-bottom: 8px;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }

        .footer p {
            color: #777;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .footer .company-name {
            font-weight: 600;
            color: #333;
        }

        .button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            margin: 20px 0;
        }

        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100%;
            }

            .email-header,
            .email-body {
                padding: 20px;
            }

            .info-row {
                flex-direction: column;
            }

            .info-label {
                margin-bottom: 5px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>🎉 Lamaran Berhasil Dikirim!</h1>
            <p>Terima kasih telah melamar posisi di perusahaan kami</p>
        </div>

        <div class="email-body">
            <p class="greeting">Halo, <strong>{{ $lamaran->NamaLengkap }}</strong></p>

            <p class="message">
                Kami telah menerima lamaran Anda untuk posisi yang tersedia. Tim rekrutmen kami akan
                meninjau kualifikasi Anda dan akan menghubungi Anda jika ada kecocokan dengan kebutuhan kami.
            </p>

            <div class="info-card">
                <h3>📋 Detail Lamaran Anda</h3>
                <div class="info-row">
                    <span class="info-label">Posisi:</span>
                    <span class="info-value"><strong>{{ $lowongan->Posisi }}</strong></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kota:</span>
                    <span class="info-value">{{ $lowongan->Kota }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $lamaran->Email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">No. HP:</span>
                    <span class="info-value">{{ $lamaran->NoHp }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Ekspetasi Gaji:</span>
                    <span class="info-value">Rp {{ number_format($lamaran->EkspetasiGaji, 0, ',', '.') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Lamar:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($lamaran->created_at)->format('d M Y, H:i') }}
                        WIB</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value"><span class="status-badge">{{ $lamaran->Status }}</span></span>
                </div>
            </div>

            <div class="next-steps">
                <h3>📌 Langkah Selanjutnya</h3>
                <ul>
                    <li>Tim kami akan meninjau lamaran Anda dalam <strong>3-7 hari kerja</strong></li>
                    <li>Jika kualifikasi Anda sesuai, kami akan menghubungi Anda melalui email atau telepon</li>
                    <li>Pastikan nomor telepon dan email Anda aktif</li>
                    <li>Anda akan menerima update status lamaran melalui email ini</li>
                </ul>
            </div>

            <p class="message">
                Jika Anda memiliki pertanyaan atau ingin mengupdate informasi lamaran Anda,
                silakan hubungi tim rekrutmen kami.
            </p>

            <div style="text-align: center;">
                <a href="{{ url('/') }}" class="button">Kunjungi Website Kami</a>
            </div>
        </div>

        <div class="footer">
            <p>Email ini dikirim otomatis, mohon tidak membalas email ini.</p>
            <p class="company-name">{{ config('app.name') }}</p>
            <p>&copy; {{ date('Y') }} All rights reserved.</p>
        </div>
    </div>
</body>

</html>
