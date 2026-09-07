<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sistem Surat Pelindo</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #e4e6e9 0%, #f5f6f8 100%);
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px 35px;
            transition: all 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-brand {
            display: flex;
            justify-content: center;
            margin-bottom: 8px;
        }

        .login-brand .logo-pelindo {
            height: 70px;
            width: auto;
            object-fit: contain;
            transition: all 0.3s ease;
        }

        .login-brand .logo-pelindo:hover {
            transform: scale(1.02);
        }

        .login-tagline {
            font-size: 13px;
            color: #6c757d;
            letter-spacing: 0.5px;
            font-weight: 500;
            text-align: center;
        }

        .login-tagline .badge-version {
            background: #C8962C;
            color: white;
            font-size: 9px;
            padding: 2px 10px;
            border-radius: 50px;
            letter-spacing: 0.5px;
            display: inline-block;
            margin-left: 5px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #003366;
            box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: #1a2b3c;
            font-size: 13px;
        }

        .btn-login {
            background: #003366;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: #002244;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 51, 102, 0.3);
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #6c757d;
        }

        .login-footer a {
            color: #003366;
            text-decoration: none;
            font-weight: 600;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .demo-account {
            margin-top: 25px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            border: 1px dashed #dee2e6;
        }

        .demo-account p {
            margin-bottom: 5px;
            font-size: 12px;
            color: #6c757d;
        }

        .demo-account .demo-item {
            display: inline-block;
            background: white;
            padding: 2px 10px;
            border-radius: 5px;
            font-size: 11px;
            margin: 2px 3px;
            border: 1px solid #e9ecef;
            font-weight: 500;
            color: #003366;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 30px 20px;
            }

            .login-brand .logo-pelindo {
                height: 50px;
            }

            .login-tagline {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

    <div class="login-page">
        <div class="login-card">

            <!-- ========================================== -->
            <!-- LOGO PELINDO -->
            <!-- ========================================== -->
            <div class="login-header">
                <div class="login-brand">
                    <img src="{{ asset('images/logo-pelindo.png') }}" 
                         alt="Logo Pelindo" 
                         class="logo-pelindo">
                </div>
                <div class="login-tagline">
                    Sistem Manajemen Surat Masuk
                </div>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Form Login -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-envelope me-1" style="color: #003366;"></i> Email atau NIP
                    </label>
                    <input type="text" name="login" value="{{ old('login') }}" 
                           class="form-control @error('login') is-invalid @enderror"
                           placeholder="Email atau NIP" required autofocus>
                    @error('login')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-lock me-1" style="color: #003366;"></i> Password
                    </label>
                    <input type="password" name="password" 
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="••••••••" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i> Login
                </button>
            </form>

    

        </div>
    </div>

    @stack('scripts')
</body>
</html>