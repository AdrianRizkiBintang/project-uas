import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
<<<<<<< HEAD
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
=======
>>>>>>> e84b764 (Menambahkan rute otentikasi, perintah konsol, dan kasus uji awal)

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
<<<<<<< HEAD
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
=======
        }),
    ],
>>>>>>> e84b764 (Menambahkan rute otentikasi, perintah konsol, dan kasus uji awal)
});
