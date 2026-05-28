<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 2. THÊM ĐOẠN CODE NÀY VÀO HÀM BOOT
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}