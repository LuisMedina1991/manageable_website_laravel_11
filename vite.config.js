import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/custom_styles.css',
                'resources/js/app.js',
                'resources/js/custom_scripts.js',
                'resources/sass/app.scss',
            ],
            refresh: true,
        }),
    ],
});
