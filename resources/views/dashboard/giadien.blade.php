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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 