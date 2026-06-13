<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(private readonly BookingService $bookingService)
    {
    }

    // luu đơn đặt xe
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'driver_name' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^[0-9]{9,11}$/'],
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ], [
            'start_date.after_or_equal' => 'Lỗi: Ngày nhận xe không được nằm trong quá khứ.',
            'end_date.after' => 'Lỗi: Ngày trả xe phải sau ngày nhận.',
            'phone.regex' => 'Số điện thoại phải có từ 9 đến 11 chữ số.',
        ]);

        // tính tiền
        $car = Car::query()
            ->whereKey($request->integer('car_id'))
            ->where('status', 'available')
            ->first();

        if ($car === null) {
            return back()
                ->withErrors(['car_id' => 'Xe đã được đặt hoặc đang bảo dưỡng.'])
                ->withInput();
        }
        
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        
        // Tính số ngày thuê
        $totalPrice = $this->bookingService->calculateTotalPrice(
            $start,
            $end,
            (float) $car->price_per_day
        );

        $booking = Booking::create([
            'user_id' => auth()->id(), 
            'car_id' => $car->id,
            'driver_name' => $request->string('driver_name')->toString(),
            'phone' => $request->string('phone')->toString(),
            'start_date' => $start,
            'end_date' => $end,
            'total_price' => $totalPrice,
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

        // Validate
        $request->validate([
            'payment_method' => 'required|in:cod,bank_transfer',
            'customer_phone' => 'required|string|max:15'
        ], [
            'customer_phone.required' => 'Vui lòng nhập số điện thoại để chúng tôi liên hệ giao xe.'
        ]);

        // Lưu số điện thoại riêng cho đơn hàng này
        $booking->customer_phone = $request->customer_phone;

        // Lấy tài khoản đang đăng nhập và lưu số điện thoại
        if ($request->has('save_phone_to_profile')) {
            $user = \App\Models\User::find(auth()->id());
            $user->phone = $request->customer_phone;
            $user->save();
        }
        
        if ($request->has('is_delivery') && $request->is_delivery == '1') {
            $request->validate([
                'delivery_address' => 'required|string|max:255'
            ], [
                'delivery_address.required' => 'Vui lòng nhập địa chỉ để chúng tôi giao xe tận nơi.'
            ]);

            $booking->is_delivery = 1; 
            $booking->delivery_address = $request->delivery_address;
            
            $days = \Carbon\Carbon::parse($booking->start_date)->diffInDays(\Carbon\Carbon::parse($booking->end_date));
            $days = $days == 0 ? 1 : $days;
            $base_price = $days * $booking->car->price_per_day;
            
            $booking->total_price = $base_price + 200000; 
        } else {
            // Nếu không chọn giao tận nơi
            $booking->is_delivery = 0;
            $booking->delivery_address = null;
        }
        $booking->save();

        // Xử lý chuyển hướng
        if ($request->payment_method === 'bank_transfer') {
            return redirect()->route('client.bookings.history')->with([
                'show_qr' => true,
                'qr_amount' => $booking->total_price,
                'qr_order_id' => $booking->id
            ]);
        } else {
            return redirect()->route('client.bookings.history')->with('success', ' Đặt thuê xe thành công, nhân viên sẽ gọi điện để xác nhận với bạn trong thời gian sớm nhất!');
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
