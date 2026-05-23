@extends('layouts.admin')

@section('title', 'Bảng điều khiển tổng quan')
@section('page_title', 'Bảng điều khiển tổng quan')

@push('styles')
    @vite(['resources/css/admin/dashboard.css'])
@endpush

@section('content')
    <div class="stat-grid">
        <div class="stat-card revenue">
            <div class="stat-info">
                <h3>Tổng doanh thu</h3>
                <p class="stat-number">{{ number_format($totalRevenue, 0, ',', '.') }} đ</p>
            </div>
        </div>
        <div class="stat-card pending">
            <div class="stat-info">
                <h3>Đơn mới chờ duyệt</h3>
                <p class="stat-number">{{ $newBookingsCount }}</p>
            </div>
        </div>
        <div class="stat-card users">
            <div class="stat-info">
                <h3>Khách hàng</h3>
                <p class="stat-number">{{ $totalUsers }}</p>
            </div>
        </div>
    </div>

    <div class="dashboard-row">
        <div class="dashboard-box car-status-box">
            <h3 class="box-title">Tình trạng xe hiện tại</h3>
            <ul class="car-status-list">
                <li>
                    <span class="status-label available">Sẵn sàng</span>
                    <span class="status-count">{{ $availableCars }} xe</span>
                </li>
                <li>
                    <span class="status-label rented">Đang cho thuê</span>
                    <span class="status-count">{{ $rentedCars }} xe</span>
                </li>
                <li>
                    <span class="status-label maintenance">Đang bảo dưỡng</span>
                    <span class="status-count">{{ $maintenanceCars }} xe</span>
                </li>
            </ul>
        </div>

        <div class="dashboard-box urgent-bookings-box">
            <h3 class="box-title">Đơn hàng cần xử lý gấp</h3>
            @if($urgentBookings->count() > 0)
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Xe thuê</th>
                            <th>Tổng tiền</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($urgentBookings as $booking)
                            <tr>
                                <td><strong>#{{ $booking->id }}</strong></td>
                                <td>{{ $booking->user->name }}</td>
                                <td>{{ $booking->car->name }}</td>
                                <td class="price">{{ number_format($booking->total_price, 0, ',', '.') }} đ</td>
                                <td>
                                    <a href="#" class="btn-action">Xem / Duyệt</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="empty-message">Tuyệt vời! Hiện không có đơn hàng nào bị tồn đọng.</p>
            @endif
        </div>
    </div>
@endsection