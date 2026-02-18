import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [
                'resources/views/**',
                'Modules/**/resources/views/**',
                'routes/**',
                'Modules/**/routes/**',
            ],
        }),
        tailwindcss(),
        VitePWA({
            registerType: 'autoUpdate',
            manifest: {
                name: 'Vertex OhPro',
                short_name: 'OhPro',
                description: 'Caderno digital do professor',
                start_url: '/',
                display: 'standalone',
                theme_color: '#4f46e5',
                background_color: '#ffffff',
            },
            workbox: {
                globPatterns: ['**/*.{js,css,html,ico,png,svg,woff2}'],
                runtimeCaching: [
                    {
                        urlPattern: /\/notebook\/class\/\d+\/grades/,
                        handler: 'NetworkFirst',
                        options: {
                            cacheName: 'notebook-grades',
                            expiration: { maxEntries: 20, maxAgeSeconds: 60 * 60 * 24 * 7 },
                            networkTimeoutSeconds: 10,
                        },
                    },
                    {
                        urlPattern: /\/notebook\/class\/\d+\/attendance/,
                        handler: 'NetworkFirst',
                        options: {
                            cacheName: 'notebook-attendance',
                            expiration: { maxEntries: 20, maxAgeSeconds: 60 * 60 * 24 * 7 },
                            networkTimeoutSeconds: 10,
                        },
                    },
                ],
            },
        }),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
