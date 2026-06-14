<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Baru dari Contact Us</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            margin: 0 0 25px 0;
            line-height: 1.6;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .info-table tr {
            border-bottom: 1px solid #f0f0f0;
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        .info-table td {
            padding: 14px 0;
            vertical-align: top;
        }

        .info-table td:first-child {
            width: 180px;
            font-weight: 600;
            color: #555555;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .info-table td:last-child {
            color: #222222;
            font-size: 15px;
            line-height: 1.5;
        }

        .message-box {
            background-color: #f8fafc;
            border-left: 4px solid #1a56db;
            border-radius: 6px;
            padding: 20px 24px;
            margin-top: 20px;
        }

        .message-box h3 {
            margin: 0 0 12px 0;
            color: #1a56db;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .message-box p {
            margin: 0;
            color: #333333;
            font-size: 15px;
            line-height: 1.7;
        }

        .badge {
            display: inline-block;
            background-color: #e8f0fe;
            color: #1a56db;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
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

        .email-footer a {
            color: #1a56db;
            text-decoration: none;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #1a56db 0%, #0e3ba0 100%);
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 25px;
        }

        .timestamp {
            color: #999;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Header -->
            <div class="email-header">
                <h1>📩 Pesan Baru dari Website</h1>
                <p>Ada calon klien yang menghubungi melalui form Contact Us</p>
            </div>

            <!-- Body -->
            <div class="email-body">
                <p class="greeting">
                    Halo Admin,<br>
                    Anda menerima pesan baru dari pengunjung website. Berikut detailnya:
                </p>

                <!-- Info Table -->
                <table class="info-table">
                    <tr>
                        <td>👤 Nama Lengkap</td>
                        <td><strong>{{ $data['NamaLengkap'] }}</strong></td>
                    </tr>
                    <tr>
                        <td>📧 Email</td>
                        <td>
                            <a href="mailto:{{ $data['Email'] }}" style="color: #1a56db; text-decoration: none;">
                                {{ $data['Email'] }}
                            </a>
                        </td>
                    </tr>
                    @if (!empty($data['NomorHandphone']))
                        <tr>
                            <td>📱 No. Handphone</td>
                            <td>
                                <a href="tel:{{ $data['NomorHandphone'] }}"
                                    style="color: #1a56db; text-decoration: none;">
                                    {{ $data['NomorHandphone'] }}
                                </a>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $data['NomorHandphone']) }}"
                                    style="color: #25d366; text-decoration: none; margin-left: 8px; font-size: 12px;">
                                    [WhatsApp]
                                </a>
                            </td>
                        </tr>
                    @endif
                    @if (!empty($data['CompanyName']))
                        <tr>
                            <td>🏢 Perusahaan</td>
                            <td>{{ $data['CompanyName'] }}</td>
                        </tr>
                    @endif
                    @if (!empty($data['LokasiPerusahaan']))
                        <tr>
                            <td>📍 Lokasi</td>
                            <td>{{ $data['LokasiPerusahaan'] }}</td>
                        </tr>
                    @endif
                    @if (!empty($data['ProdukYangDibutuhkan']))
                        <tr>
                            <td>🎯 Produk/Jasa</td>
                            <td><span class="badge">{{ $data['ProdukYangDibutuhkan'] }}</span></td>
                        </tr>
                    @endif
                    <tr>
                        <td>🕐 Waktu</td>
                        <td>
                            {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm') }} WIB
                            <div class="timestamp">IP: {{ request()->ip() ?? '-' }}</div>
                        </td>
                    </tr>
                </table>

                <!-- Message Box -->
                @if (!empty($data['Pesan']))
                    <div class="message-box">
                        <h3>💬 Pesan</h3>
                        <p>{{ $data['Pesan'] }}</p>
                    </div>
                @endif

                <!-- Quick Action -->
                <div style="text-align: center; margin-top: 30px;">
                    <a href="mailto:{{ $data['Email'] }}?subject=Re: {{ $data['ProdukYangDibutuhkan'] ?? 'Pertanyaan dari Website' }}&body=Halo {{ $data['NamaLengkap'] }},%0A%0ATerima kasih telah menghubungi kami.%0A%0A"
                        class="cta-button">
                        ✉️ Balas Email Ini
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <p>
                    Email ini dikirim otomatis dari form Contact Us website Anda.<br>
                    &copy; {{ date('Y') }} <strong>{{ config('app.name', 'Jasuindo') }}</strong>. All rights
                    reserved.
                </p>
            </div>
        </div>
    </div>
</body>

</html>
