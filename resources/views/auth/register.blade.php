<x-guest-layout>
    <div class="flex min-h-screen bg-white">
        <div class="hidden lg:flex lg:w-1/2 bg-cover bg-center relative" style="background-image: url('{{ asset('images/bg-login.jpeg') }}');">
            <div class="absolute inset-0 bg-black/40"></div> 
            <div class="relative z-10 flex flex-col justify-center h-full p-12 text-white w-full">
                <div class="text-center sm:text-left"> 
                    <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight mb-6 drop-shadow-lg">
                        Khám phá mọi nẻo đường<br>với chiếc xe lý tưởng của bạn
                    </h1>
                    <p class="text-gray-200 text-lg sm:text-xl max-w-lg drop-shadow-md">
                        Hệ thống đặt xe du lịch trực tuyến nhanh chóng, an toàn và đa dạng lựa chọn từ 4 chỗ đến Limousine cao cấp.
                    </p>
                </div>
            </div>
        </div>
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-16 lg:px-24 bg-gray-50/50 py-10">
            <div class="max-w-md w-full mx-auto bg-white p-8 sm:p-10 rounded-2xl shadow-xl shadow-gray-100 border border-gray-100">
                
                <div class="text-center mb-8 animate-slide-up">
                    <div class="inline-flex justify-center mb-6">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-24 w-auto object-contain fallback-logo" onerror="this.style.display='none'; document.getElementById('text-logo-right').style.display='block'">
                        <div id="text-logo-right" class="hidden text-4xl font-black text-blue-600 tracking-wider uppercase">
                             CARENTO
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Tạo tài khoản mới</h2>
                    <p class="text-sm text-gray-500 mt-2">Đăng ký để bắt đầu hành trình của bạn cùng chúng tôi</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div class="animate-slide-up delay-100">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Họ và tên</label>
                        <x-text-input id="name" class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150" 
                                      type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nguyễn Văn A" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div class="animate-slide-up delay-200">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Địa chỉ Email</label>
                        <x-text-input id="email" class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150" 
                                      type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@example.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="animate-slide-up delay-300">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Mật khẩu</label>
                        <x-text-input id="password" class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                                      type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div class="animate-slide-up delay-400">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Xác nhận mật khẩu</label>
                        <x-text-input id="password_confirmation" class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                                      type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>

                    <div class="pt-4 animate-slide-up delay-500">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                            ĐĂNG KÝ TÀI KHOẢN
                        </button>
                    </div>
                </form>
                <div class="mt-6 flex items-center justify-center animate-slide-up delay-400">
                    <div class="border-t border-gray-200 w-full"></div>
                    <span class="px-3 text-sm text-gray-500 bg-white">Hoặc</span>
                    <div class="border-t border-gray-200 w-full"></div>
                </div>

                <div class="mt-6 animate-slide-up delay-500">
                    <a href="#" onclick="alert('Chức năng làm sau'); return false;" class="w-full flex items-center justify-center py-3 px-4 border border-gray-300 rounded-xl shadow-sm text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-150">
                        <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        Tiếp tục với Google
                    </a>
                </div>
                <div class="text-center mt-6 pt-4 border-t border-gray-100 animate-slide-up delay-500">
                    <p class="text-sm text-gray-600">
                        Đã có tài khoản? 
                        <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition">
                            Đăng nhập ngay
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>