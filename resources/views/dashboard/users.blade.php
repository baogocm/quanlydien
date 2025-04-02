@extends('layouts.admin')

@section('title', 'Quản Lý Nhân Viên')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản Lý Nhân Viên</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-plus"></i> Thêm Nhân Viên
        </button>
    </div>

    <!-- Search Box -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tìm kiếm</label>
                        <input type="text" class="form-control" id="searchInput" placeholder="Mã nhân viên, chức vụ...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Chức vụ</label>
                        <select class="form-control">
                            <option>Tất cả</option>
                            <option>Quản lý</option>
                            <option>Nhân viên</option>
                            <option>Thu ngân</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card dashboard-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>Mã NV</th>
                            <th>Ngày sinh</th>
                            <th>Chức vụ</th>
                            <th>Tài khoản</th>
                            <th>Giới tính</th>
                            <th>Lương</th>
                            <th>SĐT</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nhanviens as $nv)
                        <tr>
                            <td>{{ $nv->manv }}</td>
                            <td>{{ $nv->ngaysinh }}</td>
                            <td>{{ $nv->chucvu }}</td>
                            <td>{{ $nv->tk }}</td>
                            <td>{{ $nv->phai }}</td>
                            <td>{{ number_format($nv->luong, 0, ',', '.') }} VNĐ</td>
                            <td>{{ $nv->sdt }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" title="Chỉnh sửa" 
                                        data-bs-toggle="modal" data-bs-target="#editUserModal{{ $nv->manv }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" title="Đổi mật khẩu"
                                        data-bs-toggle="modal" data-bs-target="#changePasswordModal{{ $nv->manv }}">
                                    <i class="fas fa-key"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Xóa"
                                        onclick="if(confirm('Bạn có chắc muốn xóa nhân viên này?')) document.getElementById('delete-form-{{ $nv->manv }}').submit()">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $nv->manv }}" action="{{ route('users.destroy', $nv->manv) }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm Nhân Viên Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mã nhân viên</label>
                        <input type="text" class="form-control" name="manv" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" name="ngaysinh" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Chức vụ</label>
                        <select class="form-control" name="chucvu" required>
                            <option value="Quản lý">Admin</option>
                            <option value="Nhân viên">Nhân viên</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tài khoản</label>
                        <input type="text" class="form-control" name="tk" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" name="mk" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giới tính</label>
                        <select class="form-control" name="phai" required>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lương</label>
                        <input type="number" class="form-control" name="luong" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" name="sdt" required>
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

<!-- Edit User Modals -->
@foreach($nhanviens as $nv)
<div class="modal fade" id="editUserModal{{ $nv->manv }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh Sửa Nhân Viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('users.update', $nv->manv) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mã nhân viên</label>
                        <input type="text" class="form-control" name="manv" value="{{ $nv->manv }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" name="ngaysinh" value="{{ $nv->ngaysinh }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Chức vụ</label>
                        <select class="form-control" name="chucvu" required>
                            <option value="Quản lý" {{ $nv->chucvu == 'Quản lý' ? 'selected' : '' }}>Quản lý</option>
                            <option value="Nhân viên" {{ $nv->chucvu == 'Nhân viên' ? 'selected' : '' }}>Nhân viên</option>
                            <option value="Thu ngân" {{ $nv->chucvu == 'Thu ngân' ? 'selected' : '' }}>Thu ngân</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tài khoản</label>
                        <input type="text" class="form-control" name="tk" value="{{ $nv->tk }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giới tính</label>
                        <select class="form-control" name="phai" required>
                            <option value="Nam" {{ $nv->phai == 'Nam' ? 'selected' : '' }}>Nam</option>
                            <option value="Nữ" {{ $nv->phai == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lương</label>
                        <input type="number" class="form-control" name="luong" value="{{ $nv->luong }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" name="sdt" value="{{ $nv->sdt }}" required>
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

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal{{ $nv->manv }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Đổi Mật Khẩu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('users.changePassword', $nv->manv) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control" name="mk" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Xác nhận mật khẩu mới</label>
                        <input type="password" class="form-control" name="mk_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('js/user.js') }}"></script>
@endforeach
@endsection 