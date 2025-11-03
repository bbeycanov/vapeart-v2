import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/filament-admin.css', // panel üçün tema
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
})
