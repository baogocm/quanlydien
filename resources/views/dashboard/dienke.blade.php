@extends('layouts.admin')

@section('title', 'Quản Lý Điện Kế')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Quản Lý Điện Kế</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDienKeModal">
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
                            <input type="text" class="form-control" id="searchInputDK" placeholder="Nhập mã điện kế...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Khách hàng</label>
                            <input type="text" class="form-control" id="searchInputKH"
                                placeholder="Tên hoặc mã khách hàng...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control">
                                <option>Tất cả</option>
                                <option>Đang hoạt động</option>
                                <option>Ngưng hoạt động</option>
                            </select>
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
                                <th>Mã Khách Hàng</th>
                                <th>Tên Khách Hàng</th>
                                <th>Ngày Lắp</th>
                                <th>Mô Tả</th>
                                <th>Địa chỉ</th>
                                <th>Chỉ Số Đầu</th>
                                <th>Chỉ Số Cuối</th>
                                <th>Trạng Thái</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dienkes as $dk)
                                <tr>
                                    <td>{{ $dk->madk }}</td>
                                    <td>{{ $dk->makh }}</td>
                                    <td>{{ $dk->khachHang->tenkh }}</td>
                                    <td>{{ $dk->ngaylap }}</td>
                                    <td>{{ $dk->mota }}</td>
                                    <td>{{ $dk->diachi }}</td>
                                    <td>{{ $dk->cs_dau }}</td>
                                    <td>{{ $dk->cs_cuoi }}</td>
                                    <td>
                                        <span class="badge {{ $dk->trangthai ? 'bg-success' : 'bg-danger' }}">
                                            {{ $dk->trangthai ? 'Đang hoạt động' : 'Ngưng hoạt động' }}
                                        </span>
                                    </td>
                                    <td class="d-flex ">
                                        <button class="btn btn-sm btn-info me-1" title="Chỉnh sửa" data-bs-toggle="modal"
                                            data-bs-target="#editDienKeModal{{ $dk->madk }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" title="Xóa"
                                            onclick="if(confirm('Bạn có chắc muốn xóa nhân viên này?')) document.getElementById('delete-form-{{ $dk->madk }}').submit()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $dk->madk }}" action="{{ route('dienke.destroy', $dk->madk) }}"
                                            method="POST" style="display: none;">
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
    <div class="modal fade" id="addDienKeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Điện Kế Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('dienke.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Mã Điện Kế</label>
                            <input type="text" class="form-control" name="madk" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mã Khách Hàng</label>
                            <input type="text" class="form-control" name="makh" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô Tả</label>
                            <input type="text" class="form-control" name="mota" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" name="diachi" required>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-primary">Thêm</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach($dienkes as $dk)
        <!-- Edit Modal Trigger -->
        <div class="modal fade" id="editDienKeModal{{ $dk->madk }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content p-5">
                    <div class="container">
                        <button type="button" class="btn-close" style="position: absolute; top: 10px; right: 10px;"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-header mb-2 justify-content-center d-flex">
                        <h5 class="modal-title">Cập nhật điện kế</h5>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-sm btn-primary me-1" title="Chỉnh sửa" data-bs-toggle="modal"
                            data-bs-target="#editChiSoModal{{ $dk->madk }}">
                            <span>Sửa chỉ số</span>
                        </button>
                        <button class="btn btn-sm btn-primary me-1" title="Chỉnh sửa trạng thái" data-bs-toggle="modal"
                            data-bs-target="#editTrangThaiModal{{ $dk->madk }}">
                            <span>Sửa trạng thái</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Chi So Modal -->
        <div class="modal fade" id="editChiSoModal{{ $dk->madk }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cập nhật chỉ số</h5>
                    </div>
                    <form action="{{ route('dienke.update', $dk->madk) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Mã điện kế</label>
                                <input type="text" class="form-control mb-2" value="{{ $dk->madk }}" readonly>
                                <label class="form-label">Chỉ số mới</label>
                                <input type="text" class="form-control" name="cs_dau" value="{{ $dk->cs_cuoi }}" hidden>
                                <input type="text" class="form-control" name="cs_cuoi" value="{{ $dk->cs_cuoi }}" required>
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

        <!-- Edit Trang Thai Modal -->
        <div class="modal fade" id="editTrangThaiModal{{ $dk->madk }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cập nhật trạng thái</h5>
                    </div>
                    <form action="{{ route('dienke.updateTrangThai', $dk->madk) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Mã điện kế</label>
                                <input type="text" class="form-control mb-2" value="{{ $dk->madk }}" readonly>
                                <label class="form-label">Trạng thái</label>
                                <select class="form-control" name="trangthai" required>
                                    <option value="1" {{ $dk->trangthai == 1 ? 'selected' : '' }}>Hoạt động</option>
                                    <option value="0" {{ $dk->trangthai == 0 ? 'selected' : '' }}>Ngưng hoạt động</option>
                                </select>
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
    <script src="{{ asset('js/dienke.js') }}"></script>
@endsection