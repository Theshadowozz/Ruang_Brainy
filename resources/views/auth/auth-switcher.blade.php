@php
    $isRegister = ($authMode ?? 'login') === 'register';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isRegister ? 'Register' : 'Login' }} - Brainy</title>
    @include('layouts.vite')
    <style>
        .auth-shell {
            --auth-white: #fff;
            --auth-blue: #1283e8;
            --auth-blue-soft: #43a7ef;
            --auth-text: #1f2937;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            background: var(--auth-white);
        }

        .auth-visual-panel,
        .auth-form-panel {
            position: absolute;
            inset-block: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition:
                left 800ms cubic-bezier(.67, .67, .34, .95),
                right 800ms cubic-bezier(.67, .67, .34, .95),
                border-radius 800ms cubic-bezier(.67, .67, .34, .95);
            will-change: left, right, border-radius;
        }

        .auth-visual-panel {
            left: 0;
            width: 49%;
            padding: 48px;
            background: var(--auth-white);
        }

        .auth-form-panel {
            left: 49%;
            z-index: 2;
            width: 51%;
            overflow: hidden;
            padding: 40px 24px;
            border-radius: 8px 0 0 8px;
            background: linear-gradient(135deg, #dff3ff 0%, var(--auth-blue-soft) 42%, var(--auth-blue) 100%);
            box-shadow: -16px 0 40px rgba(18, 131, 232, .08);
        }

        .auth-form-panel::before {
            content: "";
            position: absolute;
            inset-block: 0;
            left: 0;
            width: 132px;
            background: linear-gradient(90deg, rgba(255, 255, 255, .9), rgba(255, 255, 255, .36), transparent);
            pointer-events: none;
        }

        .auth-orbit,
        .auth-orbit::after {
            position: absolute;
            right: -110px;
            bottom: -170px;
            width: 440px;
            height: 440px;
            border: 1px solid rgba(255, 255, 255, .35);
            border-radius: 999px;
            content: "";
            pointer-events: none;
        }

        .auth-orbit::after {
            right: -80px;
            bottom: -70px;
            width: 520px;
            height: 520px;
            border-color: rgba(255, 255, 255, .22);
        }

        .auth-illustration {
            width: min(390px, 82%);
            max-height: 70vh;
            object-fit: contain;
            transition: transform 800ms cubic-bezier(.67, .67, .34, .95), opacity 520ms ease;
            will-change: transform, opacity;
        }

        .auth-card {
            position: absolute;
            top: 50%;
            left: 50%;
            z-index: 3;
            width: min(360px, calc(100% - 42px));
            border-radius: 8px;
            background: #fff;
            padding: 30px 32px;
            color: var(--auth-text);
            box-shadow: 0 24px 48px rgba(12, 64, 120, .22);
            transition:
                opacity 740ms cubic-bezier(.22, 1, .36, 1),
                filter 740ms cubic-bezier(.22, 1, .36, 1),
                transform 740ms cubic-bezier(.22, 1, .36, 1);
            will-change: opacity, filter, transform;
        }

        .auth-card-login {
            opacity: 1;
            filter: blur(0);
            transform: translate(-50%, -50%) translateX(0) scale(1);
            pointer-events: auto;
        }

        .auth-card-register {
            opacity: 0;
            filter: blur(2px);
            transform: translate(-50%, -50%) translateX(-118%) scale(.96);
            pointer-events: none;
        }

        .auth-shell.go-register .auth-visual-panel {
            left: 0;
        }

        .auth-shell.go-register .auth-form-panel {
            left: 49%;
            border-radius: 8px 0 0 8px;
            box-shadow: -16px 0 40px rgba(18, 131, 232, .08);
        }

        .auth-shell.go-register .auth-form-panel::before {
            right: auto;
            left: 0;
            background: linear-gradient(90deg, rgba(255, 255, 255, .9), rgba(255, 255, 255, .36), transparent);
        }

        .auth-shell.go-register .auth-card-login {
            opacity: 0;
            filter: blur(2px);
            transform: translate(-50%, -50%) translateX(118%) scale(.96);
            pointer-events: none;
        }

        .auth-shell.go-register .auth-card-register {
            opacity: 1;
            filter: blur(0);
            transform: translate(-50%, -50%) translateX(0) scale(1);
            pointer-events: auto;
        }

        .auth-shell.is-switching .auth-card {
            transition:
                opacity 780ms cubic-bezier(.22, 1, .36, 1),
                filter 780ms cubic-bezier(.22, 1, .36, 1),
                transform 780ms cubic-bezier(.22, 1, .36, 1);
        }

        .auth-shell.is-switching .auth-form-panel {
            animation: authPanelWidth 800ms cubic-bezier(.67, .67, .34, .95) forwards;
        }

        .auth-shell.is-switching .auth-illustration {
            opacity: .82;
            transform: scale(.96);
        }

        @keyframes authPanelWidth {
            0% {
                width: 51%;
            }
            22% {
                width: 58%;
            }
            100% {
                width: 51%;
            }
        }

        .auth-title {
            margin: 0;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 0;
            color: #111827;
        }

        .auth-subtitle {
            margin-top: 8px;
            margin-bottom: 22px;
            font-size: 14px;
            font-weight: 600;
            color: #6b7280;
        }

        .auth-logo {
            display: block;
            width: auto;
            height: 48px;
            margin: 0 auto 20px;
            object-fit: contain;
        }

        .auth-form {
            display: grid;
            gap: 14px;
        }

        .auth-field {
            display: flex;
            height: 44px;
            align-items: center;
            gap: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            padding: 0 16px;
            background: #fff;
            transition: border-color 180ms ease, box-shadow 180ms ease;
        }

        .auth-field:focus-within {
            border-color: #60a5fa;
            box-shadow: 0 0 0 4px rgba(96, 165, 250, .18);
        }

        .auth-field svg {
            width: 16px;
            height: 16px;
            flex: none;
            color: #9ca3af;
        }

        .auth-field input {
            min-width: 0;
            width: 100%;
            height: 100%;
            border: 0;
            outline: 0;
            background: transparent;
            font-size: 14px;
            color: #111827;
        }

        .auth-field input::placeholder {
            color: #9ca3af;
        }

        .auth-button {
            display: flex;
            height: 44px;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 999px;
            background: linear-gradient(45deg, #2980b9, #3498db);
            color: #fff;
            font-size: 14px;
            font-weight: 800;
            transition: transform 180ms ease, filter 180ms ease;
        }

        .auth-button:hover {
            filter: brightness(.96);
            transform: translateY(-1px);
        }

        .auth-links {
            margin-top: 16px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 10px;
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
        }

        .auth-links a,
        .auth-links button {
            border: 0;
            background: transparent;
            padding: 0;
            color: #2563eb;
            font: inherit;
            cursor: pointer;
        }

        .auth-alert {
            margin-bottom: 14px;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 13px;
        }

        .auth-alert-success {
            border: 1px solid #a7f3d0;
            background: #ecfdf5;
            color: #047857;
        }

        .auth-alert-error {
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #b91c1c;
        }

        @media (max-width: 1023px) {
            .auth-shell {
                display: flex;
                flex-direction: column;
                overflow: auto;
            }

            .auth-visual-panel,
            .auth-form-panel {
                position: relative;
                inset: auto;
                width: 100%;
                transition: none;
            }

            .auth-visual-panel {
                min-height: 32vh;
                padding: 28px;
                order: 1;
            }

            .auth-form-panel {
                min-height: 68vh;
                border-radius: 0;
                order: 2;
            }

            .auth-shell.go-register .auth-visual-panel {
                left: auto;
                order: 1;
            }

            .auth-shell.go-register .auth-form-panel {
                left: auto;
                border-radius: 0;
                order: 2;
            }

            .auth-form-panel::before {
                display: none;
            }

            .auth-card {
                position: absolute;
                width: min(360px, calc(100% - 40px));
                padding: 28px;
            }
        }

        @media (max-width: 520px) {
            .auth-card {
                width: min(330px, calc(100% - 28px));
                padding: 24px;
            }

            .auth-title {
                font-size: 24px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .auth-shell *,
            .auth-shell *::before,
            .auth-shell *::after {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-white font-sans text-gray-950">
    <main id="auth-shell" class="auth-shell {{ $isRegister ? 'go-register' : 'go-login' }}">
        <section class="auth-visual-panel">
            <a href="{{ url('/') }}" class="sr-only">Kembali ke halaman utama Brainy</a>
            <img src="{{ asset('asset/asset_login.svg') }}" alt="Ilustrasi Brainy" class="auth-illustration">
        </section>

        <section class="auth-form-panel">
            <div class="auth-orbit" aria-hidden="true"></div>

            <section class="auth-card auth-card-login" aria-labelledby="login-title">
                <img src="{{ asset('images/logo_brainy.png') }}" alt="Brainy" class="auth-logo">
                <h1 id="login-title" class="auth-title">Hello!</h1>
                <p class="auth-subtitle">Sign In to Continue</p>

                @if (session('success'))
                    <div class="auth-alert auth-alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (!$isRegister && $errors->any())
                    <div class="auth-alert auth-alert-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login.store') }}" method="POST" class="auth-form">
                    @csrf

                    <label class="auth-field">
                        <span class="sr-only">Email Address</span>
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M4.75 6.75h14.5v10.5H4.75z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                            <path d="m5.25 7.25 6.75 5.5 6.75-5.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <input name="email" type="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address">
                    </label>

                    <label class="auth-field">
                        <span class="sr-only">Password</span>
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M7.5 10.25h9a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-9a1 1 0 0 1-1-1v-6a1 1 0 0 1 1-1Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                            <path d="M9 10.25V8a3 3 0 0 1 6 0v2.25" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                        <input name="password" type="password" required autocomplete="current-password" placeholder="Password">
                    </label>

                    <button type="submit" class="auth-button">Login</button>
                </form>

                <div class="auth-links">
                    <button type="button" data-auth-toggle="register" data-url="{{ route('register') }}">Create Account</button>
                    <span>Forgot Password?</span>
                </div>
            </section>

            <section class="auth-card auth-card-register" aria-labelledby="register-title">
                <h1 id="register-title" class="auth-title">Hello!</h1>
                <p class="auth-subtitle">Sign Up to Get Started</p>

                @if ($isRegister && $errors->any())
                    <div class="auth-alert auth-alert-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('register.store') }}" method="POST" class="auth-form">
                    @csrf

                    <label class="auth-field">
                        <span class="sr-only">Full Name</span>
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 12.25a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" stroke="currentColor" stroke-width="1.8"/>
                            <path d="M5.25 19.25a6.75 6.75 0 0 1 13.5 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                        <input name="name" type="text" value="{{ old('name') }}" required autocomplete="name" placeholder="Full Name">
                    </label>

                    <label class="auth-field">
                        <span class="sr-only">Email Address</span>
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M4.75 6.75h14.5v10.5H4.75z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                            <path d="m5.25 7.25 6.75 5.5 6.75-5.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <input name="email" type="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address">
                    </label>

                    <label class="auth-field">
                        <span class="sr-only">Password</span>
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M7.5 10.25h9a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-9a1 1 0 0 1-1-1v-6a1 1 0 0 1 1-1Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                            <path d="M9 10.25V8a3 3 0 0 1 6 0v2.25" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                        <input name="password" type="password" required autocomplete="new-password" placeholder="Password">
                    </label>

                    <label class="auth-field">
                        <span class="sr-only">Confirm Password</span>
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M7.5 10.25h9a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-9a1 1 0 0 1-1-1v-6a1 1 0 0 1 1-1Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                            <path d="M9 10.25V8a3 3 0 0 1 6 0v2.25" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                        <input name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Confirm Password">
                    </label>

                    <button type="submit" class="auth-button">Register</button>
                </form>

                <div class="auth-links">
                    <button type="button" data-auth-toggle="login" data-url="{{ route('login') }}">Login Account</button>
                    <span>Forgot Password?</span>
                </div>
            </section>
        </section>
    </main>

    <script>
        const authShell = document.getElementById('auth-shell');
        const toggleButtons = document.querySelectorAll('[data-auth-toggle]');
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

        toggleButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const target = button.dataset.authToggle;
                const targetUrl = button.dataset.url;
                const wantsRegister = target === 'register';

                if (authShell.classList.contains(wantsRegister ? 'go-register' : 'go-login')) {
                    return;
                }

                authShell.classList.add('is-switching');
                authShell.classList.toggle('go-register', wantsRegister);
                authShell.classList.toggle('go-login', !wantsRegister);

                if (targetUrl) {
                    window.history.pushState({}, '', targetUrl);
                }

                window.setTimeout(() => {
                    authShell.classList.remove('is-switching');
                }, reduceMotion.matches ? 0 : 880);
            });
        });

        window.addEventListener('popstate', () => {
            const isRegisterPath = window.location.pathname.includes('register');
            authShell.classList.toggle('go-register', isRegisterPath);
            authShell.classList.toggle('go-login', !isRegisterPath);
        });
    </script>
</body>
</html>
