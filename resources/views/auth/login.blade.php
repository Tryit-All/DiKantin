@extends('layouts.app')

@section('content')
    <div class="container content1 justify-content-center" id="gambar-back">
        <img src="{{ asset('/img/logo-login.png') }}" class="logoo" alt="">
        <div class="row justify-content-center login">
            <a style="display: block; text-align: center; font-size: 30px; font-weight: bold; color: white;">Sign In</a>
            <div class="col-md-4">
                <!-- <div class="card"> -->
                {{-- <!-- <div class="card-header">{{ __('Login') }}</div> --> --}}
                {{-- <!-- <a class="dropdown-item" href="{{ route('logout') }}" --}}
                {{-- onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"> --}}
                {{-- {{ __('Logout') }} --}}
                {{-- </a> --> --}}
                <div class="card-body d-flex flex-column align-items-center">

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row mb-3 input-field">
                            <!-- <label for="email"
                                                                                                                            class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label> -->
                            <div class="col-md-12">
                                <input id="email" type="email" placeholder="Email"
                                    class="input form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required oninvalid="this.setCustomValidity('')"
                                    autocomplete="off" autofocus>

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
                        </div>

                        <div class="row mb-3 input-field">
                            <!-- <label for="password"
                                                                                                                            class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label> -->

                            <div class="col-md-12 position-relative">
                                <div class="password-wrapper d-flex align-items-center">
                                    <input id="password" type="password" placeholder="Password"
                                        class="input form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">
                                    <span class="password-toggle-icon" onclick="togglePasswordVisibility()">
                                        <i class="fas fa-eye-slash"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-md-8">
                                <button type="submit" class="btn-login">
                                    {{ __('Login') }}
                                </button>
                                <div class=”container”>
                                    <div class=”row”>
                                        <div class=”col-md-12 row-block”>
                                            <a href="{{ url('google') }}" class="btn bth-lg-primaty btn-block">
                                                <strong>Login With Google</strong>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a
                                    style="font-weight:bold; margin-top: 25px; font-size: 15px; color:white; display: flex; text-align: center; margin-left: 100px;">Powered
                                    by :</a>
                                <img src="{{ url(asset('/img/JTI-Nova - Full.png')) }}" alt="" width="120"
                                    style="display: inline-block; text-align: center; margin-left: 80px;">

                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
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
@endsection
