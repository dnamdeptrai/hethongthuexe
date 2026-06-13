<x-app-layout>
    <div class="py-4 sm:py-8 bg-white sm:bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

            <div class="bg-white sm:p-8 sm:rounded-3xl sm:shadow-sm sm:border border-gray-100">
                
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-10 items-start">
                    
                    <div class="md:col-span-7 px-4 sm:px-0">
                        <div class="h-[280px] sm:h-[400px] md:h-[450px] bg-gray-100 relative rounded-2xl overflow-hidden shadow-sm">
                            @if($car->image)
                                <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=1200&q=80" alt="{{ $car->name }}" class="w-full h-full object-cover">
                            @endif
                            <div class="absolute top-4 right-4 bg-blue-600 text-white px-4 py-1.5 rounded-full text-sm font-bold shadow-sm">
                                {{ $car->transmission }}
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-5 flex flex-col px-4 sm:px-0">
                        <span class="text-sm font-bold text-blue-600 tracking-wide uppercase"></span>
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-1 mb-4 leading-tight">{{ $car->name }}</h1>
                        
                        <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 mb-6">
                            <div class="text-sm text-gray-500 mb-1">Giá thuê tiêu chuẩn</div>
                            <div class="text-4xl font-extrabold text-blue-600">
                                {{ number_format($car->price_per_day, 0, ',', '.') }}đ <span class="text-base text-gray-500 font-normal">/ ngày</span>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('client.book.store') }}" class="space-y-5">
                            @csrf
                            <input type="hidden" name="car_id" value="{{ $car->id }}">

                            @if ($errors->any())
                                <div class="bg-red-50 text-red-600 p-3 rounded-xl text-sm font-semibold">
                                    @foreach ($errors->all() as $error)
                                        <p>• {{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="driver_name" class="block text-xs font-bold uppercase text-gray-700 mb-2 tracking-wider">Họ tên người lái</label>
                                    <input type="text" id="driver_name" name="driver_name" value="{{ old('driver_name', auth()->user()->name) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm bg-white">
                                </div>

                                <div>
                                    <label for="phone" class="block text-xs font-bold uppercase text-gray-700 mb-2 tracking-wider">Số điện thoại</label>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required pattern="[0-9]{9,11}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm bg-white">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-700 mb-2 tracking-wider">Ngày nhận xe</label>
                                    <input type="text" id="start_date" name="start_date" placeholder="Chọn ngày" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm bg-white cursor-pointer">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-700 mb-2 tracking-wider">Ngày trả xe</label>
                                    <input type="text" id="end_date" name="end_date" placeholder="Chọn ngày" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm bg-white cursor-pointer">
                                </div>
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-4 rounded-xl transition duration-150 shadow-sm text-center block text-lg">
                                    Xác nhận đặt xe
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="bg-white px-4 py-6 sm:p-8 sm:rounded-3xl sm:shadow-sm sm:border border-gray-100">
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 mb-6 uppercase tracking-wide border-b border-gray-100 pb-4">Chi tiết xe</h2>
                
                <div class="space-y-6 sm:space-y-8">
                    <div class="flex items-center gap-4 text-gray-700">
                        <span class="w-24 sm:w-32 text-gray-500 font-medium text-sm sm:text-base">Danh mục:</span>
                        <span class="font-semibold text-gray-900 bg-gray-100 px-3 py-1 rounded-lg text-sm sm:text-base">{{ $car->category->name }}</span>
                    </div>

                    <div>
                        <div class="flex items-center gap-4 text-gray-700 mb-4">
                            <span class="w-24 sm:w-32 text-gray-500 font-medium text-sm sm:text-base">Thông số:</span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4">
                            <div class="bg-gray-50 p-3 sm:p-4 rounded-2xl border border-gray-100 flex flex-col items-center justify-center text-center">
                                <div class="text-xs sm:text-sm text-gray-500 mb-1">Số chỗ ngồi</div>
                                <div class="text-base sm:text-lg font-bold text-gray-900">{{ $car->seats }} chỗ</div>
                            </div>
                            <div class="bg-gray-50 p-3 sm:p-4 rounded-2xl border border-gray-100 flex flex-col items-center justify-center text-center">
                                <div class="text-xs sm:text-sm text-gray-500 mb-1">Nhiên liệu</div>
                                <div class="text-base sm:text-lg font-bold text-gray-900">{{ $car->fuel_type }}</div>
                            </div>
                            <div class="bg-gray-50 p-3 sm:p-4 rounded-2xl border border-gray-100 flex flex-col items-center justify-center text-center">
                                <div class="text-xs sm:text-sm text-gray-500 mb-1">Hộp số</div>
                                <div class="text-base sm:text-lg font-bold text-gray-900">{{ $car->transmission }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-6 sm:pt-8">
                        <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 text-gray-700">
                            <span class="w-24 sm:w-32 text-gray-500 font-medium flex-shrink-0 text-sm sm:text-base">Chính sách:</span>
                            <div class="space-y-2 sm:space-y-3 text-sm leading-relaxed text-gray-600">
                                <p>• Yêu cầu có giấy phép lái xe (B1/B2) hợp lệ đối với dịch vụ tự lái.</p>
                                <p>• Tài sản thế chấp bắt buộc: CCCD/Hộ chiếu gốc hoặc tiền mặt/xe máy có giá trị tương đương.</p>
                                <p>• Xe được vệ sinh sạch sẽ và đổ đầy bình nhiên liệu trước khi bàn giao cho quý khách.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/vn.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const endPicker = flatpickr("#end_date", {
                locale: "vn",
                dateFormat: "Y-m-d", 
                altInput: true,
                altFormat: "d/m/Y",  
                minDate: "today",   
            });
            // Khởi tạo lịch cho Ngày Nhận
            flatpickr("#start_date", {
                locale: "vn",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                minDate: "today",    
                onChange: function(selectedDates, dateStr, instance) {
                    endPicker.set('minDate', dateStr);
                }
            });
        });
    </script>
</x-app-layout>
