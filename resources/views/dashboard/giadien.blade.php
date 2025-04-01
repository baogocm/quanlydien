@extends('layouts.admin')

@section('title', 'Quản Lý Giá Điện')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản Lý Giá Điện</h1>
        <button class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm Bậc Giá
        </button>
    </div>

    <!-- Current Rates Card -->
    <div class="card dashboard-card mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bảng Giá Điện Hiện Tại</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>Bậc</th>
                            <th>Mức Tiêu Thụ (kWh)</th>
                            <th>Đơn Giá (VNĐ/kWh)</th>
                            <th>Áp Dụng Từ</th>
                            <th>Trạng Thái</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Bậc 1</td>
                            <td>0 - 50</td>
                            <td>1,678</td>
                            <td>01/01/2024</td>
                            <td><span class="badge bg-success">Đang áp dụng</span></td>
                            <td>
                                <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Bậc 2</td>
                            <td>51 - 100</td>
                            <td>1,734</td>
                            <td>01/01/2024</td>
                            <td><span class="badge bg-success">Đang áp dụng</span></td>
                            <td>
                                <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Bậc 3</td>
                            <td>101 - 200</td>
                            <td>2,014</td>
                            <td>01/01/2024</td>
                            <td><span class="badge bg-success">Đang áp dụng</span></td>
                            <td>
                                <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Bậc 4</td>
                            <td>201 - 300</td>
                            <td>2,536</td>
                            <td>01/01/2024</td>
                            <td><span class="badge bg-success">Đang áp dụng</span></td>
                            <td>
                                <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Bậc 5</td>
                            <td>301 - 400</td>
                            <td>2,834</td>
                            <td>01/01/2024</td>
                            <td><span class="badge bg-success">Đang áp dụng</span></td>
                            <td>
                                <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Bậc 6</td>
                            <td>Trên 400</td>
                            <td>2,927</td>
                            <td>01/01/2024</td>
                            <td><span class="badge bg-success">Đang áp dụng</span></td>
                            <td>
                                <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Price History Card -->
    <div class="card dashboard-card">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Lịch Sử Thay Đổi Giá</h6>
            <div class="form-group mb-0">
                <input type="month" class="form-control" value="2024-03">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>Ngày Thay Đổi</th>
                            <th>Bậc</th>
                            <th>Giá Cũ (VNĐ)</th>
                            <th>Giá Mới (VNĐ)</th>
                            <th>Người Cập Nhật</th>
                            <th>Ghi Chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>01/01/2024</td>
                            <td>Tất cả các bậc</td>
                            <td>-</td>
                            <td>-</td>
                            <td>Admin</td>
                            <td>Cập nhật giá mới 2024</td>
                        </tr>
                        <tr>
                            <td>01/07/2023</td>
                            <td>Bậc 3</td>
                            <td>1,900</td>
                            <td>2,014</td>
                            <td>Admin</td>
                            <td>Điều chỉnh giá bậc 3</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 