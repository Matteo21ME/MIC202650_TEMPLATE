<script setup>
import { RouterView } from 'vue-router'
import NavBar from './components/NavBar.vue'
</script>

<template>
  <!-- Contenedor raíz de la aplicación -->
  <div class="app-layout">
    <NavBar />
    
    <!-- Contenedor principal para renderizar las vistas del router -->
    <main class="main-content">
      <RouterView />
    </main>
  </div>
</template>

<style>
/* 1. RESETEO Y ESTILOS GLOBALES RELES */
* { 
  box-sizing: border-box; 
  margin: 0; 
  padding: 0; 
}

body { 
  font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; 
  background-color: #f5f7fa; 
  color: #2c3e50;
  min-height: 100vh;
  width: 100%;
}

/* 2. LAYOUT VERTICAL PARA EVITAR DIVISIONES RARAS */
.app-layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  width: 100%;
}

.main-content {
  flex: 1;
  width: 100%;
  display: block; /* Rompe cualquier flexbox residual */
}
</style>