<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // Kiểm tra dữ liệu
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'start_date.after_or_equal' => 'Lỗi: Ngày nhận xe không được nằm trong quá khứ.',
            'end_date.after_or_equal' => 'Lỗi: Ngày trả xe phải sau hoặc cùng ngày với ngày nhận.',
        ]);
        
    }
}