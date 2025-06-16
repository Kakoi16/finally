<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 40px;">
    <div style="max-width: 600px; margin: auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px;">
        <h2 style="color: #2c3e50;">Verifikasi Email Anda</h2>
        <p>Halo <strong>{{ $user->name }}</strong>,</p>
        <p>Terima kasih telah mendaftar. Klik tombol di bawah untuk memverifikasi email Anda:</p>
        <p style="text-align: center;">
            <a href="{{ $verifyUrl }}" style="display: inline-block; padding: 12px 24px; background-color: #3498db; color: white; text-decoration: none; border-radius: 5px;">Verifikasi Sekarang</a>
        </p>
        <p>Jika tombol tidak bisa diklik, salin dan tempel link berikut ke browser Anda:</p>
        <p style="background: #f1f1f1; padding: 10px; word-break: break-all;">{{ $verifyUrl }}</p>
        <p>Salam,<br>Tim Kami</p>
    </div>
</body>
</html>
