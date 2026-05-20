<x-app-layout>
    <div class="py-8 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center gap-4 mb-4 overflow-x-auto pb-4 pt-2">
                @foreach($brands as $brandName => $logoPath)
                    @php
                        // Phần xử lý URL này vẫn để ở View vì nó liên quan trực tiếp đến state của UI
                        $isActive = request('brand') == $brandName;
                        $filterUrl = $isActive 
                            ? request()->fullUrlWithQuery(['brand' => null]) 
                            : request()->fullUrlWithQuery(['brand' => $brandName]);
                    @endphp
                    
                    <a href="{{ $filterUrl }}" 
                       class="flex-shrink-0 w-24 h-20 flex items-center justify-center p-3 rounded-2xl transition-all duration-200 cursor-pointer border-2 bg-white
                              {{ $isActive ? 'border-blue-600 shadow-md scale-105' : 'border-transparent hover:border-gray-200 hover:shadow-sm' }}">
                        <img src="{{ asset($logoPath) }}" alt="{{ $brandName }}" class="w-full h-full object-contain">
                    </a>
                @endforeach
            </div>

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Lựa chọn xe bạn muốn!</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($cars as $car)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-300 flex flex-col">
                        <div class="h-48 bg-gray-200 relative">
                            @if($car->image)
                                <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=800&q=80" alt="{{ $car->name }}" class="w-full h-full object-cover">
                            @endif
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-bold text-blue-600">
                                {{ $car->transmission }}
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="text-sm text-gray-500 mb-1">{{ $car->category->name }} • {{ $car->brand }}</div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $car->name }}</h4>
                            
                            <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                                <span class="flex items-center gap-1">{{ $car->seats }} chỗ</span>
                                <span class="flex items-center gap-1">{{ $car->fuel_type }}</span>
                            </div>
                            
                            <div class="mt-auto flex justify-between items-center border-t border-gray-100 pt-4">
                                <div>
                                    <div class="text-sm text-gray-500">Giá thuê từ</div>
                                    <div class="text-lg font-bold text-blue-600">
                                        {{ number_format($car->price_per_day, 0, ',', '.') }}đ<span class="text-sm text-gray-500 font-normal">/ngày</span>
                                    </div>
                                </div>
                                <button class="bg-gray-900 hover:bg-black text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition">
                                    Đặt ngay
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-dashed border-gray-300">
                        <p class="text-gray-500 text-lg">Hiện tại chưa có chiếc xe nào sẵn sàng cho thuê.</p>
                    </div>
                @endforelse
            </div>
            
        </div>
    </div>
</x-app-layout>