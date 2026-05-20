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