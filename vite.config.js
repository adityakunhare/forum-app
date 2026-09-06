import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

const publicDirectory = process.env.LARAVEL_PUBLIC_DIR || 'public';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            publicDirectory,
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
