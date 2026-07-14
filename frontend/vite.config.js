import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    vueDevTools(),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
    },
  },
  build: {
    // Cambia el directorio de salida a la carpeta public del backend
    outDir: '../backend/public',
    emptyOutDir: false, //No borrar index.php, htaccess, etc. al compilar
  },

  server: {
    proxy: {
      '/api': {
        target: 'http://localhost:8000', // Cambia esto a la URL de tu backend
        changeOrigin: true,
      },
    },
  },
})
