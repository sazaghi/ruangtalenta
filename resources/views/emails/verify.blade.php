<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>Hai {{ $user->name }},</h2>
    <p>Silakan verifikasi email kamu dengan menekan tombol di bawah ini:</p>

    <p>
        <a href="{{ $url }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; 
            text-decoration: none; border-radius: 5px;">Verifikasi Email</a>
    </p>

    <p>Jika kamu tidak mendaftar, abaikan email ini.</p>
</body>
</html>
