import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
<<<<<<< HEAD
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
=======
<<<<<<< HEAD
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
=======
>>>>>>> cd1aac3ff3eb328e01c7ec3a7a1c81eba9d6d37f
>>>>>>> 43b70fe15192ffe77de4cb776a49bd82a85fc629

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 43b70fe15192ffe77de4cb776a49bd82a85fc629
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
<<<<<<< HEAD
=======
=======
        }),
    ],
>>>>>>> cd1aac3ff3eb328e01c7ec3a7a1c81eba9d6d37f
>>>>>>> 43b70fe15192ffe77de4cb776a49bd82a85fc629
});
