<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Car;
use Carbon\Carbon; 

class BookingController extends Controller
{
    // luu đơn đặt xe
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'start_date.after_or_equal' => 'Lỗi: Ngày nhận xe không được nằm trong quá khứ.',
            'end_date.after_or_equal' => 'Lỗi: Ngày trả xe phải sau hoặc cùng ngày với ngày nhận.',
        ]);

        // tính tiền
        $car = Car::findOrFail($request->car_id);
        
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        
        // Tính số ngày thuê
        $days = $start->diffInDays($end);
        if ($days == 0) {
            $days = 1;
        }

        $total_price = $days * $car->price_per_day;

        $booking = Booking::create([
            'user_id' => auth()->id(), 
            'car_id' => $car->id,
            'start_date' => $start,
            'end_date' => $end,
            'total_price' => $total_price,
            'status' => 'pending' 
        ]);
        return redirect()->route('client.checkout', $booking->id);
    }
    public function checkout($id)
    {
        // Tìm đơn hàng khớp với ID 
        $booking = Booking::with('car')->where('user_id', auth()->id())->findOrFail($id);

        if ($booking->status !== 'pending') {
            return redirect()->route('client.bookings.history')->with('error', 'Đơn hàng này đã được xử lý!');
        }

        return view('client.checkout', compact('booking'));
    }

    public function processPayment(Request $request, $id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'payment_method' => 'required|in:cod,bank_transfer'
        ]);

        if ($request->payment_method === 'bank_transfer') {
            return redirect()->route('client.bookings.history')->with([
                'success' => 'Vui lòng quét mã QR để hoàn tất thanh toán!',
                'show_qr' => true, 
                'qr_amount' => $booking->total_price,
                'qr_order_id' => $booking->id
            ]);
        } else {
            return redirect()->route('client.bookings.history')->with('success', '🎉 Bạn đã đặt xe thành công. Vui lòng chuẩn bị tiền mặt khi đến nhận xe!');
        }
    }
    // hiện lịch sử
    public function history()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with('car') 
            ->latest()   
            ->get();
        return view('client.bookings_history', compact('bookings'));
    }
}