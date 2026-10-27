<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GlowStudio Inventory') }}</title>

    <!-- Fonts & CSS (Bootstrap & FontAwesome) -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            background-color: #fcf6f5;
            font-family: 'Nunito', sans-serif;
        }
        /* Styling Sidebar Pastel GlowStudio */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background-color: #fff9f9;
        }
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: 1rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            font-weight: 500;
            color: #6d6875;
            padding: 12px 20px;
            margin: 4px 12px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: #fff;
            background-color: #b5838d;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        /* Main Content Area */
        main {
            padding: 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                position: static;
                height: auto;
                padding-top: 0;
            }
            main {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        @auth
            <!-- Sidebar HANYA MUNCUL jika user sudah login -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="sidebar-sticky d-flex flex-column h-100">
                    <!-- Judul / Logo Aplikasi -->
                    <div class="text-center mb-4 px-3">
                        <h5 class="font-weight-bold" style="color: #b5838d;">
                            <i class="fas fa-pump-soap mr-1"></i> GlowStudio
                        </h5>
                        <span class="small text-muted">Inventory System</span>
                    </div>

                    <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted font-weight-bold" style="font-size: 0.75rem; letter-spacing: 1px;">
                        MENU UTAMA
                    </h6>
                    <ul class="nav flex-column mb-auto">
                        <!-- Menu Operasional (Bisa diakses Admin & Staff) -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                                <i class="fas fa-box"></i> Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('sales.*') && !request()->routeIs('sales.report') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                                <i class="fas fa-cash-register"></i> Penjualan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}" href="{{ route('purchases.index') }}">
                                <i class="fas fa-truck-loading"></i> Restock Barang
                            </a>
                        </li>

                        <!-- ========================================== -->
                        <!-- MENU KHUSUS ADMIN (Kategori, Supplier, Laporan, Staff) -->
                        <!-- ========================================== -->
                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted font-weight-bold" style="font-size: 0.75rem; letter-spacing: 1px;">
                                ADMINISTRATOR
                            </h6>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                                    <i class="fas fa-tags"></i> Kategori
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                                    <i class="fas fa-truck"></i> Supplier
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('sales.report') ? 'active' : '' }}" href="{{ route('sales.report') }}">
                                    <i class="fas fa-file-alt"></i> Laporan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('staff.*') ? 'active' : '' }}" href="{{ route('staff.index') }}">
                                    <i class="fas fa-users-cog"></i> Manajemen Staff
                                </a>
                            </li>
                        @endif
                    </ul>

                    <hr class="my-3 mx-3" style="border-color: #ebd5d8;">

                    <!-- Informasi User & Tombol Logout di Bawah Sidebar -->
                    <div class="px-3 mt-auto mb-4">
                        <div class="small font-weight-bold text-dark mb-1">
                            <i class="fas fa-user-circle mr-1 text-secondary"></i> {{ Auth::user()->name ?? 'User' }}
                        </div>
                        <div class="small text-muted mb-2" style="font-size: 0.75rem;">
                            Role: <span class="badge badge-secondary text-uppercase">{{ Auth::user()->role ?? '-' }}</span>
                        </div>
                        <a class="btn btn-sm btn-outline-danger btn-block" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="border-radius: 8px;">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </nav>
        @endauth

        <!-- Konten Utama di Sebelah Kanan -->
        <main style="margin-left: {{ Auth::check() ? '240px' : '0' }};">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>