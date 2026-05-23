<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Car;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        // Thống kê tổng quan
        $totalUsers = User::where('role', 'user')->count();
        $newBookingsCount = Booking::where('status', 'pending')->count();
        // doanh thu (chỉ tính đơn đã hoàn thành, đã duyệt)
        $totalRevenue = Booking::where('status', 'confirmed')->sum('total_price');

        // Tình trạng xe
        $availableCars = Car::where('status', 'available')->count();
        $rentedCars = Car::where('status', 'rented')->count();
        $maintenanceCars = Car::where('status', 'maintenance')->count();

        // Đơn hàng cần xử lý gấp 
        $urgentBookings = Booking::with(['user', 'car'])
                            ->where('status', 'pending')
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'newBookingsCount', 'totalRevenue',
            'availableCars', 'rentedCars', 'maintenanceCars',
            'urgentBookings'
        ));
    }
}