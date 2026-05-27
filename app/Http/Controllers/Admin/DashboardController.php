<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // cộng tổng tiền của các đơn đã hoàn thành
        $totalRevenue = Booking::where('status', 'completed')->sum('total_price');

        $totalCustomers = User::where('role', 'user')->count();
        $totalBookings = Booking::count();
        $totalCars = Car::count();

        // lấy thống kê trong 7 ngày gần nhất
        $sevenDaysAgo = Carbon::now()->subDays(6)->startOfDay();

        // thống kê doanh thu theo ngày
        $revenueByDay = Booking::where('status', 'completed')
            ->where('created_at', '>=', $sevenDaysAgo)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total'))
            ->groupBy('date')
            ->get();

        // thống kê lượng khách hàng mới đăng ký theo ngày
        $customersByDay = User::where('role', 'user')
            ->where('created_at', '>=', $sevenDaysAgo)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->get();

        // Nếu ngày đó không có đơn/khách
        $chartLabels = [];
        $revenueData = [];
        $customerData = [];

        for ($i = 6; $i >= 0; $i--) {
            $dateStr = Carbon::now()->subDays($i)->format('Y-m-d');
            $displayLabel = Carbon::now()->subDays($i)->format('d/m'); // Định dạng hiển thị mảng ngày: 27/05
            
            $chartLabels[] = $displayLabel;

            // Nạp doanh thu ngày tương ứng 
            $dayRevenue = $revenueByDay->firstWhere('date', $dateStr);
            $revenueData[] = $dayRevenue ? (float)$dayRevenue->total : 0;

            // Nạp số khách đăng ký ngày tương ứng
            $dayCustomer = $customersByDay->firstWhere('date', $dateStr);
            $customerData[] = $dayCustomer ? (int)$dayCustomer->count : 0;
        }

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalCustomers',
            'totalBookings',
            'totalCars',
            'chartLabels',
            'revenueData',
            'customerData'
        ));
    }
}