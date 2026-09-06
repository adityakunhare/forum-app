import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');

    const publicDirectory = env.LARAVEL_PUBLIC_DIR || 'public';

    console.log('LARAVEL_PUBLIC_DIR:', env.LARAVEL_PUBLIC_DIR);
    console.log('Public directory:', publicDirectory);

    return {
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
    };
});