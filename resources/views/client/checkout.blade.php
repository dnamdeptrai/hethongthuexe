<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <div class="py-8 sm:py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 uppercase tracking-wide px-4 sm:px-0">Thanh toán & Xác nhận</h2>

            <form method="POST" action="{{ route('client.process_payment', $booking->id) }}" x-data="mapCheckoutComponent()" class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start px-4 sm:px-0">
                @csrf
                <div class="lg:col-span-7 space-y-6">
                    
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

                        <div class="mt-4 pt-4 border-t border-gray-100" 
                             x-data="{ 
                                profilePhone: '{{ Auth::user()->phone ?? '' }}', 
                                currentPhone: '{{ old('customer_phone', Auth::user()->phone ?? '') }}',
                                showCheckbox: false,
                                timeout: null,
                                checkPhone() {
                                    clearTimeout(this.timeout);
                                    this.timeout = setTimeout(() => {
                                        this.showCheckbox = (this.currentPhone.trim() !== this.profilePhone.trim()) && (this.currentPhone.trim() !== '');
                                    }, 1000);
                                }
                             }"
                             x-init="checkPhone()"
                        >
                            <label for="customer_phone" class="block text-sm font-bold text-gray-700 mb-2">Số điện thoại liên hệ <span class="text-red-500">*</span></label>
                            
                            <input type="text" 
                                   name="customer_phone" 
                                   id="customer_phone" 
                                   x-model="currentPhone"
                                   @input="checkPhone()"
                                   placeholder="Nhập số điện thoại để nhận xe..." 
                                   required 
                                   class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl text-gray-900 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                   
                            @error('customer_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            
                            <label x-show="showCheckbox" x-collapse class="flex items-start mt-4 cursor-pointer group bg-blue-50 p-4 rounded-xl border border-blue-200 shadow-sm transition-all">
                                <div class="flex items-center h-5 mt-0.5">
                                    <input type="checkbox" name="save_phone_to_profile" value="1" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </div>
                                <div class="ml-3">
                                    <span class="block text-sm font-extrabold text-blue-900 group-hover:text-blue-700 transition">Số điện thoại mới ư?</span>
                                    <span class="block text-xs text-blue-700 mt-1">Bạn có muốn lưu số này cho những lần đặt xe tiếp theo không?</span>
                                </div>
                            </label>
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <label class="flex items-start cursor-pointer group bg-gray-50 hover:bg-blue-50/50 p-4 rounded-xl border border-gray-200 hover:border-blue-300 transition-all">
                                <div class="flex items-center h-5 mt-0.5">
                                    <input type="checkbox" name="is_delivery" value="1" x-model="wantDelivery" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </div>
                                <div class="ml-3">
                                    <span class="block text-sm font-extrabold text-gray-900 group-hover:text-blue-700 transition">Tôi muốn giao xe tận nơi</span>
                                    <span class="block text-xs text-gray-500 mt-1">Chúng tôi sẽ giao xe đến tận nhà bạn (Phụ phí mặc định: +200.000đ).</span>
                                </div>
                            </label>

                            <div x-show="wantDelivery" x-collapse class="mt-4">
                                <label for="delivery_address" class="block text-sm font-bold text-gray-700 mb-2">Địa chỉ nhận xe <span class="text-red-500">*</span></label>
                                
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <input type="text" 
                                           name="delivery_address" 
                                           id="delivery_address" 
                                           x-model="deliveryAddress"
                                           placeholder="Nhập chi tiết số nhà, tên đường, phường/xã,..." 
                                           class="flex-1 px-4 py-3 bg-white border border-gray-300 rounded-xl text-gray-900 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                           :required="wantDelivery">
                                           
                                    <button type="button" 
                                            @click="showMapModal = true; initMap();"
                                            class="sm:w-auto w-full flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-blue-700 font-bold px-5 py-3 rounded-xl border border-blue-200 shadow-sm transition-all hover:-translate-y-0.5">
                                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                                        Chọn từ bản đồ
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="bg-blue-50 p-6 sm:p-8 rounded-3xl shadow-sm border border-blue-100 mt-6 animate-fade-in">
                        <h3 class="text-xl font-bold text-blue-900 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Hướng dẫn nhận xe tại bãi
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
                                    <strong class="text-base text-blue-900">Địa điểm bãi xe (nếu không chọn giao tận nơi):</strong>
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
                        
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-gray-500 text-sm">Giá thuê xe:</span>
                            <span class="font-bold text-gray-900">{{ number_format($booking->total_price, 0, ',', '.') }}đ</span>
                        </div>

                        <div x-show="wantDelivery" x-collapse class="flex justify-between items-center text-sm text-gray-600 pt-1">
                            <span class="flex items-center gap-1 text-gray-6=500 font-medium">Phụ phí giao xe:</span>
                            <span class="font-bold text-gray-900">200.000đ</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex justify-between items-end mb-6">
                            <span class="text-gray-500 font-bold uppercase tracking-wide text-sm">Tổng thanh toán</span>
                            <span class="text-3xl font-extrabold text-blue-600" 
                                  x-text="new Intl.NumberFormat('vi-VN').format(basePrice + (wantDelivery ? deliveryFee : 0)) + 'đ'">
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Phương thức thanh toán</h3>
                        
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
                        </div>
                    </div>
                    
                    <div class="pt-6">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-4 rounded-xl transition duration-150 shadow-sm text-center block text-lg">
                            Xác nhận đặt xe
                        </button>
                    </div>
                </div>

                <div x-show="showMapModal" 
                     class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
                     x-transition
                     x-cloak>
                    
                    <div class="bg-white rounded-3xl max-w-5xl w-full p-6 shadow-2xl relative flex flex-col h-[85vh]" @click.away="showMapModal = false; searchResults = []">
                        
                        <div class="flex items-center gap-4 mb-4 relative z-[10000]">
                            <div class="relative flex-1">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg x-show="!isSearching" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    <svg x-show="isSearching" class="w-5 h-5 text-blue-500 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                </div>
                                <input type="text" 
                                       x-model="searchQuery" 
                                       @input="handleSearch()"
                                       placeholder="Nhập tên đường, phường, quận bạn muốn tìm..." 
                                       class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-blue-500 focus:border-blue-500 focus:bg-white shadow-sm transition-all"
                                       autocomplete="off">
                                
                                <button type="button" x-show="searchQuery.length > 0" @click="searchQuery = ''; searchResults = [];" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>

                                <ul x-show="searchResults.length > 0" x-transition.opacity 
                                    class="absolute w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl max-h-60 overflow-y-auto divide-y divide-gray-50">
                                    <template x-for="(res, index) in searchResults" :key="index">
                                        <li @click="selectLocation(res)" class="p-4 hover:bg-blue-50 cursor-pointer transition-colors flex items-start gap-3">
                                            <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            <span class="text-sm text-gray-700 font-medium" x-text="res.display_name"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>

                            <button type="button" @click="showMapModal = false; searchResults = []" class="flex-shrink-0 text-gray-400 hover:text-red-500 bg-gray-100 hover:bg-red-50 rounded-full p-3 transition-colors shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <div id="map_canvas" class="w-full flex-1 rounded-2xl border-2 border-gray-200 shadow-inner overflow-hidden z-0 relative" @click="searchResults = []"></div>

                        <div class="mt-4 p-4 bg-blue-50 rounded-xl border border-blue-200 flex justify-between items-center z-10">
                            <div class="flex-1 pr-4">
                                <span class="text-xs font-bold text-blue-700 uppercase block mb-1">Điểm đến đã chọn:</span>
                                <p class="text-base font-semibold text-gray-900 leading-snug" x-text="deliveryAddress || 'Chưa chọn vị trí nào...'"></p>
                            </div>
                            <div>
                                <button type="button" 
                                        @click="showMapModal = false; searchResults = []" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-xl shadow-md transition-all hover:scale-105 whitespace-nowrap">
                                    Chọn
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function mapCheckoutComponent() {
            return {
                wantDelivery: false, 
                basePrice: {{ $booking->total_price }}, 
                deliveryFee: 200000,
                deliveryAddress: '{!! addslashes(old('delivery_address', '')) !!}',
                showMapModal: false,
                map: null,
                marker: null,
                
                searchQuery: '',
                searchResults: [],
                searchTimeout: null,
                isSearching: false,

                handleSearch() {
                    clearTimeout(this.searchTimeout);
                        if (this.searchQuery.trim().length < 2) {
                        this.searchResults = [];
                        return;
                    }
                    this.isSearching = true;
                    this.searchTimeout = setTimeout(() => {
                        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.searchQuery)}&accept-language=vi&countrycodes=vn&limit=5`)
                            .then(res => res.json())
                            .then(data => {
                                this.searchResults = data;
                                this.isSearching = false;
                            })
                            .catch(err => {
                                console.error('Lỗi tìm kiếm:', err);
                                this.isSearching = false;
                            });
                    }, 500);
                },

                selectLocation(loc) {
                    const lat = parseFloat(loc.lat);
                    const lng = parseFloat(loc.lon);
                    this.map.setView([lat, lng], 18);
                    if (this.marker) {
                        this.marker.setLatLng([lat, lng]);
                    } else {
                        this.marker = L.marker([lat, lng]).addTo(this.map);
                    }
                    this.deliveryAddress = loc.display_name;
                    if(!this.searchQuery.includes(loc.name)) {
                        this.searchQuery = loc.display_name;
                    }
                    this.searchResults = []; 
                },

                initMap() {
                    setTimeout(() => {
                        if (!this.map) {
                            this.map = L.map('map_canvas').setView([20.9631, 105.7468], 16);
                            L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                                maxZoom: 20,
                                attribution: '© Google Maps'
                            }).addTo(this.map);
                            this.map.on('click', (e) => {
                                const lat = e.latlng.lat;
                                const lng = e.latlng.lng;
                                
                                if (this.marker) {
                                    this.marker.setLatLng(e.latlng);
                                } else {
                                    this.marker = L.marker(e.latlng).addTo(this.map);
                                }
                                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=vi`)
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data && data.display_name) {
                                            this.deliveryAddress = data.display_name;
                                            this.searchQuery = data.display_name; 
                                        }
                                    });
                            });
                        } else {
                            this.map.invalidateSize();
                        }
                    }, 300);
                }
            }
        }
    </script>
</x-app-layout>