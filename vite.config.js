import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
        host: "0.0.0.0",
        hmr: {
            host: 'localhost'
        },
        cors: {
            origin: "*"
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/scss/backoffice.scss',
                'resources/scss/theme.scss',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
