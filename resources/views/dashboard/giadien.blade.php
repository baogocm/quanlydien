@extends('layouts.admin')

@section('title', 'Quản Lý Giá Điện')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Quản lý giá điện</h1>
    
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('giadien.history') }}" class="btn btn-info">
            <i class="fas fa-history"></i> Xem lịch sử thay đổi giá
        </a>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus"></i> Thêm bậc giá mới
        </button>
    </div>

    <!-- Modal Thêm mới -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('giadien.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Thêm bậc giá mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tên bậc</label>
                            <input type="text" class="form-control" name="tenbac" required>
                            <small class="text-muted">Ví dụ: Bậc 1, Bậc 2, Bậc 3, ...</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Từ số KW</label>
                            <input type="number" class="form-control" name="tusokw" required min="0">
                            <small class="text-muted">Giới hạn dưới kWh của bậc</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Đến số KW</label>
                            <input type="number" class="form-control" name="densokw">
                            <small class="text-muted">Giới hạn trên kWh của bậc. Để trống nếu không giới hạn</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Đơn giá (VNĐ)</label>
                            <input type="number" class="form-control" name="dongia" required min="0">
                            <small class="text-muted">Số tiền tính cho mỗi kWh trong bậc này</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-success">Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Bảng giá điện
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Bậc</th>
                        <th>Tên bậc</th>
                        <th>Từ số KW</th>
                        <th>Đến số KW</th>
                        <th>Đơn giá (VNĐ)</th>
                        <th>Ngày áp dụng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bacgia as $bg)
                    <tr>
                        <td>{{ $bg->mabac }}</td>
                        <td>{{ $bg->tenbac }}</td>
                        <td>{{ $bg->tusokw }}</td>
                        <td>{{ $bg->densokw ?? 'Không giới hạn' }}</td>
                        <td>{{ number_format($bg->dongia, 0, ',', '.') }}</td>
                        <td>{{ date('d/m/Y', strtotime($bg->ngayapdung)) }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $bg->mabac }}">
                                <i class="fas fa-edit"></i> Sửa
                            </button>
                            <a href="{{ route('giadien.history.detail', $bg->mabac) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-history"></i> Lịch sử
                            </a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $bg->mabac }}">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Chỉnh sửa -->
                    <div class="modal fade" id="editModal{{ $bg->mabac }}" tabindex="-1" aria-labelledby="editModalLabel{{ $bg->mabac }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('giadien.update', $bg->mabac) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $bg->mabac }}">Chỉnh sửa bậc giá {{ $bg->tenbac }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Bậc</label>
                                            <input type="text" class="form-control" value="{{ $bg->mabac }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tên bậc</label>
                                            <input type="text" class="form-control" value="{{ $bg->tenbac }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Từ số KW</label>
                                            <input type="number" class="form-control" name="tusokw" value="{{ $bg->tusokw }}" required min="0">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Đến số KW</label>
                                            <input type="number" class="form-control" name="densokw" value="{{ $bg->densokw }}">
                                            <small class="text-muted">Để trống nếu không giới hạn</small>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Đơn giá (VNĐ)</label>
                                            <input type="number" class="form-control" name="dongia" value="{{ $bg->dongia }}" required min="0">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Ngày áp dụng</label>
                                            <input type="text" class="form-control" value="{{ date('d/m/Y') }}" readonly>
                                            <small class="text-muted">Ngày áp dụng sẽ được cập nhật tự động</small>
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

                    <!-- Modal Xóa -->
                    <div class="modal fade" id="deleteModal{{ $bg->mabac }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $bg->mabac }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('giadien.destroy', $bg->mabac) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $bg->mabac }}">Xác nhận xóa</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Bạn có chắc chắn muốn xóa bậc giá <strong>{{ $bg->tenbac }}</strong>?</p>
                                        <p class="text-danger">Hành động này không thể hoàn tác, nhưng lịch sử thay đổi vẫn được lưu lại.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 