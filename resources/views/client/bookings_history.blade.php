<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 tracking-wide">LỊCH SỬ ĐẶT XE</h2>
            </div>
            <div id="success-alert" class="{{ session('success') ? 'flex' : 'hidden' }} mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl font-semibold shadow-sm items-center justify-between animate-fade-in transition-all">
                <div class="flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span id="success-message">{{ session('success') }}</span>
                </div>
                <button onclick="document.getElementById('success-alert').classList.add('hidden')" class="text-green-500 hover:text-green-700 text-2xl px-2">&times;</button>
            </div>
            @forelse($bookings as $booking)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row">
                    <div class="md:w-1/4 h-48 md:h-auto bg-gray-200 relative">
                        @if($booking->car->image)
                            <img src="{{ asset('storage/' . $booking->car->image) }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover">
                        @endif
                    </div>
                    
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <span class="text-xs font-bold text-gray-500 uppercase">{{ $booking->car->brand }}</span>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $booking->car->name }}</h3>
                                </div>
                                @if($booking->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full">Chờ duyệt</span>
                                @elseif($booking->status == 'confirmed')
                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">Đã duyệt</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full">Đã hủy</span>
                                @endif
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mt-4 text-sm text-gray-600">
                                <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                    <div class="text-xs text-gray-400 mb-1">Ngày nhận</div>
                                    <div class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }}</div>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                    <div class="text-xs text-gray-400 mb-1">Ngày trả</div>
                                    <div class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-100 flex justify-between items-center">
                            <div class="text-sm text-gray-500">Mã đơn: #{{ $booking->id }}</div>
                            <div class="text-right">
                                <span class="text-sm text-gray-500">Tổng tiền:</span>
                                <span class="text-xl font-extrabold text-blue-600 ml-2">{{ number_format($booking->total_price, 0, ',', '.') }}đ</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white p-12 rounded-2xl border border-dashed border-gray-300 text-center">
                    <p class="text-gray-500 text-lg mb-4">Bạn chưa có đơn đặt xe nào.</p>
                    <a href="{{ route('client.dashboard') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-xl transition">
                        Khám phá xe ngay
                    </a>
                </div>
            @endforelse

        </div>
    </div>
    @if(session('show_qr'))
        <div id="qr_modal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="document.getElementById('qr_modal').remove()"></div>
            
            <div class="bg-white rounded-3xl max-w-sm w-full p-8 text-center shadow-2xl relative z-10 animate-[wiggle_0.3s_ease-in-out]">
                <button onclick="document.getElementById('qr_modal').remove()" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 bg-gray-100 rounded-full p-1 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <h3 class="text-2xl font-extrabold text-blue-900 mb-1 uppercase tracking-wide">Thanh toán</h3>
                <p class="text-gray-500 mb-6 text-sm">Quét mã bằng ứng dụng ngân hàng</p>

                <div class="bg-blue-50 p-3 rounded-2xl inline-block border border-blue-100 mb-6 shadow-inner">
                    <img src="https://img.vietqr.io/image/MB-0963669540-compact.png?amount={{ session('qr_amount') }}&addInfo=Thanh toan don xe {{ session('qr_order_id') }}&accountName=DANG HAI NAM"
                         alt="VietQR" class="w-56 h-56 object-contain mx-auto rounded-xl">
                </div>

                <div class="space-y-3 text-sm text-left bg-gray-50 p-5 rounded-2xl border border-gray-100 mb-6">
                    <div class="flex justify-between items-center"><span class="text-gray-500">Chủ TK:</span> <strong class="text-gray-900 text-right">TRAN THI HUYEN</strong></div>
                    <div class="flex justify-between items-center"><span class="text-gray-500">Số tiền:</span> <strong class="text-blue-600 text-lg">{{ number_format(session('qr_amount'), 0, ',', '.') }}đ</strong></div>
                    <div class="flex justify-between items-center"><span class="text-gray-500">Nội dung:</span> <strong class="text-gray-900 text-right font-mono">Thanh toan don xe {{ session('qr_order_id') }}</strong></div>
                </div>

                <button onclick="closeQRAndShowSuccess()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl transition shadow-md hover:shadow-lg">
                    Tôi đã chuyển khoản xong
                </button>
            </div>
        </div>
    @endif
    <script>
        function closeQRAndShowSuccess() {
            const modal = document.getElementById('qr_modal');
            if(modal) modal.remove();
          
            const alertBox = document.getElementById('success-alert');
            const alertMsg = document.getElementById('success-message');
            
            if(alertBox && alertMsg) {
                alertMsg.innerText = 'Đặt thuê xe thành công, nhân viên sẽ gọi điện để xác nhận với bạn trong thời gian sớm nhất!';
                alertBox.classList.remove('hidden');
                alertBox.classList.add('flex');
            }
        }
    </script>
</x-app-layout>