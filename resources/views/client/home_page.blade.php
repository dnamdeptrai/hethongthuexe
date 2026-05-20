<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Khám phá xe du lịch') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
                <form class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" placeholder="Bạn muốn thuê xe gì? (VD: Innova, Limousine...)" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    <div class="w-full md:w-48">
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="">Tất cả loại xe</option>
                            <option value="4">Xe 4 chỗ</option>
                            <option value="7">Xe 7 chỗ</option>
                            <option value="limousine">Limousine cao cấp</option>
                        </select>
                    </div>
                    <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition duration-150 shadow-sm">
                        Tìm kiếm
                    </button>
                </form>
            </div>

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Xe nổi bật dành cho bạn</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                @forelse($cars as $car)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-300">
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
                        <div class="p-6">
                            <div class="text-sm text-gray-500 mb-1">{{ $car->category->name }} • {{ $car->brand }}</div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $car->name }}</h4>
                            
                            <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                                <span class="flex items-center gap-1">{{ $car->seats }} chỗ</span>
                                <span class="flex items-center gap-1">{{ $car->fuel_type }}</span>
                            </div>
                            
                            <div class="flex justify-between items-end border-t border-gray-100 pt-4 mt-4">
                                <div>
                                    <div class="text-sm text-gray-500">Giá thuê từ</div>
                                    <div class="text-xl font-bold text-blue-600">
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