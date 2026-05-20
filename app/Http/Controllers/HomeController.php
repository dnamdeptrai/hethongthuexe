<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        //chỉ lấy xe đang available
        $query = Car::where('status', 'available');

        // Tìm kiếm
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        // Lọc theo Loại xe
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Lọc theo Hãng xe 
        if ($request->filled('brand')) {
            $query->where('brand', $request->input('brand'));
        }

        $cars = $query->get();
        $categories = Category::all(); 
        
        $brands = [
            'Toyota' => 'car_logo/toyota.png',
            'Maybach' => 'car_logo/maybach.png',
            'Ford' => 'car_logo/ford.png',
            'Honda' => 'car_logo/honda.png',
            'Mazda' => 'car_logo/mazda.png',
            'Kia' => 'car_logo/kia.png',
            'VinFast' => 'car_logo/vinfast.png',
            'Hyundai' => 'car_logo/hyundai.png',
            'Mercedes' => 'car_logo/mercedes.png',
            'Nissan' => 'car_logo/nisan.png',
            'BMW' => 'car_logo/bmw.png',
            
            
        ];
        // Lấy dữ liệu và truyền sang View
        $cars = $query->get();
        $categories = Category::all(); 
        
        return view('client.home_page', compact('cars', 'categories', 'brands'));
    }
}