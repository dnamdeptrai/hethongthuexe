<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hệ thống Quản trị')</title>

    @vite(['resources/css/admin/layout.css'])
    @stack('styles')
</head>
<body>

    <nav class="admin-topbar">
        <div class="topbar-container">
            
            <div class="topbar-left">
                <a href="{{ route('admin.dashboard') }}" class="logo-link">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Carento" class="admin-logo">
                </a>
                
                <ul class="topbar-menu">
                    <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Bảng điều khiển</a></li>
                    <li><a href="{{ route('admin.booking') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">Đơn đặt xe</a></li>
                    <li><a href="{{ route('admin.cars.index') }}" class="{{ request()->routeIs('admin.cars.*') ? 'active' : '' }}">Kho Xe</a></li>                    <li><a href="#">Khách hàng</a></li>
                    <li><a href="#">Tin nhắn</a></li>
                </ul>
            </div>

            <div class="topbar-right">
                <div class="user-dropdown">
                    <button class="user-dropdown-btn">
                        {{ Auth::user()->name }}
                        <svg class="icon-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="dropdown-menu">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Đăng xuất</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </nav>

    <main class="admin-main-container">
        <div class="admin-page-header">
            <h2 class="page-title">@yield('page_title', 'Hệ thống quản trị')</h2>
        </div>
        
        <div class="admin-content">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>