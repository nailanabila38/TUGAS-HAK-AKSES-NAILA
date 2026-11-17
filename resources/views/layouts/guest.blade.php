<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ruang &amp; Fasilitas Sidang</title>
    <link rel="stylesheet" href="{{ asset('login.css') }}">
</head>
<body class="login-page">
    <div class="login-box">
        <h1>Ruang &amp; Fasilitas Sidang</h1>
        <p class="sub">Masuk untuk mengelola data ruang</p>

        {{ $slot }}
    </div>
</body>
</html>