@extends('layouts.admin')

@section('title', 'Thêm Xe Mới')
@section('page_title', 'Thêm Xe Mới')

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
        
        <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-grid">
                <div class="form-group">
                    <label>Tên xe</label>
                    <input type="text" name="name" class="form-control" required placeholder="VD: VinFast VF8">
                </div>
                
                <div class="form-group">
                    <label>Hãng xe</label>
                    <input type="text" name="brand" class="form-control" required placeholder="VD: VinFast">
                </div>

                <div class="form-group">
                    <label>Danh mục</label>
                    <select name="category_id" class="form-control" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Số chỗ ngồi</label>
                    <input type="text" name="seats" class="form-control" required placeholder="VD: 4, 7, limo">
                </div>

                <div class="form-group">
                    <label>Hộp số</label>
                    <select name="transmission" class="form-control">
                        <option value="Số tự động">Số tự động</option>
                        <option value="Số sàn">Số sàn</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Nhiên liệu</label>
                    <input type="text" name="fuel_type" class="form-control" required placeholder="VD: Xăng, Điện, Dầu">
                </div>

                <div class="form-group">
                    <label>Giá thuê/Ngày (VND)</label>
                    <input type="number" name="price_per_day" class="form-control" required placeholder="VD: 800000">
                </div>

                <div class="form-group">
                    <label>Hình ảnh xe</label>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>

            <div class="form-actions mt-4">
                <button type="submit" class="btn-primary">Lưu xe mới</button>
                <a href="{{ route('admin.cars.index') }}" class="btn-secondary" style="text-decoration: none;">Hủy bỏ</a>
            </div>
        </form>
    </div>
@endsection