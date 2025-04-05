@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Tổng số hóa đơn -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng số hóa đơn</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $hoadons->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hóa đơn chưa thanh toán -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Chưa thanh toán</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $hoadons->where('tinhtrang', 0)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tổng số khách hàng -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Tổng số khách hàng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $khachhangs->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tổng số nhân viên -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Tổng số nhân viên</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $nhanviens->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Hóa đơn gần đây -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Hóa đơn gần đây</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Mã HD</th>
                                    <th>Khách hàng</th>
                                    <th>Kỳ</th>
                                    <th>Tổng tiền</th>
                                    <th>Tình trạng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hoadons->take(5) as $hd)
                                <tr>
                                    <td>{{ $hd->mahd }}</td>
                                    <td>{{ $hd->chiTietHoaDon->first()->dienKe->khachHang->tenkh }}</td>
                                    <td>{{ $hd->ky }}</td>
                                    <td>{{ number_format($hd->tinhTongTien(), 0, ',', '.') }}</td>
                                    <td>
                                        @if($hd->tinhtrang == 0)
                                            <span class="badge bg-warning">Chưa thanh toán</span>
                                        @else
                                            <span class="badge bg-success">Đã thanh toán</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê thanh toán -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thống kê thanh toán</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4">
                        <canvas id="paymentChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Đã thanh toán
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> Chưa thanh toán
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dữ liệu cho biểu đồ
    const data = {
        labels: ['Đã thanh toán', 'Chưa thanh toán'],
        datasets: [{
            data: [
                {{ $hoadons->where('tinhtrang', 1)->count() }},
                {{ $hoadons->where('tinhtrang', 0)->count() }}
            ],
            backgroundColor: ['#1cc88a', '#f6c23e'],
            hoverBackgroundColor: ['#17a673', '#f4b619'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    };

    // Cấu hình biểu đồ
    const config = {
        type: 'doughnut',
        data: data,
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '70%'
        }
    };

    // Vẽ biểu đồ
    const ctx = document.getElementById('paymentChart').getContext('2d');
    new Chart(ctx, config);
});
</script>
@endsection 