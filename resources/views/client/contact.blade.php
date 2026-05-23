<x-app-layout>
    <div class="py-12 sm:py-20 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-16">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-blue-900 tracking-tight mb-4">Liên Hệ Với Chúng Tôi</h1>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto">Mọi thắc mắc, phản hồi hoặc cần hỗ trợ đặt xe, đội ngũ của chúng tôi luôn sẵn sàng lắng nghe và giải đáp cho bạn.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                <div class="lg:col-span-7 bg-white p-8 sm:p-10 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Gửi tin nhắn cho chúng tôi</h3>
                    <form action="#" method="POST" class="space-y-6">
                        @csrf <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Họ và tên</label>
                                <input type="text" 
                                       name="name"
                                       value="{{ old('name', auth()->user()?->name) }}"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                       placeholder="Nhập tên của bạn" required>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Số điện thoại</label>
                                <input type="text" 
                                       name="phone"
                                       value="{{ old('phone', auth()->user()?->phone) }}"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                       placeholder="Nhập số điện thoại" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email liên hệ</label>
                            <input type="email" 
                                   name="email"
                                   value="{{ old('email', auth()->user()?->email) }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                   placeholder="Nhập địa chỉ email của bạn" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nội dung lời nhắn</label>
                            <textarea name="message" rows="5" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none" placeholder="Bạn cần chúng tôi hỗ trợ điều gì?" required></textarea>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-4 rounded-xl transition duration-150 shadow-sm text-lg">
                            Gửi yêu cầu hỗ trợ
                        </button>
                    </form>
                </div>

                <div class="lg:col-span-5 space-y-8">
                    <div class="bg-blue-50 p-8 rounded-3xl border border-blue-100 shadow-sm">
                        <h3 class="text-xl font-bold text-blue-900 mb-6">Thông tin trực tiếp</h3>
                        <ul class="space-y-6 text-blue-800">
                            <li class="flex items-start">
                                <div class="bg-white p-3 rounded-full shadow-sm mr-4 text-blue-600 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <strong class="block text-blue-900 mb-1">Trụ sở chính:</strong>
                                    <span class="leading-relaxed">Đại học Phenikaa, phường Yên Nghĩa, quận Hà Đông, Hà Nội</span>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-white p-3 rounded-full shadow-sm mr-4 text-blue-600 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <div>
                                    <strong class="block text-blue-900 mb-1">Hotline hỗ trợ:</strong>
                                    <span class="text-xl font-bold tracking-wide">0987654321</span>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-white p-3 rounded-full shadow-sm mr-4 text-blue-600 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <strong class="block text-blue-900 mb-1">Email:</strong>
                                    <span>example@gmail.com</span>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="rounded-3xl overflow-hidden shadow-sm border border-gray-200 h-[300px]">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3725.748366050519!2d105.74459841533145!3d20.962615686034177!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313452efff394ce3%3A0x391a39d4325be464!2sPhenikaa%20University!5e0!3m2!1sen!2s!4v1683884848393!5m2!1sen!2s" 
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>