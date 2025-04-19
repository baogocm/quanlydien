@extends('layouts.admin')

@section('title', 'Chi Tiết Lịch Sử Giá Điện')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Chi tiết lịch sử bậc giá: {{ $bacgia->tenbac }}</h1>
    
    <div class="mb-4">
        <a href="{{ route('giadien.history') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Quay lại lịch sử
        </a>
        <a href="{{ route('giadien.index') }}" class="btn btn-secondary">
            <i class="fas fa-home"></i> Về trang giá điện
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-info-circle me-1"></i>
            Thông tin bậc giá hiện tại
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Mã bậc:</strong> {{ $bacgia->mabac }}</p>
                    <p><strong>Tên bậc:</strong> {{ $bacgia->tenbac }}</p>
                    <p><strong>Từ số KW:</strong> {{ $bacgia->tusokw }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Đến số KW:</strong> {{ $bacgia->densokw ?? 'Không giới hạn' }}</p>
                    <p><strong>Đơn giá:</strong> {{ number_format($bacgia->dongia, 0, ',', '.') }} VNĐ</p>
                    <p><strong>Ngày áp dụng:</strong> {{ date('d/m/Y', strtotime($bacgia->ngayapdung)) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-history me-1"></i>
            Lịch sử thay đổi
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Thời điểm thay đổi</th>
                        <th>Từ số KW</th>
                        <th>Đến số KW</th>
                        <th>Đơn giá (VNĐ)</th>
                        <th>Ngày áp dụng</th>
                        <th>Loại thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($history as $item)
                    <tr>
                        <td>{{ date('d/m/Y H:i:s', strtotime($item->ngayketthuc ?? $item->created_at)) }}</td>
                        <td>{{ $item->tusokw }}</td>
                        <td>{{ $item->densokw ?? 'Không giới hạn' }}</td>
                        <td>{{ number_format($item->dongia, 0, ',', '.') }}</td>
                        <td>{{ date('d/m/Y', strtotime($item->ngayapdung)) }}</td>
                        <td>
                            @if($item->action == 'create')
                                <span class="badge bg-success">Thêm mới</span>
                            @elseif($item->action == 'update')
                                <span class="badge bg-primary">Cập nhật</span>
                            @elseif($item->action == 'delete')
                                <span class="badge bg-danger">Xóa</span>
                            @else
                                <span class="badge bg-secondary">Không xác định</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 