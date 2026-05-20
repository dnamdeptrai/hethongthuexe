<x-app-layout>
    <div class="py-8 sm:py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 uppercase tracking-wide px-4 sm:px-0">Thanh toán & Xác nhận</h2>

            <form method="POST" action="{{ route('client.process_payment', $booking->id) }}" class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start px-4 sm:px-0">
                @csrf

                <div class="lg:col-span-7 space-y-6">
                    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100">

                    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Thông tin người đặt</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Họ và tên</label>
                                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 font-semibold">{{ Auth::user()->name }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Email xác nhận</label>
                                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 font-semibold">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-50 p-6 sm:p-8 rounded-3xl shadow-sm border border-blue-100 mt-6 animate-fade-in">
                        <h3 class="text-xl font-bold text-blue-900 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Hướng dẫn nhận xe
                        </h3>
                        
                        <div class="space-y-5 text-sm text-blue-800">
                            <div>
                                <strong class="block mb-2 text-base text-blue-900">Giấy tờ bắt buộc cần mang theo:</strong>
                                <ul class="list-disc pl-5 space-y-1.5">
                                    <li>Căn cước công dân (CCCD) hoặc Hộ chiếu bản gốc.</li>
                                    <li>Giấy phép lái xe hợp lệ (hạng B1/B2 trở lên).</li>
                                    <li>Tài sản thế chấp: CCCD/Hộ chiếu bản gốc hoặc tài sản có giá trị tương đương.</li>
                                </ul>
                            </div>
                            
                            <div class="pt-4 border-t border-blue-200">
                                <div class="flex flex-wrap items-center gap-3">
                                    <strong class="text-base text-blue-900">Địa điểm giao nhận xe:</strong>
                                    <a href="https://www.google.com/maps/search/?api=1&query=Bãi+xe+Đại+học+Phenikaa,+Hà+Đông,+Hà+Nội" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       class="inline-flex items-center gap-2 text-blue-700 hover:text-blue-900 font-bold bg-white px-4 py-2 rounded-xl shadow-sm transition-all border border-blue-200 hover:shadow-md hover:-translate-y-0.5">
                                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                                        Bãi xe Đại học Phenikaa, Hà Đông, Hà Nội
                                    </a>                                       
                                      
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="lg:col-span-5 bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Tóm tắt đơn hàng #{{ $booking->id }}</h3>
                    
                    <div class="flex gap-4 mb-6">
                        <div class="w-24 h-24 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                            @if($booking->car->image)
                                <img src="{{ asset('storage/' . $booking->car->image) }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex flex-col justify-center">
                            <span class="text-xs font-bold text-blue-600 uppercase">{{ $booking->car->brand }}</span>
                            <span class="text-lg font-bold text-gray-900 leading-tight mt-1">{{ $booking->car->name }}</span>
                            <span class="text-sm text-gray-500 mt-1">{{ $booking->car->transmission }} • {{ $booking->car->seats }} chỗ</span>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 mb-6 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 text-sm">Ngày nhận xe:</span>
                            <span class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 text-sm">Ngày trả xe:</span>
                            <span class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}</span>
                        </div>
                        <div class="pt-3 border-t border-gray-200 flex justify-between items-center">
                            <span class="text-gray-500 text-sm">Đơn giá:</span>
                            <span class="font-semibold text-gray-900">{{ number_format($booking->car->price_per_day, 0, ',', '.') }}đ / ngày</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex justify-between items-end mb-6">
                            <span class="text-gray-500 font-bold uppercase tracking-wide text-sm">Tổng thanh toán</span>
                            <span class="text-3xl font-extrabold text-blue-600">{{ number_format($booking->total_price, 0, ',', '.') }}đ</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Phương thức thanh toán</h3>
                        
                        <div class="space-y-4">
                            <label class="flex items-center p-5 border-2 border-gray-100 hover:border-gray-300 bg-white rounded-2xl cursor-pointer transition-all has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50">
                                <input type="radio" name="payment_method" value="cod" checked class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <div class="ml-4">
                                    <span class="block text-gray-900 font-bold text-lg">Thanh toán khi nhận xe (COD)</span>
                                </div>
                            </label>

                            <label class="flex items-center p-5 border-2 border-gray-100 hover:border-gray-300 bg-white rounded-2xl cursor-pointer transition-all has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50">
                                <input type="radio" name="payment_method" value="bank_transfer" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <div class="ml-4">
                                    <span class="block text-gray-900 font-bold text-lg">Chuyển khoản VietQR</span>
                                </div>
                            </label>

                            <div id="qr_block" class="hidden mt-4 p-6 bg-blue-50 rounded-2xl border border-blue-200 text-center animate-fade-in">
                                <h4 class="text-blue-900 font-extrabold mb-4 uppercase tracking-wide">Quét mã để thanh toán</h4>
                                <div class="bg-white p-4 rounded-xl inline-block shadow-sm mb-4 border border-gray-100">
                                    <img src="https://img.vietqr.io/image/MB-0963669540-compact.png?amount={{ $booking->total_price }}&addInfo=Thanh toan don xe {{ $booking->id }}&accountName=DANG HAI NAM" 
                                         alt="VietQR" class="w-48 h-48 object-contain">
                                </div>

                                <div class="text-sm text-blue-800 space-y-2 bg-white/50 p-4 rounded-xl border border-blue-100">
                                    <p class="flex justify-between"><span>Ngân hàng:</span> <strong>MB Bank</strong></p>
                                    <p class="flex justify-between"><span>Chủ tài khoản:</span> <strong>Trần Thị Huyền</strong></p>
                                    <p class="flex justify-between"><span>Số tài khoản:</span> <strong>0963669540</strong></p>
                                    <p class="flex justify-between"><span>Số tiền:</span> <strong class="text-blue-600">{{ number_format($booking->total_price, 0, ',', '.') }}đ</strong></p>
                                    <p class="flex justify-between"><span>Nội dung:</span> <strong>Thanh toan don xe {{ $booking->id }}</strong></p>
                                </div>
                                
                                <p class="mt-4 text-xs text-blue-600 italic font-semibold">* Quý khách vui lòng chuyển đúng nội dung. Bấm "Hoàn tất đặt xe" sau khi đã chuyển khoản thành công!</p>
                            </div>
                        </div>
                    </div>
                    <div class="pt-6">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-4 rounded-xl transition duration-150 shadow-sm text-center block text-lg">
                            Xác nhận đặt xe
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
    
</x-app-layout>