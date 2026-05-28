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

        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-16 lg:px-24 bg-gray-50/50">
            <div class="max-w-md w-full mx-auto bg-white p-8 sm:p-10 rounded-2xl shadow-xl shadow-gray-100 border border-gray-100">
                
                <div class="text-center mb-8">
                    <div class="inline-flex justify-center mb-6"> 
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-24 w-auto object-contain fallback-logo" onerror="this.style.display='none'; document.getElementById('text-logo-right').style.display='block'">
                        <div id="text-logo-right" class="hidden text-4xl font-black text-blue-600 tracking-wider uppercase">
                            CARENTO
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Chào mừng bạn trở lại!</h2>
                    <p class="text-sm text-gray-500 mt-2">Vui lòng đăng nhập tài khoản để tiếp tục trải nghiệm</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div class="animate-slide-up delay-100">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Địa chỉ Email</label>
                        <div class="relative">
                            <x-text-input id="email" class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150" 
                                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="animate-slide-up delay-200">
                        <div class="flex justify-between items-center mb-1">
                            <label for="password" class="block text-sm font-semibold text-gray-700">Mật khẩu</label>
                            @if (Route::has('password.request'))
                                <a class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition" href="{{ route('password.request') }}">Quên mật khẩu?</a>
                            @endif
                        </div>
                        <x-text-input id="password" class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                                        type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div class="flex items-center justify-between pt-1 animate-slide-up delay-300">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 w-4 h-4" name="remember">
                            <span class="ms-2 text-sm text-gray-600 select-none">Duy trì đăng nhập</span>
                        </label>
                    </div>

                    <div class="pt-2 animate-slide-up delay-400">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                            Đăng nhập
                        </button>
                    </div>
                </form>
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Hoặc</span>
                    </div>
                </div>

                <a href="{{ route('google.login') }}" 
                class="flex items-center justify-center gap-3 w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    
                    <svg class="h-5 w-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#EA4335" d="M5.266 9.765A7.077 7.077 0 0 1 12 4.909c1.69 0 3.218.6 4.418 1.582L19.91 3C17.782 1.145 15.055 0 12 0 7.33 0 3.353 2.641 1.41 6.51l3.856 3.255z"/>
                        <path fill="#34A853" d="M16.04 15.345c-1.077.732-2.432 1.164-4.04 1.164-3.09 0-5.723-2.036-6.655-4.823L1.455 14.93C3.427 18.836 7.418 21.5 12 21.5c3.082 0 5.927-1.127 8.082-3.127l-4.123-3.028z"/>
                        <path fill="#4285F4" d="M23.5 12c0-.75-.064-1.477-.182-2.182H12v4.364h6.455a5.54 5.54 0 0 1-2.414 3.636l4.123 3.028C22.582 18.523 23.5 15.51 23.5 12z"/>
                        <path fill="#FBBC05" d="M5.345 11.686A7.004 7.004 0 0 1 5.345 9.76l-3.855-3.25A11.944 11.944 0 0 0 0 12c0 2.055.518 4.01 1.432 5.73l3.913-3.045a7.042 7.042 0 0 1-.055-2.999z"/>
                    </svg>
                    
                    <span>Tiếp tục với Google</span>
                </a>
                </div>
                <div class="text-center mt-6 pt-4 border-t border-gray-100 animate-slide-up delay-500">
                    <p class="text-sm text-gray-600">
                        Chưa có tài khoản? <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition">Đăng ký ngay</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>