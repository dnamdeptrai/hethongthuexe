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
                'resources/css/admin/cars.css', 
                'resources/css/admin/customers.css',
                'resources/css/admin/messages.css'],
            refresh: true,
        }),
    ],
});
