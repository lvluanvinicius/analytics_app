import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.tsx',
            refresh: true,
        }),
        react(),
    ],
    server: {
        host: "0.0.0.0", // Escuta em todos os endereços (IPv4 e IPv6)
        port: 5174, // Porta do servidor Vite
        origin: "http://analytics.api", // Domínio usado pelo navegador
        hmr: {
            host: "analytics.api",
            protocol: "ws", // Use 'wss' para HTTPS
            port: 5174
        },
    },
});
