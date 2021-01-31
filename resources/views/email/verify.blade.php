<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tawarin</title>
</head>
<body>
    <h2>Hai. {{ $text['name'] }}</h2>
    <p>Kami berusaja mendaparkan request dari email {{ $text['email'] }} untuk memverifikasi akun anda, gunakan kode dibawah ini untuk proses verifikasi</p>
    <h1>{{ $text['code'] }}</h1>
    <p>Apabila ada kendala dalam melakukan verifikasi email, mohon laportkan kepada CS Tawarin secepatnya.</p>
</body>
</html>
