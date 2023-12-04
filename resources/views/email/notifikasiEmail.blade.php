<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="<https://fonts.googleapis.com/icon?family=Material+Icons>" rel="stylesheet" />
    @vite('resources/css/app.css')
    <link rel="shortcut icon" href="{{ URL::asset('img/logo-kotak.png') }}">
    <script src="<https://cdn.tailwindcss.com>"></script>
    <title>Dikantin | Virifikasi Email</title>
</head>

<body>

    <div class="flex flex-col bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
        role="alert">
        <strong class="font-bold">Hallo {{ $hasil->email }}, Email Anda Sudah Terverifikasi !</strong>
        <span class="block sm:inline"> Anda bisa login menggunakan akun yang sudah anda daftarkan sebelumnya.</span>
    </div>
    {{-- @if (isset($status))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Email Verification Link Sent!</strong>
            <span class="block sm:inline">A fresh verification link has been sent to your email address.</span>
        </div>
    @endif

    @if ($status == false)
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Email Verified!</strong>
            <span class="block sm:inline">Your email has been verified. You can now log in.</span>
        </div>
    @endif --}}
</body>

</html>
