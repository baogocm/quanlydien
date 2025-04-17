@extends('layouts.admin')

@section('title', 'Quản Lý Khách Hàng')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Quản Lý Khách Hàng</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGuestModal">
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
                            <input type="text" class="form-control" id="searchInput"
                                placeholder="Tên khách hàng, mã khách hàng...">
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
                                <th>Số Điện Thoại</th>
                                <th>Căn cước công dân</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($khachhangs as $kh)
                                <tr>
                                    <td>{{ $kh->makh }}</td>
                                    <td>{{ $kh->tenkh }}</td>
                                    <td>{{ $kh->dt }}</td>
                                    <td>{{ $kh->cmnd }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" title="Chỉnh sửa" data-bs-toggle="modal"
                                            data-bs-target="#editGuestModal{{ $kh->makh }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" title="Xóa"
                                            onclick="if(confirm('Bạn có chắc muốn xóa nhân viên này?')) document.getElementById('delete-form-{{ $kh->makh }}').submit()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $kh->makh }}"
                                            action="{{ route('khachhang.destroy', $kh->makh) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
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
    <div class="modal fade" id="addGuestModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="container">
                    <button type="button" class="btn-close" style="position: absolute; top: 10px; right: 10px;"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Khách Hàng Mới</h5>
                </div>
                <form action="{{ route('khachhang.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Mã khách hàng</label>
                            <input type="text" class="form-control" name="makh" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" name="tenkh" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" name="dt" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Căn cước công dân</label>
                            <input type="text" class="form-control" name="cmnd" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach($khachhangs as $kh)
        <div class="modal fade" id="editGuestModal{{ $kh->makh }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="container">
                        <button type="button" class="btn-close" style="position: absolute; top: 10px; right: 10px;"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title">Chỉnh Sửa Khách Hàng</h5>
                    </div>
                    <form action="{{ route('khachhang.update', $kh->makh) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Mã khách hàng</label>
                                <input type="text" class="form-control" name="makh" value="{{ $kh->makh }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" name="tenkh" value="{{ $kh->tenkh }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" name="dt" value="{{ $kh->dt }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Căn cước công dân</label>
                                <input type="text" class="form-control" name="cmnd" value="{{ $kh->cmnd }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <script src="{{ asset('js/guest.js') }}"></script>
@endsection