import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.scss',
                'resources/css/pricing.scss',
                'resources/css/payment-success.scss',
                'resources/css/about.scss',
                'resources/css/contact.scss',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
