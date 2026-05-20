<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="Họ và tên" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-gray-50 text-gray-500" :value="old('email', $user->email)" required autocomplete="username" readonly />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        Email của bạn chưa được xác minh.
                        <button form="send-verification" class="underline font-bold hover:text-yellow-900 focus:outline-none">
                            Bấm vào đây để gửi lại link xác minh.
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            Một link xác minh mới đã được gửi đến email của bạn.
                        </p>
                    @endif
                </div>
            @endif
        </div>
        
        <div>
            <x-input-label for="phone" value="Số điện thoại liên hệ" />
            
            <x-text-input id="phone" name="phone" type="text" 
                class="mt-1 block w-full {{ empty($user->phone) ? 'border-red-500 ring-1 ring-red-500 focus:border-red-500 focus:ring-red-500' : '' }}" 
                :value="old('phone', $user->phone)" autocomplete="tel" placeholder="Nhập số điện thoại của bạn..." />
            
            @if(empty($user->phone))
                <p class="mt-2 text-sm text-red-600 font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    Vui lòng cập nhật số điện thoại.
                </p>
            @endif
            
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
            <x-primary-button class="bg-blue-600 hover:bg-blue-700">Lưu thay đổi</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm font-bold text-green-600 flex items-center gap-1"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Đã lưu thành công!
                </p>
            @endif
        </div>
    </form>
</section>