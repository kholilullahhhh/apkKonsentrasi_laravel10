<!DOCTYPE html>
<html>

<head>
    <title>Aktivasi Akun</title>
</head>

<body>
    <h2>Halo, {{ $user->name }} 👋</h2>
    <p>Terima kasih telah mendaftar. Klik tautan di bawah ini untuk mengaktifkan akun Anda:</p>
    <a href="{{ $url }}"
        style="background:#4CAF50;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;">
        Aktifkan Akun
    </a>
    <p>Jika Anda tidak merasa membuat akun, abaikan email ini.</p>
</body>

</html>