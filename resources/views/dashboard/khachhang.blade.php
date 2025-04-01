@extends('layouts.admin')

@section('title', 'Quản Lý Khách Hàng')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản Lý Khách Hàng</h1>
        <button class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm Khách Hàng
        </button>
    </div>

    <!-- Search Box -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tìm kiếm</label>
                        <input type="text" class="form-control" placeholder="Tên khách hàng, mã khách hàng...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Khu vực</label>
                        <select class="form-control">
                            <option>Tất cả</option>
                            <option>Khu vực 1</option>
                            <option>Khu vực 2</option>
                            <option>Khu vực 3</option>
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

    <!-- Customers Table -->
    <div class="card dashboard-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>Mã KH</th>
                            <th>Họ và Tên</th>
                            <th>Địa Chỉ</th>
                            <th>Số Điện Thoại</th>
                            <th>Email</th>
                            <th>Khu Vực</th>
                            <th>Trạng Thái</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>KH001</td>
                            <td>Nguyễn Văn A</td>
                            <td>123 Nguyễn Huệ, Q1</td>
                            <td>0901234567</td>
                            <td>nguyenvana@email.com</td>
                            <td>Khu vực 1</td>
                            <td><span class="badge bg-success">Đang hoạt động</span></td>
                            <td>
                                <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>KH002</td>
                            <td>Trần Thị B</td>
                            <td>456 Lê Lợi, Q5</td>
                            <td>0907654321</td>
                            <td>tranthib@email.com</td>
                            <td>Khu vực 2</td>
                            <td><span class="badge bg-success">Đang hoạt động</span></td>
                            <td>
                                <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>KH003</td>
                            <td>Lê Văn C</td>
                            <td>789 Trần Hưng Đạo, Q3</td>
                            <td>0903456789</td>
                            <td>levanc@email.com</td>
                            <td>Khu vực 1</td>
                            <td><span class="badge bg-warning">Tạm ngưng</span></td>
                            <td>
                                <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>Hiển thị 1-3 của 50 khách hàng</div>
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