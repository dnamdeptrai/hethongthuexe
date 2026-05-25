@extends('layouts.admin')

@section('title', 'Quản lý Kho Xe')
@section('page_title', 'Danh sách Xe')

@push('styles')
    @vite(['resources/css/admin/cars.css'])
@endpush

@section('content')
    <div class="admin-card">
        
        <div class="card-header-flex">
            
            <div style="display: flex; gap: 12px; align-items: center;">
                <form action="{{ route('admin.cars.index') }}" method="GET" style="display: flex; gap: 8px;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm tên xe..." class="form-control" style="padding: 8px 12px; height: 38px; width: 250px;">
                    <button type="submit" class="btn-secondary" style="height: 38px; padding: 8px 16px; margin: 0;">Tìm</button>
                </form>
                
                <a href="{{ route('admin.cars.create') }}" class="btn-primary" style="height: 38px; display: inline-flex; align-items: center;">+ Thêm xe mới</a>
            </div>
        </div>

        @if(session('success'))
            <div style="background-color: #d1fae5; color: #065f46; padding: 16px; border-radius: 8px; margin-top: 16px; border: 1px solid #a7f3d0;">
                <strong>Thành công!</strong> {{ session('success') }}
            </div>
        @endif

        <table class="admin-table mt-3">
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên xe & Hãng</th>
                    <th>Loại / Chỗ ngồi</th>
                    <th>Giá thuê/Ngày</th>
                    <th>Trạng thái</th>
                    <th style="text-align: center;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cars as $car)
                    <tr>
                        <td>
                            @if($car->image)
                                <img src="{{ asset('storage/' . $car->image) }}" class="car-thumbnail" alt="Ảnh xe">
                            @else
                                <div class="car-thumbnail-placeholder">No Image</div>
                            @endif
                        </td>
                        <td>
                            <strong style="color: #111827;">{{ $car->name }}</strong>
                            <div style="color: #6b7280; font-size: 12px;">{{ $car->brand }}</div>
                        </td>
                        <td>
                            <div style="color: #111827;">{{ $car->category->name ?? 'N/A' }}</div>
                            <div style="color: #6b7280; font-size: 12px;">{{ $car->transmission }}</div>
                        </td>
                        <td style="font-weight: 600; color: #111827;">{{ number_format($car->price_per_day, 0, ',', '.') }} đ</td>
                        
                        <td>
                            <form action="{{ route('admin.cars.update_status', $car->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" style="padding: 6px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 13px; font-weight: 600; outline: none; cursor: pointer; background-color: {{ $car->status == 'available' ? '#d1fae5' : ($car->status == 'rented' ? '#dbeafe' : '#fee2e2') }}; color: {{ $car->status == 'available' ? '#059669' : ($car->status == 'rented' ? '#2563eb' : '#dc2626') }};">
                                    <option value="available" {{ $car->status == 'available' ? 'selected' : '' }}>Sẵn sàng</option>
                                    <option value="rented" {{ $car->status == 'rented' ? 'selected' : '' }}>Đang thuê</option>
                                    <option value="maintenance" {{ $car->status == 'maintenance' ? 'selected' : '' }}>Bảo dưỡng</option>
                                </select>
                            </form>
                        </td>

                        <td style="text-align: center;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <a href="{{ route('admin.cars.edit', $car->id) }}" class="btn-action btn-edit">Sửa</a>
                                
                                <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa chiếc xe này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete">Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #9ca3af; font-style: italic;">
                            {{ request('search') ? 'Không tìm thấy xe nào phù hợp.' : 'Chưa có xe nào trong kho.' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="pagination-wrapper">
            {{ $cars->links() }}
        </div>
    </div>
@endsection