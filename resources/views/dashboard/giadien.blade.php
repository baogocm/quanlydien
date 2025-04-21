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
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBacGiaModal">
            <i class="fas fa-plus"></i> Thêm Bậc Giá Mới
        </button>
        <a href="{{ route('giadien.history') }}" class="btn btn-info">
            <i class="fas fa-history"></i> Xem lịch sử các phiên bản giá
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Bảng giá điện hiện tại (Version: {{ $latestVersion->id ?? 'N/A' }} - Áp dụng từ: {{ $latestVersion ? \Carbon\Carbon::parse($latestVersion->ngayapdung)->format('d/m/Y') : 'N/A' }})
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã Bậc</th>
                        <th>Tên bậc</th>
                        <th>Từ số KW</th>
                        <th>Đến số KW</th>
                        <th>Đơn giá (VNĐ/kWh)</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bacgia as $bg)
                    <tr>
                        <td>{{ $bg->mabac }}</td>
                        <td>{{ $bg->tenbac }}</td>
                        <td>{{ number_format($bg->tusokw, 0, ',', '.') }}</td>
                        <td>{{ $bg->densokw == 99999 ? 'Trở lên' : number_format($bg->densokw, 0, ',', '.') }}</td>
                        <td>{{ number_format($bg->dongia, 2, ',', '.') }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" title="Sửa"
                                    data-bs-toggle="modal" data-bs-target="#editModal{{ $bg->mabac }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" title="Xóa"
                                    onclick="if(confirm('Bạn có chắc muốn xóa bậc giá {{ $bg->tenbac }}?')) document.getElementById('delete-form-{{ $bg->mabac }}').submit()">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-form-{{ $bg->mabac }}" action="{{ route('giadien.destroy', $bg->mabac) }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Không có dữ liệu bậc giá cho phiên bản hiện tại.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Thêm Bậc Giá -->
<div class="modal fade" id="addBacGiaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm Bậc Giá Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('giadien.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tên Bậc</label>
                        <input type="text" class="form-control" name="tenbac" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Từ Số KW</label>
                        <input type="number" class="form-control" name="tusokw" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Đến Số KW</label>
                        <input type="number" class="form-control" name="densokw" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Đơn Giá (VNĐ/kWh)</label>
                        <input type="number" step="0.01" class="form-control" name="dongia" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ghi Chú Version</label>
                        <textarea class="form-control" name="ghichu"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Thêm Mới</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sửa Bậc Giá -->
@foreach($bacgia as $bg)
<div class="modal fade" id="editModal{{ $bg->mabac }}" tabindex="-1" aria-labelledby="editModalLabel{{ $bg->mabac }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('giadien.update', $bg->mabac) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $bg->mabac }}">Chỉnh sửa bậc giá điện</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mã bậc</label>
                        <input type="text" class="form-control" value="{{ $bg->mabac }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên bậc</label>
                        <input type="text" class="form-control" name="tenbac" value="{{ $bg->tenbac }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Từ số KW</label>
                        <input type="number" class="form-control" name="tusokw" value="{{ $bg->tusokw }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Đến số KW</label>
                        <input type="number" class="form-control" name="densokw" value="{{ $bg->densokw == 99999 ? '' : $bg->densokw }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Đơn giá (VNĐ/kWh)</label>
                        <input type="number" step="0.01" class="form-control" name="dongia" value="{{ $bg->dongia }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ghi chú version</label>
                        <textarea class="form-control" name="ghichu"></textarea>
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

@endsection

@push('scripts')
<script>
    function loadEditData(mabac, tenbac, tusokw, densokw, dongia) {
        // Set form action URL
        const form = document.getElementById('editForm');
        form.action = `/giadien/update/${mabac}`;
        
        // Load data vào các input fields
        document.getElementById('edit_tenbac').value = tenbac;
        document.getElementById('edit_tusokw').value = tusokw;
        document.getElementById('edit_densokw').value = densokw === 99999 ? '' : densokw;
        document.getElementById('edit_dongia').value = dongia;
        
        // Focus vào trường đầu tiên để dễ chỉnh sửa
        document.getElementById('edit_tenbac').focus();
    }
</script>
@endpush 