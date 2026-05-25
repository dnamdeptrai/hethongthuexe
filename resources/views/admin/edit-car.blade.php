@extends('layouts.admin')

@section('title', 'Sửa Thông Tin Xe')
@section('page_title', 'Chỉnh Sửa Thông Tin Xe')

@push('styles')
    @vite(['resources/css/admin/cars.css'])
@endpush

@section('content')
   <div class="admin-card form-card">
        
        @if ($errors->any())
            <div class="alert alert-danger" style="background: #fef2f2; color: #dc2626; padding: 16px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #fecaca;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-grid">
                <div class="form-group">
                    <label>Tên xe</label>
                    <input type="text" name="name" class="form-control" required value="{{ $car->name }}">
                </div>
                
                <div class="form-group">
                    <label>Hãng xe</label>
                    <input type="text" name="brand" class="form-control" required value="{{ $car->brand }}">
                </div>

                <div class="form-group">
                    <label>Danh mục</label>
                    <select name="category_id" class="form-control" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $car->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Số chỗ ngồi</label>
                    <input type="text" name="seats" class="form-control" required value="{{ $car->seats }}">
                </div>

                <div class="form-group">
                    <label>Hộp số</label>
                    <select name="transmission" class="form-control">
                        <option value="Số tự động" {{ $car->transmission == 'Số tự động' ? 'selected' : '' }}>Số tự động</option>
                        <option value="Số sàn" {{ $car->transmission == 'Số sàn' ? 'selected' : '' }}>Số sàn</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Nhiên liệu</label>
                    <input type="text" name="fuel_type" class="form-control" required value="{{ $car->fuel_type }}">
                </div>

                <div class="form-group">
                    <label>Giá thuê/Ngày (VND)</label>
                    <input type="number" name="price_per_day" class="form-control" required value="{{ $car->price_per_day }}">
                </div>
                <div class="form-group">
                    <label>Trạng thái xe</label>
                    <select name="status" class="form-control" required>
                        <option value="available" {{ $car->status == 'available' ? 'selected' : '' }}>Sẵn sàng</option>
                        <option value="rented" {{ $car->status == 'rented' ? 'selected' : '' }}>Đang thuê</option>
                        <option value="maintenance" {{ $car->status == 'maintenance' ? 'selected' : '' }}>Bảo dưỡng</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Hình ảnh xe mới (Bỏ trống nếu giữ ảnh cũ)</label>
                    <input type="file" name="image" class="form-control">
                    @if($car->image)
                        <div style="margin-top: 12px;">
                            <img src="{{ asset('storage/' . $car->image) }}" alt="Current Image" style="height: 60px; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-actions mt-4">
                <button type="submit" class="btn-primary">Cập nhật thông tin</button>
                <a href="{{ route('admin.cars.index') }}" class="btn-secondary" style="text-decoration: none;">Hủy bỏ</a>
            </div>
        </form>
    </div>
@endsection