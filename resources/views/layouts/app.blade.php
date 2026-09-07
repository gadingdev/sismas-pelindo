<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Surat Pelindo')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')

    <style>
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            border-radius: 8px;
            color: #1a2b3c;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            margin-bottom: 2px;
        }

        .sidebar-link:hover {
            background-color: #f1f5f9;
            color: #003366;
        }

        .sidebar-link.active {
            background-color: #003366;
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 51, 102, 0.25);
        }

        .sidebar-link.active i {
            color: #ffffff;
        }

        .sidebar-link i {
            width: 20px;
            text-align: center;
            font-size: 16px;
            color: #4a5568;
            transition: color 0.2s ease;
        }

        .sidebar-link.active i {
            color: #ffffff;
        }

        .sidebar-link .link-text {
            margin-left: 12px;
            font-size: 14px;
        }

        .sidebar-divider {
            margin: 8px 16px;
            border-color: #e9ecef;
        }

        .sidebar-logo {
            text-align: center;
            padding: 20px 16px 16px 16px;
            border-bottom: 1px solid #e9ecef;
        }

        .sidebar-logo img {
            height: 45px;
            width: auto;
            object-fit: contain;
        }

        .sidebar-logo .logo-title {
            margin-top: 8px;
            margin-bottom: 0;
            font-weight: 600;
            font-size: 13px;
            color: #4a5568;
        }

        .sidebar-logo .logo-version {
            font-size: 9px;
            font-weight: 500;
            letter-spacing: 0.5px;
            background-color: #003366;
            color: white;
            padding: 2px 10px;
            border-radius: 50px;
            display: inline-block;
            margin-top: 4px;
        }

        .user-info {
            display: flex;
            align-items: center;
            padding: 4px 14px;
            border-radius: 50px;
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .user-info .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #003366;
        }

        .user-info .user-avatar-placeholder {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #003366;
            color: #ffffff;
            font-weight: 700;
            font-size: 14px;
        }

        .user-info .user-name {
            font-size: 13px;
            font-weight: 600;
            color: #1a2b3c;
            line-height: 1.2;
        }

        .user-info .user-role {
            font-size: 10px;
            color: #6c757d;
            line-height: 1.2;
        }
    </style>
</head>
<body>

    <div class="d-flex" style="height: 100vh; overflow: hidden;">
        
        <!-- ========================================== -->
        <!-- SIDEBAR -->
        <!-- ========================================== -->
        <div class="d-flex flex-column flex-shrink-0" style="width: 250px; min-width: 250px; background-color: #ffffff; border-right: 1px solid #e9ecef; height: 100vh; overflow-y: auto; z-index: 1050; position: relative;">
            
            <div class="sidebar-logo">
                <img src="{{ asset('images/logo-pelindo.png') }}" alt="Logo Pelindo">
                <p class="logo-title">Sistem Manajemen Surat Masuk</p>
            </div>

            <!-- ========================================== -->
            <!-- NAVIGASI SIDEBAR -->
            <!-- ========================================== -->
            <ul class="nav flex-column" style="padding: 12px 12px 4px 12px;">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                       href="{{ route('dashboard') }}">
                        <i class="fas fa-gauge-high"></i>
                        <span class="link-text">Dashboard</span>
                    </a>
                </li>

                <!-- Foto (Kelola Foto Dashboard) -->
                <li class="nav-item">
                    <a class="sidebar-link {{ request()->routeIs('dashboard.foto*') ? 'active' : '' }}" 
                       href="{{ route('dashboard.foto') }}">
                        <i class="fas fa-images"></i>
                        <span class="link-text">Foto</span>
                    </a>
                </li>

                <!-- Profil -->
                <li class="nav-item">
                    <a class="sidebar-link {{ request()->routeIs('profil*') ? 'active' : '' }}" 
                       href="{{ route('profil.index') }}">
                        <i class="fas fa-user"></i>
                        <span class="link-text">Profil</span>
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <button onclick="confirmLogout()" class="sidebar-link" style="border: none; background: none; width: 100%; text-align: left; cursor: pointer; color: #dc3545;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="link-text">Logout</span>
                    </button>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>

        </div>

        <!-- ========================================== -->
        <!-- KONTEN UTAMA -->
        <!-- ========================================== -->
        <div class="d-flex flex-column flex-grow-1" style="height: 100vh; overflow: hidden;">

            <!-- NAVBAR -->
            <nav class="navbar navbar-expand-md flex-shrink-0" style="background-color: #ffffff; border-bottom: 1px solid #e9ecef; padding: 8px 16px; min-height: 62px;">
                <div class="container-fluid" style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between;">
                    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" style="color: #003366;">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <span></span>
                    
                    <ul class="navbar-nav ms-auto align-items-center">
                        <!-- ========================================== -->
                        <!-- USER INFO  -->
                        <!-- ========================================== -->
                        <li class="nav-item">
                            <div class="user-info">
                                @if(Auth::user()->foto)
                                    <img src="{{ Storage::url(Auth::user()->foto) }}" 
                                         class="user-avatar me-2">
                                @else
                                    <div class="user-avatar-placeholder me-2">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="d-flex flex-column">
                                    <span class="user-name">{{ Auth::user()->name }}</span>
                                    <span class="user-role">{{ Auth::user()->role_label }}</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- KONTEN -->
            <main class="flex-grow-1 p-4 overflow-auto" style="background-color: #e2e2e2;">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @yield('content')
            </main>

        </div>
    </div>

    @push('scripts')
    <script>
    function confirmLogout() {
        Swal.fire({
            title: 'Apakah Anda yakin ingin keluar?',
            text: "Anda akan keluar dari sistem dan harus login kembali.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#003366',
            confirmButtonText: '<i class="fas fa-sign-out-alt me-2"></i> Ya, Keluar!',
            cancelButtonText: '<i class="fas fa-times me-2"></i> Batal',
            reverseButtons: true,
            backdrop: 'rgba(0, 51, 102, 0.2)',
            background: '#ffffff',
            customClass: {
                title: 'text-dark fw-bold',
                confirmButton: 'btn btn-danger px-4 py-2',
                cancelButton: 'btn btn-primary px-4 py-2',
                popup: 'rounded-4 shadow-lg',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
    </script>
    @endpush

    @stack('scripts')
</body>
</html>