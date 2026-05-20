<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-extrabold text-gray-900 uppercase tracking-wide">Quản lý Đơn đặt xe</h2>
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-xl font-bold border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider border-b border-gray-200">
                                <th class="p-4 font-bold">Mã Đơn</th>
                                <th class="p-4 font-bold">Khách hàng</th>
                                <th class="p-4 font-bold">Chi tiết xe</th>
                                <th class="p-4 font-bold">Thời gian thuê</th>
                                <th class="p-4 font-bold">Tổng tiền</th>
                                <th class="p-4 font-bold text-center">Trạng thái</th>
                                <th class="p-4 font-bold text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @forelse($bookings as $booking)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4 font-bold text-gray-900">#{{ $booking->id }}</td>
                                    
                                    <td class="p-4">
                                        <div class="font-bold text-gray-900">{{ $booking->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $booking->user->email }}</div>
                                    </td>
                                    
                                    <td class="p-4">
                                        <div class="font-bold text-blue-600">{{ $booking->car->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $booking->car->brand }}</div>
                                    </td>
                                    
                                    <td class="p-4 text-gray-600">
                                        {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}
                                    </td>
                                    
                                    <td class="p-4 font-bold text-gray-900">
                                        {{ number_format($booking->total_price, 0, ',', '.') }}đ
                                    </td>
                                    
                                    <td class="p-4 text-center">
                                        @if($booking->status == 'pending')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full">Chờ duyệt</span>
                                        @elseif($booking->status == 'confirmed')
                                            <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">Đã duyệt</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full">Đã hủy</span>
                                        @endif
                                    </td>
                                    
                                    <td class="p-4 text-center">
                                        @if($booking->status == 'pending')
                                            <div class="flex justify-center gap-2">
                                                <form action="{{ route('admin.bookings.update_status', $booking->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-lg transition shadow-sm tooltip" title="Duyệt đơn">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.bookings.update_status', $booking->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn này?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg transition shadow-sm tooltip" title="Hủy đơn">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs italic">- Đã xử lý -</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-gray-500">Chưa có đơn đặt xe nào trong hệ thống.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>