<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Acceso') — {{ config('app.name', 'CPET') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @if (file_exists(public_path('images/icon/logo.png')))
        <link rel="shortcut icon" href="{{ asset('images/icon/logo.png') }}" type="image/x-icon">
    @endif

    @vite(['resources/css/app.css'])

    <style>
        .auth-shell {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1.25rem;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            font-family: "Poppins", ui-sans-serif, system-ui, sans-serif;
            background:
                radial-gradient(ellipse 90% 70% at 10% 20%, rgba(196, 146, 46, 0.14), transparent 55%),
                radial-gradient(ellipse 80% 60% at 90% 85%, rgba(47, 111, 173, 0.35), transparent 50%),
                linear-gradient(155deg, #07101c 0%, #0f2744 42%, #1a4574 100%);
        }

        .auth-shell::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient(
                    -32deg,
                    transparent,
                    transparent 11px,
                    rgba(255, 255, 255, 0.015) 11px,
                    rgba(255, 255, 255, 0.015) 12px
                );
            pointer-events: none;
        }

        .auth-panel {
            position: relative;
            z-index: 1;
            width: min(100%, 420px);
            background: #f7f9fb;
            border-radius: 1rem;
            box-shadow: 0 24px 48px rgba(10, 22, 40, 0.28);
            padding: 2.25rem 2rem 2rem;
            animation: auth-rise 0.5s ease-out both;
        }

        @keyframes auth-rise {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-brand { text-align: center; margin-bottom: 1.75rem; }

        .auth-brand__mark {
            width: 64px;
            height: 64px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: linear-gradient(145deg, #1a4574, #0a1628);
            border: 2px solid rgba(196, 146, 46, 0.55);
            overflow: hidden;
        }

        .auth-brand__mark img { width: 100%; height: 100%; object-fit: cover; }
        .auth-brand__mark span { font-weight: 700; font-size: 1.1rem; color: #f5e6c8; }

        .auth-brand__name {
            font-size: clamp(1.55rem, 4vw, 1.85rem);
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 0.35rem;
        }

        .auth-brand__tag {
            margin: 0;
            font-size: 0.9rem;
            font-weight: 500;
            color: #3d5a73;
        }

        .auth-heading { margin: 0 0 1.35rem; text-align: center; }
        .auth-heading h1 { margin: 0 0 0.4rem; font-size: 1.2rem; font-weight: 600; color: #183b61; }
        .auth-heading p { margin: 0; font-size: 0.9rem; color: #3d5a73; line-height: 1.45; }

        .auth-alert {
            margin: 0 0 1rem;
            padding: 0.75rem 0.9rem;
            border-radius: 0.5rem;
            font-size: 0.88rem;
        }
        .auth-alert--danger { background: #fef3f2; color: #b42318; border: 1px solid #fecdca; }
        .auth-alert--info { background: #eef4fa; color: #1a4574; border: 1px solid #c9d8e8; }

        .auth-field { margin-bottom: 1.05rem; }
        .auth-field label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.84rem;
            font-weight: 600;
            color: #183b61;
        }
        .auth-field input[type="text"],
        .auth-field input[type="email"],
        .auth-field input[type="password"] {
            width: 100%;
            padding: 0.72rem 0.9rem;
            border: 1px solid #c5d0db;
            border-radius: 0.5rem;
            background: #fff;
            font: inherit;
            font-size: 0.95rem;
            color: #0f172a;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .auth-field input:focus {
            outline: none;
            border-color: #c4922e;
            box-shadow: 0 0 0 3px rgba(196, 146, 46, 0.28);
        }
        .auth-field input.is-invalid { border-color: #b42318; }
        .auth-error { display: block; margin-top: 0.35rem; font-size: 0.8rem; color: #b42318; }

        .auth-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 1.35rem;
            flex-wrap: wrap;
        }
        .auth-check {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            font-size: 0.88rem;
            color: #3d5a73;
            cursor: pointer;
        }
        .auth-check input { accent-color: #183b61; }
        .auth-link { font-size: 0.88rem; font-weight: 600; color: #1a4574; text-decoration: none; }
        .auth-link:hover { color: #a67822; text-decoration: underline; }

        .auth-submit {
            width: 100%;
            border: 0;
            border-radius: 0.5rem;
            padding: 0.85rem 1rem;
            font: inherit;
            font-size: 0.95rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(180deg, #1f568f 0%, #0f2744 100%);
            cursor: pointer;
            box-shadow: 0 10px 22px rgba(18, 38, 63, 0.28);
            transition: filter 0.2s, transform 0.15s;
        }
        .auth-submit:hover { filter: brightness(1.06); }
        .auth-submit:active { transform: translateY(1px); }
        .auth-submit--accent {
            background: linear-gradient(180deg, #d0a045 0%, #c4922e 100%);
            color: #1a1408;
        }

        .auth-foot {
            margin-top: 0.5rem;
            text-align: center;
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.55);
            position: relative;
            z-index: 1;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="auth-shell">
        @yield('content')
        <p class="auth-foot">© {{ date('Y') }} Policía del Estado Trujillo · CPET</p>
    </div>
    @yield('scripts')
</body>
</html>
