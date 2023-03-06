import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
// import ziggyPlugin from 'ziggy-rollup-plugin';



export default defineConfig({
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-browser',

        }
    },
    plugins: [
        laravel({
            input: 'resources/js/app.js',
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
        // ziggyPlugin({
        //     // options de configuration de Ziggy ici
        //   }),
    ],
});
