@extends('layouts.admin')

@section('title', 'Quản Lý Điện Kế')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản Lý Điện Kế</h1>
        <button class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm Điện Kế
        </button>
    </div>

    <!-- Search Box -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Mã điện kế</label>
                        <input type="text" class="form-control" placeholder="Nhập mã điện kế...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Khách hàng</label>
                        <input type="text" class="form-control" placeholder="Tên hoặc mã khách hàng...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select class="form-control">
                            <option>Tất cả</option>
                            <option>Đang hoạt động</option>
                            <option>Đang bảo trì</option>
                            <option>Ngưng hoạt động</option>
                        </select>
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

    <!-- Electricity Meters Table -->
    <div class="card dashboard-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>Mã Điện Kế</th>
                            <th>Khách Hàng</th>
                            <th>Địa Chỉ Lắp Đặt</th>
                            <th>Chỉ Số Hiện Tại</th>
                            <th>Ngày Lắp Đặt</th>
                            <th>Trạng Thái</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>DK001</td>
                            <td>Nguyễn Văn A</td>
                            <td>123 Nguyễn Huệ, Q1</td>
                            <td>1,234 kWh</td>
                            <td>01/01/2024</td>
                            <td><span class="badge bg-success">Đang hoạt động</span></td>
                            <td>
                                <button class="btn btn-sm btn-info" title="Cập nhật chỉ số">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" title="Lịch sử chỉ số">
                                    <i class="fas fa-history"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>DK002</td>
                            <td>Trần Thị B</td>
                            <td>456 Lê Lợi, Q5</td>
                            <td>2,345 kWh</td>
                            <td>15/01/2024</td>
                            <td><span class="badge bg-warning">Đang bảo trì</span></td>
                            <td>
                                <button class="btn btn-sm btn-info" title="Cập nhật chỉ số">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" title="Lịch sử chỉ số">
                                    <i class="fas fa-history"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>DK003</td>
                            <td>Lê Văn C</td>
                            <td>789 Trần Hưng Đạo, Q3</td>
                            <td>3,456 kWh</td>
                            <td>01/02/2024</td>
                            <td><span class="badge bg-success">Đang hoạt động</span></td>
                            <td>
                                <button class="btn btn-sm btn-info" title="Cập nhật chỉ số">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" title="Lịch sử chỉ số">
                                    <i class="fas fa-history"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>Hiển thị 1-3 của 30 điện kế</div>
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