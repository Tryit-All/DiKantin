<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<https://fonts.googleapis.com/icon?family=Material+Icons>" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('build/assets/app-0d576ebc.css') }}">
    {{-- @vite('resources/css/app.css') --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <script src="<https://cdn.tailwindcss.com>"></script>
    <link rel="shortcut icon" href="{{ URL::asset('img/logo-kotak.png') }}">
    <title>Dikantin | Login</title>
</head>

<body class="bg-gray-100">

    <div class="w-full h-screen flex flex-col md:flex-row text-[#34364A]">

        <!-- Banner Section -->
        <div id="Banner"
            class="md:w-7/12 h-1/2 md:h-screen bg-cover text-white flex flex-col justify-between font-sans relative"
            style="background-image: url('{{ asset('/img/bc-login.png') }}');">
            <div class="absolute inset-0 bg-black bg-opacity-30"></div>
            <div class="px-4 pt-8 md:pt-6 relative z-10">
                <img src="{{ asset('/img/logoPutih.png') }}" class="logoo" alt="" width="150px">
            </div>
            <div class="bg-gradient-to-t from-blue-900 md:pl-8 px-6 pb-8 md:pr-[25%] relative z-10">
                <p class="text-2xl md:text-6xl font-semibold leading-[75px] tracking-wide">TIME FOR BUSINESS
                    MANAGEMENT</p>
                <p class="text-sm md:text-md text-white">Welcome to "DIKANTIN POLIJE," the JTINOVA affiliated
                    application
                    designed to assist you in streamlining report management, sales recapitulation, and simplifying the
                    sales process.</p>
            </div>
        </div>

        <!-- Form Section -->
        <div id="FormSection" class="md:w-5/12 flex flex-col justify-center items-center p-4">

            <h1 class="text-center mb-4 md:mb-8 text-2xl md:text-3xl font-bold"><span class="text-md md:text-xl">Welcome
                    Back! </span><br />Efficient, Intuitive and Organized.</h1>

            <div id="Forms" class="flex flex-col gap-4 md:gap-6 text-center w-full md:w-7/12">
                <form class="text-left font-medium flex flex-col gap-4 md:gap-6" method="POST"
                    action="{{ route('loginUserWeb') }}">
                    @csrf
                    <div class="flex flex-col">
                        <label class="mb-2" for="email">Email</label>
                        <input type="email" id="email" value="{{ old('email') }}" required
                            class="input form-control @error('email') is-invalid @enderror border rounded-md border-gray-400 hover:border-black focus:border-black p-2 md:p-[8px_10px]"
                            name="email" placeholder="Enter your email" required />
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <script>
                            var emailInput = document.getElementById('email');
                            emailInput.addEventListener('invalid', function(event) {
                                if (emailInput.value === '') {
                                    event.target.setCustomValidity('Silahkan Isi Email Anda');
                                }
                            });
                        </script>
                    </div>

                    <div class="flex flex-col">
                        <label class="mb-2" for="password">Password</label>
                        <div class="relative">
                            <input type="password" id="password"
                                class="input form-control @error('password') is-invalid @enderror border rounded-md border-gray-400 hover:border-black focus:border-black p-2 md:p-[8px_10px] w-full"
                                name="password" placeholder="Enter your password" required />
                            <span class=" material-icons absolute top-[33%] right-[15px] password-toggle-icon"
                                onclick="togglePasswordVisibility()">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                        </div>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit"
                        class="text-center text-white p-2 md:p-[8px_10px] bg-blue-700 rounded-md">Login</button>
                </form>

                <div>or</div>

                <a href="{{ url('google') }}"
                    class="border rounded border-gray-400 hover:border-black focus:border-black p-2 md:p-[8px_10px]"><img
                        src="{{ asset('/assets/images/brands/g-suite.png') }}" alt="google"
                        class="inline mr-1 md:mr-2" width="18px" /> Sign-in with Google</a>
            </div>

            <div class="flex justify-center pt-6 items-center flex-col w-full md:w-96">
                <span class="text-xs md:text-sm pt-3 text-center">Copyright by :</span>
                <img src="{{ asset('/img/JTI-Nova - Full.png') }}" class="logo" alt="" width="130px">
            </div>
        </div>
    </div>
</body>


<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var icon = document.querySelector(".password-toggle-icon i");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        }
    }
</script>

</html>
