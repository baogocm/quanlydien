@extends('layouts.admin')

@section('title', 'Quản Lý Hóa Đơn')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản Lý Hóa Đơn</h1>
    </div>

    <!-- Search Box -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tìm kiếm</label>
                        <input type="text" class="form-control" id="searchInput" placeholder="Mã hóa đơn, mã điện kế...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Kỳ</label>
                        <select class="form-control" id="kyFilter">
                            <option value="">Tất cả</option>
                            @foreach($kys as $ky)
                                <option value="{{ $ky }}">Kỳ {{ $ky }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoices Table -->
    <div class="card dashboard-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>Mã HD</th>
                            <th>Nhân viên</th>
                            <th>Mã điện kế</th>
                            <th>Kỳ</th>
                            <th>Tổng tiền</th>
                            <th>Tình trạng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hoadons as $hd)
                        <tr>
                            <td>{{ $hd->mahd }}</td>
                            <td>{{ $hd->nhanVien->tennv }}</td>
                            <td>{{ $hd->chiTietHoaDon->first()->madk }}</td>
                            <td>{{ $hd->ky }}</td>
                            <td>{{ number_format($hd->tinhTongTien(), 0, ',', '.') }}</td>
                            <td>
                                @if($hd->tinhtrang == 0)
                                    <span class="badge bg-warning">Chưa thanh toán</span>
                                @else
                                    <span class="badge bg-success">Đã thanh toán</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $hd->mahd }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if($hd->tinhtrang == 0)
                                <form action="{{ route('hoadon.updateStatus', $hd->mahd) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Xác nhận đã thu tiền cho hóa đơn #{{ $hd->mahd }}?')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Chi tiết -->
@foreach($hoadons as $hd)
<div class="modal fade" id="detailModal{{ $hd->mahd }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chi tiết hóa đơn #{{ $hd->mahd }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Mã hóa đơn:</strong> {{ $hd->mahd }}</p>
                        <p><strong>Nhân viên lập:</strong> {{ $hd->nhanVien->tennv }}</p>
                        <p><strong>Kỳ:</strong> {{ $hd->ky }}</p>
                        <p><strong>Ngày lập:</strong> {{ date('d/m/Y', strtotime($hd->ngaylaphd)) }}</p>
                        <p><strong>Chỉ số đầu:</strong> {{ $hd->chisodau }}</p>
                        <p><strong>Chỉ số cuối:</strong> {{ $hd->chisocuoi }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Từ ngày:</strong> {{ date('d/m/Y', strtotime($hd->tungay)) }}</p>
                        <p><strong>Đến ngày:</strong> {{ date('d/m/Y', strtotime($hd->denngay)) }}</p>
                        <p><strong>Tổng tiền:</strong> {{ number_format($hd->tinhTongTien(), 0, ',', '.') }} VNĐ</p>
                        <p><strong>Tình trạng:</strong> 
                            @if($hd->tinhtrang == 0)
                                <span class="badge bg-warning">Chưa thanh toán</span>
                            @else
                                <span class="badge bg-success">Đã thanh toán</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="mt-3">
                    <p><strong>Chi tiết điện tiêu thụ</strong></p>
                    <table class="table table-bordered mt-2">
                        <thead>
                            <tr>
                                <th>Bậc</th>
                                <th>Điện năng tiêu thụ</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $tongDienNangTieuThu = $hd->chisocuoi - $hd->chisodau;
                                $bacGia = App\Models\BacGia::orderBy('tusokw')->get();
                                $dienNangConLai = $tongDienNangTieuThu;
                                $tongTien = 0;
                            @endphp
                            @foreach($bacGia as $bac)
                                @php
                                    if ($dienNangConLai <= 0) continue;
                                    
                                    $soDien = 0;
                                    if ($bac->densokw === null) {
                                        $soDien = $dienNangConLai;
                                    } else {
                                        $soDien = min($dienNangConLai, $bac->densokw - $bac->tusokw);
                                    }
                                    
                                    $thanhTien = $soDien * $bac->dongia;
                                    $tongTien += $thanhTien;
                                    $dienNangConLai -= $soDien;
                                @endphp
                                <tr>
                                    <td>Bậc {{ $bac->mabac }}</td>
                                    <td>{{ $soDien }} kWh</td>
                                    <td>{{ number_format($bac->dongia, 0, ',', '.') }}</td>
                                    <td>{{ number_format($thanhTien, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                                <td><strong>{{ number_format($hd->tinhTongTien(), 0, ',', '.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="text-end mt-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<script src="{{ asset('js/hoadon.js') }}"></script>
@endsection 