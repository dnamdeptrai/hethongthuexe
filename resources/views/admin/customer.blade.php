@extends('layouts.admin')

@section('title', 'Quản lý Khách Hàng')
@section('page_title', 'Danh sách Khách Hàng')

@push('styles')
    @vite(['resources/css/admin/cars.css', 'resources/css/admin/customer.css'])
@endpush

@section('content')
    <div class="admin-card">
        <div class="card-header-flex">
            <form action="{{ route('admin.customers.index') }}" method="GET" class="search-form">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm tên, email, SĐT..." class="form-control search-input">
                <button type="submit" class="btn-secondary search-btn">Tìm kiếm</button>
            </form>
        </div>

        <table class="admin-table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Thông tin Khách hàng</th>
                    <th>Liên hệ</th>
                    <th class="text-center">Tổng Đơn Đặt</th>
                    <th>Ngày đăng ký</th>
                    <th class="text-center">Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr class="clickable-row" onclick="window.location='{{ route('admin.customers.show', $customer->id) }}';">                        
                        <td class="customer-id">#{{ $customer->id }}</td>
                        
                        <td>
                            <div class="customer-info-wrapper">
                                <div class="customer-name-text">
                                    {{ $customer->name }}
                                </div>
                            </div>
                        </td>
                        
                        <td>
                            <div class="contact-phone">{{ $customer->phone ?? 'Chưa cập nhật' }}</div>
                            <div class="contact-email">{{ $customer->email }}</div>
                        </td>
                        
                        <td class="text-center">
                            <span class="badge-count">{{ $customer->bookings_count }} đơn</span>
                        </td>
                        
                        <td class="date-text">
                            {{ $customer->created_at->format('d/m/Y') }}
                        </td>
                        
                        <td class="text-center">
                            <span class="badge-status-active">Hoạt động</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-row-text">
                            {{ request('search') ? 'Không tìm thấy khách hàng nào phù hợp.' : 'Chưa có khách hàng nào đăng ký.' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="pagination-wrapper">
            {{ $customers->links() }}
        </div>
    </div>
@endsection