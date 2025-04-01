@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Tạo Báo Cáo
        </a>
    </div>

    <!-- Stats Cards Row -->
    <div class="row">
        <!-- Tổng số khách hàng Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Khách Hàng</div>
                            <div class="h5 mb-0 font-weight-bold">2,500</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tổng thu Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card bg-gradient-success text-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng Thu (Tháng)</div>
                            <div class="h5 mb-0 font-weight-bold">500,000,000 đ</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hóa đơn chưa thanh toán Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card bg-gradient-info text-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Hóa Đơn Chưa Thu</div>
                            <div class="h5 mb-0 font-weight-bold">50</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-invoice fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tổng điện tiêu thụ Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card bg-gradient-warning text-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Điện Tiêu Thụ (Tháng)</div>
                            <div class="h5 mb-0 font-weight-bold">150,000 kWh</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bolt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Hóa Đơn Gần Đây -->
        <div class="col-12 col-lg-6 mb-4">
            <div class="card dashboard-card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Hóa Đơn Gần Đây</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th>Mã HĐ</th>
                                    <th>Khách Hàng</th>
                                    <th>Số Tiền</th>
                                    <th>Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>HD001</td>
                                    <td>Nguyễn Văn A</td>
                                    <td>1,500,000 đ</td>
                                    <td><span class="badge bg-success">Đã Thu</span></td>
                                </tr>
                                <tr>
                                    <td>HD002</td>
                                    <td>Trần Thị B</td>
                                    <td>2,300,000 đ</td>
                                    <td><span class="badge bg-warning">Chưa Thu</span></td>
                                </tr>
                                <tr>
                                    <td>HD003</td>
                                    <td>Lê Văn C</td>
                                    <td>1,800,000 đ</td>
                                    <td><span class="badge bg-danger">Quá Hạn</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Khách Hàng Mới -->
        <div class="col-12 col-lg-6 mb-4">
            <div class="card dashboard-card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Khách Hàng Mới</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th>Mã KH</th>
                                    <th>Tên</th>
                                    <th>Địa Chỉ</th>
                                    <th>Ngày Đăng Ký</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>KH001</td>
                                    <td>Phạm Thị D</td>
                                    <td>123 Nguyễn Huệ</td>
                                    <td>20/04/2024</td>
                                </tr>
                                <tr>
                                    <td>KH002</td>
                                    <td>Hoàng Văn E</td>
                                    <td>456 Lê Lợi</td>
                                    <td>19/04/2024</td>
                                </tr>
                                <tr>
                                    <td>KH003</td>
                                    <td>Trương Thị F</td>
                                    <td>789 Trần Hưng Đạo</td>
                                    <td>18/04/2024</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 