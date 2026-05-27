import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 
                'resources/js/app.js', 
                'resources/css/admin/layout.css', 
                'resources/css/admin/dashboard.css', 
                'resources/css/admin/booking.css', 
                'resources/css/admin/car.css', 
                'resources/css/admin/customer.css'],
            
            refresh: true,
        }),
    ],
});
