<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Car;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo các danh mục xe đa dạng hơn
        $cat4 = Category::firstOrCreate(['slug' => 'xe-4-cho'], ['name' => 'Xe 4 chỗ']);
        $cat7 = Category::firstOrCreate(['slug' => 'xe-7-cho'], ['name' => 'Xe 7 chỗ']);
        $cat16 = Category::firstOrCreate(['slug' => 'xe-16-cho'], ['name' => 'Xe 16 chỗ']);
        $cat29 = Category::firstOrCreate(['slug' => 'xe-29-cho'], ['name' => 'Xe 29 chỗ']);
        $cat45 = Category::firstOrCreate(['slug' => 'xe-45-cho'], ['name' => 'Xe 45 chỗ']);
        $catLimo = Category::firstOrCreate(['slug' => 'limousine'], ['name' => 'Limousine cao cấp']);

        // 2. Mảng dữ liệu xe cực khủng
        $cars = [
            // Xe 4 chỗ
            ['category_id' => $cat4->id, 'name' => 'Honda City 2024', 'brand' => 'Honda', 'transmission' => 'Số tự động', 'fuel_type' => 'Xăng', 'seats' => 4, 'price_per_day' => 600000, 'status' => 'available'],
            ['category_id' => $cat4->id, 'name' => 'Kia Morning 2023', 'brand' => 'Kia', 'transmission' => 'Số sàn', 'fuel_type' => 'Xăng', 'seats' => 4, 'price_per_day' => 400000, 'status' => 'available'],
            ['category_id' => $cat4->id, 'name' => 'Mazda 3 Luxury', 'brand' => 'Mazda', 'transmission' => 'Số tự động', 'fuel_type' => 'Xăng', 'seats' => 4, 'price_per_day' => 750000, 'status' => 'available'],
            ['category_id' => $cat4->id, 'name' => 'Toyota Vios 2024', 'brand' => 'Toyota', 'transmission' => 'Số sàn', 'fuel_type' => 'Xăng', 'seats' => 4, 'price_per_day' => 500000, 'status' => 'available'],
            
            // Xe 7 chỗ
            ['category_id' => $cat7->id, 'name' => 'Mitsubishi Xpander', 'brand' => 'Mitsubishi', 'transmission' => 'Số tự động', 'fuel_type' => 'Xăng', 'seats' => 7, 'price_per_day' => 800000, 'status' => 'available'],
            ['category_id' => $cat7->id, 'name' => 'Ford Everest 2024', 'brand' => 'Ford', 'transmission' => 'Số tự động', 'fuel_type' => 'Dầu', 'seats' => 7, 'price_per_day' => 1200000, 'status' => 'available'],
            ['category_id' => $cat7->id, 'name' => 'Hyundai SantaFe', 'brand' => 'Hyundai', 'transmission' => 'Số tự động', 'fuel_type' => 'Dầu', 'seats' => 7, 'price_per_day' => 1300000, 'status' => 'available'],
            ['category_id' => $cat7->id, 'name' => 'Toyota Fortuner', 'brand' => 'Toyota', 'transmission' => 'Số sàn', 'fuel_type' => 'Dầu', 'seats' => 7, 'price_per_day' => 1000000, 'status' => 'available'],
            
            // Xe 16 chỗ
            ['category_id' => $cat16->id, 'name' => 'Ford Transit 2023', 'brand' => 'Ford', 'transmission' => 'Số sàn', 'fuel_type' => 'Dầu', 'seats' => 16, 'price_per_day' => 1200000, 'status' => 'available'],
            ['category_id' => $cat16->id, 'name' => 'Hyundai Solati', 'brand' => 'Hyundai', 'transmission' => 'Số sàn', 'fuel_type' => 'Dầu', 'seats' => 16, 'price_per_day' => 1500000, 'status' => 'available'],
            ['category_id' => $cat16->id, 'name' => 'Mercedes Sprinter', 'brand' => 'Mercedes', 'transmission' => 'Số sàn', 'fuel_type' => 'Dầu', 'seats' => 16, 'price_per_day' => 1300000, 'status' => 'available'],

            // Xe 29 chỗ
            ['category_id' => $cat29->id, 'name' => 'Hyundai County', 'brand' => 'Hyundai', 'transmission' => 'Số sàn', 'fuel_type' => 'Dầu', 'seats' => 29, 'price_per_day' => 2200000, 'status' => 'available'],
            ['category_id' => $cat29->id, 'name' => 'Samco Felix', 'brand' => 'Samco', 'transmission' => 'Số sàn', 'fuel_type' => 'Dầu', 'seats' => 29, 'price_per_day' => 2500000, 'status' => 'available'],
            ['category_id' => $cat29->id, 'name' => 'Thaco Town', 'brand' => 'Thaco', 'transmission' => 'Số sàn', 'fuel_type' => 'Dầu', 'seats' => 29, 'price_per_day' => 2400000, 'status' => 'available'],

            // Xe 45 chỗ
            ['category_id' => $cat45->id, 'name' => 'Hyundai Universe', 'brand' => 'Hyundai', 'transmission' => 'Số sàn', 'fuel_type' => 'Dầu', 'seats' => 45, 'price_per_day' => 3500000, 'status' => 'available'],
            ['category_id' => $cat45->id, 'name' => 'Thaco Bluesky', 'brand' => 'Thaco', 'transmission' => 'Số sàn', 'fuel_type' => 'Dầu', 'seats' => 45, 'price_per_day' => 3200000, 'status' => 'available'],

            // Limousine
            ['category_id' => $catLimo->id, 'name' => 'Ford Transit Limousine 9 Chỗ', 'brand' => 'Ford', 'transmission' => 'Số sàn', 'fuel_type' => 'Dầu', 'seats' => 9, 'price_per_day' => 2500000, 'status' => 'available'],
            ['category_id' => $catLimo->id, 'name' => 'Kia Carnival Royal', 'brand' => 'Kia', 'transmission' => 'Số tự động', 'fuel_type' => 'Dầu', 'seats' => 7, 'price_per_day' => 2000000, 'status' => 'available'],
            ['category_id' => $catLimo->id, 'name' => 'Hyundai Solati Limousine 11 Chỗ', 'brand' => 'Hyundai', 'transmission' => 'Số tự động', 'fuel_type' => 'Dầu', 'seats' => 11, 'price_per_day' => 3000000, 'status' => 'available'],
        ];

        foreach ($cars as $car) {
            Car::updateOrCreate(
                ['name' => $car['name']], 
                $car 
            );
        }

        $this->command->info('Đã cập nhật thành công!');
    }
}