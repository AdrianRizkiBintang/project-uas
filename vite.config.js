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
<<<<<<< HEAD
>>>>>>> friend-repo/main
=======
>>>>>>> 43b70fe15192ffe77de4cb776a49bd82a85fc629
>>>>>>> 3abcfe4cede430b0b2dc1e5e423bb33d0da8224f

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> friend-repo/main
=======
>>>>>>> 43b70fe15192ffe77de4cb776a49bd82a85fc629
>>>>>>> 3abcfe4cede430b0b2dc1e5e423bb33d0da8224f
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
<<<<<<< HEAD
>>>>>>> friend-repo/main
=======
>>>>>>> 43b70fe15192ffe77de4cb776a49bd82a85fc629
>>>>>>> 3abcfe4cede430b0b2dc1e5e423bb33d0da8224f
});
