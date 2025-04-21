@extends('layouts.admin')

@section('title', 'Chi Tiết Bảng Giá Điện Version ' . $version->id)

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Chi Tiết Bảng Giá Điện - Version {{ $version->id }}</h1>
    <p class="mb-4"><strong>Ngày áp dụng:</strong> {{ \Carbon\Carbon::parse($version->ngayapdung)->format('d/m/Y H:i:s') }}<br>
        <strong>Ghi chú:</strong> {{ $version->ghichu ?? 'Không có' }}
    </p>
    
    <div class="mb-4">
        <a href="{{ route('giadien.history') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Quay lại Lịch sử
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Các Bậc Giá Áp Dụng</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableDetail" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Mã Bậc</th>
                            <th>Tên Bậc</th>
                            <th>Từ Số KW</th>
                            <th>Đến Số KW</th>
                            <th>Đơn Giá (VNĐ/kWh)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bacGias as $bac)
                            <tr>
                                <td>{{ $bac->mabac }}</td>
                                <td>{{ $bac->tenbac }}</td>
                                <td>{{ number_format($bac->tusokw, 0, ',', '.') }}</td>
                                <td>{{ $bac->densokw == 99999 ? 'Trở lên' : number_format($bac->densokw, 0, ',', '.') }}</td>
                                <td>{{ number_format($bac->dongia, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Không có bậc giá nào cho phiên bản này.</td>
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
    //     $('#dataTableDetail').DataTable();
    // });
</script>
@endpush 