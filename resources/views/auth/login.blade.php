@extends('layouts.master')
@section('content')
    <div class="login-container">
        <h2 class="login-title">Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="inputLogin" class="form-label">Email address</label>
                <input id="inputLogin" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <span>{{ $message }}</span>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputChoosePassword" class="form-label">Password</label>
                <input id="inputChoosePassword" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <span>{{ $message }}</span>
                    </span>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="flexSwitchCheckChecked"
                    {{ old('remember') || isset($_COOKIE['remember_login']) ? 'checked' : '' }}>
                    <label class="form-check-label" for="flexSwitchCheckChecked">Remember me</label>
                </div>
                <a href="{{ route('password.request') }}" class="forgot-password text-primary">Forgot Password?</a>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginInput = document.getElementById('inputLogin');
            const passwordInput = document.getElementById('inputChoosePassword');
            const rememberCheckbox = document.getElementById('flexSwitchCheckChecked');

            // Retrieve saved login details if "Remember Me" was checked
            if (rememberCheckbox.checked) {
                loginInput.value = getCookie('remember_login') || '';
                passwordInput.value = getCookie('remember_password') || '';
            }

            // Save login details to cookies if "Remember Me" is checked
            rememberCheckbox.addEventListener('change', function() {
                if (rememberCheckbox.checked) {
                    setCookie('remember_login', loginInput.value, 7);
                    setCookie('remember_password', passwordInput.value, 7);
                } else {
                    deleteCookie('remember_login');
                    deleteCookie('remember_password');
                }
            });

            // Cookie handling functions
            function setCookie(name, value, days) {
                const d = new Date();
                d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
                const expires = "expires=" + d.toUTCString();
                document.cookie = name + "=" + value + ";" + expires + ";path=/";
            }

            function getCookie(name) {
                const nameEQ = name + "=";
                const ca = document.cookie.split(';');
                for (let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
                }
                return null;
            }

            function deleteCookie(name) {
                document.cookie = name + '=; Max-Age=-99999999;';
            }
        });
    </script>
@endpush
