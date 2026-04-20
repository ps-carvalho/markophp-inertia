import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import react from '@vitejs/plugin-react';
import { svelte } from '@sveltejs/vite-plugin-svelte';
import tailwindcss from '@tailwindcss/vite';
import { resolve } from 'path';

export default defineConfig({
  plugins: [
    vue(),
    react(),
    svelte(),
    tailwindcss(),
  ],
  server: {
    host: '0.0.0.0',
    port: Number(process.env.VITE_DEV_SERVER_PORT ?? 5173),
    strictPort: true,
  },
  resolve: {
    alias: {
      '@': resolve(__dirname, 'resources/js'),
    },
  },
  build: {
    outDir: 'public/build',
    manifest: true,
    rollupOptions: {
      input: {
        vue: 'app/web/resources/js/app.js',
        react: 'app/react-web/resources/js/app.jsx',
        svelte: 'app/svelte-web/resources/js/app.js',
      },
    },
  },
});
