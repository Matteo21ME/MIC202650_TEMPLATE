<script setup>
import { computed } from 'vue'
import { session } from '@/services/session'

// Obtenemos el nombre directamente de la sesión actual
const userName = computed(() => session.user?.name || 'Usuario')

// Métricas globales genéricas (fáciles de conectar a cualquier API en el futuro)
const stats = [
  { title: 'Actividad del Mes', value: '1,240', icon: '📊', color: '#1a6b8a' },
  { title: 'Tareas Pendientes', value: '5', icon: '⏳', color: '#f39c12' },
  { title: 'Eventos Programados', value: '8', icon: '🗓️', color: '#2ecc71' },
]

// Lista de novedades o bitácora general del sistema
const systemUpdates = [
  { id: 1, title: 'Actualización del Sistema', desc: 'Se optimizó la velocidad de carga de los reportes.', date: 'Hoy' },
  { id: 2, title: 'Mantenimiento Programado', desc: 'El sistema tendrá una pausa de estabilidad este domingo a las 2:00 AM.', date: 'Ayer' },
]
</script>

<template>
  <div class="dashboard-container">
    <!-- Encabezado de Bienvenida General -->
    <header class="dashboard-header">
      <h1>Bienvenido al Panel, {{ userName }} 👋</h1>
      <p>Aquí tienes un resumen general del estado de la plataforma y tus accesos principales.</p>
    </header>

    <!-- Panel de Indicadores (Métricas) -->
    <section class="stats-grid">
      <div v-for="(stat, index) in stats" :key="index" class="stat-card">
        <div class="stat-icon" :style="{ backgroundColor: stat.color + '15', color: stat.color }">
          {{ stat.icon }}
        </div>
        <div class="stat-info">
          <h3>{{ stat.value }}</h3>
          <p>{{ stat.title }}</p>
        </div>
      </div>
    </section>

    <!-- Sección de Bloques Informativos -->
    <div class="dashboard-content">
      <!-- Tarjeta de Accesos Directos -->
      <section class="content-card">
        <h2>Accesos Disponibles</h2>
        <p class="section-desc">Enlaces directos a los módulos compartidos del sistema.</p>
        
        <div class="actions-grid">
          <RouterLink to="/roles" class="action-btn">
            <span>🛡️</span> Módulo de Roles
          </RouterLink>
          
          <!-- Este botón te servirá para cuando descomentes tus otras rutas de negocio -->
          <RouterLink to="/" class="action-btn">
            <span>🏠</span> Vista Principal
          </RouterLink>
        </div>
      </section>

      <!-- Tarjeta de Novedades / Tablón de Anuncios -->
      <section class="content-card">
        <h2>Anuncios del Sistema</h2>
        <p class="section-desc">Notas informativas y actualizaciones generales.</p>
        
        <div class="updates-list">
          <div v-for="update in systemUpdates" :key="update.id" class="update-item">
            <div class="update-header">
              <h4>{{ update.title }}</h4>
              <span class="update-date">{{ update.date }}</span>
            </div>
            <p class="update-desc">{{ update.desc }}</p>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<style scoped>
.dashboard-container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 2.5rem 1.5rem;
  font-family: system-ui, -apple-system, sans-serif;
  color: #2c3e50;
}

/* Header */
.dashboard-header {
  margin-bottom: 2.5rem;
}
.dashboard-header h1 {
  font-size: 1.8rem;
  font-weight: 700;
  color: #1a252f;
  margin: 0 0 0.4rem 0;
}
.dashboard-header p {
  color: #7f8c8d;
  margin: 0;
  font-size: 0.95rem;
}

/* Grid de Estadísticas */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2.5rem;
}
.stat-card {
  background: #ffffff;
  border-radius: 10px;
  padding: 1.5rem;
  display: flex;
  align-items: center;
  gap: 1.25rem;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
  border: 1px solid rgba(0, 0, 0, 0.06);
}
.stat-icon {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.4rem;
}
.stat-info h3 {
  font-size: 1.6rem;
  font-weight: 700;
  margin: 0;
  color: #2c3e50;
}
.stat-info p {
  margin: 0;
  font-size: 0.85rem;
  color: #7f8c8d;
  font-weight: 500;
}

/* Layout de bloques */
.dashboard-content {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.5rem;
}
@media (max-width: 768px) {
  .dashboard-content { grid-template-columns: 1fr; }
}

.content-card {
  background: #ffffff;
  border-radius: 10px;
  padding: 1.5rem;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
  border: 1px solid rgba(0, 0, 0, 0.06);
}
.content-card h2 {
  font-size: 1.2rem;
  font-weight: 600;
  margin: 0 0 0.25rem 0;
}
.section-desc {
  font-size: 0.85rem;
  color: #95a5a6;
  margin: 0 0 1.5rem 0;
}

/* Cuadrícula de Accesos Rápidos */
.actions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
  gap: 1rem;
}
.action-btn {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 0.6rem;
  padding: 1.5rem 1rem;
  background: #f8f9fa;
  border: 1px solid #e9ecef;
  border-radius: 8px;
  color: #1a6b8a;
  text-decoration: none;
  font-weight: 600;
  font-size: 0.9rem;
  transition: all 0.2s ease;
  text-align: center;
}
.action-btn span { font-size: 1.6rem; }
.action-btn:hover {
  background: #1a6b8a;
  color: #ffffff;
  transform: translateY(-2px);
  border-color: #1a6b8a;
}

/* Lista de Anuncios */
.updates-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}
.update-item {
  padding: 0.75rem 1rem;
  background: #fdfdfd;
  border-left: 3px solid #1a6b8a;
  border-radius: 4px;
}
.update-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 0.25rem;
}
.update-header h4 {
  margin: 0;
  font-size: 0.9rem;
  font-weight: 600;
  color: #2c3e50;
}
.update-date {
  font-size: 0.75rem;
  color: #95a5a6;
}
.update-desc {
  margin: 0;
  font-size: 0.85rem;
  color: #576574;
  line-height: 1.4;
}
</style>