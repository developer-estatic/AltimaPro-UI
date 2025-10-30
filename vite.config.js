import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        tailwindcss(),
            laravel({
                input: [
                    "resources/sass/app.scss",
                    "resources/css/app.css",
                    "resources/css/style.css",
                    "resources/css/custom-staging-design.css",
                    "resources/css/adminlte-custom.css",
                    "resources/css/left-navigation.css",
                    "resources/css/header-staging.css",
                    "resources/js/app.js",
                    "resources/js/update.js",
                    "resources/js/head.js",
                    "resources/js/datatable.js",
                    "resources/js/global-datatable.js",
                ],
            refresh: [
                `resources/sass/**/*`,
                `resources/css/**/*`,
                `resources/js/**/*`,
                `resources/views/**/*`,
                "./app/Livewire/*.php",
                "./app/Livewire/**/*.php",
            ],
        }),
    ],
    server: {
        cors: true,
    },
});
