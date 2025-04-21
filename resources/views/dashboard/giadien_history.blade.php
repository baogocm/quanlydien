@extends('layouts.admin')

@section('title', 'Lịch sử Bảng Giá Điện')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Lịch sử Bảng Giá Điện</h1>
    <p class="mb-4">Danh sách các phiên bản bảng giá điện đã được áp dụng.</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Các Phiên Bản Bảng Giá</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Version</th>
                            <th>Ngày Áp Dụng</th>
                            <th>Ghi Chú</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($versions as $version)
                            <tr>
                                <td>{{ $version->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($version->ngayapdung)->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $version->ghichu }}</td>
                                <td>
                                    <a href="{{ route('giadien.history.detail', $version->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Xem Chi Tiết
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Không có dữ liệu lịch sử.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
{{-- Thêm các script cần thiết cho DataTable nếu bạn dùng --}}
<script>
    // $(document).ready(function() {
    //     $('#dataTable').DataTable();
    // });
</script>
@endpush 