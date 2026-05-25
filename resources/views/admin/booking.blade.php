@extends('layouts.admin')

@section('title', 'Quản lý Đơn đặt xe')
@section('page_title', 'Danh sách Đơn đặt xe')

@push('styles')
    @vite(['resources/css/admin/booking.css'])
@endpush

@section('content')
    <div class="admin-card">
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Mã Đơn</th>
                        <th>Khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Chi tiết xe</th>
                        <th>Giao nhận</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td><strong>#{{ $booking->id }}</strong></td>
                            
                            <td>
                                <div class="fw-bold text-dark">{{ $booking->user->name }}</div>
                                <div class="text-muted small">{{ $booking->user->email }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $booking->user->phone }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-blue">{{ $booking->car->name }}</div>
                                <div class="text-muted small">{{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}</div>
                            </td>

                            <td>
                                @if($booking->is_delivery)
                                    <span class="badge badge-outline-blue">Giao tận nơi</span>
                                    <div class="text-muted small mt-1">{{ $booking->delivery_address }}</div>
                                @else
                                    <span class="badge badge-outline-gray">Tại bãi xe Phenikaa</span>
                                @endif
                            </td>
                            
                            <td class="price">{{ number_format($booking->total_price, 0, ',', '.') }} đ</td>
                            
                            <td>
                                <span class="badge badge-{{ $booking->status }}">
                                    @if($booking->status == 'pending') Chờ duyệt
                                    @elseif($booking->status == 'confirmed') Đã duyệt
                                    @elseif($booking->status == 'ongoing') Đang thuê
                                    @elseif($booking->status == 'completed') Hoàn thành
                                    @else Đã hủy
                                    @endif
                                </span>
                            </td>
                            
                            <td class="actions text-center">
                                <form action="{{ route('admin.bookings.update_status', $booking->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="status-select" onchange="this.form.submit()">
                                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Đã duyệt</option>
                                        <option value="ongoing" {{ $booking->status == 'ongoing' ? 'selected' : '' }}>Đang thuê</option>
                                        <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Hủy đơn</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-message">Chưa có đơn đặt xe nào trong hệ thống.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection