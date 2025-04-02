<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tiền Điện - @yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <!-- <nav id="sidebar" class="bg-primary text-white">
            <div class="sidebar-header">
                <h3>Quản Lý Tiền Điện</h3>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <a href="/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li>
                    <a href="/khachhang"><i class="fas fa-users"></i> Khách Hàng</a>
                </li>
                <li>
                    <a href="/dienke"><i class="fas fa-calculator"></i> Điện Kế</a>
                </li>
                <li>
                    <a href="/hoadon"><i class="fas fa-file-invoice"></i> Hóa Đơn</a>
                </li>
                <li>
                    <a href="/giadien"><i class="fas fa-money-bill"></i> Giá Điện</a>
                </li>
                <li>
                    <a href="/users"><i class="fas fa-user"></i> Người Dùng</a>
                </li>
            </ul>

            <div class="mt-auto p-3">
                <form action="{{ route('logout') }}" method="POST" class="d-grid">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                    </button>
                </form>
            </div>
        </nav> -->

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="sidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Quản lý tiền điện</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="/dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/khachhang">
                    <i class="fas fa-users"></i>
                    <span>Khách Hàng</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/dienke">
                    <i class="fas fa-calculator"></i>
                    <span>Điện Kế</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/hoadon">
                    <i class="fas fa-file-invoice"></i>
                    <span>Hóa Đơn</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/giadien">
                    <i class="fas fa-money-bill"></i>
                    <span>Giá Điện</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/users">
                    <i class="fas fa-user"></i>
                    <span>Người Dùng</span>
                </a>
            </li>
        </ul>

        <!-- Page Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light mb-2">
                <div class="container-fluid d-flex">
                    <!-- Nút Toggle Sidebar (Ẩn trên màn hình lớn, hiển thị trên màn hình nhỏ) -->
                    <button type="button" id="sidebarCollapse" class="btn btn-info d-md-none d-block">
                        <i class="fas fa-bars"></i>
                    </button>

                    <!-- Đẩy dropdown về cuối cùng -->
                    <div class="ms-auto">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i> {{ Session::get('nhanvien')->manv ?? 'Admin' }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user-cog"></i> Profile</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>


            <!-- Main Content -->
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>

</html>