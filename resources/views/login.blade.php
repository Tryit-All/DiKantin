<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.108.0">
    <title>{{ $title }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="/css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <!-- Custom styles for this template -->
    {{-- <link href="sign-in.css" rel="stylesheet"> --}}
</head>

<body>
    <main class="form-signin d-flex justify-content-center align-items-center">
        <div class="p-4 bungkus">
            {{-- @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('loginError'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('loginError') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif --}}
            <h1 class="text-white fw-bold text-center">Login</h1>
            <h1 class="h3 mt-4 mb-1 font-weight-bold text-center text-white">Login to your account</h1>
            <form method="POST" action="/" class="cover-login">
                @csrf
                <div class="form-floating">
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror "
                        id="username" placeholder="text" required autofocus value="{{ old('username') }}">
                    {{-- <i class='bx bx-user-circle'></i> --}}
                    <label for="username">Username</label>
                    @error('username')
                        <div class="valid-feedback">
                            {{ 'The eusername must be valid username address' }}
                        </div>
                    @enderror
                </div>
                <div class="form-floating">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror "
                        id="floatingPassword" placeholder="Password">
                    <span class="eye" onclick="myFunction()">
                        <i id="hide1" class="fa-sharp fa-solid fa-eye"></i>
                        <i id="hide2" class="fa-sharp fa-solid fa-eye-slash"></i>
                    </span>
                    <label for="floatingPassword">Password</label>
                    @error('password')
                        <div class="valid-feedback">
                            {{ 'The password must be valid password' }}
                        </div>
                    @enderror
                </div>
                <div class="mt-5  align-items-center justify-content-center">
                    <button class="btn-block btn btn-lg rounded-pill btn-login" type="submit">Login</button>
                </div>
            </form>
            {{-- <div class="container-register mt-3">
                <p class="text-center register p-1">Belum Punya Akun ?<a href="/register" class="text-decoration-none">
                        <span class=" fw-bold">Silahkan
                            Register !</span></a>
                </p>
            </div> --}}
        </div>
        <img src="/img/bg-polije.png" alt="" class="bg-polije img-fluid">
        <img src="/img/polije.png" alt="" class="polije img-fluid">
    </main>

    <script>
        function myFunction() {
            var x = document.getElementById("floatingPassword");
            var y = document.getElementById("hide1");
            var z = document.getElementById("hide2");

            if (x.type === 'password') {
                x.type = "text";
                y.style.display = "block";
                z.style.display = "none";
            } else {
                x.type = "password";
                y.style.display = "none";
                z.style.display = "block";
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
