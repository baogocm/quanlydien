@extends('layouts.admin')

@section('title', 'Quản Lý Hóa Đơn')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản Lý Hóa Đơn</h1>
        <button class="btn btn-primary">
            <i class="fas fa-plus"></i> Tạo Hóa Đơn
        </button>
    </div>

    <!-- Search Box -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Mã hóa đơn</label>
                        <input type="text" class="form-control" placeholder="Nhập mã hóa đơn...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Khách hàng</label>
                        <input type="text" class="form-control" placeholder="Tên hoặc mã khách hàng...">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Từ ngày</label>
                        <input type="date" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Đến ngày</label>
                        <input type="date" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button class="btn btn-primary form-control">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bills Table -->
    <div class="card dashboard-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>Mã HĐ</th>
                            <th>Khách Hàng</th>
                            <th>Kỳ Hóa Đơn</th>
                            <th>Chỉ Số Cũ</th>
                            <th>Chỉ Số Mới</th>
                            <th>Tiêu Thụ</th>
                            <th>Thành Tiền</th>
                            <th>Trạng Thái</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>HD001</td>
                            <td>Nguyễn Văn A</td>
                            <td>03/2024</td>
                            <td>1,234</td>
                            <td>1,534</td>
                            <td>300 kWh</td>
                            <td>750,000 đ</td>
                            <td><span class="badge bg-success">Đã thanh toán</span></td>
                            <td>
                                <button class="btn btn-sm btn-info" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" title="In hóa đơn">
                                    <i class="fas fa-print"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>HD002</td>
                            <td>Trần Thị B</td>
                            <td>03/2024</td>
                            <td>2,345</td>
                            <td>2,789</td>
                            <td>444 kWh</td>
                            <td>1,110,000 đ</td>
                            <td><span class="badge bg-warning">Chưa thanh toán</span></td>
                            <td>
                                <button class="btn btn-sm btn-info" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" title="In hóa đơn">
                                    <i class="fas fa-print"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>HD003</td>
                            <td>Lê Văn C</td>
                            <td>03/2024</td>
                            <td>3,456</td>
                            <td>3,890</td>
                            <td>434 kWh</td>
                            <td>1,085,000 đ</td>
                            <td><span class="badge bg-danger">Quá hạn</span></td>
                            <td>
                                <button class="btn btn-sm btn-info" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" title="In hóa đơn">
                                    <i class="fas fa-print"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>Hiển thị 1-3 của 100 hóa đơn</div>
                <nav>
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection 