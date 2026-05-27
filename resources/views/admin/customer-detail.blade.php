@extends('layouts.admin')

@section('title', 'Chi tiết Khách Hàng')

@push('styles')
    @vite(['resources/css/admin/cars.css', 'resources/css/admin/customer-detail.css'])
@endpush

@section('content')
    <div class="back-btn-container">
        <a href="{{ route('admin.customers.index') }}" class="btn-secondary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            ← Quay lại danh sách
        </a>
    </div>

    <div class="admin-card" style="display: flex; gap: 32px; align-items: center; margin-bottom: 30px; flex-wrap: wrap;">
        
        <div class="customer-info-grid">
            <div>
                <div class="info-column-label">Họ và Tên</div>
                <div class="info-column-value-name">{{ $customer->name }}</div>
            </div>
            <div>
                <div class="info-column-label">Số điện thoại</div>
                <div class="info-column-value">{{ $customer->phone ?? 'Chưa cập nhật' }}</div>
            </div>
            <div>
                <div class="info-column-label">Địa chỉ Email</div>
                <div class="info-column-value">{{ $customer->email }}</div>
            </div>
            <div>
                <div class="info-column-label">Ngày đăng ký</div>
                <div class="info-column-value">{{ $customer->created_at->format('d/m/Y') }}</div>
            </div>
            <div>
                <div class="info-column-label">Trạng thái</div>
                <div>
                    <span class="badge-status-active">Hoạt động</span>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-card">
        <div class="card-header-flex" style="border-bottom: 1px solid #f3f4f6; padding-bottom: 16px; margin-bottom: 16px;">
            <h3>Lịch sử đơn đặt xe (Tổng số: {{ $customer->bookings->count() }} đơn)</h3>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Mã Đơn</th>
                    <th>Xe thuê</th>
                    <th>Thời gian thuê</th>
                    <th>Hình thức nhận xe</th>
                    <th>Tổng thanh toán</th>
                    <th style="text-align: center;">Trạng thái đơn</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customer->bookings as $booking)
                    <tr>
                        <td style="font-weight: 700; color: #111827;">#{{ $booking->id }}</td>
                        
                        <td>
                            <div class="booking-car-name">{{ $booking->car->name ?? 'Xe đã bị xóa' }}</div>
                            <div class="booking-car-brand">Hãng: {{ $booking->car->brand ?? 'N/A' }}</div>
                        </td>
                        
                        <td class="booking-time-display">
                            <div>{{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }}</div>
                            <div class="booking-time-to">đến {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}</div>
                        </td>
                        
                        <td>
                            @if($booking->is_delivery)
                                <span class="badge-delivery-site">Giao tận nơi</span>
                                <div class="delivery-address-detail">{{ $booking->delivery_address }}</div>
                            @else
                                <span class="badge-pickup-site">Tại bãi xe Phenikaa</span>
                            @endif
                        </td>
                        
                        <td class="booking-final-price">
                            {{ number_format($booking->total_price, 0, ',', '.') }} đ
                        </td>
                        
                        <td style="text-align: center;">
                            <span class="badge" style="
                                @if($booking->status == 'pending') background-color: #fef3c7; color: #d97706;
                                @elseif($booking->status == 'confirmed') background-color: #d1fae5; color: #059669;
                                @elseif($booking->status == 'ongoing') background-color: #dbeafe; color: #2563eb;
                                @elseif($booking->status == 'completed') background-color: #f3f4f6; color: #4b5563;
                                @else background-color: #fee2e2; color: #dc2626;
                                @endif
                            ">
                                @if($booking->status == 'pending') Chờ duyệt
                                @elseif($booking->status == 'confirmed') Đã duyệt
                                @elseif($booking->status == 'ongoing') Đang thuê
                                @elseif($booking->status == 'completed') Hoàn thành
                                @else Đã hủy
                                @endif
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-row-text">
                            Khách hàng này chưa từng thực hiện giao dịch đặt xe nào trên hệ thống.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection