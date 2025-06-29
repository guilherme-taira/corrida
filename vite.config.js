import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
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
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },

    // 👇 Adicione isso aqui
    server: {
        host: '0.0.0.0',               // Permite acesso de outros dispositivos na rede
        port: 5173,                    // Porta padrão do Vite
        strictPort: true,             // Impede que ele mude de porta se 5173 estiver ocupada
        hmr: {
            host: '192.168.1.7',      // IP do seu computador na rede local
        },
    },
});
