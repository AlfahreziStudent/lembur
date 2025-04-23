<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMPSTI</title>
    <!-- BOXICONS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- STYLE -->
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>
<body>
    <!-- Form Container -->
     <div class="form-container">
        <div class="col col-1">
            <div class="image-layer">
                <img src="{{ asset('assets/img/white-outline.png') }}" class="form-image-main" alt="">
                <img src="{{ asset('assets/img/dots.png') }}" class="form-image dots" alt="">
                <img src="{{ asset('assets/img/coin.png') }}" class="form-image coin" alt="">
                <img src="{{ asset('assets/img/spring.png') }}" class="form-image spring" alt="">
                <img src="{{ asset('assets/img/rocket.png') }}" class="form-image rocket" alt="">
                <img src="{{ asset('assets/img/cloud.png') }}" class="form-image cloud" alt="">
                <img src="{{ asset('assets/img/stars.png') }}" class="form-image stars" alt="">
            </div>
        </div>

        <div class="col col-2">
            <div class="btn-box">
                <a class="btn btn-2" href="{{ route('register') }}">Sign Up</a>
            </div>

            <!-- logins Form Container -->
            <div class="login-form active">
                <div class="form-tittle">
                    <span>Sign In</span>
                </div>
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form action="{{ route('login') }}" method="POST" class="form-inputs">
                    @csrf
                    <div class="input-box">
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="Email"  class="input-field" placeholder="Email"/>
                        <i class="bx bx-user icon"></i>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

                    <div class="input-box">
                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" class="input-field" placeholder="Password"/>
                        <i class="bx bx-lock-alt icon"></i>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    <div class="forgot-pass">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>
                    <div class="input-box">
                       <button class="input-submit">
                            <span>Sign In</span>
                            <i class="bx bx-right-arrow-alt"></i>
                       </button>
                    </div>
                </form>

            </div>
        </div>
     </div>
    <!-- JS -->
    <script src="{{ asset('assets/js/login.js') }}"></script>
</body>
</html>


