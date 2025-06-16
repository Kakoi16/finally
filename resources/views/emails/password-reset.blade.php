<!DOCTYPE html>
<html>
<head>
    <title>Reset Password Anda</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2>Halo, {{ $user->name }}!</h2>
    <p>Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.</p>
    <p>Silakan klik tombol di bawah ini untuk mereset password Anda:</p>
    
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <table cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="border-radius: 5px;" bgcolor="#007bff">
                            <a href="{{ $resetUrl }}"
                               target="_blank"
                               style="padding: 15px 25px; border: 1px solid #007bff; border-radius: 5px; font-family: Arial, sans-serif; font-size: 16px; color: #ffffff; text-decoration: none; display: inline-block;">
                                Reset Password
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <p>Link reset password ini akan kedaluwarsa dalam 60 menit.</p>
    <p>Jika Anda tidak merasa meminta reset password, abaikan saja email ini.</p>
    <br>
    <p>Terima kasih,</p>
    <p>Tim Aplikasi Anda</p>
</body>
</html>
